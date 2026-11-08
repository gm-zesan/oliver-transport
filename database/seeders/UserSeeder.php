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
        User::unguarded(function () {
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

            // 3. Passenger Accounts (Intercity seat booking, reservation history)
            $passengers = [
                [
                    'name' => 'Sarah Jenkins',
                    'email' => 'passenger@olivertransport.ca',
                    'phone' => '416-555-0144',
                ],
                [
                    'name' => 'Alexandre Tremblay',
                    'email' => 'alex.tremblay@gmail.com',
                    'phone' => '514-555-0112',
                ],
                [
                    'name' => 'Emily Chen',
                    'email' => 'emily.chen@outlook.com',
                    'phone' => '416-555-0189',
                ],
                [
                    'name' => 'Michael Ross',
                    'email' => 'michael.ross@yahoo.com',
                    'phone' => '647-555-0134',
                ],
                [
                    'name' => 'Sophie Laurent',
                    'email' => 'sophie.laurent@gmail.com',
                    'phone' => '514-555-0177',
                ],
                [
                    'name' => 'David Miller',
                    'email' => 'david.miller@gmail.com',
                    'phone' => '416-555-0163',
                ],
                [
                    'name' => 'Fatima Zahra',
                    'email' => 'fatima.zahra@gmail.com',
                    'phone' => '514-555-0125',
                ],
            ];

            foreach ($passengers as $p) {
                User::firstOrCreate(
                    ['email' => $p['email']],
                    [
                        'name' => $p['name'],
                        'phone' => $p['phone'],
                        'password' => $defaultPassword,
                        'role' => 'passenger',
                        'email_verified_at' => now(),
                    ]
                );
            }
        });
    }
}
