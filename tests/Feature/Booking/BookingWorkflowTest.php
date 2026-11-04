<?php

declare(strict_types=1);

use App\Events\BookingConfirmed;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleSeat;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    // Seed essential baseline fixtures
    $this->vehicle = Vehicle::factory()->create([
        'plate_number' => 'RAJIA',
        'passenger_capacity' => 6,
    ]);

    $this->driverSeat = VehicleSeat::factory()->driverSeat()->create(['vehicle_id' => $this->vehicle->id]);
    $this->seatS1 = VehicleSeat::factory()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S1', 'cabin_position' => 'front_passenger', 'is_driver_seat' => false]);
    $this->seatS2 = VehicleSeat::factory()->rearCabin()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S2']);
    $this->seatS3 = VehicleSeat::factory()->rearCabin()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S3']);

    $this->locNamur = Location::factory()->create(['name' => 'Station Métro Namur', 'city' => 'Montreal']);
    $this->locYorkdale = Location::factory()->create(['name' => 'Yorkdale Mall', 'city' => 'Toronto']);
    $this->locYonge = Location::factory()->create(['name' => 'Yonge Station', 'city' => 'Toronto']);

    $this->route = Route::factory()->create([
        'direction_code' => 'MTL_TO_TOR',
        'name' => 'Montreal → Toronto',
    ]);

    $this->stop0 = RouteStop::factory()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locNamur->id,
        'stop_sequence' => 0,
        'scheduled_time' => '06:30:00',
        'stop_type' => 'origin',
    ]);

    $this->stop1 = RouteStop::factory()->intermediate()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locYorkdale->id,
        'stop_sequence' => 1,
    ]);

    $this->stop2 = RouteStop::factory()->destination()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locYonge->id,
        'stop_sequence' => 2,
    ]);

    $this->schedule = Schedule::factory()->create([
        'route_id' => $this->route->id,
        'vehicle_id' => $this->vehicle->id,
        'departure_time' => '06:30:00',
    ]);

    $this->trip = Trip::factory()->create([
        'schedule_id' => $this->schedule->id,
        'route_id' => $this->route->id,
        'vehicle_id' => $this->vehicle->id,
        'trip_date' => now()->addDays(2)->format('Y-m-d'),
        'scheduled_departure_time' => '06:30:00',
        'status' => 'scheduled',
    ]);

    $this->passenger = User::factory()->passenger()->create();
});

test('passenger can successfully book a single seat via 16-step lifecycle', function () {
    Event::fake([BookingConfirmed::class]);

    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ];

    $response = $this->actingAs($this->passenger)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'booking_reference',
            'redirect_url',
            'message',
        ]);

    $this->assertDatabaseHas('bookings', [
        'user_id' => $this->passenger->id,
        'trip_id' => $this->trip->id,
        'seat_count' => 1,
        'status' => 'confirmed',
        'currency' => 'CAD',
    ]);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();

    // Verify unique booking reference format OT-YYYY-XXXX
    expect($booking->booking_reference)->toMatch('/^OT-\d{4}-[A-Z0-9]{4}$/');

    // Verify booking seat record
    $this->assertDatabaseHas('booking_seats', [
        'booking_id' => $booking->id,
        'vehicle_seat_id' => $this->seatS1->id,
        'boarding_sequence' => 0,
        'dropoff_sequence' => 2,
    ]);

    // Verify initial unpaid cash payment record
    $this->assertDatabaseHas('payments', [
        'booking_id' => $booking->id,
        'payment_method' => 'cash',
        'status' => 'unpaid',
        'currency' => 'CAD',
    ]);

    Event::assertDispatched(BookingConfirmed::class);
});

test('passenger can reserve multi-seat reservation (up to 6 seats) under single account', function () {
    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id, $this->seatS2->id, $this->seatS3->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ];

    $response = $this->actingAs($this->passenger)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(201);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    expect($booking->seat_count)->toBe(3);
    expect($booking->bookingSeats)->toHaveCount(3);
    expect((float) $booking->final_fare)->toBeGreaterThan(0.0);
});

test('booking rejected if seat count exceeds 6 seats', function () {
    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [1, 2, 3, 4, 5, 6, 7], // 7 seats
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
    ];

    $response = $this->actingAs($this->passenger)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['vehicle_seat_ids']);
});

test('booking rejected if driver seat is included', function () {
    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->driverSeat->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ];

    $response = $this->actingAs($this->passenger)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(409)
        ->assertJson(['error' => 'SEAT_UNAVAILABLE']);
});

test('booking rejected if dropoff is upstream of boarding stop', function () {
    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop2->id, // Sequence 2
        'dropoff_stop_id' => $this->stop0->id,  // Sequence 0
        'idempotency_key' => (string) str()->uuid(),
    ];

    $response = $this->actingAs($this->passenger)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(422);
});

test('guest cannot submit booking and is redirected or unauthorized', function () {
    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
    ];

    $response = $this->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(401);
});

test('rider or operator role cannot submit passenger booking', function () {
    $rider = User::factory()->rider()->create();

    $payload = [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
    ];

    $response = $this->actingAs($rider)
        ->postJson(route('passenger.bookings.store'), $payload);

    $response->assertStatus(403);
});

test('available trips api automatically resolves route and fixed departure time from pickup and dropoff locations without direction parameter', function () {
    $tripDate = now()->addDays(2)->format('Y-m-d');

    // Create schedule for trip lookup
    $response = $this->getJson(route('api.trips.available', [
        'pickup' => 'namur',
        'dropoff' => 'yorkdale',
        'date' => $tripDate,
    ]));

    $response->assertOk()
        ->assertJsonPath('trips.0.route.direction_code', 'MTL_TO_TOR')
        ->assertJsonPath('trips.0.scheduled_departure_time', '06:30:00');
});
