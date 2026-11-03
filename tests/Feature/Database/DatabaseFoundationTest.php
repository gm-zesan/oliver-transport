<?php

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleSeat;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\QueryException;

test('all factories create valid database records with correct defaults', function () {
    $vehicle = Vehicle::factory()->create();
    expect($vehicle->exists)->toBeTrue()
        ->and($vehicle->passenger_capacity)->toBe(6)
        ->and($vehicle->is_active)->toBeTrue();

    $seat = VehicleSeat::factory()->create(['vehicle_id' => $vehicle->id]);
    expect($seat->exists)->toBeTrue()
        ->and($seat->is_driver_seat)->toBeFalse();

    $location = Location::factory()->create();
    expect($location->exists)->toBeTrue();

    $route = Route::factory()->create();
    expect($route->exists)->toBeTrue()
        ->and($route->is_active)->toBeTrue();

    $stop = RouteStop::factory()->create([
        'route_id' => $route->id,
        'location_id' => $location->id,
    ]);
    expect($stop->exists)->toBeTrue();

    $schedule = Schedule::factory()->create([
        'route_id' => $route->id,
        'vehicle_id' => $vehicle->id,
    ]);
    expect($schedule->exists)->toBeTrue();

    $trip = Trip::factory()->create([
        'schedule_id' => $schedule->id,
        'route_id' => $route->id,
        'vehicle_id' => $vehicle->id,
    ]);
    expect($trip->exists)->toBeTrue()
        ->and($trip->status)->toBe('scheduled');

    $booking = Booking::factory()->create([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $stop->id,
        'dropoff_stop_id' => $stop->id,
    ]);
    expect($booking->exists)->toBeTrue()
        ->and($booking->currency)->toBe('CAD')
        ->and($booking->status)->toBe('confirmed');

    $bookingSeat = BookingSeat::factory()->create([
        'booking_id' => $booking->id,
        'trip_id' => $trip->id,
        'vehicle_seat_id' => $seat->id,
    ]);
    expect($bookingSeat->exists)->toBeTrue();

    $coupon = Coupon::factory()->create();
    expect($coupon->exists)->toBeTrue()
        ->and($coupon->is_active)->toBeTrue();

    $usage = CouponUsage::factory()->create([
        'coupon_id' => $coupon->id,
        'booking_id' => $booking->id,
    ]);
    expect($usage->exists)->toBeTrue();

    $payment = Payment::factory()->create([
        'booking_id' => $booking->id,
    ]);
    expect($payment->exists)->toBeTrue()
        ->and($payment->currency)->toBe('CAD')
        ->and($payment->status)->toBe('unpaid');
});

test('eloquent relationships navigate bidirectionally across the entire schema', function () {
    $vehicle = Vehicle::factory()->create();
    $driverSeat = VehicleSeat::factory()->driverSeat()->create(['vehicle_id' => $vehicle->id]);
    $passengerSeat = VehicleSeat::factory()->create(['vehicle_id' => $vehicle->id, 'seat_number' => 'S1']);

    expect($vehicle->seats)->toHaveCount(2)
        ->and($vehicle->bookableSeats)->toHaveCount(1)
        ->and($passengerSeat->vehicle->id)->toBe($vehicle->id);

    $route = Route::factory()->create();
    $location = Location::factory()->create();
    $stop = RouteStop::factory()->create(['route_id' => $route->id, 'location_id' => $location->id]);

    expect($route->stops->first()->id)->toBe($stop->id)
        ->and($stop->route->id)->toBe($route->id)
        ->and($stop->location->id)->toBe($location->id)
        ->and($location->routeStops->first()->id)->toBe($stop->id);

    $rider = User::factory()->rider()->create();
    $schedule = Schedule::factory()->create(['route_id' => $route->id, 'vehicle_id' => $vehicle->id]);
    $trip = Trip::factory()->create([
        'schedule_id' => $schedule->id,
        'route_id' => $route->id,
        'vehicle_id' => $vehicle->id,
        'rider_id' => $rider->id,
    ]);

    expect($trip->schedule->id)->toBe($schedule->id)
        ->and($trip->route->id)->toBe($route->id)
        ->and($trip->vehicle->id)->toBe($vehicle->id)
        ->and($trip->rider->id)->toBe($rider->id)
        ->and($rider->assignedTrips->first()->id)->toBe($trip->id);

    $passenger = User::factory()->passenger()->create();
    $booking = Booking::factory()->create([
        'user_id' => $passenger->id,
        'trip_id' => $trip->id,
        'boarding_stop_id' => $stop->id,
        'dropoff_stop_id' => $stop->id,
    ]);
    $bookingSeat = BookingSeat::factory()->create([
        'booking_id' => $booking->id,
        'trip_id' => $trip->id,
        'vehicle_seat_id' => $passengerSeat->id,
    ]);

    expect($booking->user->id)->toBe($passenger->id)
        ->and($booking->passenger->id)->toBe($passenger->id)
        ->and($passenger->bookings->first()->id)->toBe($booking->id)
        ->and($booking->trip->id)->toBe($trip->id)
        ->and($booking->boardingStop->id)->toBe($stop->id)
        ->and($booking->dropoffStop->id)->toBe($stop->id)
        ->and($booking->bookingSeats->first()->id)->toBe($bookingSeat->id)
        ->and($bookingSeat->booking->id)->toBe($booking->id)
        ->and($bookingSeat->vehicleSeat->id)->toBe($passengerSeat->id);

    $coupon = Coupon::factory()->create();
    $usage = CouponUsage::factory()->create([
        'coupon_id' => $coupon->id,
        'booking_id' => $booking->id,
        'user_id' => $passenger->id,
    ]);

    expect($booking->couponUsage->id)->toBe($usage->id)
        ->and($coupon->usages->first()->id)->toBe($usage->id)
        ->and($usage->coupon->id)->toBe($coupon->id)
        ->and($usage->booking->id)->toBe($booking->id)
        ->and($usage->user->id)->toBe($passenger->id);

    $payment = Payment::factory()->paid($rider)->create(['booking_id' => $booking->id]);

    expect($booking->payment->id)->toBe($payment->id)
        ->and($payment->booking->id)->toBe($booking->id)
        ->and($payment->collector->id)->toBe($rider->id)
        ->and($rider->collectedPayments->first()->id)->toBe($payment->id);
});

test('unique constraints are strictly enforced across tables', function () {
    // 1. Vehicle plate uniqueness
    Vehicle::factory()->create(['plate_number' => 'UNIQUE-1']);
    expect(fn () => Vehicle::factory()->create(['plate_number' => 'UNIQUE-1']))
        ->toThrow(QueryException::class);

    // 2. VehicleSeat (vehicle_id, seat_number) composite uniqueness
    $vehicle = Vehicle::factory()->create();
    VehicleSeat::factory()->create(['vehicle_id' => $vehicle->id, 'seat_number' => 'S1']);
    expect(fn () => VehicleSeat::factory()->create(['vehicle_id' => $vehicle->id, 'seat_number' => 'S1']))
        ->toThrow(QueryException::class);

    // 3. Route direction_code uniqueness
    Route::factory()->create(['direction_code' => 'MTL_TO_TOR']);
    expect(fn () => Route::factory()->create(['direction_code' => 'MTL_TO_TOR']))
        ->toThrow(QueryException::class);

    // 4. RouteStop (route_id, stop_sequence) composite uniqueness
    $route = Route::factory()->create();
    $loc = Location::factory()->create();
    RouteStop::factory()->create(['route_id' => $route->id, 'location_id' => $loc->id, 'stop_sequence' => 0]);
    expect(fn () => RouteStop::factory()->create(['route_id' => $route->id, 'location_id' => $loc->id, 'stop_sequence' => 0]))
        ->toThrow(QueryException::class);

    // 5. Trip (schedule_id, trip_date) composite uniqueness
    $sched = Schedule::factory()->create();
    Trip::factory()->create(['schedule_id' => $sched->id, 'trip_date' => '2026-12-01']);
    expect(fn () => Trip::factory()->create(['schedule_id' => $sched->id, 'trip_date' => '2026-12-01']))
        ->toThrow(QueryException::class);

    // 6. Booking reference uniqueness
    Booking::factory()->create(['booking_reference' => 'OT-2026-REF1']);
    expect(fn () => Booking::factory()->create(['booking_reference' => 'OT-2026-REF1']))
        ->toThrow(QueryException::class);

    // 7. Payment booking_id uniqueness (1-to-1)
    $booking = Booking::factory()->create();
    Payment::factory()->create(['booking_id' => $booking->id]);
    expect(fn () => Payment::factory()->create(['booking_id' => $booking->id]))
        ->toThrow(QueryException::class);

    // 8. Coupon code uniqueness
    Coupon::factory()->create(['code' => 'PROMO10']);
    expect(fn () => Coupon::factory()->create(['code' => 'PROMO10']))
        ->toThrow(QueryException::class);
});

test('referential cascade and deletion behavior works as documented', function () {
    // Cascade deletion: Deleting a vehicle cascades to its seats
    $vehicle = Vehicle::factory()->create();
    $seat = VehicleSeat::factory()->create(['vehicle_id' => $vehicle->id]);
    $vehicle->delete();
    expect(VehicleSeat::find($seat->id))->toBeNull();

    // Cascade deletion: Deleting a booking cascades to booking_seats and coupon_usages
    $booking = Booking::factory()->create();
    $bookingSeat = BookingSeat::factory()->create(['booking_id' => $booking->id]);
    $coupon = Coupon::factory()->create();
    $usage = CouponUsage::factory()->create([
        'booking_id' => $booking->id,
        'coupon_id' => $coupon->id,
    ]);

    $booking->delete();
    expect(BookingSeat::find($bookingSeat->id))->toBeNull()
        ->and(CouponUsage::find($usage->id))->toBeNull();

    // Set null deletion: Deleting the rider assigned to a trip sets rider_id to null
    $rider = User::factory()->rider()->create();
    $trip = Trip::factory()->create(['rider_id' => $rider->id]);
    $rider->delete();
    expect($trip->fresh()->rider_id)->toBeNull();

    // Set null deletion: Deleting the collector of a payment sets collected_by to null
    $collector = User::factory()->rider()->create();
    $booking2 = Booking::factory()->create();
    $payment = Payment::factory()->paid($collector)->create(['booking_id' => $booking2->id]);
    $collector->delete();
    expect($payment->fresh()->collected_by)->toBeNull();

    // Set null deletion: Deleting user who cancelled booking sets cancelled_by to null
    $canceller = User::factory()->passenger()->create();
    $cancelledBooking = Booking::factory()->cancelled($canceller)->create();
    $canceller->delete();
    expect($cancelledBooking->fresh()->cancelled_by)->toBeNull();
});

test('mass assignment protection prevents unfillable attributes across all models', function () {
    // Attempting to mass assign an unfillable attribute must throw MassAssignmentException
    expect(fn () => new Vehicle(['plate_number' => 'X', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new VehicleSeat(['seat_number' => 'S1', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Location(['name' => 'Loc', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Route(['name' => 'R', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new RouteStop(['stop_sequence' => 1, 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Schedule(['departure_time' => '06:30', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Trip(['status' => 'scheduled', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Booking(['booking_reference' => 'OT-1', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new BookingSeat(['boarding_sequence' => 0, 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Coupon(['code' => 'C', 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new CouponUsage(['discount_applied' => 10, 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);

    expect(fn () => new Payment(['amount' => 50, 'unfillable_field' => 'bad']))
        ->toThrow(MassAssignmentException::class);
});

test('database seeder populates deterministic static configuration', function () {
    $this->seed(DatabaseSeeder::class);

    // Fleet: Honda Odyssey RAJIA
    $vehicle = Vehicle::where('plate_number', 'RAJIA')->first();
    expect($vehicle)->not->toBeNull()
        ->and($vehicle->passenger_capacity)->toBe(6)
        ->and($vehicle->seats)->toHaveCount(7)
        ->and($vehicle->bookableSeats)->toHaveCount(6);

    // Stations: 3 confirmed stations
    expect(Location::count())->toBe(3)
        ->and(Location::where('city', 'Montreal')->count())->toBe(1)
        ->and(Location::where('city', 'Toronto')->count())->toBe(2);

    // Routes: 2 confirmed corridors
    expect(Route::count())->toBe(2)
        ->and(Route::where('direction_code', 'MTL_TO_TOR')->exists())->toBeTrue()
        ->and(Route::where('direction_code', 'TOR_TO_MTL')->exists())->toBeTrue();

    // Stops: 3 per route = 6 total
    expect(RouteStop::count())->toBe(6);

    // Schedules: 2 daily recurring runs
    expect(Schedule::count())->toBe(2);

    // Users: 3 default accounts for operator, rider, passenger
    expect(User::where('role', 'operator')->count())->toBe(1)
        ->and(User::where('role', 'rider')->count())->toBe(1)
        ->and(User::where('role', 'passenger')->count())->toBe(1);
});
