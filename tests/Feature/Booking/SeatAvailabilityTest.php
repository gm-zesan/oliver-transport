<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Location;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleSeat;

beforeEach(function () {
    $this->vehicle = Vehicle::factory()->create([
        'plate_number' => 'RAJIA',
        'passenger_capacity' => 6,
    ]);

    $this->driverSeat = VehicleSeat::factory()->driverSeat()->create(['vehicle_id' => $this->vehicle->id]);
    $this->seatS1 = VehicleSeat::factory()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S1', 'cabin_position' => 'front_passenger', 'is_driver_seat' => false]);
    $this->seatS2 = VehicleSeat::factory()->rearCabin()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S2']);

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

    $this->passengerA = User::factory()->passenger()->create();
    $this->passengerB = User::factory()->passenger()->create();
});

test('sequential non-overlapping seat reuse is allowed for adjacent journey intervals', function () {
    // Passenger A books Montreal (0) -> Yorkdale (1) on Seat S1: Interval [0, 1)
    $responseA = $this->actingAs($this->passengerA)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop1->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $responseA->assertStatus(201);

    // Passenger B books Yorkdale (1) -> Yonge Station (2) on the same Seat S1: Interval [1, 2)
    // Mathematical evaluation: (0 < 2) AND (1 < 1) => TRUE AND FALSE => FALSE (No Overlap!)
    $responseB = $this->actingAs($this->passengerB)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop1->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $responseB->assertStatus(201);

    // Both bookings are stored and confirmed
    expect(Booking::count())->toBe(2);
    expect(BookingSeat::where('vehicle_seat_id', $this->seatS1->id)->count())->toBe(2);
});

test('overlapping segment booking triggers http 409 conflict and prevents double booking', function () {
    // Passenger A books Montreal (0) -> Yonge Station (2) on Seat S1: Interval [0, 2)
    $responseA = $this->actingAs($this->passengerA)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $responseA->assertStatus(201);

    // Passenger B attempts to book Yorkdale (1) -> Yonge Station (2) on the same Seat S1: Interval [1, 2)
    // Mathematical evaluation: (0 < 2) AND (1 < 2) => TRUE AND TRUE => TRUE (Overlap Detected!)
    $responseB = $this->actingAs($this->passengerB)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop1->id,
        'dropoff_stop_id' => $this->stop2->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $responseB->assertStatus(409)
        ->assertJson([
            'success' => false,
            'error' => 'SEAT_UNAVAILABLE',
        ]);

    // Ensure only Passenger A has the seat
    expect(Booking::count())->toBe(1);
    expect(BookingSeat::where('vehicle_seat_id', $this->seatS1->id)->count())->toBe(1);
});

test('seat availability api accurately reports segment vacancy for vehicle cabin', function () {
    // Reserve S1 on segment [0, 1)
    $this->actingAs($this->passengerA)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop1->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    // Query availability for segment [0, 1) -> S1 should be unavailable
    $res1 = $this->getJson(route('api.trips.seats', [
        'trip' => $this->trip->id,
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop1->id,
    ]));

    $res1->assertOk();
    $seats1 = collect($res1->json('seats'));
    $s1OnSegment1 = $seats1->firstWhere('seat_number', 'S1');
    $s2OnSegment1 = $seats1->firstWhere('seat_number', 'S2');
    expect($s1OnSegment1['is_available'])->toBeFalse();
    expect($s2OnSegment1['is_available'])->toBeTrue();

    // Query availability for segment [1, 2) -> S1 SHOULD BE AVAILABLE (reuse!)
    $res2 = $this->getJson(route('api.trips.seats', [
        'trip' => $this->trip->id,
        'boarding_stop_id' => $this->stop1->id,
        'dropoff_stop_id' => $this->stop2->id,
    ]));

    $res2->assertOk();
    $seats2 = collect($res2->json('seats'));
    $s1OnSegment2 = $seats2->firstWhere('seat_number', 'S1');
    expect($s1OnSegment2['is_available'])->toBeTrue();
});
