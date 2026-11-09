<?php

use App\Models\User;

test('passenger registration page renders successfully for guests', function () {
    $response = $this->get(route('register'));

    $response->assertOk()
        ->assertSee('Create Passenger Account')
        ->assertSee('Create your account to book your seats.');
});

test('new passenger can register and is redirected to passenger dashboard', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Passenger',
        'email' => 'john.passenger@example.com',
        'phone' => '647-555-1234',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $this->assertAuthenticated();
    $user = User::where('email', 'john.passenger@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('passenger');
    expect($user->name)->toBe('John Passenger');
    expect($user->phone)->toBe('647-555-1234');

    $response->assertRedirect(route('passenger.bookings.index'));
});

test('new passenger can register without phone number', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Alice No Phone',
        'email' => 'alice.nophone@example.com',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $this->assertAuthenticated();
    $user = User::where('email', 'alice.nophone@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('passenger');
    expect($user->name)->toBe('Alice No Phone');

    $response->assertRedirect(route('passenger.bookings.index'));
});

test('passenger registration fails when email is already registered', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post(route('register.store'), [
        'name' => 'Jane Duplicate',
        'email' => 'existing@example.com',
        'phone' => '647-555-9999',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('passenger registration fails when passwords do not match', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Jane Mismatch',
        'email' => 'jane.mismatch@example.com',
        'phone' => '647-555-8888',
        'password' => 'secret1234',
        'password_confirmation' => 'different-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('password');
});
