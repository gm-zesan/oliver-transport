<?php

use App\Models\User;
use Illuminate\Database\Eloquent\MassAssignmentException;

test('user model role helpers correctly identify user roles', function () {
    $passenger = new User(['name' => 'Passenger', 'email' => 'p@test.com', 'phone' => '123']);
    $passenger->role = 'passenger';

    expect($passenger->isPassenger())->toBeTrue();
    expect($passenger->isRider())->toBeFalse();
    expect($passenger->isOperator())->toBeFalse();
    expect($passenger->hasRole('passenger'))->toBeTrue();
    expect($passenger->hasRole(['passenger', 'rider']))->toBeTrue();

    $rider = new User(['name' => 'Rider', 'email' => 'r@test.com', 'phone' => '456']);
    $rider->role = 'rider';

    expect($rider->isRider())->toBeTrue();
    expect($rider->isPassenger())->toBeFalse();
    expect($rider->isOperator())->toBeFalse();
    expect($rider->hasRole('rider'))->toBeTrue();

    $operator = new User(['name' => 'Operator', 'email' => 'o@test.com', 'phone' => '789']);
    $operator->role = 'operator';

    expect($operator->isOperator())->toBeTrue();
    expect($operator->isPassenger())->toBeFalse();
    expect($operator->isRider())->toBeFalse();
    expect($operator->hasRole('operator'))->toBeTrue();
});

test('user role cannot be mass-assigned for security', function () {
    expect(function () {
        new User([
            'name' => 'Attacker',
            'email' => 'attacker@test.com',
            'phone' => '1234567890',
            'password' => 'secret1234',
            'role' => 'operator', // attempting privilege escalation
        ]);
    })->toThrow(MassAssignmentException::class);
});
