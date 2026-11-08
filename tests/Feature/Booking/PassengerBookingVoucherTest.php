<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Location;
use App\Models\Payment;
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

    $this->seatS1 = VehicleSeat::factory()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S1', 'cabin_position' => 'front_passenger', 'is_driver_seat' => false]);

    $this->locNamur = Location::factory()->create(['name' => 'Station Métro Namur', 'city' => 'Montreal']);
    $this->locYorkdale = Location::factory()->create(['name' => 'Yorkdale Mall', 'city' => 'Toronto']);

    $this->route = Route::factory()->create(['direction_code' => 'MTL_TO_TOR']);

    $this->stop0 = RouteStop::factory()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locNamur->id,
        'stop_sequence' => 0,
        'stop_type' => 'origin',
    ]);

    $this->stop1 = RouteStop::factory()->destination()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locYorkdale->id,
        'stop_sequence' => 1,
    ]);

    $this->schedule = Schedule::factory()->create([
        'route_id' => $this->route->id,
        'vehicle_id' => $this->vehicle->id,
    ]);

    $this->trip = Trip::factory()->create([
        'schedule_id' => $this->schedule->id,
        'route_id' => $this->route->id,
        'vehicle_id' => $this->vehicle->id,
        'trip_date' => now()->addDays(2)->format('Y-m-d'),
        'status' => 'scheduled',
    ]);

    $this->passengerA = User::factory()->passenger()->create();
    $this->passengerB = User::factory()->passenger()->create();

    $this->booking = Booking::create([
        'booking_reference' => 'OT-2026-TEST',
        'user_id' => $this->passengerA->id,
        'trip_id' => $this->trip->id,
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop1->id,
        'seat_count' => 1,
        'base_fare' => 65.00,
        'discount_amount' => 0.00,
        'final_fare' => 65.00,
        'currency' => 'CAD',
        'status' => 'confirmed',
    ]);

    BookingSeat::create([
        'booking_id' => $this->booking->id,
        'trip_id' => $this->trip->id,
        'vehicle_seat_id' => $this->seatS1->id,
        'boarding_sequence' => 0,
        'dropoff_sequence' => 1,
    ]);

    Payment::create([
        'booking_id' => $this->booking->id,
        'amount' => 65.00,
        'currency' => 'CAD',
        'payment_method' => 'cash',
        'status' => 'unpaid',
    ]);
});

test('passenger can view confirmed booking boarding pass voucher', function () {
    $response = $this->actingAs($this->passengerA)
        ->get(route('passenger.bookings.show', $this->booking->booking_reference));

    $response->assertOk()
        ->assertSee('OT-2026-TEST')
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Honda Odyssey')
        ->assertSee('RAJIA')
        ->assertSee('S1')
        ->assertSee('Cash Payment Settlement Upon Boarding')
        ->assertSee('647-655-1884');
});

test('idor security: passenger b cannot view passenger a boarding pass', function () {
    $response = $this->actingAs($this->passengerB)
        ->get(route('passenger.bookings.show', $this->booking->booking_reference));

    $response->assertNotFound();
});

test('passenger can view list of reservations', function () {
    $response = $this->actingAs($this->passengerA)
        ->get(route('passenger.bookings.index'));

    $response->assertOk()
        ->assertSee('My Reservations')
        ->assertSee('OT-2026-TEST')
        ->assertSee('Station Métro Namur');
});

test('passenger reservations index renders recent bookings with allocated seats without errors', function () {
    $response = $this->actingAs($this->passengerA)
        ->get(route('passenger.bookings.index'));

    $response->assertOk()
        ->assertSee('OT-2026-TEST')
        ->assertSee('Station Métro Namur')
        ->assertSee('S1');
});
