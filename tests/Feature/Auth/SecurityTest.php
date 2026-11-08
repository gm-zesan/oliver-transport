<?php

use App\Models\User;

test('passenger registration rejects role mass-assignment and defaults to passenger', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Security Tester',
        'email' => 'tester@example.com',
        'phone' => '5145550199',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
        'role' => 'operator', // Attempt privilege escalation
    ]);

    $response->assertRedirect(route('passenger.bookings.index'));

    $user = User::where('email', 'tester@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe('passenger');
});

test('intended redirect to restricted dashboard cannot bypass role authorization', function () {
    $passenger = User::factory()->passenger()->create([
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    // Guest attempts to visit rider dashboard, which sets session intended URL
    $guestResponse = $this->get(route('rider.dashboard'));
    $guestResponse->assertRedirect(route('login'));

    // Authenticate as a passenger
    $loginResponse = $this->post(route('login.store'), [
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    // Login redirects to intended URL (/rider/dashboard)
    $loginResponse->assertRedirect(route('rider.dashboard'));

    // Following redirect to /rider/dashboard as passenger must return HTTP 403 Forbidden
    $dashboardResponse = $this->get(route('rider.dashboard'));
    $dashboardResponse->assertForbidden();
});

test('intended redirect to operator dashboard is blocked for passenger', function () {
    $passenger = User::factory()->passenger()->create([
        'email' => 'passenger2@example.com',
        'password' => 'secret1234',
    ]);

    // Guest attempts to visit operator dashboard
    $this->get(route('operator.dashboard'))->assertRedirect(route('login'));

    // Log in as passenger
    $loginResponse = $this->post(route('login.store'), [
        'email' => 'passenger2@example.com',
        'password' => 'secret1234',
    ]);

    $loginResponse->assertRedirect(route('operator.dashboard'));

    // Operator dashboard access forbidden for passenger
    $this->get(route('operator.dashboard'))->assertForbidden();
});

test('session ID regenerates upon successful login to mitigate session fixation', function () {
    $user = User::factory()->passenger()->create([
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    $this->get(route('login'));
    $previousSessionId = session()->getId();

    $this->post(route('login.store'), [
        'email' => 'passenger@example.com',
        'password' => 'secret1234',
    ]);

    $newSessionId = session()->getId();
    expect($newSessionId)->not->toBe($previousSessionId);
});

test('session ID regenerates upon registration', function () {
    $this->get(route('register'));
    $previousSessionId = session()->getId();

    $this->post(route('register.store'), [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'phone' => '5145550188',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $newSessionId = session()->getId();
    expect($newSessionId)->not->toBe($previousSessionId);
});

test('session is invalidated upon logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $sessionIdBeforeLogout = session()->getId();

    $response = $this->post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
    expect(session()->getId())->not->toBe($sessionIdBeforeLogout);
});
