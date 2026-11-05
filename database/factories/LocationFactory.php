<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->city().' Station',
            'city' => 'Montreal',
            'province' => 'QC',
            'address' => fake()->streetAddress(),
            'subtitle' => 'Montreal Hub',
            'dropoff_subtitle' => 'Montreal Drop-off',
        ];
    }

    /**
     * Indicate location is in Montreal.
     */
    public function montreal(): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => 'Montreal',
            'province' => 'QC',
        ]);
    }

    /**
     * Indicate location is in Toronto.
     */
    public function toronto(): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => 'Toronto',
            'province' => 'ON',
        ]);
    }
}
