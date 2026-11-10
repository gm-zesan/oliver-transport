@extends('frontend.layout.app')

@section('title', 'Services & Daily Routes — PickMeRoute Montreal ↔ Toronto Passenger Shuttle')

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

    <!-- Services Page Cinematic Hero Header -->
    <section
        class="relative bg-[#0B0F17] pt-32 pb-20 sm:pt-36 sm:pb-24 lg:pt-40 lg:pb-28 border-b border-slate-800 text-white overflow-hidden bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(180deg, rgba(11, 15, 23, 0.90) 0%, rgba(11, 15, 23, 0.78) 50%, rgba(11, 15, 23, 0.96) 100%), url('{{ asset('images/service-intercity.jpg') }}');">

        <!-- Ambient Atmospheric Glow -->
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-[#22C55E]/15 rounded-full blur-[140px] pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-emerald-600/10 rounded-full blur-[120px] pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-flex items-center justify-center gap-3 mb-4">
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
                <span class="text-xs sm:text-sm font-black tracking-widest text-[#22C55E] uppercase font-heading">
                    OUR CORRIDOR SERVICES
                </span>
                <span class="w-6 sm:w-8 h-[1.5px] bg-[#22C55E]"></span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading text-white drop-shadow-md">
                Intercity Shuttle Services
            </h1>
            <p class="mt-4 text-sm sm:text-base lg:text-lg text-slate-200 max-w-2xl mx-auto leading-relaxed drop-shadow-xs">
                Daily fixed-schedule passenger transportation connecting Montreal and Toronto. Reserved visual seating, cash
                settlement upon boarding, and executive comfort in our Honda Odyssey fleet.
            </p>
        </div>
    </section>

    <!-- Core Routes Section (Route A & Route B) -->
    <section id="core-routes" class="relative py-20 lg:py-28 bg-white border-b border-slate-100 overflow-hidden">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/5 rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute bottom-0 left-10 w-80 h-80 bg-slate-100/60 rounded-full blur-2xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-16 space-y-2.5 sm:space-y-3">
                <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                    DAILY SCHEDULED CORRIDORS
                </span>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    Select Your Daily Route
                </h2>
                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto">
                    Operating 7 days a week, 365 days a year between Montreal and Toronto. Flat rate of
                    ${{ number_format($regularFare, 0) }} CAD with cash settlement on boarding.
                </p>
            </div>

            <!-- 2 Core Services Grid: Route A & Route B (Dynamic from Database) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                @foreach($routesViewData as $routeItem)
                    <div
                        class="group relative rounded-3xl bg-white p-0 sm:p-7 flex flex-col sm:flex-row items-stretch gap-0 sm:gap-6 border border-slate-200/80 shadow-sm hover:shadow-2xl hover:shadow-[#22C55E]/10 hover:border-[#22C55E]/50 transition-all duration-300 overflow-hidden">
                        <div
                            class="w-full sm:w-[46%] h-[210px] sm:h-auto min-h-[210px] sm:min-h-[220px] rounded-none sm:rounded-2xl overflow-hidden flex-shrink-0 bg-slate-900">
                            <img src="{{ $routeItem['image_path'] }}" alt="PickMeRoute {{ $routeItem['name'] }} Shuttle"
                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out" />
                        </div>
                        <div class="w-full sm:w-[54%] flex flex-col justify-between p-5 sm:p-0 sm:py-1">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5 sm:mb-2">
                                    <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#16A34A]">
                                        {{ $routeItem['service_label'] }}
                                    </span>
                                    <span class="text-base sm:text-sm font-black text-slate-900 font-mono">
                                        ${{ number_format($routeItem['regular_fare'], 0) }} <span
                                            class="text-xs font-semibold text-slate-500 font-sans">CAD</span>
                                    </span>
                                </div>

                                <h3
                                    class="text-xl sm:text-2xl font-bold text-[#111827] tracking-tight font-heading group-hover:text-[#16A34A] transition-colors">
                                    {{ $routeItem['name'] }}
                                </h3>

                                <div class="mt-3.5 sm:mt-4 space-y-3 sm:space-y-2.5 text-xs sm:text-sm text-slate-700">
                                    <div class="flex items-start gap-2.5">
                                        <span class="flex sm:hidden text-[#16A34A] flex-shrink-0 mt-0.5">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <span
                                            class="hidden sm:flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="leading-relaxed">
                                            <strong class="font-bold text-slate-900">{{ $routeItem['pickup_label'] }}</strong>
                                            <span class="font-normal text-slate-600">{{ $routeItem['pickup_text'] }}</span>
                                        </span>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="flex sm:hidden text-[#16A34A] flex-shrink-0 mt-0.5">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <span
                                            class="hidden sm:flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="leading-relaxed">
                                            <strong class="font-bold text-slate-900">{{ $routeItem['dropoff_label'] }}</strong>
                                            <span class="font-normal text-slate-600">{{ $routeItem['dropoff_text'] }}</span>
                                        </span>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="flex sm:hidden text-[#16A34A] flex-shrink-0 mt-0.5">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <span
                                            class="hidden sm:flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="leading-relaxed font-normal text-slate-600 sm:text-slate-700">
                                            <span class="sm:hidden">Cash payment upon boarding with driver</span>
                                            <span class="hidden sm:inline">Cash payment upon boarding with driver
                                                ({{ '$' . number_format($routeItem['regular_fare'], 0) }} CAD)</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-4 sm:mt-6 pt-0 sm:pt-4 sm:border-t sm:border-slate-200/70 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                                <div class="order-1 sm:order-2 self-start sm:self-auto">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#E8FBF0] text-[#16A34A] text-xs font-semibold sm:bg-transparent sm:p-0 sm:text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-[#16A34A] sm:hidden flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        <span>{{ $routeItem['seats_count'] }} Passenger Seats</span>
                                    </span>
                                </div>

                                <div class="order-2 sm:order-1 w-full sm:w-auto">
                                    <a href="javascript:void(0)" onclick="handleGlobalBookNow('{{ $routeItem['btn_key'] }}')"
                                        class="flex sm:inline-flex w-full sm:w-auto min-h-[48px] sm:min-h-[44px] items-center justify-center gap-2 rounded-2xl sm:rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-3 sm:py-2.5 text-sm font-bold transition duration-200 shadow-md sm:shadow-sm hover:shadow-lg cursor-pointer">
                                        <span>Book
                                            {{ $routeItem['direction_code'] === 'MTL_TO_TOR' ? 'Route A' : 'Route B' }}</span>
                                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Executive Fleet & Cabin Amenities Section -->
    <section class="py-20 lg:py-28 bg-[#F8FAFC] border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                    PASSENGER EXPERIENCE
                </span>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    Travel in Executive Comfort
                </h2>
                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto">
                    Our Silver {{ $vehicleModel }} (Plate: {{ $vehiclePlate }}) is configured for high comfort and peace of
                    mind on the 540km corridor.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Guaranteed Reserved Seat</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Select your exact seat (S1–S{{ $passengerSeatsCount }}) on our interactive vehicle cabin diagram. We
                        never overbook or reassign seats without consent.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Dual Climate Control</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Front and rear independent climate zones ensure ideal cabin temperatures throughout hot summers and
                        cold Canadian winters.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Luggage Allowance</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Each passenger reservation includes 1 standard travel bag/suitcase in the rear luggage trunk plus 1
                        personal item (backpack/purse) inside the cabin.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Cash Settlement on Boarding</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Book online with instant confirmation and pay the driver directly in cash upon boarding. No
                        pre-payment friction or credit card processing fees.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Fixed Transit Stations</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Direct connection between Station Métro Namur in Montreal and Yorkdale Mall &amp; Yonge Station in
                        Toronto. Convenient subway and highway accessibility.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="rounded-3xl bg-white p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition">
                    <div class="h-12 w-12 rounded-2xl bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Commercial Insurance &amp; Safety</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Full commercial passenger liability insurance on every scheduled run with dedicated, professional
                        commercial drivers.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-Footer Action Banner -->
    <section class="relative py-14 sm:py-20 lg:py-24 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="rounded-3xl bg-gradient-to-br from-[#111827] to-[#0B0F17] text-white p-7 sm:p-10 lg:p-12 border border-slate-800 shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
                <div
                    class="absolute -right-20 -bottom-20 w-72 h-72 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none">
                </div>

                <div class="relative z-10 text-center lg:text-left space-y-2.5 max-w-xl">
                    <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase block">
                        READY TO TRAVEL?
                    </span>
                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading tracking-tight leading-tight">
                        Reserve Your Seat on Today's Shuttle
                    </h3>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                        Instant online seat selection with cash settlement upon boarding. Montreal to Toronto and Toronto to
                        Montreal departures daily.
                    </p>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center gap-3.5 w-full lg:w-auto">
                    <button type="button" onclick="handleGlobalBookNow()"
                        class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-7 py-3 text-sm font-bold shadow-lg shadow-[#22C55E]/30 transition cursor-pointer">
                        <span>Select Seats &amp; Reserve</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <a href="{{ route('faq') }}"
                        class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 text-white px-6 py-3 text-sm font-bold border border-white/20 transition cursor-pointer">
                        <span>Browse FAQs</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection