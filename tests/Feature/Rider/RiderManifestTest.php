<?php

declare(strict_types=1);

use App\Models\Trip;
use App\Models\User;
use App\Services\Booking\BookingService;
use App\Services\Trip\TripService;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('unassigned rider receives 403 forbidden when accessing another drivers trip manifest (IDOR protection)', function () {
    $tripService = app(TripService::class);
    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    // Create a second rider
    $otherRider = User::factory()->create([
        'role' => 'rider',
        'name' => 'Marc Chauffeur',
        'email' => 'marc.driver@pickmeroute.com',
    ]);

    $this->actingAs($otherRider)
        ->get(route('rider.trips.manifest', $trip))
        ->assertForbidden();
});

test('assigned rider can view trip manifest with stop sequence, booked seats, and financial KPIs', function () {
    $tripService = app(TripService::class);
    $bookingService = app(BookingService::class);
    $rider = User::where('role', 'rider')->firstOrFail();
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    // Book S1 for this trip
    $s1Id = $trip->vehicle->seats->where('seat_number', 'S1')->first()->id;
    $namurStop = $trip->route->stops->where('stop_sequence', 0)->first();
    $yongeStop = $trip->route->stops->where('stop_sequence', 2)->first();

    $booking = $bookingService->createBooking([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yongeStop->id,
        'vehicle_seat_ids' => [$s1Id],
    ], $passenger);

    $response = $this->actingAs($rider)
        ->get(route('rider.trips.manifest', $trip));

    $response->assertOk()
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Yonge Station')
        ->assertSee($passenger->name)
        ->assertSee('S1')
        ->assertSee($booking->booking_reference)
        ->assertSee('tel:'.$passenger->phone)
        ->assertSee('Expected Cash')
        ->assertSee('Pending Cash')
        ->assertSee('Collect CAD $65.00');
});

test('assigned rider can check in a passenger physically boarding the vehicle', function () {
    $tripService = app(TripService::class);
    $bookingService = app(BookingService::class);
    $rider = User::where('role', 'rider')->firstOrFail();
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    $s1Id = $trip->vehicle->seats->where('seat_number', 'S1')->first()->id;
    $namurStop = $trip->route->stops->where('stop_sequence', 0)->first();
    $yongeStop = $trip->route->stops->where('stop_sequence', 2)->first();

    $booking = $bookingService->createBooking([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yongeStop->id,
        'vehicle_seat_ids' => [$s1Id],
    ], $passenger);

    expect($booking->isCheckedIn())->toBeFalse();

    $response = $this->actingAs($rider)
        ->post(route('rider.trips.bookings.check-in', [$trip, $booking]));

    $response->assertRedirect()
        ->assertSessionHas('status', "{$passenger->name} has checked in.");

    $freshBooking = $booking->fresh();
    expect($freshBooking->isCheckedIn())->toBeTrue();
    expect($freshBooking->checked_in_at)->not->toBeNull();
});

test('assigned rider can collect cash payment upon passenger boarding', function () {
    $tripService = app(TripService::class);
    $bookingService = app(BookingService::class);
    $rider = User::where('role', 'rider')->firstOrFail();
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    $s1Id = $trip->vehicle->seats->where('seat_number', 'S1')->first()->id;
    $namurStop = $trip->route->stops->where('stop_sequence', 0)->first();
    $yongeStop = $trip->route->stops->where('stop_sequence', 2)->first();

    $booking = $bookingService->createBooking([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yongeStop->id,
        'vehicle_seat_ids' => [$s1Id],
    ], $passenger);

    $payment = $booking->payment;
    expect($payment->status)->toBe('unpaid');

    $response = $this->actingAs($rider)
        ->post(route('rider.trips.payments.collect', [$trip, $payment]));

    $response->assertRedirect()
        ->assertSessionHas('status', 'Cash payment of CAD $65.00 recorded successfully.');

    $freshPayment = $payment->fresh();
    expect($freshPayment->status)->toBe('paid');
    expect($freshPayment->collected_by)->toBe($rider->id);
    expect($freshPayment->collected_at)->not->toBeNull();
});

test('cannot collect cash twice on an already paid booking payment', function () {
    $tripService = app(TripService::class);
    $bookingService = app(BookingService::class);
    $rider = User::where('role', 'rider')->firstOrFail();
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    $s1Id = $trip->vehicle->seats->where('seat_number', 'S1')->first()->id;
    $namurStop = $trip->route->stops->where('stop_sequence', 0)->first();
    $yongeStop = $trip->route->stops->where('stop_sequence', 2)->first();

    $booking = $bookingService->createBooking([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yongeStop->id,
        'vehicle_seat_ids' => [$s1Id],
    ], $passenger);

    $payment = $booking->payment;

    // First collection succeeds
    $this->actingAs($rider)
        ->post(route('rider.trips.payments.collect', [$trip, $payment]))
        ->assertRedirect()
        ->assertSessionHas('status');

    // Second collection returns error flash
    $this->actingAs($rider)
        ->post(route('rider.trips.payments.collect', [$trip, $payment]))
        ->assertRedirect()
        ->assertSessionHas('error', 'Cash payment has already been collected for this booking.');
});

test('assigned rider can update trip lifecycle status from scheduled to in_progress to completed', function () {
    $tripService = app(TripService::class);
    $rider = User::where('role', 'rider')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    expect($trip->status)->toBe('scheduled');

    // Start trip
    $this->actingAs($rider)
        ->patch(route('rider.trips.status', $trip), [
            'status' => 'in_progress',
        ])
        ->assertRedirect()
        ->assertSessionHas('status', "Trip run #{$trip->id} is now In Progress (Trip Started).");

    expect($trip->fresh()->status)->toBe('in_progress');

    // Complete trip
    $this->actingAs($rider)
        ->patch(route('rider.trips.status', $trip), [
            'status' => 'completed',
        ])
        ->assertRedirect()
        ->assertSessionHas('status', "Trip run #{$trip->id} is now Completed.");

    expect($trip->fresh()->status)->toBe('completed');
});

test('unassigned rider cannot collect payment or check in booking on another drivers trip (IDOR)', function () {
    $tripService = app(TripService::class);
    $bookingService = app(BookingService::class);
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $testDate = Carbon::now('America/Toronto')->addDays(7)->toDateString();
    $trip = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $testDate);

    $s1Id = $trip->vehicle->seats->where('seat_number', 'S1')->first()->id;
    $namurStop = $trip->route->stops->where('stop_sequence', 0)->first();
    $yongeStop = $trip->route->stops->where('stop_sequence', 2)->first();

    $booking = $bookingService->createBooking([
        'trip_id' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yongeStop->id,
        'vehicle_seat_ids' => [$s1Id],
    ], $passenger);

    $otherRider = User::factory()->create([
        'role' => 'rider',
        'name' => 'Foreign Driver',
        'email' => 'foreign.driver@pickmeroute.com',
    ]);

    // Check-in rejected
    $this->actingAs($otherRider)
        ->post(route('rider.trips.bookings.check-in', [$trip, $booking]))
        ->assertForbidden();

    // Payment collection rejected
    $this->actingAs($otherRider)
        ->post(route('rider.trips.payments.collect', [$trip, $booking->payment]))
        ->assertForbidden();
});
