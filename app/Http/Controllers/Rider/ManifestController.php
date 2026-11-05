<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rider;

use App\Exceptions\PaymentAlreadyCollectedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rider\UpdateTripStatusRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Services\Rider\RiderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManifestController extends Controller
{
    public function __construct(
        protected RiderService $riderService
    ) {}

    /**
     * Display the live stop-by-stop passenger manifest for an assigned trip run.
     */
    public function show(Trip $trip, Request $request): View
    {
        $manifest = $this->riderService->getTripManifest($trip, $request->user());

        return view('rider.manifest', [
            'trip' => $manifest['trip'],
            'kpis' => $manifest['kpis'],
            'stops' => $manifest['stops'],
            'user' => $request->user(),
        ]);
    }

    /**
     * Update trip lifecycle operational status (scheduled -> in_progress -> completed).
     */
    public function updateStatus(Trip $trip, UpdateTripStatusRequest $request): RedirectResponse
    {
        $status = $request->validated('status');
        $this->riderService->updateTripStatus($trip, $request->user(), $status);

        $statusLabels = [
            'scheduled' => 'Scheduled',
            'in_progress' => 'In Progress (Trip Started)',
            'completed' => 'Completed',
        ];

        $label = $statusLabels[$status] ?? ucfirst($status);

        return back()->with('status', "Trip run #{$trip->id} is now {$label}.");
    }

    /**
     * Record cash payment collected physically upon passenger boarding.
     */
    public function collectCash(Trip $trip, Payment $payment, Request $request): RedirectResponse
    {
        try {
            $this->riderService->recordCashCollection($trip, $payment, $request->user());

            $formattedAmount = number_format((float) $payment->amount, 2);

            return back()->with('status', "Cash payment of CAD \${$formattedAmount} recorded successfully.");
        } catch (PaymentAlreadyCollectedException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mark a passenger as checked in upon boarding.
     */
    public function checkIn(Trip $trip, Booking $booking, Request $request): RedirectResponse
    {
        $this->riderService->checkInPassenger($trip, $booking, $request->user());

        $passengerName = $booking->user?->name ?? 'Passenger';

        return back()->with('status', "{$passengerName} has checked in.");
    }
}
