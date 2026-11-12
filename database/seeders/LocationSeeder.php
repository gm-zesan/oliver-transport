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
                'name_fr' => 'Station Métro Namur',
                'city' => 'Montreal',
                'city_fr' => 'Montréal',
                'province' => 'QC',
                'address' => 'Station Métro Namur, Décarie Blvd, Montreal, QC',
                'address_fr' => 'Station Métro Namur, boul. Décarie, Montréal, QC',
                'subtitle' => 'Montreal • Fixed Morning Departure',
                'subtitle_fr' => 'Montréal • Départ matinal fixe',
                'dropoff_subtitle' => 'Montreal • Final Drop-off',
                'dropoff_subtitle_fr' => 'Montréal • Arrivée finale',
            ],
            [
                'code' => 'yorkdale',
                'name' => 'Yorkdale Mall',
                'name_fr' => 'Centre commercial Yorkdale',
                'city' => 'Toronto',
                'city_fr' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yorkdale Shopping Centre (Pick-up Bay), Toronto, ON',
                'address_fr' => 'Centre commercial Yorkdale (Quai d’embarquement), Toronto, ON',
                'subtitle' => 'Toronto • 1st Pickup (Hwy 401 & TTC)',
                'subtitle_fr' => 'Toronto • 1er arrêt de ramassage (Autoroute 401 & TTC)',
                'dropoff_subtitle' => 'Toronto • 1st Drop-off',
                'dropoff_subtitle_fr' => 'Toronto • 1er arrêt de dépôt',
            ],
            [
                'code' => 'yonge',
                'name' => 'Yonge Station',
                'name_fr' => 'Station Yonge',
                'city' => 'Toronto',
                'city_fr' => 'Toronto',
                'province' => 'ON',
                'address' => 'Yonge Subway Station Terminal, Toronto, ON',
                'address_fr' => 'Terminus de métro Yonge, Toronto, ON',
                'subtitle' => 'Toronto • 2nd Pickup (Subway Terminal)',
                'subtitle_fr' => 'Toronto • 2e arrêt de ramassage (Terminus de métro)',
                'dropoff_subtitle' => 'Toronto • 2nd Drop-off',
                'dropoff_subtitle_fr' => 'Toronto • 2e arrêt de dépôt',
            ],
        ];

        foreach ($locations as $data) {
            Location::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'name_fr' => $data['name_fr'],
                    'city' => $data['city'],
                    'city_fr' => $data['city_fr'],
                    'province' => $data['province'],
                    'address' => $data['address'],
                    'address_fr' => $data['address_fr'],
                    'subtitle' => $data['subtitle'],
                    'subtitle_fr' => $data['subtitle_fr'],
                    'dropoff_subtitle' => $data['dropoff_subtitle'],
                    'dropoff_subtitle_fr' => $data['dropoff_subtitle_fr'],
                ]
            );
        }
    }
}
