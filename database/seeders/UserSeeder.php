<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates deterministic login test accounts for all 3 system roles.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // 1. Operator Account (Administration, schedules, manifests, fleet)
        User::firstOrCreate(
            ['email' => 'operator@olivertransport.ca'],
            [
                'name' => 'Oliver Dispatch Operator',
                'phone' => '647-655-1884',
                'password' => $defaultPassword,
                'role' => 'operator',
                'email_verified_at' => now(),
            ]
        );

        // 2. Rider / Driver Account (Trip manifest, passenger check-in, cash collection)
        User::firstOrCreate(
            ['email' => 'rider@olivertransport.ca'],
            [
                'name' => 'Jean-Luc Chauffeur',
                'phone' => '514-555-0199',
                'password' => $defaultPassword,
                'role' => 'rider',
                'email_verified_at' => now(),
            ]
        );

        // 3. Passenger Account (Intercity seat booking, reservation history)
        User::firstOrCreate(
            ['email' => 'passenger@olivertransport.ca'],
            [
                'name' => 'Sarah Jenkins',
                'phone' => '416-555-0144',
                'password' => $defaultPassword,
                'role' => 'passenger',
                'email_verified_at' => now(),
            ]
        );
    }
}
