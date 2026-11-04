<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds for default promotional coupons.
     */
    public function run(): void
    {
        // 1. Primary Promotional Launch Coupon ($10 OFF -> $55 CAD flat promotional rate)
        Coupon::firstOrCreate(
            ['code' => 'LAUNCH10'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 10.00,
                'min_booking_amount' => 50.00,
                'max_discount_amount' => null,
                'max_total_uses' => null,
                'max_uses_per_user' => 10,
                'current_uses' => 0,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addYear(),
                'is_active' => true,
            ]
        );

        // 2. Percentage Launch Coupon (15% OFF)
        Coupon::firstOrCreate(
            ['code' => 'OLIVER15'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'min_booking_amount' => 50.00,
                'max_discount_amount' => 50.00,
                'max_total_uses' => 500,
                'max_uses_per_user' => 2,
                'current_uses' => 0,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ]
        );
    }
}
