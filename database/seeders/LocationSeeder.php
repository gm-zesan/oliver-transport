<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Seed predefined physical station hubs.
     */
    public function run(): void
    {
        $locations = [
            [
                'code' => 'namur',
                'name' => 'Station Métro Namur',
                'city' => 'Montreal',
                'province' => 'QC',
                'address' => 'Station Métro Namur, Décarie Blvd, Montreal, QC',
                'subtitle' => 'Montreal • Fixed Morning Departure',
                'dropoff_subtitle' => 'Montreal • Final Drop-off',
            ],
            [
                'code' => 'yorkdale',
                'name' => 'Yorkdale Mall',
                'city' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yorkdale Shopping Centre (Pick-up Bay), Toronto, ON',
                'subtitle' => 'Toronto • 1st Pickup (Hwy 401 & TTC)',
                'dropoff_subtitle' => 'Toronto • 1st Drop-off',
            ],
            [
                'code' => 'yonge',
                'name' => 'Yonge Station',
                'city' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yonge Subway Station Terminal, Toronto, ON',
                'subtitle' => 'Toronto • 2nd Pickup (Subway Terminal)',
                'dropoff_subtitle' => 'Toronto • 2nd Drop-off',
            ],
        ];

        foreach ($locations as $data) {
            Location::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'city' => $data['city'],
                    'province' => $data['province'],
                    'address' => $data['address'],
                    'subtitle' => $data['subtitle'],
                    'dropoff_subtitle' => $data['dropoff_subtitle'],
                ]
            );
        }
    }
}
