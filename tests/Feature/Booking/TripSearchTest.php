<?php

declare(strict_types=1);

use App\Models\Location;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
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

    $this->routeMtlToTor = Route::factory()->create([
        'direction_code' => 'MTL_TO_TOR',
        'name' => 'Montreal → Toronto',
        'is_active' => true,
    ]);

    $this->routeTorToMtl = Route::factory()->create([
        'direction_code' => 'TOR_TO_MTL',
        'name' => 'Toronto → Montreal',
        'is_active' => true,
    ]);

    $this->stop0 = RouteStop::factory()->create([
        'route_id' => $this->routeMtlToTor->id,
        'location_id' => $this->locNamur->id,
        'stop_sequence' => 0,
        'scheduled_time' => '06:30:00',
        'stop_type' => 'origin',
    ]);

    $this->stop1 = RouteStop::factory()->intermediate()->create([
        'route_id' => $this->routeMtlToTor->id,
        'location_id' => $this->locYorkdale->id,
        'stop_sequence' => 1,
    ]);

    $this->scheduleMtl = Schedule::factory()->create([
        'route_id' => $this->routeMtlToTor->id,
        'vehicle_id' => $this->vehicle->id,
        'departure_time' => '06:30:00',
        'is_active' => true,
    ]);

    $this->scheduleTor = Schedule::factory()->create([
        'route_id' => $this->routeTorToMtl->id,
        'vehicle_id' => $this->vehicle->id,
        'departure_time' => '12:15:00',
        'is_active' => true,
    ]);
});

test('api returns trips for valid direction and date', function () {
    $response = $this->getJson('/api/trips/available?direction=MTL_TO_TOR&date=2026-11-10');

    $response->assertOk()
        ->assertJsonStructure([
            'trips' => [
                '*' => [
                    'id',
                    'trip_date',
                    'scheduled_departure_time',
                    'status',
                    'unit_fare',
                    'route',
                ],
            ],
        ]);

    expect($response->json('trips'))->toHaveCount(1);
});

test('api returns trips for TOR_TO_MTL direction', function () {
    $response = $this->getJson('/api/trips/available?direction=TOR_TO_MTL&date=2026-11-10');

    $response->assertOk();
    expect($response->json('trips'))->toHaveCount(1);
});

test('api defaults to today when date is omitted', function () {
    $response = $this->getJson('/api/trips/available?direction=MTL_TO_TOR');

    $response->assertOk();
    expect($response->json('trips'))->toHaveCount(1);
    expect($response->json('trips.0.trip_date'))->toBe(now()->format('Y-m-d'));
});

test('api resolves direction from pickup and dropoff query parameters', function () {
    $response = $this->getJson('/api/trips/available?pickup=namur&dropoff=yorkdale&date=2026-11-10');

    $response->assertOk();
    expect($response->json('trips'))->toHaveCount(1);
    expect($response->json('trips.0.route.direction_code'))->toBe('MTL_TO_TOR');
});

test('database seeder runs successfully and seeds routes and schedules', function () {
    $this->seed();

    expect(Route::count())->toBeGreaterThanOrEqual(2);
    expect(Schedule::count())->toBeGreaterThanOrEqual(2);
});
