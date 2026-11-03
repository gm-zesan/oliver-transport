<?php

declare(strict_types=1);

use App\Models\User;

test('homepage returns 200 OK and renders semantic layout', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('<!DOCTYPE html>', false)
        ->assertSee('viewport-fit=cover', false)
        ->assertSee('csrf-token', false)
        ->assertSee('instrument-sans');
});

test('homepage features authentic oliver transport branding', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Ol')
        ->assertSee('iver')
        ->assertSee('Transport')
        ->assertSee('Montreal • Toronto • Montreal');
});

test('homepage accurately displays route a morning service details', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Route A')
        ->assertSee('Montreal → Toronto')
        ->assertSee('Station Métro Namur')
        ->assertSee('6:30 AM')
        ->assertSee('Yorkdale Mall')
        ->assertSee('Yonge Station');
});

test('homepage accurately displays route b afternoon service details without unconfirmed stations', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Route B')
        ->assertSee('Toronto → Montreal')
        ->assertSee('Yorkdale Mall')
        ->assertSee('12:15 PM')
        ->assertSee('Yonge Station')
        ->assertSee('1:15 PM')
        ->assertDontSee('Namur Station Drop-off Confirmed');
});

test('homepage displays confirmed standard fare of $65 cad with cash-on-boarding notice', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('$65')
        ->assertSee('CAD')
        ->assertSee('Cash Payment Upon Boarding')
        ->assertSee('Pay the driver directly in cash when boarding');
});

test('homepage features confirmed fleet profile with honda odyssey and plate rajia', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Honda Odyssey')
        ->assertSee('RAJIA')
        ->assertSee('6 Passenger Seats');
});

test('homepage publishes confirmed public contact channels', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('647-655-1884')
        ->assertSee('Oliver Transport');
});

test('homepage renders guest authentication call to actions for guests', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(route('login'))
        ->assertSee(route('register'))
        ->assertSee('Sign In')
        ->assertSee('Book Your Seat')
        ->assertSee('id="auth-booking-modal"', false)
        ->assertSee('Sign In to Book Your Seat')
        ->assertSee('id="label-pickup"', false)
        ->assertSee('id="label-destination"', false)
        ->assertSee('id="label-travel-date"', false);
});

test('homepage displays role-specific dashboard link for authenticated passenger', function () {
    $passenger = User::factory()->passenger()->create();

    $response = $this->actingAs($passenger)->get(route('home'));

    $response->assertOk()
        ->assertSee(route('passenger.dashboard'))
        ->assertSee('Dashboard')
        ->assertSee(route('logout'));
});

test('homepage displays role-specific dashboard link for authenticated rider', function () {
    $rider = User::factory()->rider()->create();

    $response = $this->actingAs($rider)->get(route('home'));

    $response->assertOk()
        ->assertSee(route('rider.dashboard'))
        ->assertSee('Dashboard');
});

test('homepage displays role-specific dashboard link for authenticated operator', function () {
    $operator = User::factory()->operator()->create();

    $response = $this->actingAs($operator)->get(route('home'));

    $response->assertOk()
        ->assertSee(route('operator.dashboard'))
        ->assertSee('Dashboard');
});
