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

test('about page loads successfully with 200 OK', function (): void {
    $response = $this->get(route('about'));

    $response->assertOk()
        ->assertSee('Redefining Montreal ↔ Toronto Travel')
        ->assertSee('ABOUT PICKMEROUTE')
        ->assertSee('Why Select Us for Your Journey')
        ->assertSee('Station Métro Namur')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Yonge Station')
        ->assertSee('Honda Odyssey')
        ->assertSee('RAJIA');
});

test('about page dynamically updates fare guarantee from database pricing setting', function (): void {
    PricingSetting::where('key', 'regular_fare')->update(['amount' => 75.00]);

    $response = $this->get(route('about'));

    $response->assertOk()
        ->assertSee('Guaranteed flat fare of $75 CAD per passenger per trip');
});

test('header and footer link to about page', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(route('about'));
});

test('about page includes authentication modal and seat picker modal globally', function (): void {
    $response = $this->get(route('about'));

    $response->assertOk()
        ->assertSee('id="auth-booking-modal"', false)
        ->assertSee('id="seat-picker-modal"', false)
        ->assertSee('handleGlobalBookNow', false);
});
