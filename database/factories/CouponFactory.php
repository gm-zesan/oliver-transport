<?php

namespace Database\Factories;

use App\Enums\DiscountType;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('PROMO##??')),
            'discount_type' => DiscountType::Percentage,
            'discount_value' => 10.00,
            'min_booking_amount' => 0.00,
            'max_discount_amount' => null,
            'max_total_uses' => null,
            'max_uses_per_user' => 1,
            'current_uses' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addMonth(),
            'is_active' => true,
            'is_show' => true,
        ];
    }

    /**
     * Indicate a fixed CAD dollar discount.
     */
    public function fixed(float $amount = 10.00): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => DiscountType::Fixed,
            'discount_value' => $amount,
        ]);
    }

    /**
     * Indicate a percentage discount.
     */
    public function percentage(float $percent = 15.00): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => DiscountType::Percentage,
            'discount_value' => $percent,
        ]);
    }

    /**
     * Indicate that the coupon is hidden from the public homepage.
     */
    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_show' => false,
        ]);
    }

    /**
     * Indicate that the coupon is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subDay(),
        ]);
    }

    /**
     * Indicate that the coupon is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
