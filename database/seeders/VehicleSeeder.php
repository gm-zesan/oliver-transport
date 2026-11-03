<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleSeat;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Seed fleet vehicles and predefined physical cabin seats.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'plate_number' => 'RAJIA',
                'model' => 'Honda Odyssey (Commercial 6-Passenger Shuttle)',
                'passenger_capacity' => 6,
                'is_active' => true,
                'seats' => [
                    ['seat_number' => 'DRIVER', 'cabin_position' => 'front_driver', 'is_driver_seat' => true],
                    ['seat_number' => 'S1', 'cabin_position' => 'front_passenger', 'is_driver_seat' => false],
                    ['seat_number' => 'S2', 'cabin_position' => 'rear', 'is_driver_seat' => false],
                    ['seat_number' => 'S3', 'cabin_position' => 'rear', 'is_driver_seat' => false],
                    ['seat_number' => 'S4', 'cabin_position' => 'rear', 'is_driver_seat' => false],
                    ['seat_number' => 'S5', 'cabin_position' => 'rear', 'is_driver_seat' => false],
                    ['seat_number' => 'S6', 'cabin_position' => 'rear', 'is_driver_seat' => false],
                ],
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            $vehicle = Vehicle::firstOrCreate(
                ['plate_number' => $vehicleData['plate_number']],
                [
                    'model' => $vehicleData['model'],
                    'passenger_capacity' => $vehicleData['passenger_capacity'],
                    'is_active' => $vehicleData['is_active'],
                ]
            );

            foreach ($vehicleData['seats'] as $seatData) {
                VehicleSeat::firstOrCreate(
                    [
                        'vehicle_id' => $vehicle->id,
                        'seat_number' => $seatData['seat_number'],
                    ],
                    [
                        'cabin_position' => $seatData['cabin_position'],
                        'is_driver_seat' => $seatData['is_driver_seat'],
                    ]
                );
            }
        }
    }
}
