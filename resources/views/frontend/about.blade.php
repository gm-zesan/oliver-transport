@extends('frontend.layout.app')

@section('title', __('About Us — PickMeRoute Montreal ↔ Toronto Passenger Shuttle'))

@section('content')
    <script>
        window.PICKME_CONFIG = window.OLIVER_CONFIG = {
            regularFare: {{ $regularFare }},
            promotionalFare: {{ $promotionalFare }},
            currency: 'CAD',
            vehicle: {
                model: @json($vehicleModel),
                plate: @json($vehiclePlate),
                capacity: {{ $passengerSeatsCount }}
            },
            stations: @json($clientStations),
            routes: @json($clientRoutes)
        };
    </script>

    <!-- About Page Cinematic Hero Header -->
    <section class="relative bg-[#0B0F17] pt-32 pb-20 sm:pt-36 sm:pb-24 lg:pt-40 lg:pb-28 border-b border-slate-800 text-white overflow-hidden bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(180deg, rgba(11, 15, 23, 0.90) 0%, rgba(11, 15, 23, 0.78) 50%, rgba(11, 15, 23, 0.96) 100%), url('{{ asset('images/honda-odyssey-fleet-raw.jpg') }}');">

        <!-- Ambient Atmospheric Glow -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#22C55E]/15 rounded-full blur-[140px] pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-emerald-600/10 rounded-full blur-[120px] pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-flex items-center justify-center gap-3 mb-4">
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
                <span class="text-xs sm:text-sm font-black tracking-widest text-[#22C55E] uppercase font-heading">
                    {{ __('ABOUT PICKMEROUTE') }}
                </span>
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading text-white drop-shadow-md">
                {{ __('Redefining Montreal ↔ Toronto Travel') }}
            </h1>
            <p class="mt-4 text-sm sm:text-base lg:text-lg text-slate-200 max-w-2xl mx-auto leading-relaxed drop-shadow-xs">
                {{ __('Founded to offer a clean, punctual, and personal alternative to crowded coach buses, PickMeRoute connects Quebec and Ontario daily with guaranteed reserved seating.') }}
            </p>
        </div>
    </section>

    <!-- Our Mission & Fleet Showcase Section -->
    <section class="py-20 lg:py-28 bg-white border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <!-- Left: Our Story & Philosophy (7 cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase block">
                        {{ __('OUR STORY & PURPOSE') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                        {{ __('Built Around Punctuality, Transparency, and Executive Comfort') }}
                    </h2>
                    <p class="text-base text-[#64748B] leading-relaxed">
                        {{ __('Traveling between Montreal and Toronto should never feel stressful, overcrowded, or unpredictable. PickMeRoute operates a dedicated daily intercity corridor designed specifically for commuters, students, families, and business travelers who value guaranteed seating and straightforward service.') }}
                    </p>
                    <p class="text-base text-[#64748B] leading-relaxed">
                        {{ __('Instead of confusing multi-stop bus terminals or unreliable last-minute ride-shares, we operate strictly on fixed daily schedules connecting three highly accessible transit hubs: :namur in Montreal, and :yorkdale & :yonge in Toronto.', ['namur' => $namurLoc?->localized_name ?? 'Station Métro Namur', 'yorkdale' => $yorkdaleLoc?->localized_name ?? 'Yorkdale Mall', 'yonge' => $yongeLoc?->localized_name ?? 'Yonge Station']) }}
                    </p>

                    <!-- Key Highlights Row -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4">
                        <div class="rounded-2xl bg-[#F8FAFC] border border-slate-200/80 p-4">
                            <span class="text-2xl sm:text-3xl font-black text-[#16A34A] font-mono block">365</span>
                            <span class="text-xs font-bold text-slate-600 mt-1 block">{{ __('Days/Year Service') }}</span>
                        </div>
                        <div class="rounded-2xl bg-[#F8FAFC] border border-slate-200/80 p-4">
                            <span class="text-2xl sm:text-3xl font-black text-[#16A34A] font-mono block">{{ $passengerSeatsCount }}</span>
                            <span class="text-xs font-bold text-slate-600 mt-1 block">{{ __('Reserved Seats Max') }}</span>
                        </div>
                        <div class="col-span-2 sm:col-span-1 rounded-2xl bg-[#F8FAFC] border border-slate-200/80 p-4">
                            <span class="text-2xl sm:text-3xl font-black text-[#16A34A] font-mono block">${{ number_format($regularFare, 0) }}</span>
                            <span class="text-xs font-bold text-slate-600 mt-1 block">{{ __('CAD Flat Rate') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Fleet Highlight Card (5 cols) -->
                <div class="lg:col-span-5">
                    <div class="rounded-3xl bg-[#111827] text-white border border-slate-800 shadow-2xl overflow-hidden">
                        <div class="h-56 sm:h-64 w-full overflow-hidden relative bg-slate-900">
                            <img src="{{ asset('images/service-corporate.jpg') }}" alt="PickMeRoute {{ $vehicleModel }} Fleet"
                                class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-transparent to-transparent"></div>
                            <span class="absolute top-4 right-4 px-3 py-1 rounded-full bg-[#22C55E] text-white text-xs font-black tracking-wider uppercase shadow-md">
                                {{ __('Active Fleet') }}
                            </span>
                        </div>
                        <div class="p-7 space-y-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-[#22C55E] block">{{ __('Commercial Passenger Minivan') }}</span>
                                <h3 class="text-2xl font-black font-heading text-white mt-1">
                                    Silver {{ $vehicleModel }}
                                </h3>
                                <p class="text-xs text-slate-400 font-mono mt-0.5">{{ __('Ontario License Plate: :plate', ['plate' => $vehiclePlate]) }}</p>
                            </div>
                            <ul class="space-y-2.5 text-sm text-slate-300 border-t border-slate-800 pt-4">
                                <li class="flex items-center gap-2.5">
                                    <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('1 Front Window Seat (S1) + 5 Rear Cabin Seats (S2–S6)') }}</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Leather Interior, Dual Climate & Privacy Tinting') }}</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Routine Safety Maintenance & Commercial Coverage') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Why Choose Us Interactive Frosted Glass Section -->
    <section id="why-us"
        class="relative py-24 lg:py-32 bg-[#0B0F17] overflow-hidden border-b border-slate-800 text-white bg-cover bg-no-repeat bg-[center_left]"
        style="background-image: url('{{ asset('images/why-us-luxury-transport-flipped.jpg') }}'); background-position: left center; background-size: cover;">

        <!-- Luminous Vignette Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-950/35 to-slate-950/75 pointer-events-none" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/60 pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex flex-col lg:flex-row items-center justify-end">

                <!-- RIGHT SIDE: Translucent Frosted Glass Card -->
                <div class="w-full lg:w-[520px] xl:w-[560px]">
                    <div class="rounded-[36px] bg-slate-950/55 sm:bg-slate-900/45 backdrop-blur-2xl lg:backdrop-blur-3xl border border-white/25 p-7 sm:p-10 lg:p-12 shadow-2xl shadow-black/80 ring-1 ring-white/10 relative overflow-hidden">

                        <!-- Top Specular Highlight Edge -->
                        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent pointer-events-none"></div>
                        <div class="absolute -top-24 -right-24 w-52 h-52 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>

                        <div class="space-y-3 mb-6 relative z-10 text-center lg:text-left">
                            <div>
                                <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase">
                                    {{ __('WHY CHOOSE US') }}
                                </span>
                            </div>

                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight font-heading leading-tight drop-shadow-sm text-center lg:text-left">
                                {{ __('Why Select Us for Your Journey') }}
                            </h2>

                            <p class="text-sm text-slate-200 leading-relaxed text-center lg:text-left">
                                {{ __('Premium comfort, guaranteed seating, and reliable daily intercity transit.') }}
                            </p>
                        </div>

                        <!-- Clean Accordion List with Frosted Dividers -->
                        <div class="mt-8 space-y-3.5 divide-y divide-white/15 relative z-10">

                            <!-- Item 1: Best Rate Guarantee -->
                            <details class="group pt-3.5 first:pt-0" open>
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <span class="text-[#22C55E] font-bold text-lg leading-none">$</span>
                                        <span>{{ __('Best Rate Guarantee') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    {{ __('Guaranteed flat fare of $:fare CAD per passenger per trip with zero hidden fees. Cash Payment Upon Boarding: Pay the driver directly in cash when boarding.', ['fare' => number_format($regularFare, 0)]) }}
                                </div>
                            </details>

                            <!-- Item 2: Insurance Protected -->
                            <details class="group pt-3.5">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span>{{ __('Insurance Protected') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    {{ __('Full commercial passenger insurance coverage on all trips with courteous, experienced, and dedicated drivers.') }}
                                </div>
                            </details>

                            <!-- Item 3: Always Available -->
                            <details class="group pt-3.5">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                        </svg>
                                        <span>{{ __('Always Available') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    {{ __('Daily fixed departures 7 days a week, 365 days a year: :routeA from Montreal, :yorkdale & :yonge from Toronto.', ['routeA' => $routeATime, 'yorkdale' => $yorkdalePickupTime, 'yonge' => $yongePickupTime]) }}
                                </div>
                            </details>

                            <!-- Item 4: Montreal ↔ Toronto Hubs -->
                            <details class="group pt-3.5">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ __('Montreal ↔ Toronto Hubs') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    {{ __('Direct service connecting :namur in Montreal with :yorkdale and :yonge in Toronto.', ['namur' => $namurLoc?->localized_name ?? 'Station Métro Namur', 'yorkdale' => $yorkdaleLoc?->localized_name ?? 'Yorkdale Mall', 'yonge' => $yongeLoc?->localized_name ?? 'Yonge Station']) }}
                                </div>
                            </details>

                            <!-- Item 5: Fleet & Cabin Seating -->
                            <details class="group pt-3.5">
                                <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 5h8m-8 5h8M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                        <span>{{ __('Fleet & Cabin Seating') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    {{ __('Travel in our :model (Plate: :plate) featuring exactly :seats Passenger Seats, leather interior, and climate control for executive comfort.', ['model' => $vehicleModel, 'plate' => $vehiclePlate, 'seats' => $passengerSeatsCount]) }}
                                </div>
                            </details>

                        </div>

                        <!-- CTA Button -->
                        <div class="mt-8 pt-6 border-t border-white/15 relative z-10">
                            <button type="button" onclick="handleGlobalBookNow()"
                                class="inline-flex items-center justify-center gap-2.5 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-xl shadow-[#22C55E]/30 transition-all duration-200 hover:scale-[1.02] cursor-pointer min-h-[50px]">
                                <span>{{ __('Reserve Your Seat') }}</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Fixed Station Hubs Showcase -->
    <section class="py-20 lg:py-28 bg-[#F8FAFC] border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                    {{ __('FIXED TRANSIT LOCATIONS') }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    {{ __('Our 3 Corridor Station Hubs') }}
                </h2>
                <p class="text-base text-[#64748B] leading-relaxed">
                    {{ __('Every stop is selected for maximum metro/subway convenience, safe passenger loading, and quick highway access.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- Hub 1 -->
                <div class="rounded-3xl bg-white border border-slate-200/80 p-7 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full bg-[#E8FBF0] text-[#16A34A] text-xs font-black uppercase tracking-wider">{{ __('Montreal Hub') }}</span>
                        <span class="text-xs font-mono font-bold text-slate-400">QC</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-heading">{{ $namurLoc?->localized_name ?? 'Station Métro Namur' }}</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        {{ __('Conveniently positioned right at the Orange Line metro exit. Serves as our Route A morning boarding (:time) and Route B evening destination (:arrival EST).', ['time' => $routeATime, 'arrival' => $namurArrivalTime]) }}
                    </p>
                </div>

                <!-- Hub 2 -->
                <div class="rounded-3xl bg-white border border-slate-200/80 p-7 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full bg-[#E8FBF0] text-[#16A34A] text-xs font-black uppercase tracking-wider">{{ __('Toronto Hub 1') }}</span>
                        <span class="text-xs font-mono font-bold text-slate-400">ON</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-heading">{{ $yorkdaleLoc?->localized_name ?? 'Yorkdale Mall' }}</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        {{ __('Easy access from Highway 401 and TTC Line 1. Serves as Route A\'s first Toronto drop-off and Route B\'s afternoon primary pickup (:time).', ['time' => $yorkdalePickupTime]) }}
                    </p>
                </div>

                <!-- Hub 3 -->
                <div class="rounded-3xl bg-white border border-slate-200/80 p-7 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full bg-[#E8FBF0] text-[#16A34A] text-xs font-black uppercase tracking-wider">{{ __('Toronto Hub 2') }}</span>
                        <span class="text-xs font-mono font-bold text-slate-400">ON</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-heading">{{ $yongeLoc?->localized_name ?? 'Yonge Station' }}</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        {{ __('Central North York / Midtown transit access with direct TTC subway connection. Serves as Route A\'s final drop-off and Route B\'s second pickup (:time).', ['time' => $yongePickupTime]) }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-Footer Action Banner -->
    <section class="relative py-14 sm:py-20 lg:py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-br from-[#111827] to-[#0B0F17] text-white p-7 sm:p-10 lg:p-12 border border-slate-800 shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="absolute -right-20 -bottom-20 w-72 h-72 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 text-center lg:text-left space-y-2.5 max-w-xl">
                    <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase block">
                        {{ __('HAVE QUESTIONS OR READY TO BOOK?') }}
                    </span>
                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading tracking-tight leading-tight">
                        {{ __('Travel Between Montreal & Toronto With Confidence') }}
                    </h3>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                        {{ __('Reserve your visual cabin seat online now and pay cash upon boarding, or reach out to our team 7 days a week.') }}
                    </p>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center gap-3.5 w-full lg:w-auto">
                    <button type="button" onclick="handleGlobalBookNow()"
                        class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-7 py-3 text-sm font-bold shadow-lg shadow-[#22C55E]/30 transition cursor-pointer">
                        <span>{{ __('Reserve Your Seat') }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <a href="{{ route('services') }}"
                        class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 text-white px-6 py-3 text-sm font-bold border border-white/20 transition cursor-pointer">
                        <span>{{ __('View Daily Services') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
