<?php

declare(strict_types=1);

namespace App\Services\Pricing;

use App\Models\PricingSetting;
use Carbon\Carbon;

class PricingService
{
    /**
     * Resolve the active base unit fare per passenger per trip in CAD from the database.
     * Dynamic values are managed via Database Seeder / Admin Panel in pricing_settings.
     */
    public function resolveUnitBaseFare(?Carbon $date = null): float
    {
        return PricingSetting::getFare('regular_fare', 65.00);
    }

    /**
     * Calculate total gross base fare for a given number of seats.
     */
    public function calculateGrossBaseFare(int $seatCount, ?Carbon $date = null): float
    {
        $unitFare = $this->resolveUnitBaseFare($date);
        $unitCents = (int) round($unitFare * 100);
        $totalCents = $unitCents * $seatCount;

        return round($totalCents / 100, 2);
    }

    /**
     * Calculate final fare after applying discount.
     */
    public function calculateFinalFare(float $baseFare, float $discountAmount): float
    {
        $baseCents = (int) round($baseFare * 100);
        $discountCents = (int) round($discountAmount * 100);
        $finalCents = max(0, $baseCents - $discountCents);

        return round($finalCents / 100, 2);
    }
}
