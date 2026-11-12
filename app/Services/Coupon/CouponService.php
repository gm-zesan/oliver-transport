<?php

declare(strict_types=1);

namespace App\Services\Coupon;

use App\Enums\DiscountType;
use App\Exceptions\InvalidCouponException;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponService
{
    /**
     * Validate coupon code eligibility under optional pessimistic lock.
     *
     * @throws InvalidCouponException
     */
    public function validateCoupon(
        string $code,
        float $grossBaseFare,
        int $userId,
        bool $forUpdate = false
    ): Coupon {
        $normalizedCode = strtoupper(trim($code));

        $query = Coupon::whereRaw('UPPER(code) = ?', [$normalizedCode]);

        if ($forUpdate) {
            $query->lockForUpdate();
        }

        /** @var Coupon|null $coupon */
        $coupon = $query->first();

        if (! $coupon) {
            throw new InvalidCouponException(__('The promotion code entered is invalid.'));
        }

        if (! $coupon->is_active) {
            throw new InvalidCouponException(__('This coupon code is no longer active.'));
        }

        $now = Carbon::now('America/Toronto');

        if ($coupon->starts_at && $now->lessThan($coupon->starts_at)) {
            throw new InvalidCouponException(__('This coupon is not valid yet.'));
        }

        if ($coupon->expires_at && $now->greaterThan($coupon->expires_at)) {
            throw new InvalidCouponException(__('This coupon has expired.'));
        }

        if ($coupon->max_total_uses !== null && $coupon->current_uses >= $coupon->max_total_uses) {
            throw new InvalidCouponException(__('This coupon has reached its maximum total redemptions.'));
        }

        if ($coupon->max_uses_per_user !== null) {
            $userUsageCount = DB::table('coupon_usages')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $userId)
                ->count();

            if ($userUsageCount >= $coupon->max_uses_per_user) {
                throw new InvalidCouponException(__('You have already reached the redemption limit for this promotion code.'));
            }
        }

        if ($coupon->min_booking_amount !== null && $grossBaseFare < (float) $coupon->min_booking_amount) {
            throw new InvalidCouponException(
                __('This coupon requires a minimum booking amount of $:amount CAD.', [
                    'amount' => number_format((float) $coupon->min_booking_amount, 2),
                ])
            );
        }

        return $coupon;
    }

    /**
     * Calculate discount amount in CAD for a validated coupon.
     */
    public function calculateDiscount(Coupon $coupon, float $grossBaseFare, int $seatCount = 1): float
    {
        $grossCents = (int) round($grossBaseFare * 100);

        if ($coupon->discount_type === DiscountType::Percentage) {
            $discountPercent = (float) $coupon->discount_value;
            $discountCents = (int) round(($grossCents * $discountPercent) / 100);

            if ($coupon->max_discount_amount !== null) {
                $maxCapCents = (int) round((float) $coupon->max_discount_amount * 100);
                $discountCents = min($discountCents, $maxCapCents);
            }
        } else {
            // Fixed dollar amount discount per reserved seat
            $fixedPerSeatCents = (int) round((float) $coupon->discount_value * 100);
            $totalFixedCents = $fixedPerSeatCents * max(1, $seatCount);

            if ($coupon->max_discount_amount !== null) {
                $maxCapCents = (int) round((float) $coupon->max_discount_amount * 100);
                $totalFixedCents = min($totalFixedCents, $maxCapCents);
            }

            $discountCents = min($grossCents, $totalFixedCents);
        }

        $discountCents = min($grossCents, max(0, $discountCents));

        return round($discountCents / 100, 2);
    }

    /**
     * Record usage of a coupon and increment redemptions counter.
     */
    public function recordUsage(Coupon $coupon, int $bookingId, int $userId, float $discountApplied): CouponUsage
    {
        $usage = CouponUsage::create([
            'coupon_id' => $coupon->id,
            'booking_id' => $bookingId,
            'user_id' => $userId,
            'discount_applied' => $discountApplied,
        ]);

        $coupon->increment('current_uses');

        return $usage;
    }
}
