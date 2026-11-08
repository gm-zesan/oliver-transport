<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('unauthenticated guest is redirected to login when accessing rider dashboard', function () {
    $this->get(route('rider.dashboard'))
        ->assertRedirect(route('login'));
});

test('passenger cannot access rider dashboard and receives 403 forbidden', function () {
    $passenger = User::where('role', 'passenger')->firstOrFail();

    $this->actingAs($passenger)
        ->get(route('rider.dashboard'))
        ->assertForbidden();
});

test('authenticated rider can access dashboard and view assigned daily runs and fleet details', function () {
    $rider = User::where('role', 'rider')->firstOrFail();
    $today = Carbon::now('America/Toronto');

    $response = $this->actingAs($rider)
        ->get(route('rider.dashboard'));

    $response->assertOk()
        ->assertSee('Welcome, Jean-Luc Chauffeur')
        ->assertSee('RAJIA')
        ->assertSee('Honda Odyssey')
        ->assertSee('Montreal ↔ Toronto')
        ->assertSee('Route A • Daily Service')
        ->assertSee('Route B • Daily Service')
        ->assertSee('Open Passenger Boarding Roster')
        ->assertSee($today->format('M j, Y'));
});

test('rider can view runs for a specific future or past date via date filter', function () {
    $rider = User::where('role', 'rider')->firstOrFail();
    $tomorrow = Carbon::now('America/Toronto')->addDay();

    $response = $this->actingAs($rider)
        ->get(route('rider.dashboard', ['date' => $tomorrow->toDateString()]));

    $response->assertOk()
        ->assertSee('Previewing: '.$tomorrow->format('M j, Y'))
        ->assertSee('Open Passenger Boarding Roster');
});

test('role restriction modal markup is rendered on the page for non-passenger users', function () {
    $rider = User::where('role', 'rider')->firstOrFail();

    $this->actingAs($rider)
        ->get(route('rider.dashboard'))
        ->assertOk()
        ->assertSee('role-restriction-modal')
        ->assertSee('Driver Account Active')
        ->assertSee('Shuttle Booking Unavailable')
        ->assertSee('Sign in as Passenger');
});
