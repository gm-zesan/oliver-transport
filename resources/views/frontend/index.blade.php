@extends('frontend.layout.app')

@section('title', 'Oliver Transport — Daily Montreal ↔ Toronto Passenger Shuttle')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-white pt-10 pb-16 lg:pt-16 lg:pb-24 border-b border-surface-border overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Top Eyebrow Badge -->
            <div class="flex items-center justify-center lg:justify-start">
                <span class="inline-flex items-center gap-2 rounded-full border border-surface-border bg-surface-subtle px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-content-primary shadow-2xs">
                    <span class="h-2 w-2 rounded-full bg-brand-green"></span>
                    <span>Daily Scheduled Shuttle Service • Montreal ↔ Toronto</span>
                </span>
            </div>

            <!-- Hero Headline & Core Proposition -->
            <div class="mt-6 text-center lg:text-left max-w-4xl">
                <h1 class="text-4xl font-black tracking-tight text-content-primary sm:text-6xl lg:text-7xl leading-[1.08]">
                    Montreal to <span class="text-brand-green">Toronto</span>.<br class="hidden sm:inline" />
                    <span class="text-brand-charcoal">Daily. Direct. Reserved.</span>
                </h1>
                <p class="mt-5 text-lg sm:text-xl font-normal text-content-secondary leading-relaxed max-w-2xl">
                    Scheduled intercity passenger shuttle connecting <strong class="font-semibold text-content-primary">Station Métro Namur</strong> in Montreal with <strong class="font-semibold text-content-primary">Yorkdale Mall &amp; Yonge Station</strong> in Toronto. Choose your seat online and pay cash upon boarding.
                </p>
            </div>

            <!-- Hero Two-Column Grid: Booking Panel & Vehicle Showcase -->
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left: Booking Intent & Corridor Quick-Select (5 cols) -->
                <div class="lg:col-span-5 flex flex-col justify-center">
                    <div class="rounded-3xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-sm">
                        
                        <div class="flex items-center justify-between border-b border-surface-border pb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Corridor Fare</span>
                                <div class="flex items-baseline gap-1 mt-0.5">
                                    <span class="font-mono text-4xl font-black text-content-primary">$65</span>
                                    <span class="text-sm font-bold text-content-secondary">CAD</span>
                                    <span class="text-xs text-content-muted">/ passenger / trip</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold text-brand-green border border-brand-green/20">
                                Flat Rate
                            </span>
                        </div>

                        <!-- Direction Selection Options -->
                        <div class="mt-6 space-y-3">
                            <label class="text-xs font-bold uppercase tracking-wider text-content-secondary block">
                                Scheduled Daily Departures
                            </label>

                            <!-- Route A Pill -->
                            <div class="rounded-2xl border-2 border-brand-green bg-brand-green-subtle/40 p-4 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-green text-xs font-bold text-white">A</span>
                                        <h3 class="text-sm font-bold text-content-primary">Montreal → Toronto</h3>
                                    </div>
                                    <span class="font-mono text-xs font-bold text-brand-green">6:30 AM Daily</span>
                                </div>
                                <p class="mt-2 text-xs text-content-muted pl-8">
                                    Station Métro Namur → Yorkdale Mall &amp; Yonge Station
                                </p>
                            </div>

                            <!-- Route B Pill -->
                            <div class="rounded-2xl border border-surface-border bg-white p-4 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-charcoal text-xs font-bold text-white">B</span>
                                        <h3 class="text-sm font-bold text-content-primary">Toronto → Montreal</h3>
                                    </div>
                                    <span class="font-mono text-xs font-bold text-content-primary">12:15 &amp; 1:15 PM</span>
                                </div>
                                <p class="mt-2 text-xs text-content-muted pl-8">
                                    Yorkdale Mall &amp; Yonge Station → Montreal
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 space-y-3">
                            @auth
                                @php
                                    $dashboardLink = auth()->user()->isRider() 
                                        ? route('rider.dashboard') 
                                        : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard'));
                                @endphp
                                <a href="{{ $dashboardLink }}" 
                                   class="inline-flex min-h-[48px] min-w-[48px] w-full items-center justify-center rounded-xl bg-brand-green px-6 py-3.5 text-base font-bold text-white shadow-xs hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green text-center">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="inline-flex min-h-[48px] min-w-[48px] w-full items-center justify-center rounded-xl bg-brand-green px-6 py-3.5 text-base font-bold text-white shadow-xs hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green text-center">
                                    Book Your Seat
                                </a>
                                <div class="flex items-center justify-between gap-3 pt-1">
                                    <a href="{{ route('login') }}" class="text-xs font-semibold text-content-secondary hover:text-brand-green transition py-1">
                                        Already registered? Sign In
                                    </a>
                                    <a href="{{ route('register') }}" class="text-xs font-semibold text-brand-green hover:underline py-1">
                                        Create Account
                                    </a>
                                </div>
                            @endauth
                        </div>

                        <!-- Cash on Boarding Notice -->
                        <div class="mt-6 pt-4 border-t border-surface-border flex items-start gap-2 text-xs text-content-muted">
                            <svg class="h-4 w-4 text-brand-green mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                <strong>Cash Payment Upon Boarding:</strong> Reserve your seat online today. Pay the driver directly in cash when boarding.
                            </span>
                        </div>

                    </div>
                </div>

                <!-- Right: Large Vehicle Showcase (7 cols) -->
                <div class="lg:col-span-7 flex flex-col">
                    <div class="overflow-hidden rounded-3xl border border-surface-border bg-white shadow-md">
                        <!-- Vehicle Photo Top Bar -->
                        <div class="bg-brand-charcoal px-6 py-3.5 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-brand-green"></span>
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Operating Fleet • 6 Passenger Seats</span>
                                    <h3 class="text-sm font-bold text-white">Silver Honda Odyssey</h3>
                                </div>
                            </div>
                            <span class="font-mono text-xs font-extrabold bg-slate-800 text-brand-yellow px-3 py-1 rounded-lg border border-slate-700 tracking-wider">
                                RAJIA
                            </span>
                        </div>

                        <!-- Authentic Vehicle Photograph (Clean Crop) -->
                        <div class="relative bg-slate-100 overflow-hidden">
                            <img src="{{ asset('images/oliver-transport-van.jpg') }}" 
                                 alt="Oliver Transport Commercial Silver Honda Odyssey Minivan with License Plate RAJIA" 
                                 class="w-full h-auto object-cover object-center transform transition duration-500 hover:scale-[1.02]"
                                 loading="eager" />
                        </div>

                        <!-- Vehicle Specs Banner -->
                        <div class="p-6 bg-surface-subtle grid grid-cols-1 sm:grid-cols-3 gap-4 text-center border-t border-surface-border">
                            <div class="p-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Cabin Capacity</span>
                                <span class="text-sm font-bold text-content-primary mt-1 block">6 Bookable Passenger Seats</span>
                                <span class="text-xs text-content-muted block">(Driver permanently excluded)</span>
                            </div>
                            <div class="p-2 border-t sm:border-t-0 sm:border-l border-surface-border">
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Seat Selection</span>
                                <span class="text-sm font-bold text-brand-green mt-1 block">Interactive Visual Picker</span>
                                <span class="text-xs text-content-muted block">Choose S1 or S2–S6 rows</span>
                            </div>
                            <div class="p-2 border-t sm:border-t-0 sm:border-l border-surface-border">
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Daily Reliability</span>
                                <span class="text-sm font-bold text-content-primary mt-1 block">365 Days / Year</span>
                                <span class="text-xs text-content-muted block">Fixed departure timetable</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Route Schedules Section -->
    <section id="schedule" class="py-20 lg:py-28 bg-surface-subtle border-b border-surface-border">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <x-section-heading 
                eyebrow="Corridors &amp; Schedules" 
                title="Fixed Daily Timetable &amp; Predefined Stations" 
                subtitle="Travel between Montreal and Toronto with scheduled pickup and drop-off hubs located at major transit connections in each city."
            />

            <!-- Two Attractive Route Schedule Presentations -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                
                <!-- Route A Card -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 sm:p-10 shadow-xs">
                    <div class="flex items-center justify-between border-b border-surface-border pb-5">
                        <div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                                Route A • Morning Service
                            </span>
                            <h3 class="mt-2 text-2xl font-black text-content-primary sm:text-3xl">
                                Montreal → Toronto
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Departure Time</span>
                            <span class="font-mono text-2xl font-black text-brand-green sm:text-3xl">6:30 AM</span>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-content-secondary leading-relaxed">
                        Daily morning departure from Montreal connecting directly to prime transit hubs in Toronto.
                    </p>

                    <!-- Station Timeline -->
                    <div class="mt-8 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
                        <!-- Origin: Namur -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-green text-white text-xs font-bold ring-4 ring-white">
                                1
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">Origin Departure Hub • 6:30 AM</span>
                                <h4 class="text-base font-bold text-content-primary">Station Métro Namur</h4>
                                <p class="text-xs text-content-muted mt-0.5">Montreal, QC • Direct Orange Line subway access</p>
                            </div>
                        </div>

                        <!-- Drop-off 1: Yorkdale -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                2
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">First Drop-off Station</span>
                                <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • TTC Subway Line 1 &amp; highway terminal</p>
                            </div>
                        </div>

                        <!-- Drop-off 2: Yonge Station -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                3
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Second Drop-off Station</span>
                                <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • TTC Line 1 &amp; Line 2 hub connection</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
                        <span>Schedule: <strong>Daily, 7 days/week</strong></span>
                        <span>Timezone: <strong>America/Toronto (ET)</strong></span>
                    </div>
                </div>

                <!-- Route B Card -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 sm:p-10 shadow-xs">
                    <div class="flex items-center justify-between border-b border-surface-border pb-5">
                        <div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-charcoal px-3 py-1 text-xs font-bold uppercase tracking-wider text-white">
                                Route B • Afternoon Service
                            </span>
                            <h3 class="mt-2 text-2xl font-black text-content-primary sm:text-3xl">
                                Toronto → Montreal
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">First Pickup</span>
                            <span class="font-mono text-2xl font-black text-content-primary sm:text-3xl">12:15 PM</span>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-content-secondary leading-relaxed">
                        Daily afternoon return trip from central Toronto pick-up points back to Montreal.
                    </p>

                    <!-- Station Timeline -->
                    <div class="mt-8 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
                        <!-- Pickup 1: Yorkdale -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                                1
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">First Pickup Hub • 12:15 PM</span>
                                <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • Designated passenger boarding location</p>
                            </div>
                        </div>

                        <!-- Pickup 2: Yonge Station -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                                2
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">Second Pickup Hub • 1:15 PM</span>
                                <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • Designated passenger boarding location</p>
                            </div>
                        </div>

                        <!-- Terminus: Montreal -->
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                3
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Final Destination Terminus</span>
                                <h4 class="text-base font-bold text-content-primary">Montreal</h4>
                                <p class="text-xs text-content-muted mt-0.5">Estimated arrival ~7:15 PM ET (subject to highway traffic)</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
                        <span>Schedule: <strong>Daily, 7 days/week</strong></span>
                        <span>Settlement: <strong>Cash on boarding</strong></span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Transparent Pricing Section -->
    <section id="fares" class="py-20 lg:py-28 bg-white border-b border-surface-border">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <x-section-heading 
                eyebrow="Transparent Pricing" 
                title="Simple Flat Rate. No Surprises." 
                subtitle="One predictable fare per passenger per trip, regardless of which predefined stations you travel between. Settle with physical cash directly upon boarding."
            />

            <!-- Pricing Focus Container -->
            <div class="mx-auto max-w-4xl rounded-3xl border border-surface-border bg-surface-card p-8 sm:p-12 shadow-xs">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:items-center">
                    
                    <!-- Left: Rate Summary (5 cols) -->
                    <div class="md:col-span-5 text-center md:text-left md:border-r md:border-surface-border md:pr-8">
                        <span class="inline-flex items-center gap-1 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                            Standard Fare
                        </span>
                        
                        <div class="mt-4 flex items-baseline justify-center md:justify-start gap-1">
                            <span class="font-mono text-5xl sm:text-6xl font-black tracking-tight text-content-primary">$65</span>
                            <span class="text-xl font-bold text-content-secondary">CAD</span>
                            <span class="text-xs text-content-muted">/ trip</span>
                        </div>

                        <p class="mt-3 text-sm text-content-secondary leading-relaxed">
                            Fixed rate per passenger per trip between Montreal and Toronto. No hidden ticketing fees, no surge pricing, and no credit card needed to reserve.
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('login') }}" 
                               class="inline-flex min-h-[48px] min-w-[48px] w-full items-center justify-center rounded-xl bg-brand-green px-6 py-3.5 text-base font-bold text-white shadow-xs hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green text-center">
                                Reserve for $65 CAD
                            </a>
                        </div>
                    </div>

                    <!-- Right: Included Specifications (7 cols) -->
                    <div class="md:col-span-7 space-y-4">
                        <h3 class="text-base font-bold text-content-primary">
                            Every Reservation Includes:
                        </h3>

                        <ul class="space-y-3.5 text-sm text-content-secondary">
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Personal Seat Choice:</strong> Visually choose your physical seat (S1 front passenger window, or S2–S6 rear cabin) when booking.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Commercial Minivan Fleet:</strong> Travel in our silver Honda Odyssey minivan (Ontario license plate RAJIA).</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Multi-Seat Reservations:</strong> Book 1 to 6 seats in a single reservation under one passenger account.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Cash Settlement:</strong> Confirm your booking online with zero upfront card payment. Settle in physical cash at boarding.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Service Benefits Section (Verified Only) -->
    <section id="features" class="py-20 lg:py-28 bg-surface-subtle border-b border-surface-border">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <x-section-heading 
                eyebrow="Service Standards" 
                title="Why Travel with Oliver Transport" 
                subtitle="Designed for passengers who appreciate scheduled consistency, individual seat selection, and straightforward cash settlement."
            />

            <!-- 4 Verified Core Service Pillars -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                
                <!-- Pillar 1 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Daily Fixed Schedule</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Operating 7 days a week, 365 days a year. Depart Montreal at 6:30 AM or return from Toronto at 12:15 PM and 1:15 PM.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Visual Seat Selection</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Hand-pick your exact physical seat (S1 front window or S2–S6 rear rows) on our cabin map. The system never auto-assigns an alternate seat.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Transit Subway Hubs</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Predefined stations at Station Métro Namur (Orange Line, Montreal), Yorkdale Mall (Line 1), and Yonge Station (Lines 1 &amp; 2) in Toronto.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Cash Settlement at Boarding</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Zero upfront electronic credit card transactions required to reserve. Settle your fare directly with the driver in physical cash when boarding.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Final Booking Call-to-Action -->
    <section class="py-20 lg:py-24 bg-brand-charcoal text-white relative overflow-hidden">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-800 px-4 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-slate-700">
                Daily Fixed Intercity Service
            </span>

            <h2 class="text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl">
                Ready to Travel Montreal ↔ Toronto?
            </h2>

            <p class="max-w-2xl mx-auto text-base text-slate-300 sm:text-lg leading-relaxed">
                Reserve your preferred seat online in minutes with zero credit card required. Pay cash to the driver when you board.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                @auth
                    <a href="{{ $dashboardLink }}" 
                       class="inline-flex min-h-[48px] min-w-[48px] w-full sm:w-auto items-center justify-center rounded-xl bg-brand-green px-8 py-3.5 text-base font-bold text-white shadow-md hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex min-h-[48px] min-w-[48px] w-full sm:w-auto items-center justify-center rounded-xl bg-brand-green px-8 py-3.5 text-base font-bold text-white shadow-md hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                        Book Your Seat
                    </a>
                    <a href="tel:6476551884" 
                       class="inline-flex min-h-[48px] min-w-[48px] w-full sm:w-auto items-center justify-center rounded-xl border border-slate-700 bg-slate-800/80 px-6 py-3.5 text-base font-bold text-white hover:bg-slate-700 transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                        Call or Text: 647-655-1884
                    </a>
                @endauth
            </div>

            <p class="pt-2 text-xs text-slate-400">
                Customer support available via phone/SMS/WhatsApp at <strong class="text-white">647-655-1884</strong> or Facebook at <strong class="text-white">Oliver Transport</strong>.
            </p>
        </div>
    </section>
@endsection
