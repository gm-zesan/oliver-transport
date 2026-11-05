<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\DiscountType;
use App\Exceptions\InvalidCouponException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\ApplyCouponRequest;
use App\Models\Trip;
use App\Services\Coupon\CouponService;
use App\Services\Pricing\PricingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function __construct(
        public CouponService $couponService,
        public PricingService $pricingService
    ) {}

    /**
     * Validate promotional coupon code and calculate prospective discount.
     */
    public function validate(ApplyCouponRequest $request): JsonResponse
    {
        $code = $request->validated('code');
        $tripId = $request->validated('trip_id');
        $seatCount = (int) $request->validated('seat_count');

        $trip = null;
        if (! empty($tripId)) {
            $trip = Trip::find((int) $tripId);
        }

        if ($trip) {
            $tripDate = Carbon::parse($trip->trip_date);
        } elseif (! empty($request->validated('date'))) {
            $tripDate = Carbon::parse((string) $request->validated('date'));
        } else {
            $tripDate = Carbon::today();
        }

        $grossFare = $this->pricingService->calculateGrossBaseFare($seatCount, $tripDate);
        $userId = auth()->id() ?? 0;

        try {
            $coupon = $this->couponService->validateCoupon($code, $grossFare, $userId, forUpdate: false);
            $discount = $this->couponService->calculateDiscount($coupon, $grossFare, $seatCount);
            $finalFare = $this->pricingService->calculateFinalFare($grossFare, $discount);

            return response()->json([
                'is_valid' => true,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type instanceof DiscountType ? $coupon->discount_type->value : (string) $coupon->discount_type,
                'discount_value' => (float) $coupon->discount_value,
                'discount_amount' => $discount,
                'gross_fare' => $grossFare,
                'final_fare' => $finalFare,
                'trip_id' => $trip?->id,
                'message' => 'Promotion code successfully applied.',
            ]);
        } catch (InvalidCouponException $e) {
            return response()->json([
                'is_valid' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
