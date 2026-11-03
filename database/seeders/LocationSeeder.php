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
                'name' => 'Station Métro Namur',
                'city' => 'Montreal',
                'province' => 'QC',
                'address' => 'Station Métro Namur, Décarie Blvd, Montreal, QC',
            ],
            [
                'name' => 'Yorkdale Mall',
                'city' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yorkdale Shopping Centre (Pick-up Bay), Toronto, ON',
            ],
            [
                'name' => 'Yonge Station',
                'city' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yonge Subway Station Terminal, Toronto, ON',
            ],
        ];

        foreach ($locations as $data) {
            Location::firstOrCreate(
                ['name' => $data['name']],
                [
                    'city' => $data['city'],
                    'province' => $data['province'],
                    'address' => $data['address'],
                ]
            );
        }
    }
}
