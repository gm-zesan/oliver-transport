<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Exceptions\PaymentAlreadyCollectedException;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Record physical cash payment collected by an authorized rider upon boarding.
     *
     * @throws PaymentAlreadyCollectedException
     */
    public function recordCashCollection(Payment|Booking $target, int $riderId): Payment
    {
        $paymentId = $target instanceof Payment ? $target->id : $target->payment?->id;

        if (! $paymentId && $target instanceof Booking) {
            // Lazy load or fail if not yet created
            $payment = $target->payment()->firstOrFail();
            $paymentId = $payment->id;
        }

        return DB::transaction(function () use ($paymentId, $riderId) {
            /** @var Payment $payment */
            $payment = Payment::where('id', $paymentId)->lockForUpdate()->firstOrFail();

            if ($payment->status === 'paid') {
                throw new PaymentAlreadyCollectedException('Cash payment has already been collected for this booking.');
            }

            $payment->update([
                'status' => 'paid',
                'collected_by' => $riderId,
                'collected_at' => now(),
            ]);

            return $payment->fresh();
        });
    }
}
