<?php

use App\Models\User;

test('unauthenticated users are redirected to login when accessing role dashboards', function () {
    $this->get(route('passenger.dashboard'))->assertRedirect(route('login'));
    $this->get(route('rider.dashboard'))->assertRedirect(route('login'));
    $this->get(route('operator.dashboard'))->assertRedirect(route('login'));
});

test('passenger can access passenger dashboard', function () {
    $passenger = User::factory()->passenger()->create();

    $this->actingAs($passenger)
        ->get(route('passenger.dashboard'))
        ->assertOk()
        ->assertSee('Passenger Portal')
        ->assertSee($passenger->name);
});

test('passenger cannot access rider or operator dashboards', function () {
    $passenger = User::factory()->passenger()->create();

    $this->actingAs($passenger)
        ->get(route('rider.dashboard'))
        ->assertForbidden();

    $this->actingAs($passenger)
        ->get(route('operator.dashboard'))
        ->assertForbidden();
});

test('rider can access rider dashboard', function () {
    $rider = User::factory()->rider()->create();

    $this->actingAs($rider)
        ->get(route('rider.dashboard'))
        ->assertOk()
        ->assertSee('Driver Operational Panel')
        ->assertSee('Honda Odyssey')
        ->assertSee($rider->name);
});

test('rider cannot access passenger or operator dashboards', function () {
    $rider = User::factory()->rider()->create();

    $this->actingAs($rider)
        ->get(route('passenger.dashboard'))
        ->assertForbidden();

    $this->actingAs($rider)
        ->get(route('operator.dashboard'))
        ->assertForbidden();
});

test('operator can access operator dashboard', function () {
    $operator = User::factory()->operator()->create();

    $this->actingAs($operator)
        ->get(route('operator.dashboard'))
        ->assertOk()
        ->assertSee('System Operator Portal')
        ->assertSee($operator->name);
});

test('operator cannot access passenger or rider dashboards without explicit role', function () {
    $operator = User::factory()->operator()->create();

    $this->actingAs($operator)
        ->get(route('passenger.dashboard'))
        ->assertForbidden();

    $this->actingAs($operator)
        ->get(route('rider.dashboard'))
        ->assertForbidden();
});
