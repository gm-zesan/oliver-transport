<?php

namespace App\Services\Passenger;

use App\Models\User;

class PassengerService
{
    /**
     * Register a new passenger user.
     *
     * @param  array{name: string, email: string, phone: string, password: string}  $data
     */
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);
    }
}
