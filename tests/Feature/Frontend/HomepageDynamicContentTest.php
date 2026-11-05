<?php

declare(strict_types=1);

use App\Models\Coupon;
use App\Models\Location;
use App\Models\PricingSetting;
use App\Models\Route;
use App\Models\Vehicle;
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

test('homepage loads successfully with 200 OK and receives database models', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewHasAll([
        'regularFare',
        'promotionalFare',
        'routes',
        'locations',
        'vehicle',
        'promotionalCoupons',
        'clientStations',
        'clientRoutes',
    ]);
});

test('homepage dynamically displays station hubs from database', function (): void {
    $locations = Location::all();
    expect($locations)->toHaveCount(3);

    $response = $this->get(route('home'));

    $response->assertOk();
    foreach ($locations as $location) {
        $response->assertSee($location->name);
        $response->assertSee($location->city);
    }
});

test('homepage dynamically displays active routes and schedules from database', function (): void {
    $routes = Route::with('stops.location')->where('is_active', true)->get();
    expect($routes)->toHaveCount(2);

    $response = $this->get(route('home'));

    $response->assertOk();
    foreach ($routes as $route) {
        $response->assertSee($route->name);
    }
});

test('homepage dynamically displays vehicle fleet details from database', function (): void {
    $vehicle = Vehicle::where('plate_number', 'RAJIA')->first();
    expect($vehicle)->not->toBeNull();

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee($vehicle->model)
        ->assertSee($vehicle->plate_number)
        ->assertSee("{$vehicle->passenger_capacity} Passenger Seats");
});

test('homepage dynamically updates regular fare when database pricing setting changes', function (): void {
    PricingSetting::where('key', 'regular_fare')->update(['amount' => 75.00]);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('$75 CAD')
        ->assertSee('Guaranteed flat fare of $75 CAD per passenger per trip');
});

test('homepage dynamically renders promotional coupons from database when is_show is true', function (): void {
    $coupons = Coupon::where('is_active', true)->where('is_show', true)->get();
    expect($coupons)->toHaveCount(1);

    $response = $this->get(route('home'));

    $response->assertOk();
    foreach ($coupons as $coupon) {
        $response->assertSee($coupon->code);
        if ($coupon->headline) {
            $response->assertSee($coupon->headline);
        }
    }
});

test('homepage hides coupon section when is_show is false but coupon remains active for booking', function (): void {
    $coupon = Coupon::where('code', 'LAUNCH10')->first();
    $coupon->update(['is_show' => false]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewHas('promotionalCoupons', []);
    $response->assertDontSee('🔥 $10 OFF Launch Special');

    // Verify coupon is still active in database for booking
    expect($coupon->fresh()->is_active)->toBeTrue()
        ->and($coupon->fresh()->is_show)->toBeFalse();
});

test('homepage dynamically updates station departure times when database route_stops change', function (): void {
    $routeA = Route::where('direction_code', 'MTL_TO_TOR')->first();
    $originStop = $routeA->stops()->where('stop_type', 'origin')->first();

    // Update scheduled time in database
    $originStop->update(['scheduled_time' => '07:45:00']);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('7:45 AM')
        ->assertViewHas('routeATime', '7:45 AM');
});

test('homepage blade view contains zero domain calculation php blocks', function (): void {
    $viewContent = file_get_contents(resource_path('views/frontend/index.blade.php'));

    expect(str_contains($viewContent, '@php'))->toBeFalse();
});
