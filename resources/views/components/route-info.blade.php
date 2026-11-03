<div {{ $attributes->merge(['class' => 'grid grid-cols-1 gap-8 lg:grid-cols-2']) }}>
    <!-- Route A: Montreal to Toronto -->
    <div class="flex flex-col rounded-2xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between border-b border-surface-border pb-4">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-green-subtle px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                    Route A • Morning
                </span>
                <h3 class="mt-2 text-xl font-black text-content-primary sm:text-2xl">
                    Montreal → Toronto
                </h3>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold uppercase tracking-wider text-content-muted">Daily Departure</span>
                <p class="font-mono text-xl font-extrabold text-brand-green sm:text-2xl">6:30 AM</p>
            </div>
        </div>

        <p class="mt-4 text-sm text-content-secondary">
            Daily fixed-schedule shuttle connecting Montreal with major transit and retail destinations in Toronto.
        </p>

        <!-- Timeline -->
        <div class="mt-6 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
            <!-- Boarding -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-green text-white text-xs font-bold ring-4 ring-white">
                    1
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-green">Departure Hub</span>
                        <span class="font-mono text-xs font-bold text-content-primary">06:30 AM</span>
                    </div>
                    <h4 class="text-base font-bold text-content-primary">Station Métro Namur</h4>
                    <p class="text-xs text-content-muted">Montreal, QC • Direct subway connection</p>
                </div>
            </div>

            <!-- Stop 1 Drop-off -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                    2
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-content-muted">1st Drop-off</span>
                    <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                    <p class="text-xs text-content-muted">Toronto, ON • Major retail & transit hub</p>
                </div>
            </div>

            <!-- Stop 2 Drop-off -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                    3
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-content-muted">2nd Drop-off</span>
                    <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                    <p class="text-xs text-content-muted">Toronto, ON • TTC Subway & Downtown connections</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
            <span>Operating: <strong>7 days / week</strong></span>
            <span>Timezone: <strong>Eastern Time (ET)</strong></span>
        </div>
    </div>

    <!-- Route B: Toronto to Montreal -->
    <div class="flex flex-col rounded-2xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between border-b border-surface-border pb-4">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-charcoal px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-white">
                    Route B • Afternoon
                </span>
                <h3 class="mt-2 text-xl font-black text-content-primary sm:text-2xl">
                    Toronto → Montreal
                </h3>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold uppercase tracking-wider text-content-muted">Pickups From</span>
                <p class="font-mono text-xl font-extrabold text-content-primary sm:text-2xl">12:15 PM</p>
            </div>
        </div>

        <p class="mt-4 text-sm text-content-secondary">
            Daily afternoon return shuttle departing central Toronto stations back to Montreal.
        </p>

        <!-- Timeline -->
        <div class="mt-6 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
            <!-- Pickup 1 -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                    1
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-green">1st Pickup</span>
                        <span class="font-mono text-xs font-bold text-content-primary">12:15 PM</span>
                    </div>
                    <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                    <p class="text-xs text-content-muted">Toronto, ON • Designated passenger pickup</p>
                </div>
            </div>

            <!-- Pickup 2 -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                    2
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-green">2nd Pickup</span>
                        <span class="font-mono text-xs font-bold text-content-primary">1:15 PM</span>
                    </div>
                    <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                    <p class="text-xs text-content-muted">Toronto, ON • Designated passenger pickup</p>
                </div>
            </div>

            <!-- Montreal Drop-off -->
            <div class="relative flex items-start gap-4">
                <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                    3
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-content-muted">Final Destination</span>
                    <h4 class="text-base font-bold text-content-primary">Montreal</h4>
                    <p class="text-xs text-content-muted">Estimated arrival ~7:15 PM EST (subject to traffic)</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
            <span>Operating: <strong>7 days / week</strong></span>
            <span>Settlement: <strong>Cash on Boarding</strong></span>
        </div>
    </div>
</div>

