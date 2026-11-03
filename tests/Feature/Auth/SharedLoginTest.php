<?php

use App\Models\User;

test('shared unified login page renders successfully for guests', function () {
    $response = $this->get(route('login'));

    $response->assertOk()
        ->assertSee('Sign in to Oliver Transport')
        ->assertSee('One portal for Passengers, Riders, and Operators');
});

test('passenger logs in through shared login and redirects to passenger dashboard', function () {
    $passenger = User::factory()->passenger()->create([
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    $this->assertAuthenticatedAs($passenger);
    $response->assertRedirect(route('passenger.dashboard'));
});

test('rider logs in through shared login and redirects to rider dashboard', function () {
    $rider = User::factory()->rider()->create([
        'email' => 'driver@example.com',
        'password' => 'secret1234',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'driver@example.com',
        'password' => 'secret1234',
    ]);

    $this->assertAuthenticatedAs($rider);
    $response->assertRedirect(route('rider.dashboard'));
});

test('operator logs in through shared login and redirects to operator dashboard', function () {
    $operator = User::factory()->operator()->create([
        'email' => 'operator@example.com',
        'password' => 'secret1234',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'operator@example.com',
        'password' => 'secret1234',
    ]);

    $this->assertAuthenticatedAs($operator);
    $response->assertRedirect(route('operator.dashboard'));
});

test('users cannot authenticate with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'passenger@example.com',
        'password' => 'correct-password',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'passenger@example.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('login requests are rate limited after 5 failed attempts', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->post(route('login.store'), [
            'email' => 'spammer@example.com',
            'password' => 'wrong-pass',
        ]);
    }

    $response = $this->from(route('login'))->post(route('login.store'), [
        'email' => 'spammer@example.com',
        'password' => 'wrong-pass',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $errors = session('errors')->get('email');
    expect($errors[0])->toContain('Too many login attempts');
});

test('authenticated user can log out and is redirected to login', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});
