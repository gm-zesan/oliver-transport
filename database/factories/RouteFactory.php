<?php

namespace Database\Factories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Route>
 */
class RouteFactory extends Factory
{
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Montreal to Toronto',
            'direction_code' => strtoupper(fake()->unique()->lexify('ROUTE_????')),
            'is_active' => true,
        ];
    }

    /**
     * Predefined Route A: Montreal to Toronto.
     */
    public function montrealToToronto(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Montreal → Toronto',
            'direction_code' => 'MTL_TO_TOR',
            'is_active' => true,
        ]);
    }

    /**
     * Predefined Route B: Toronto to Montreal.
     */
    public function torontoToMontreal(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Toronto → Montreal',
            'direction_code' => 'TOR_TO_MTL',
            'is_active' => true,
        ]);
    }

    /**
     * Indicate route is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
