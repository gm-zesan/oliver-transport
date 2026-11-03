<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CouponUsage>
 */
class CouponUsageFactory extends Factory
{
    protected $model = CouponUsage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coupon_id' => Coupon::factory(),
            'booking_id' => Booking::factory(),
            'user_id' => function (array $attributes) {
                return Booking::find($attributes['booking_id'])?->user_id ?? User::factory()->passenger();
            },
            'discount_applied' => 10.00,
        ];
    }
}
