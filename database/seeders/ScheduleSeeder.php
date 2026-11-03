<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Seed recurring timetable schedules.
     */
    public function run(): void
    {
        $schedules = [
            [
                'route_direction_code' => 'MTL_TO_TOR',
                'vehicle_plate' => 'RAJIA',
                'departure_time' => '06:30:00',
                'days_of_week' => 'all',
                'is_active' => true,
            ],
            [
                'route_direction_code' => 'TOR_TO_MTL',
                'vehicle_plate' => 'RAJIA',
                'departure_time' => '12:15:00',
                'days_of_week' => 'all',
                'is_active' => true,
            ],
        ];

        foreach ($schedules as $data) {
            $route = Route::where('direction_code', $data['route_direction_code'])->firstOrFail();
            $vehicle = Vehicle::where('plate_number', $data['vehicle_plate'])->firstOrFail();

            Schedule::firstOrCreate(
                [
                    'route_id' => $route->id,
                    'vehicle_id' => $vehicle->id,
                    'departure_time' => $data['departure_time'],
                ],
                [
                    'days_of_week' => $data['days_of_week'],
                    'is_active' => $data['is_active'],
                ]
            );
        }
    }
}
