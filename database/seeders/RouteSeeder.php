<?php

namespace Database\Seeders;

use App\Enums\StopType;
use App\Models\Location;
use App\Models\Route;
use App\Models\RouteStop;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Seed directional routes and ordered station sequences.
     */
    public function run(): void
    {
        $routes = [
            [
                'direction_code' => 'MTL_TO_TOR',
                'name' => 'Montreal → Toronto',
                'service_label' => 'Route A • Daily Service',
                'image_path' => 'images/service-intercity.jpg',
                'btn_key' => 'route-a',
                'is_active' => true,
                'stops' => [
                    [
                        'location_name' => 'Station Métro Namur',
                        'stop_sequence' => 0,
                        'scheduled_time' => '06:30:00',
                        'stop_type' => StopType::Origin,
                    ],
                    [
                        'location_name' => 'Yorkdale Mall',
                        'stop_sequence' => 1,
                        'scheduled_time' => '12:15:00',
                        'stop_type' => StopType::Intermediate,
                    ],
                    [
                        'location_name' => 'Yonge Station',
                        'stop_sequence' => 2,
                        'scheduled_time' => '13:15:00',
                        'stop_type' => StopType::Destination,
                    ],
                ],
            ],
            [
                'direction_code' => 'TOR_TO_MTL',
                'name' => 'Toronto → Montreal',
                'service_label' => 'Route B • Daily Service',
                'image_path' => 'images/service-corporate.jpg',
                'btn_key' => 'route-b',
                'is_active' => true,
                'stops' => [
                    [
                        'location_name' => 'Yorkdale Mall',
                        'stop_sequence' => 0,
                        'scheduled_time' => '12:15:00',
                        'stop_type' => StopType::Origin,
                    ],
                    [
                        'location_name' => 'Yonge Station',
                        'stop_sequence' => 1,
                        'scheduled_time' => '13:15:00',
                        'stop_type' => StopType::Intermediate,
                    ],
                    [
                        'location_name' => 'Station Métro Namur',
                        'stop_sequence' => 2,
                        'scheduled_time' => '19:15:00',
                        'stop_type' => StopType::Destination,
                    ],
                ],
            ],
        ];

        foreach ($routes as $routeData) {
            $route = Route::updateOrCreate(
                ['direction_code' => $routeData['direction_code']],
                [
                    'name' => $routeData['name'],
                    'service_label' => $routeData['service_label'],
                    'image_path' => $routeData['image_path'],
                    'btn_key' => $routeData['btn_key'],
                    'is_active' => $routeData['is_active'],
                ]
            );

            foreach ($routeData['stops'] as $stopData) {
                $location = Location::where('name', $stopData['location_name'])->firstOrFail();

                RouteStop::firstOrCreate(
                    [
                        'route_id' => $route->id,
                        'stop_sequence' => $stopData['stop_sequence'],
                    ],
                    [
                        'location_id' => $location->id,
                        'scheduled_time' => $stopData['scheduled_time'],
                        'stop_type' => $stopData['stop_type'],
                    ]
                );
            }
        }
    }
}
