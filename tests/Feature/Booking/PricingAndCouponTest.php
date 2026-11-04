<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\PricingSetting;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleSeat;
use App\Services\Pricing\PricingService;

beforeEach(function () {
    $this->vehicle = Vehicle::factory()->create(['plate_number' => 'RAJIA']);
    $this->seatS1 = VehicleSeat::factory()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S1', 'cabin_position' => 'front_passenger', 'is_driver_seat' => false]);
    $this->seatS2 = VehicleSeat::factory()->rearCabin()->create(['vehicle_id' => $this->vehicle->id, 'seat_number' => 'S2']);

    $this->locNamur = Location::factory()->create(['name' => 'Station Métro Namur']);
    $this->locYorkdale = Location::factory()->create(['name' => 'Yorkdale Mall']);
    $this->locYonge = Location::factory()->create(['name' => 'Yonge Station']);

    $this->route = Route::factory()->create(['direction_code' => 'MTL_TO_TOR']);

    $this->stop0 = RouteStop::factory()->create([
        'route_id' => $this->route->id,
        'location_id' => $this->locNamur->id,
        'stop_sequence' => 0,
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
    ]);

    $this->trip = Trip::factory()->create([
        'schedule_id' => $this->schedule->id,
        'route_id' => $this->route->id,
        'vehicle_id' => $this->vehicle->id,
        'trip_date' => now()->addDays(3)->format('Y-m-d'),
        'status' => 'scheduled',
    ]);

    $this->passenger = User::factory()->passenger()->create();
});

test('per-trip fare is strictly flat regardless of intermediate stop combinations', function () {
    $pricingService = app(PricingService::class);
    $unitFare = $pricingService->resolveUnitBaseFare();

    // Booking short hop: Montreal (0) -> Yorkdale (1)
    $resShort = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop1->id,
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $resShort->assertStatus(201);
    $bookingShort = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    expect((float) $bookingShort->base_fare)->toBe($unitFare);
    expect((float) $bookingShort->final_fare)->toBe($unitFare);
});

test('percentage coupon successfully applies discount under cap', function () {
    $coupon = Coupon::factory()->percentage(10)->create([
        'code' => 'SAVE10',
        'is_active' => true,
        'max_discount_amount' => 50.00,
    ]);

    $response = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id, $this->seatS2->id], // 2 seats
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'coupon_code' => 'SAVE10',
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $response->assertStatus(201);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    $unitFare = app(PricingService::class)->resolveUnitBaseFare();
    $expectedBase = $unitFare * 2;
    $expectedDiscount = round($expectedBase * 0.10, 2);
    $expectedFinal = $expectedBase - $expectedDiscount;

    expect((float) $booking->base_fare)->toBe($expectedBase);
    expect((float) $booking->discount_amount)->toBe($expectedDiscount);
    expect((float) $booking->final_fare)->toBe($expectedFinal);

    $this->assertDatabaseHas('coupon_usages', [
        'coupon_id' => $coupon->id,
        'booking_id' => $booking->id,
        'user_id' => $this->passenger->id,
    ]);
});

test('fixed amount coupon reduces final fare', function () {
    $coupon = Coupon::factory()->fixed(15.00)->create([
        'code' => 'PROMO15',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'coupon_code' => 'PROMO15',
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $response->assertStatus(201);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    $unitFare = app(PricingService::class)->resolveUnitBaseFare();
    expect((float) $booking->discount_amount)->toBe(15.00);
    expect((float) $booking->final_fare)->toBe($unitFare - 15.00);
});

test('launch10 promotional coupon reduces regular $65 fare to confirmed $55 promotional rate', function () {
    Coupon::factory()->fixed(10.00)->create([
        'code' => 'LAUNCH10',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'coupon_code' => 'LAUNCH10',
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $response->assertStatus(201);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    expect((float) $booking->base_fare)->toBe(65.00);
    expect((float) $booking->discount_amount)->toBe(10.00);
    expect((float) $booking->final_fare)->toBe(55.00);
});

test('launch10 promotional coupon applies $10 per seat discount on multi-seat reservations', function () {
    Coupon::factory()->fixed(10.00)->create([
        'code' => 'LAUNCH10',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id, $this->seatS2->id], // 2 seats
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'coupon_code' => 'LAUNCH10',
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $response->assertStatus(201);

    $booking = Booking::where('user_id', $this->passenger->id)->firstOrFail();
    expect((float) $booking->base_fare)->toBe(130.00); // 2 * $65
    expect((float) $booking->discount_amount)->toBe(20.00); // 2 * $10
    expect((float) $booking->final_fare)->toBe(110.00); // 2 * $55
});

test('coupon validation rejects expired or inactive code', function () {
    Coupon::factory()->create([
        'code' => 'EXPIRED',
        'is_active' => false,
    ]);

    $response = $this->actingAs($this->passenger)->postJson(route('passenger.bookings.store'), [
        'trip_id' => $this->trip->id,
        'vehicle_seat_ids' => [$this->seatS1->id],
        'boarding_stop_id' => $this->stop0->id,
        'dropoff_stop_id' => $this->stop2->id,
        'coupon_code' => 'EXPIRED',
        'idempotency_key' => (string) str()->uuid(),
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'error' => 'VALIDATION_FAILED',
        ]);
});

test('coupon validation api provides real-time prospective discount calculation', function () {
    Coupon::factory()->percentage(20)->create([
        'code' => 'FLASH20',
        'is_active' => true,
    ]);

    $response = $this->postJson(route('api.coupons.validate'), [
        'code' => 'FLASH20',
        'trip_id' => $this->trip->id,
        'seat_count' => 1,
    ]);

    $response->assertOk()
        ->assertJson([
            'is_valid' => true,
            'code' => 'FLASH20',
            'discount_type' => 'percentage',
            'discount_value' => 20,
        ]);
});

test('coupon validation api works when trip_id is omitted by using travel date', function () {
    Coupon::factory()->fixed(10)->create([
        'code' => 'TEST10',
        'is_active' => true,
    ]);

    $response = $this->postJson(route('api.coupons.validate'), [
        'code' => 'TEST10',
        'date' => '2026-11-10',
        'seat_count' => 2,
    ]);

    $response->assertOk()
        ->assertJson([
            'is_valid' => true,
            'code' => 'TEST10',
            'discount_amount' => 20,
        ]);
});

test('pricing service dynamically resolves fare from database pricing_settings', function () {
    PricingSetting::updateOrCreate(
        ['key' => 'regular_fare'],
        ['amount' => 75.00, 'currency' => 'CAD', 'is_active' => true]
    );

    $pricingService = app(PricingService::class);
    expect($pricingService->resolveUnitBaseFare())->toBe(75.00);
    expect($pricingService->calculateGrossBaseFare(2))->toBe(150.00);
});
