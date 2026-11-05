<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\DiscountType;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds for default promotional coupons.
     */
    public function run(): void
    {
        // Remove legacy secondary promo code if present
        Coupon::where('code', 'OLIVER15')->delete();

        // 1. Primary Promotional Launch Coupon ($10 OFF -> $55 CAD flat promotional rate)
        Coupon::updateOrCreate(
            ['code' => 'LAUNCH10'],
            [
                'tab_label' => '🔥 $10 OFF Launch Special',
                'tag' => 'Active Launch Special',
                'route_tag' => 'Montreal ↔ Toronto Corridor',
                'headline' => 'Ride for Only $55 CAD with Promo Code',
                'description' => 'Get $10.00 CAD off the regular $65.00 CAD fare on all daily departures. Valid on both Route A (Montreal → Toronto) and Route B (Toronto → Montreal).',
                'terms' => 'Valid on all daily departures • Min booking $50 CAD • Cash settlement on boarding',
                'accent_color' => '#22C55E',
                'discount_type' => DiscountType::Fixed,
                'discount_value' => 10.00,
                'min_booking_amount' => 50.00,
                'max_discount_amount' => null,
                'max_total_uses' => null,
                'max_uses_per_user' => 10,
                'current_uses' => 0,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addYear(),
                'is_active' => true,
                'is_show' => true,
            ]
        );
    }
}
