<div {{ $attributes->merge(['class' => 'mx-auto max-w-4xl']) }}>
    <div class="relative overflow-hidden rounded-3xl border border-surface-border bg-surface-card p-8 sm:p-12 shadow-sm">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12 md:items-center">
            <!-- Price Display -->
            <div class="md:col-span-5 text-center md:text-left md:border-r md:border-surface-border md:pr-8">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                    Standard Flat Rate
                </span>
                
                <div class="mt-4 flex items-baseline justify-center md:justify-start gap-1">
                    <span class="font-mono text-5xl sm:text-6xl font-black tracking-tight text-content-primary">$65</span>
                    <span class="text-lg font-bold text-content-secondary">CAD</span>
                    <span class="text-sm font-semibold text-content-muted">/ passenger</span>
                </div>

                <p class="mt-3 text-sm text-content-secondary leading-relaxed">
                    Simple, transparent per-trip fare. No hidden booking fees, no dynamic surge pricing, and no distance penalties.
                </p>

                <div class="mt-6 rounded-xl bg-surface-subtle p-3.5 text-xs text-content-muted border border-surface-border text-left">
                    <div class="flex items-center gap-2 font-bold text-content-primary">
                        <svg class="h-4 w-4 text-brand-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Cash Payment Upon Boarding</span>
                    </div>
                    <p class="mt-1 text-content-secondary">
                        Reserve your seat online with zero upfront credit card charge. Pay the driver directly in cash when boarding.
                    </p>
                </div>
            </div>

            <!-- Features Included -->
            <div class="md:col-span-7 space-y-4">
                <h3 class="text-lg font-bold text-content-primary">
                    Every Reservation Includes:
                </h3>

                <ul class="space-y-3 text-sm text-content-secondary">
                    <li class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Guaranteed Reserved Seat:</strong> Hand-pick your exact physical seat (S1–S6) on our cabin diagram. Never auto-assigned.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Luggage Allowance Included:</strong> Travel comfortably with passenger luggage securely stowed in the rear compartment.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Commercial Minivan Comfort:</strong> Climate-controlled silver Honda Odyssey with generous legroom.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Multi-Seat Booking:</strong> Reserve 1 to 6 seats in a single reservation under one passenger account.</span>
                    </li>
                </ul>

                <div class="mt-6 pt-4 border-t border-surface-border">
                    <p class="text-xs text-content-muted">
                        <em>Introductory promotional rates ($55 CAD) and seasonal coupon discounts may be announced and applied at operator discretion during promotional windows.</em>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

