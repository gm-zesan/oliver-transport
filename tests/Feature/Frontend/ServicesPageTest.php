<?php

declare(strict_types=1);

use App\Models\PricingSetting;
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
});

test('services page loads successfully with 200 OK', function (): void {
    $response = $this->get(route('services'));

    $response->assertOk()
        ->assertSee('Intercity Shuttle Services')
        ->assertSee('OUR CORRIDOR SERVICES')
        ->assertSee('Montreal → Toronto')
        ->assertSee('Toronto → Montreal')
        ->assertSee('6 Passenger Seats')
        ->assertSee('Honda Odyssey')
        ->assertSee('RAJIA');
});

test('services page dynamically updates fare from database pricing setting', function (): void {
    PricingSetting::where('key', 'regular_fare')->update(['amount' => 75.00]);

    $response = $this->get(route('services'));

    $response->assertOk()
        ->assertSee('$75')
        ->assertSee('Flat rate of $75 CAD');
});

test('header and footer link to services page', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(route('services'));
});

test('services page includes authentication modal and seat picker modal globally', function (): void {
    $response = $this->get(route('services'));

    $response->assertOk()
        ->assertSee('id="auth-booking-modal"', false)
        ->assertSee('id="seat-picker-modal"', false)
        ->assertSee('handleGlobalBookNow', false);
});
