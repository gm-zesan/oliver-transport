<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

test('login page does not display forgot password option', function (): void {
    $this->get(route('login'))
        ->assertOk()
        ->assertDontSee('Forgot password?')
        ->assertDontSee('forgot-password');

    expect(Route::has('password.request'))->toBeFalse();
});

test('forgot and reset password routes are disabled', function (): void {
    $this->get('/forgot-password')->assertNotFound();
    $this->post('/forgot-password', ['email' => 'passenger@example.com'])->assertNotFound();
    $this->get('/reset-password/test-token')->assertNotFound();
    $this->post('/reset-password', [
        'token' => 'test-token',
        'email' => 'passenger@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNotFound();
});
