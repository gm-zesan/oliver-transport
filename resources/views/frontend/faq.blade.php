@extends('frontend.layout.app')

@section('title', 'Frequently Asked Questions — PickMeRoute Montreal ↔ Toronto Passenger Shuttle')

@section('content')
    <!-- Dedicated FAQ Header -->
    <section class="relative bg-[#111827] pt-32 pb-16 sm:pt-36 sm:pb-20 border-b border-slate-800 text-white overflow-hidden">
        <!-- Ambient atmospheric glow -->
        <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-[#22C55E]/10 rounded-full blur-[120px] pointer-events-none" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center z-10">
            <span class="inline-block text-xs font-black tracking-widest text-[#22C55E] uppercase mb-3">
                HELP &amp; CORRIDOR GUIDE
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight font-heading text-white">
                Frequently Asked Questions
            </h1>
            <p class="mt-4 text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Everything you need to know about our daily Montreal ↔ Toronto intercity passenger shuttle, predefined stations, luggage guidelines, and cash settlement upon boarding.
            </p>
        </div>
    </section>

    <!-- FAQ Main Content Section -->
    <section class="py-14 sm:py-20 lg:py-24 bg-[#F8FAFC]">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

            <!-- Category 1: Fares & Cash Settlement -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#22C55E]/15 text-[#16A34A] font-black text-lg">
                        $
                    </span>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                            Fares &amp; Cash Settlement
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500">Transparent pricing with zero hidden surcharges.</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <!-- Q1 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200" open>
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>How do I pay for my trip?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Payment is simple and cash-only (${{ number_format($regularFare, 0) }} CAD flat fare). You pay the driver directly in cash when boarding the vehicle at your station. No online credit card deposit or upfront electronic payment is required to book your seat.
                        </p>
                    </details>

                    <!-- Q2 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>How much is the regular fare vs. promotional launch rate?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Our standard flat rate is ${{ number_format($regularFare, 0) }} CAD per seat per trip. By applying the introductory promo code <strong class="font-mono text-[#16A34A] bg-[#E8FBF0] px-2 py-0.5 rounded">LAUNCH10</strong> during reservation, you enjoy our promotional rate of only ${{ number_format($promotionalFare, 0) }} CAD ($10 CAD savings per seat).
                        </p>
                    </details>

                    <!-- Q3 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>Are there any booking fees, taxes, or hidden surcharges?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            None. The price you see (${{ number_format($regularFare, 0) }} CAD or ${{ number_format($promotionalFare, 0) }} CAD with promo code) is the exact amount you hand to the driver upon boarding. There are zero booking platform fees or surge surcharges.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Category 2: Stations & Schedules -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#22C55E]/15 text-[#16A34A]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                            Stations &amp; Schedules
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500">Fixed daily departures 7 days a week, 365 days a year.</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <!-- Q4 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>Where are the exact pickup and drop-off stations?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed space-y-2">
                            <p>PickMeRoute operates strictly between 3 predefined transit hubs with immediate subway and highway connectivity:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li><strong class="text-slate-900">Station Métro Namur (Montreal):</strong> Décarie corridor with direct Orange Line Métro access.</li>
                                <li><strong class="text-slate-900">Yorkdale Mall (Toronto):</strong> Direct access to TTC Subway Line 1 and Highway 401.</li>
                                <li><strong class="text-slate-900">Yonge Station (Toronto):</strong> TTC Line 1 connectivity along the Yonge Street corridor.</li>
                            </ul>
                        </div>
                    </details>

                    <!-- Q5 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>What are the daily departure times?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed space-y-2">
                            <p><strong class="text-slate-900">Route A (Montreal → Toronto):</strong> Departs {{ $namurLoc?->name ?? 'Station Métro Namur' }} daily at {{ $routeATime }} EST sharp.</p>
                            <p><strong class="text-slate-900">Route B (Toronto → Montreal):</strong> Pickups at {{ $yorkdaleLoc?->name ?? 'Yorkdale Mall' }} at {{ $yorkdalePickupTime }} EST and {{ $yongeLoc?->name ?? 'Yonge Station' }} at {{ $yongePickupTime }} EST, arriving in Montreal around {{ $namurArrivalTime }} EST.</p>
                        </div>
                    </details>

                    <!-- Q6 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>How early should I arrive at the pickup station?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Please arrive at your pickup station at least 15 minutes prior to the scheduled departure time. Our driver verifies your reservation name, assists with loading your luggage, and conducts quick cash boarding.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Category 3: Seating & Vehicle Amenities -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#22C55E]/15 text-[#16A34A]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                            Seating &amp; Vehicle Amenities
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500">Executive Honda Odyssey with guaranteed reserved seats.</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <!-- Q7 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>Can I choose my specific seat or book multiple seats?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Yes! Our booking system provides an interactive vehicle cabin diagram. You can book from 1 to {{ $passengerSeatsCount }} seats in a single reservation and pick the exact seats (S1 front passenger window, S2–S6 cabin seats) so you and your group sit together.
                        </p>
                    </details>

                    <!-- Q8 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>What vehicle do you operate?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Our primary fleet is a Silver <strong class="text-slate-900 font-bold">{{ $vehicleModel }}</strong> (License Plate: <strong class="text-slate-900 font-bold font-mono">{{ $vehiclePlate }}</strong>). It features leather interior, multi-zone automatic climate control, USB charging ports, and executive cabin comfort.
                        </p>
                    </details>

                    <!-- Q9 -->
                    <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                        <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                            <span>What is your luggage allowance?</span>
                            <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                            Each passenger is allowed 1 standard check-in suitcase (up to 50 lbs / 23 kg) in the trunk plus 1 personal item (backpack, laptop bag, or purse) inside the cabin. If you are traveling with extra or oversized luggage, please inform us in advance via phone or WhatsApp.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Still Have Questions / Contact Support Banner -->
            <div class="rounded-3xl bg-[#111827] text-white p-8 sm:p-10 border border-slate-800 shadow-xl relative overflow-hidden">
                <div class="absolute -right-16 -top-16 w-60 h-60 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#22C55E] block mb-1">
                            LIVE ASSISTANCE
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black font-heading tracking-tight">
                            Still have questions?
                        </h3>
                        <p class="mt-2 text-sm text-slate-300 max-w-md">
                            Our team is live 7 days a week to help with custom pickups, booking confirmation, or questions.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                        <a href="tel:6476551884"
                            class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 text-white px-6 py-3 text-sm font-bold border border-white/20 transition cursor-pointer">
                            <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>647-655-1884</span>
                        </a>
                        <button type="button" onclick="handleGlobalBookNow()"
                            class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-7 py-3 text-sm font-bold shadow-lg shadow-[#22C55E]/30 transition cursor-pointer">
                            <span>Book Now</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

