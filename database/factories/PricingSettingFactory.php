<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PricingSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PricingSetting>
 */
class PricingSettingFactory extends Factory
{
    protected $model = PricingSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => 'regular_fare',
            'amount' => 65.00,
            'currency' => 'CAD',
            'description' => 'Regular ticket base fare per seat in CAD',
            'is_active' => true,
        ];
    }
}
