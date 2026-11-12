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
                'tab_label_fr' => '🔥 10 $ DE RABAIS Spécial de lancement',
                'tag' => 'Active Launch Special',
                'tag_fr' => 'Offre spéciale de lancement',
                'route_tag' => 'Montreal ↔ Toronto Corridor',
                'route_tag_fr' => 'Corridor Montréal ↔ Toronto',
                'headline' => 'Ride for Only $55 CAD',
                'headline_fr' => 'Voyagez pour seulement 55 $ CAD',
                'description' => 'Save $10 CAD per seat on daily departures between Montreal and Toronto.',
                'description_fr' => 'Économisez 10 $ CAD par siège sur les départs quotidiens entre Montréal et Toronto.',
                'terms' => 'Valid on all daily departures · Min booking $50 CAD · Cash settlement on boarding',
                'terms_fr' => 'Valide sur tous les départs quotidiens · Réservation min. 50 $ CAD · Paiement comptant à l’embarquement',
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
