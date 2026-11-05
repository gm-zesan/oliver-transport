<?php

declare(strict_types=1);

use App\Enums\StopType;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Trip;
use App\Models\User;
use App\Services\Trip\TripService;
use Database\Seeders\CouponSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\PricingSettingSeeder;
use Database\Seeders\RouteSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\VehicleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed([
        LocationSeeder::class,
        VehicleSeeder::class,
        RouteSeeder::class,
        ScheduleSeeder::class,
        CouponSeeder::class,
        PricingSettingSeeder::class,
    ]);

    $this->passengerA = User::factory()->passenger()->create([
        'name' => 'Jean-Pierre Tremblay',
        'email' => 'jp.tremblay@example.com',
        'phone' => '514-555-0188',
    ]);

    $this->passengerB = User::factory()->passenger()->create([
        'name' => 'David Miller',
        'email' => 'david.m@example.com',
        'phone' => '416-555-0199',
    ]);
});

test('complete passenger end-to-end booking lifecycle simulation with real-time seat locks and digital pass', function (): void {
    $travelDate = now()->addDays(2)->format('Y-m-d');

    // 1. Unauthenticated guest attempts to book directly via POST -> 401 Unauthorized
    $trip = app(TripService::class)->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $travelDate);
    $namurStop = $trip->route->stops->firstWhere('stop_type', StopType::Origin);
    $yorkdaleStop = $trip->route->stops->firstWhere('stop_type', StopType::Intermediate);
    $seats = $trip->vehicle->bookableSeats->sortBy('seat_number')->values();

    $guestResponse = $this->postJson(route('passenger.bookings.store'), [
        'trip_id' => $trip->id,
        'vehicle_seat_ids' => [$seats[0]->id],
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yorkdaleStop->id,
    ]);
    $guestResponse->assertStatus(401);

    // 2. Query available trips API (Step 1)
    $searchResponse = $this->actingAs($this->passengerA)->getJson(route('api.trips.available', [
        'pickup' => 'namur',
        'dropoff' => 'yorkdale',
        'date' => $travelDate,
    ]));
    $searchResponse->assertOk()
        ->assertJsonPath('trips.0.route.direction_code', 'MTL_TO_TOR');

    // 3. Query real-time seat availability (Step 2) -> All 6 bookable seats available initially
    $seatResponse = $this->actingAs($this->passengerA)->getJson(route('api.trips.seats', [
        'trip' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yorkdaleStop->id,
    ]));
    $seatResponse->assertOk();
    $availableSeats = collect($seatResponse->json('seats'))->where('is_available', true);
    expect($availableSeats)->toHaveCount(6);

    // 4. Validate promotional coupon code LAUNCH10 (Step 3) for 2 seats
    $couponResponse = $this->actingAs($this->passengerA)->postJson(route('api.coupons.validate'), [
        'code' => 'LAUNCH10',
        'trip_id' => $trip->id,
        'seat_count' => 2,
    ]);
    $couponResponse->assertOk()
        ->assertJson([
            'is_valid' => true,
            'code' => 'LAUNCH10',
            'discount_type' => 'fixed',
            'discount_value' => 10,
            'discount_amount' => 20, // $10 per seat * 2 seats
            'gross_fare' => 130,     // $65 * 2
            'final_fare' => 110,     // $130 - $20 = $110
        ]);

    // 5. Submit confirmed reservation for 2 seats (S1 & S2)
    $idempotencyKey = (string) str()->uuid();
    $bookingResponse = $this->actingAs($this->passengerA)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $trip->id,
        'vehicle_seat_ids' => [$seats[0]->id, $seats[1]->id],
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yorkdaleStop->id,
        'coupon_code' => 'LAUNCH10',
        'idempotency_key' => $idempotencyKey,
    ]);

    $bookingResponse->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'booking_reference',
            'redirect_url',
            'message',
        ]);

    $bookingRef = $bookingResponse->json('booking_reference');
    $booking = Booking::where('booking_reference', $bookingRef)->firstOrFail();

    expect($booking->user_id)->toBe($this->passengerA->id)
        ->and($booking->seat_count)->toBe(2)
        ->and((float) $booking->base_fare)->toBe(130.00)
        ->and((float) $booking->discount_amount)->toBe(20.00)
        ->and((float) $booking->final_fare)->toBe(110.00)
        ->and($booking->status)->toBe('confirmed')
        ->and($booking->payment_status)->toBe('unpaid');

    // 6. Verify payments record exists with cash on boarding and unpaid status
    $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
    expect((float) $payment->amount)->toBe(110.00)
        ->and($payment->currency)->toBe('CAD')
        ->and($payment->payment_method)->toBe('cash')
        ->and($payment->status)->toBe('unpaid')
        ->and($payment->collected_by)->toBeNull();

    // 7. Re-check seat availability for passenger B on the same trip segment -> S1 & S2 are now LOCKED
    $seatResponseAfter = $this->actingAs($this->passengerB)->getJson(route('api.trips.seats', [
        'trip' => $trip->id,
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yorkdaleStop->id,
    ]));

    $seatsStatus = collect($seatResponseAfter->json('seats'));
    $seat1Status = $seatsStatus->firstWhere('seat_number', $seats[0]->seat_number);
    $seat2Status = $seatsStatus->firstWhere('seat_number', $seats[1]->seat_number);
    $seat3Status = $seatsStatus->firstWhere('seat_number', $seats[2]->seat_number);

    expect($seat1Status['is_available'])->toBeFalse()
        ->and($seat2Status['is_available'])->toBeFalse()
        ->and($seat3Status['is_available'])->toBeTrue();

    // 8. Passenger B attempts to book seat S1 -> Concurrency rejection HTTP 409 SEAT_UNAVAILABLE
    $conflictResponse = $this->actingAs($this->passengerB)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $trip->id,
        'vehicle_seat_ids' => [$seats[0]->id],
        'boarding_stop_id' => $namurStop->id,
        'dropoff_stop_id' => $yorkdaleStop->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $conflictResponse->assertStatus(409)
        ->assertJson([
            'success' => false,
            'error' => 'SEAT_UNAVAILABLE',
        ]);

    // 9. Passenger A views digital boarding pass voucher
    $voucherResponse = $this->actingAs($this->passengerA)->get(route('passenger.bookings.show', $bookingRef));
    $voucherResponse->assertOk()
        ->assertSee($bookingRef)
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('$110.00 CAD')
        ->assertSee('Cash Payment Settlement Upon Boarding')
        ->assertSee('Boarding Pass')
        ->assertSee('Print Pass');

    // 10. Passenger A views My Bookings list & Passenger Dashboard
    $historyResponse = $this->actingAs($this->passengerA)->get(route('passenger.bookings.index'));
    $historyResponse->assertOk()
        ->assertSee($bookingRef)
        ->assertSee('$110.00 CAD');

    $dashResponse = $this->actingAs($this->passengerA)->get(route('passenger.dashboard'));
    $dashResponse->assertOk()
        ->assertSee($bookingRef);
});
