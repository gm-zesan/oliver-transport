@extends('frontend.layout.app')

@section('title', __('Frequently Asked Questions — PickMeRoute Montreal ↔ Toronto Passenger Shuttle'))

@section('content')
    <!-- Dedicated FAQ Header with Cinematic Riding/Travel Hero Background -->
    <section class="relative bg-[#0B0F17] pt-32 pb-20 sm:pt-36 sm:pb-24 lg:pt-40 lg:pb-28 border-b border-slate-800 text-white overflow-hidden bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(180deg, rgba(11, 15, 23, 0.90) 0%, rgba(11, 15, 23, 0.78) 50%, rgba(11, 15, 23, 0.96) 100%), url('{{ asset('images/faq-hero-bg.jpg') }}');">

        <!-- Ambient atmospheric glow -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#22C55E]/15 rounded-full blur-[140px] pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-emerald-600/10 rounded-full blur-[120px] pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-flex items-center justify-center gap-3 mb-4">
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
                <span class="text-xs sm:text-sm font-black tracking-widest text-[#22C55E] uppercase font-heading">
                    {{ __('HELP & CORRIDOR GUIDE') }}
                </span>
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading text-white drop-shadow-md">
                {{ __('Frequently Asked Questions') }}
            </h1>
            <p class="mt-4 text-sm sm:text-base lg:text-lg text-slate-200 max-w-2xl mx-auto leading-relaxed drop-shadow-xs">
                {{ __('Everything you need to know about our daily Montreal ↔ Toronto intercity passenger shuttle, predefined stations, luggage guidelines, and cash settlement upon boarding.') }}
            </p>
        </div>
    </section>

    <!-- FAQ Main Content Section (Optimized for Mobile & 2-Column Help Center on Desktop) -->
    <section class="py-14 sm:py-20 lg:py-24 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                <!-- Left Column (Desktop Only): Sticky Navigation & Quick Support Sidebar (4 cols) -->
                <aside class="hidden lg:block lg:col-span-4 sticky top-28 space-y-6">
                    
                    <!-- Topic Navigation Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs">
                        <span class="text-xs font-black tracking-widest text-slate-400 uppercase block mb-4">
                            {{ __('BROWSE BY TOPIC') }}
                        </span>
                        <nav class="space-y-2">
                            <a href="#category-fares"
                                class="flex items-center justify-between p-3 rounded-2xl text-sm font-bold text-slate-700 hover:text-[#16A34A] hover:bg-[#E8FBF0]/60 transition">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#22C55E]/15 text-[#16A34A] text-xs font-bold">$</span>
                                    <span>{{ __('Fares & Payment') }}</span>
                                </div>
                                <span class="text-xs text-slate-400 font-semibold font-mono">3 Qs</span>
                            </a>
                            <a href="#category-stations"
                                class="flex items-center justify-between p-3 rounded-2xl text-sm font-bold text-slate-700 hover:text-[#16A34A] hover:bg-[#E8FBF0]/60 transition">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#22C55E]/15 text-[#16A34A] text-xs font-bold">📍</span>
                                    <span>{{ __('Stations & Schedules') }}</span>
                                </div>
                                <span class="text-xs text-slate-400 font-semibold font-mono">3 Qs</span>
                            </a>
                            <a href="#category-seating"
                                class="flex items-center justify-between p-3 rounded-2xl text-sm font-bold text-slate-700 hover:text-[#16A34A] hover:bg-[#E8FBF0]/60 transition">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#22C55E]/15 text-[#16A34A] text-xs font-bold">💺</span>
                                    <span>{{ __('Seating & Amenities') }}</span>
                                </div>
                                <span class="text-xs text-slate-400 font-semibold font-mono">3 Qs</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Direct Support Card -->
                    <div class="rounded-3xl bg-[#111827] text-white p-6 border border-slate-800 shadow-md relative overflow-hidden">
                        <div class="absolute -right-12 -top-12 w-36 h-36 bg-[#22C55E]/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10 space-y-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#22C55E] block">
                                {{ __('NEED DIRECT HELP?') }}
                            </span>
                            <h3 class="text-lg font-bold font-heading text-white">
                                {{ __('Talk to Dispatch') }}
                            </h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                {{ __('Live support available 7 days a week from 6:00 AM to 9:00 PM EST for travel inquiries.') }}
                            </p>
                            <div class="pt-2">
                                <a href="tel:6476551884"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 text-white py-2.5 px-4 text-xs font-bold border border-white/20 transition cursor-pointer">
                                    <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ __('Call / SMS / WhatsApp: 647-655-1884') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Fast Reservation Card -->
                    <div class="rounded-3xl border border-[#22C55E]/30 bg-[#E8FBF0]/50 p-6 shadow-xs text-center space-y-3">
                        <span class="text-xs font-black tracking-wider text-[#16A34A] uppercase block">
                            {{ __('DAILY PASSENGER SHUTTLE') }}
                        </span>
                        <h4 class="text-base font-bold text-slate-900">
                            {{ __('Ready to Travel Between Montreal & Toronto?') }}
                        </h4>
                        <p class="text-xs text-slate-600">
                            {{ __('Fixed flat fare of $:fare CAD. Cash settlement upon boarding.', ['fare' => number_format($regularFare, 0)]) }}
                        </p>
                        <button type="button" onclick="handleGlobalBookNow()"
                            class="w-full inline-flex min-h-[44px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs font-bold shadow-md shadow-[#22C55E]/20 transition cursor-pointer">
                            <span>{{ __('Reserve Your Seat') }}</span>
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                </aside>

                <!-- Right Column: Accordion Questions & Category Sections (8 cols on desktop, full width on mobile) -->
                <div class="w-full lg:col-span-8 space-y-12 sm:space-y-16">

                    <!-- Category 1: Fares & Cash Settlement -->
                    <div id="category-fares" class="scroll-mt-32">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#22C55E]/15 text-[#16A34A] font-black text-xl">
                                $
                            </span>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                                    {{ __('Fares & Cash Settlement') }}
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-500">{{ __('Transparent flat pricing with zero hidden surcharges.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3.5">
                            <!-- Q1 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200" open>
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('How do I pay for my trip?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Payment is simple and cash-only ($:fare CAD flat fare). You pay the driver directly in cash when boarding the vehicle at your station. No online credit card deposit or upfront electronic payment is required to book your seat.', ['fare' => number_format($regularFare, 0)]) }}
                                </p>
                            </details>

                            <!-- Q2 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('How much is the regular fare vs. promotional launch rate?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Our standard flat rate is $:regular CAD per seat per trip. By applying the introductory promo code :code during reservation, you enjoy our promotional rate of only $:promo CAD ($:savings CAD savings per seat).', ['regular' => number_format($regularFare, 0), 'promo' => number_format($promotionalFare, 0), 'code' => 'LAUNCH10', 'savings' => 10]) }}
                                </p>
                            </details>

                            <!-- Q3 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('Are there any booking fees, taxes, or hidden surcharges?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('None. The price you see ($:regular CAD or $:promo CAD with promo code) is the exact amount you hand to the driver upon boarding. There are zero booking platform fees or surge surcharges.', ['regular' => number_format($regularFare, 0), 'promo' => number_format($promotionalFare, 0)]) }}
                                </p>
                            </details>
                        </div>
                    </div>

                    <!-- Category 2: Stations & Schedules -->
                    <div id="category-stations" class="scroll-mt-32">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#22C55E]/15 text-[#16A34A]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                                    {{ __('Stations & Schedules') }}
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-500">{{ __('Fixed daily departures 7 days a week, 365 days a year.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3.5">
                            <!-- Q4 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('Where are the exact pickup and drop-off stations?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <div class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed space-y-2">
                                    <p>{{ __('PickMeRoute operates strictly between 3 predefined transit hubs with immediate subway and highway connectivity:') }}</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li><strong class="text-slate-900">{{ $namurLoc?->localized_name ?? 'Station Métro Namur' }} ({{ __('Montreal') }}):</strong> {{ __('Décarie corridor with direct Orange Line Métro access.') }}</li>
                                        <li><strong class="text-slate-900">{{ $yorkdaleLoc?->localized_name ?? 'Yorkdale Mall' }} ({{ __('Toronto') }}):</strong> {{ __('Direct access to TTC Subway Line 1 and Highway 401.') }}</li>
                                        <li><strong class="text-slate-900">{{ $yongeLoc?->localized_name ?? 'Yonge Station' }} ({{ __('Toronto') }}):</strong> {{ __('TTC Line 1 connectivity along the Yonge Street corridor.') }}</li>
                                    </ul>
                                </div>
                            </details>

                            <!-- Q5 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('What are the daily departure times?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <div class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed space-y-2">
                                    <p><strong class="text-slate-900">{{ __('Route A') }} ({{ __('Montreal → Toronto') }}):</strong> {{ __('Departs :station daily at :time EST sharp.', ['station' => $namurLoc?->localized_name ?? 'Station Métro Namur', 'time' => $routeATime]) }}</p>
                                    <p><strong class="text-slate-900">{{ __('Route B') }} ({{ __('Toronto → Montreal') }}):</strong> {{ __('Pickups at :yorkdale at :yorkdaleTime EST and :yonge at :yongeTime EST, arriving in Montreal around :arrival EST.', ['yorkdale' => $yorkdaleLoc?->localized_name ?? 'Yorkdale Mall', 'yorkdaleTime' => $yorkdalePickupTime, 'yonge' => $yongeLoc?->localized_name ?? 'Yonge Station', 'yongeTime' => $yongePickupTime, 'arrival' => $namurArrivalTime]) }}</p>
                                </div>
                            </details>

                            <!-- Q6 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('How early should I arrive at the pickup station?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Please arrive at your pickup station at least 15 minutes prior to the scheduled departure time. Our driver verifies your reservation name, assists with loading your luggage, and conducts quick cash boarding.') }}
                                </p>
                            </details>
                        </div>
                    </div>

                    <!-- Category 3: Seating & Vehicle Amenities -->
                    <div id="category-seating" class="scroll-mt-32">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#22C55E]/15 text-[#16A34A]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-[#111827] font-heading tracking-tight">
                                    {{ __('Seating & Vehicle Amenities') }}
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-500">{{ __('Executive Honda Odyssey with guaranteed reserved seats.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3.5">
                            <!-- Q7 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('Can I choose my specific seat or book multiple seats?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Yes! Our booking system provides an interactive vehicle cabin diagram. You can book from 1 to :count seats in a single reservation and pick the exact seats (S1 front passenger window, S2–S6 cabin seats) so you and your group sit together.', ['count' => $passengerSeatsCount]) }}
                                </p>
                            </details>

                            <!-- Q8 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('What vehicle do you operate?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Our primary fleet is a Silver :model (License Plate: :plate). It features leather interior, multi-zone automatic climate control, USB charging ports, and executive cabin comfort.', ['model' => $vehicleModel, 'plate' => $vehiclePlate]) }}
                                </p>
                            </details>

                            <!-- Q9 -->
                            <details class="group rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 transition-all duration-200">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                                    <span>{{ __('What is your luggage allowance?') }}</span>
                                    <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-600 group-open:bg-[#22C55E] group-open:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </summary>
                                <p class="mt-3.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                                    {{ __('Each passenger is allowed 1 standard check-in suitcase (up to 50 lbs / 23 kg) in the trunk plus 1 personal item (backpack, laptop bag, or purse) inside the cabin. If you are traveling with extra or oversized luggage, please inform us in advance via phone or WhatsApp.') }}
                                </p>
                            </details>
                        </div>
                    </div>

                    <!-- Bottom Live Assistance Banner for Mobile & Tablet -->
                    <div class="rounded-3xl bg-[#111827] text-white p-8 sm:p-10 border border-slate-800 shadow-xl relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 w-60 h-60 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="text-center md:text-left">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#22C55E] block mb-1">
                                    {{ __('LIVE ASSISTANCE') }}
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-black font-heading tracking-tight">
                                    {{ __('Still have questions?') }}
                                </h3>
                                <p class="mt-2 text-sm text-slate-300 max-w-md">
                                    {{ __('Our team is live 7 days a week to help with custom pickups, booking confirmation, or questions.') }}
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
                                    <span>{{ __('Book Now') }}</span>
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
