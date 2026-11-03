<x-layouts.app>
    <x-slot:title>Oliver Transport — Scheduled Montreal ↔ Toronto Shuttle</x-slot:title>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-12 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                <!-- Text / Value Proposition -->
                <div>
                    <!-- Promo Tag -->
                    <div class="inline-flex items-center gap-2 rounded-full border border-provisional-alert/30 bg-provisional-alert/10 px-3.5 py-1 text-xs font-bold uppercase tracking-wide text-provisional-alert">
                        <span>First Ride • Launch Promotion</span>
                    </div>

                    <h1 class="mt-4 text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Montreal to <span class="text-provisional-accent">Toronto</span>
                    </h1>

                    <p class="mt-3 text-lg font-medium text-provisional-muted">
                        Direct, scheduled intercity shuttle service operating daily. Guaranteed reserved seating in our comfortable commercial 6-passenger van.
                    </p>

                    <!-- Pricing Highlights -->
                    <div class="mt-6 flex flex-wrap items-center gap-4">
                        <div class="rounded-xl border border-provisional-accent/30 bg-provisional-accent/10 p-4">
                            <span class="block text-xs font-bold uppercase tracking-wider text-provisional-accent">Launch Price</span>
                            <span class="text-3xl font-black text-white">$55 <span class="text-sm font-semibold text-provisional-muted">CAD / trip</span></span>
                        </div>
                        <div class="rounded-xl border border-provisional-border bg-provisional-surface p-4 opacity-75">
                            <span class="block text-xs font-bold uppercase tracking-wider text-provisional-muted">Regular Fare</span>
                            <span class="text-2xl font-bold line-through text-provisional-muted">$65 <span class="text-xs font-semibold">CAD</span></span>
                        </div>
                    </div>

                    <!-- Call to Actions (Enforcing minimum 48px touch targets for mobile accessibility) -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        @auth
                            <a href="{{ auth()->user()->isRider() ? route('rider.dashboard') : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard')) }}" 
                               class="inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-lg bg-provisional-accent px-6 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent transition">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-lg bg-provisional-accent px-6 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent transition">
                                Sign In to Book
                            </a>
                            <a href="{{ route('register') }}" 
                               class="inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-lg border border-provisional-border bg-provisional-surface px-6 py-3 text-base font-bold text-white hover:bg-provisional-card hover:text-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent transition">
                                Create Account
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Route & Station Highlights -->
                <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 shadow-2xl">
                    <h2 class="text-lg font-bold uppercase tracking-wider text-provisional-accent flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        3 Predefined Stations
                    </h2>

                    <!-- Station List -->
                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-3 rounded-lg border border-provisional-border/50 bg-provisional-card/50 p-3.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-provisional-accent/20 text-xs font-bold text-provisional-accent">1</span>
                            <div>
                                <h3 class="font-bold text-white">Station Métro Namur (Montreal, QC)</h3>
                                <p class="text-xs text-provisional-muted">Route A Departure: 6:30 AM • Route B Final Drop-off</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 rounded-lg border border-provisional-border/50 bg-provisional-card/50 p-3.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-provisional-accent/20 text-xs font-bold text-provisional-accent">2</span>
                            <div>
                                <h3 class="font-bold text-white">Yorkdale Mall (Toronto, ON)</h3>
                                <p class="text-xs text-provisional-muted">Route A 1st Drop-off • Route B Pickup 1: 12:15 PM</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 rounded-lg border border-provisional-border/50 bg-provisional-card/50 p-3.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-provisional-accent/20 text-xs font-bold text-provisional-accent">3</span>
                            <div>
                                <h3 class="font-bold text-white">Yonge Station (Toronto, ON)</h3>
                                <p class="text-xs text-provisional-muted">Route A 2nd Drop-off • Route B Pickup 2: 1:15 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fleet Note -->
                    <div class="mt-6 rounded-lg border border-provisional-highlight/20 bg-provisional-highlight/5 p-3.5 text-xs text-provisional-muted">
                        <strong class="text-provisional-highlight">Fleet:</strong> Commercial Honda Odyssey (Plate: <strong>RAJIA</strong>), 6 bookable passenger seats. Driver seat permanently excluded.
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
