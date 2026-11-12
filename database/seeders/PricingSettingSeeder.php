<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PricingSetting;
use Illuminate\Database\Seeder;

class PricingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds for pricing settings.
     */
    public function run(): void
    {
        PricingSetting::firstOrCreate(
            ['key' => 'regular_fare'],
            [
                'amount' => 65.00,
                'currency' => 'CAD',
                'description' => 'Regular ticket base fare per seat in CAD',
                'description_fr' => 'Tarif de base régulier par siège en CAD',
                'is_active' => true,
            ]
        );
    }
}
