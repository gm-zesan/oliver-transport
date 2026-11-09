@extends('frontend.layout.app')

@section('title', 'PickMeRoute — Daily Montreal ↔ Toronto Passenger Shuttle')

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

    <!-- 1. HERO SECTION: Cinematic Video Background with Dark Gradient Overlay & Glass Booking Panel -->
    <section
        class="relative min-h-[92vh] flex items-center justify-center overflow-hidden bg-[#111827] pt-28 pb-16 sm:pt-32 sm:pb-20 lg:pt-36 lg:pb-24 border-b border-slate-800">

        <!-- Background Video Loop with Dark Cinematic Overlay -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <video autoplay muted loop playsinline poster="{{ asset('images/hero-video-poster.jpg') }}"
                class="w-full h-full object-cover scale-105">
                <source src="{{ asset('videos/hero-odyssey-loop.mp4') }}" type="video/mp4">
            </video>
            <!-- Refined Lighter Cinematic Overlay for Maximum Luminous Visibility & Clarity -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#111827]/75 via-[#111827]/60 to-black/50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/70 via-transparent to-black/20"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16">

                <!-- LEFT SIDE: Spacious, High-Impact Brand Messaging (approx 50%) -->
                <div
                    class="lg:w-[50%] w-full flex flex-col justify-center items-center lg:items-start text-center lg:text-left">

                    <!-- Main Heading matching Reference Image 1 -->
                    <h1
                        class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-black tracking-tight text-white leading-[1.05] font-heading drop-shadow-sm text-center lg:text-left">
                        Your Journey,<br />
                        <span class="text-[#22C55E]">Our Priority.</span>
                    </h1>

                    <!-- Subtitle matching Reference Image 1 -->
                    <p
                        class="mt-4 sm:mt-6 text-lg sm:text-2xl lg:text-3xl font-bold text-white tracking-tight leading-snug drop-shadow-sm text-center lg:text-left">
                        Travel in Comfort. Arrive in Style.
                    </p>

                    <!-- Description with Green Vertical Line (Hidden on Mobile <lg) -->
                    <div class="hidden lg:flex mt-7 items-stretch gap-4">
                        <span class="w-1 bg-[#22C55E] rounded-full flex-shrink-0"></span>
                        <p class="text-sm sm:text-base text-slate-200 leading-relaxed font-normal max-w-lg drop-shadow-sm">
                            Experience reliable, comfortable and<br class="hidden sm:inline" />
                            professional transportation with PickMeRoute.
                        </p>
                    </div>
                </div>

                <!-- RIGHT SIDE: Translucent Glass Booking Form -->
                <div class="lg:w-[46%] w-full flex justify-center lg:justify-end">
                    <div id="booking-panel"
                        class="w-full max-w-md rounded-3xl p-6 sm:p-7 shadow-2xl shadow-black/50 border border-white/15 bg-[#111827]/50 backdrop-blur-2xl transition duration-200 scroll-mt-20 sm:scroll-mt-24">

                        <!-- Top Auto-Detected Route & Scheduled Time Header -->
                        <div class="flex items-center justify-between pb-3.5 border-b border-white/10">
                            <div class="flex items-center gap-2">
                                <span id="hero-route-badge" class="text-xs sm:text-sm font-bold text-white tracking-wide">
                                    {{ $routeA?->name ?? 'Montreal → Toronto' }}
                                </span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/10">
                                <svg class="h-3.5 w-3.5 text-[#22C55E]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="hero-schedule-badge" class="text-xs font-black text-white">
                                    {{ $routeATime }} Daily
                                </span>
                            </div>
                        </div>

                        <!-- Booking Form with Uber-Style Dropdowns -->
                        <form id="hero-booking-form" action="{{ route('login') }}" method="GET" class="mt-4 space-y-3">

                            <!-- 1. Pick Up Address Input (Uber-Style Dropdown) -->
                            <div class="relative" id="pickup-field-wrapper">
                                <div onclick="togglePickupDropdown()"
                                    class="rounded-2xl border border-white/15 bg-white/10 hover:bg-white/15 focus-within:bg-white/20 focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition cursor-pointer p-3.5 flex items-center gap-3 shadow-xs select-none">

                                    <!-- Left Pin -->
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="h-3 w-3 rounded-full border-2 border-[#22C55E] bg-slate-900 ring-2 ring-[#22C55E]/30"></span>
                                    </div>

                                    <!-- Center: Label and Selected Text -->
                                    <div class="flex-1 min-w-0">
                                        <span id="label-pickup"
                                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                            Pickup address
                                        </span>
                                        <span id="pickup-display-text"
                                            class="block text-sm sm:text-base font-medium text-slate-300 truncate leading-snug">
                                            Select pickup location
                                        </span>
                                        <input type="hidden" name="from" id="pickup_location" value="">
                                    </div>

                                    <!-- Right: Navigation Arrow -->
                                    <div class="text-[#22C55E] transition flex-shrink-0">
                                        <svg class="h-4 w-4 transform -rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Floating Dropdown Menu -->
                                <div id="pickup-dropdown-menu"
                                    class="absolute left-0 right-0 top-full mt-2 z-50 rounded-2xl bg-[#1E232A] shadow-2xl border border-slate-700 divide-y divide-slate-800 hidden overflow-hidden text-white">

                                    <div
                                        class="px-4 py-2 bg-slate-900 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                        Select Pickup Address
                                    </div>

                                    @foreach($locations as $loc)
                                        <div onclick="selectPickup('{{ $loc->code }}')"
                                            class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                            <div
                                                class="w-10 h-10 rounded-full {{ $loc->code === 'namur' ? 'bg-[#22C55E]/20 text-[#22C55E]' : 'bg-slate-800 text-white' }} flex items-center justify-center flex-shrink-0 shadow-xs">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="font-bold text-white text-sm sm:text-base leading-tight">{{ $loc->name }}</span>
                                                    <span
                                                        class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] bg-[#22C55E]/15 px-2 py-0.5 rounded-full border border-[#22C55E]/30">{{ $loc->pickup_time }}</span>
                                                </div>
                                                <span
                                                    class="text-xs text-slate-400 block mt-0.5">{{ $loc->subtitle ?? "{$loc->city} • Station Hub" }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <!-- 2. Drop Off Address Input (Uber-Style Dropdown) -->
                            <div class="relative" id="dest-field-wrapper">
                                <div onclick="toggleDestDropdown()"
                                    class="rounded-2xl border border-white/15 bg-white/10 hover:bg-white/15 focus-within:bg-white/20 focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition cursor-pointer p-3.5 flex items-center gap-3 shadow-xs select-none">

                                    <!-- Left Pin -->
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0">
                                        <span class="h-2.5 w-2.5 rounded-[2px] bg-[#22C55E]"></span>
                                    </div>

                                    <!-- Center: Label and Selected Text -->
                                    <div class="flex-1 min-w-0">
                                        <span id="label-destination"
                                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                            Drop-off address
                                        </span>
                                        <span id="dest-display-text"
                                            class="block text-sm sm:text-base font-medium text-slate-300 truncate leading-snug">
                                            Select drop-off location
                                        </span>
                                        <input type="hidden" name="to" id="destination_location" value="">
                                    </div>

                                    <!-- Right: Dropdown Chevron -->
                                    <div class="text-slate-400 hover:text-white transition flex-shrink-0">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Floating Dropdown Menu -->
                                <div id="dest-dropdown-menu"
                                    class="absolute left-0 right-0 top-full mt-2 z-50 rounded-2xl bg-[#1E232A] shadow-2xl border border-slate-700 divide-y divide-slate-800 hidden overflow-hidden text-white">

                                    <div
                                        class="px-4 py-2 bg-slate-900 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                        Select Drop-off Address
                                    </div>

                                    @foreach($locations as $loc)
                                        <div id="hero-dest-opt-{{ $loc->code }}" onclick="selectDestination('{{ $loc->code }}')"
                                            class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer {{ $loc->code === 'namur' ? 'hidden' : '' }}">
                                            <div
                                                class="w-10 h-10 rounded-full bg-[#22C55E]/20 text-[#22C55E] flex items-center justify-center flex-shrink-0 shadow-xs">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="font-bold text-white text-sm sm:text-base leading-tight">{{ $loc->name }}</span>
                                                    <span
                                                        class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] bg-[#22C55E]/15 px-2 py-0.5 rounded-full border border-[#22C55E]/30">{{ $loc->dropoff_time }}</span>
                                                </div>
                                                <span
                                                    class="text-xs text-slate-400 block mt-0.5">{{ $loc->dropoff_subtitle }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <!-- 3. Travel Date Input -->
                            <div
                                class="rounded-2xl border border-white/15 bg-white/10 hover:bg-white/15 focus-within:bg-white/20 focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition p-3.5 flex items-center gap-3 shadow-xs">
                                <div class="h-6 w-6 flex items-center justify-center flex-shrink-0 text-[#22C55E]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label for="travel_date" id="label-travel-date"
                                        class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                        Travel Date
                                    </label>
                                    <input id="travel_date" name="date" type="date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full bg-transparent text-sm sm:text-base font-bold text-white focus:outline-none cursor-pointer [color-scheme:dark]" />
                                </div>
                            </div>

                            <!-- 4. Fixed Departure Time (Corridor schedule) -->
                            <div
                                class="rounded-2xl border border-white/15 bg-white/10 p-3.5 flex items-center justify-between shadow-xs">
                                <div class="flex items-center gap-3">
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0 text-[#22C55E]">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span id="hero-schedule-label"
                                            class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                            Fixed Departure Time
                                        </span>
                                        <span id="hero-schedule-display"
                                            class="text-sm sm:text-base font-bold text-slate-300 leading-snug">
                                            <span id="hero-schedule-text">Select stations above</span>
                                        </span>
                                    </div>
                                </div>
                                <span id="hero-route-tag"
                                    class="rounded-full bg-[#22C55E]/15 text-[#22C55E] border border-[#22C55E]/30 px-2.5 py-1 text-[11px] font-extrabold uppercase tracking-wider">
                                    Fixed Schedule
                                </span>
                            </div>

                            <!-- 5. Reserve Now Button -->
                            <div class="pt-2">
                                @auth
                                    @if(auth()->user()->isPassenger())
                                        <button type="button" onclick="openSeatPickerModal()"
                                            class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3.5 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center cursor-pointer">
                                            <span>Select Seats &amp; Reserve</span>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </button>
                                    @else
                                        <a href="{{ auth()->user()->isRider() ? route('rider.dashboard') : route('operator.dashboard') }}"
                                            class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3.5 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center">
                                            <span>Go to Dashboard</span>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    @endif
                                @else
                                    <button type="button" onclick="handleGlobalBookNow()"
                                        class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3.5 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center cursor-pointer">
                                        <span>Select Seats &amp; Reserve</span>
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                @endauth
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="services" class="relative py-24 lg:py-32 bg-white border-b border-slate-100 overflow-hidden">
        <!-- Luxury Ambient Radial Glow (Oliver Green aura) -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/5 rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute bottom-0 left-10 w-80 h-80 bg-slate-100/60 rounded-full blur-2xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: Standardized Centered with Eyebrow, Title & Subtitle -->
            <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-14 md:mb-16 lg:mb-20 space-y-2.5 sm:space-y-3">
                <div>
                    <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                        OUR CORE ROUTES
                    </span>
                </div>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    Daily Intercity Services
                </h2>
                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto">
                    Fixed-schedule daily passenger ride-share connecting our 3 primary hubs across Montreal and Toronto.
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


    <section id="why-us"
        class="relative py-28 lg:py-36 bg-[#0B0F17] overflow-hidden border-b border-slate-800 text-white bg-cover bg-no-repeat bg-[center_left]"
        style="background-image: url('{{ asset('images/why-us-luxury-transport-flipped.jpg') }}'); background-position: left center; background-size: cover;">

        <!-- Luminous Vignette Overlay: Crystal-clear on left so vehicle shines, soft gradient on right allowing true glass translucency -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-950/35 to-slate-950/75 pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/60 pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex flex-col lg:flex-row items-center justify-end">

                <!-- RIGHT SIDE: Translucent Frosted Glass Card (Authentic Glass Pane with Low Opacity & Backdrop Blur) -->
                <div class="w-full lg:w-[520px] xl:w-[560px]">
                    <div
                        class="rounded-[36px] bg-slate-950/45 sm:bg-slate-900/40 backdrop-blur-2xl lg:backdrop-blur-3xl border border-white/25 p-7 sm:p-10 lg:p-12 shadow-2xl shadow-black/80 ring-1 ring-white/10 relative overflow-hidden">

                        <!-- Top Specular Highlight Edge -->
                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent pointer-events-none">
                        </div>
                        <!-- Soft Ambient Emerald Glow inside Card -->
                        <div
                            class="absolute -top-24 -right-24 w-52 h-52 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <!-- Pure Text Category Label (Centered on Phone, Left on Desktop) -->
                        <div class="space-y-3 mb-6 relative z-10 text-center lg:text-left">
                            <div>
                                <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase">
                                    WHY CHOOSE US
                                </span>
                            </div>

                            <h2
                                class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight font-heading leading-tight drop-shadow-sm text-center lg:text-left">
                                Why Select Us for Your Journey
                            </h2>

                            <p class="text-sm text-slate-200 leading-relaxed text-center lg:text-left">
                                Premium comfort, guaranteed seating, and reliable daily intercity transit.
                            </p>
                        </div>

                        <!-- Clean Accordion List with Frosted Dividers -->
                        <div class="mt-8 space-y-3.5 divide-y divide-white/15 relative z-10">

                            <!-- Item 1: Best Rate Guarantee -->
                            <details class="group pt-3.5 first:pt-0" open>
                                <summary
                                    class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <span class="text-[#22C55E] font-bold text-lg leading-none">$</span>
                                        <span>Best Rate Guarantee</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    Guaranteed flat fare of ${{ number_format($regularFare, 0) }} CAD per passenger per trip
                                    with zero hidden fees. Cash Payment Upon Boarding: Pay the driver directly in cash when
                                    boarding.
                                </div>
                            </details>

                            <!-- Item 2: Insurance Protected -->
                            <details class="group pt-3.5">
                                <summary
                                    class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span>Insurance Protected</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    Full commercial passenger insurance coverage on all trips with courteous,
                                    experienced, and dedicated drivers.
                                </div>
                            </details>

                            <!-- Item 3: Always Available -->
                            <details class="group pt-3.5">
                                <summary
                                    class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                        </svg>
                                        <span>Always Available</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    Daily fixed departures 7 days a week, 365 days a year: {{ $routeATime }} from
                                    Montreal, 12:15 PM &amp; 1:15 PM from Toronto.
                                </div>
                            </details>

                            <!-- Item 4: Montreal ↔ Toronto Hubs -->
                            <details class="group pt-3.5">
                                <summary
                                    class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Montreal ↔ Toronto Hubs</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    Direct service connecting {{ $namurLoc?->name ?? 'Station Métro Namur' }} in Montreal
                                    with {{ $yorkdaleLoc?->name ?? 'Yorkdale Mall' }}
                                    and {{ $yongeLoc?->name ?? 'Yonge Station' }} in Toronto.
                                </div>
                            </details>

                            <!-- Item 5: Fleet & Cabin Seating -->
                            <details class="group pt-3.5">
                                <summary
                                    class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-white select-none py-2 hover:text-[#22C55E] transition-colors">
                                    <div class="flex items-center gap-3.5">
                                        <svg class="h-5 w-5 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7h8m-8 5h8m-8 5h8M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                        <span>Fleet &amp; Cabin Seating</span>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-white transition-transform duration-200 group-open:rotate-180 flex-shrink-0 ml-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="pl-7 pr-2 pt-1 pb-2.5 text-sm text-slate-300 leading-relaxed">
                                    Travel in our {{ $vehicleModel }} (Plate: {{ $vehiclePlate }}) featuring exactly
                                    {{ $passengerSeatsCount }} Passenger Seats, leather interior, and climate control for
                                    executive comfort.
                                </div>
                            </details>

                        </div>

                        <!-- CTA Button -->
                        <div class="mt-8 pt-6 border-t border-white/15 relative z-10">
                            <button type="button" onclick="handleGlobalBookNow()"
                                class="inline-flex items-center justify-center gap-2.5 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-xl shadow-[#22C55E]/30 transition-all duration-200 hover:scale-[1.02] cursor-pointer min-h-[50px]">
                                <span>Reserve Your Seat</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <section id="how-it-works" class="relative py-24 lg:py-32 bg-[#F8FAFC] border-b border-slate-200/80 overflow-hidden">
        <!-- Ambient Atmosphere Subtle Tint -->
        <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-[#22C55E]/[0.03] blur-3xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: Standardized Centered with Eyebrow, Title & Subtitle -->
            <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-14 md:mb-16 lg:mb-20 space-y-2.5 sm:space-y-3">
                <div class="flex items-center justify-center gap-3">
                    <span class="w-8 h-[1.5px] bg-[#16A34A]/60 hidden sm:inline-block"></span>
                    <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                        SIMPLE 3-STEP PROCESS
                    </span>
                    <span class="w-8 h-[1.5px] bg-[#16A34A]/60 hidden sm:inline-block"></span>
                </div>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    How It Works
                </h2>
                <p class="text-sm sm:text-base lg:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto px-2">
                    Booking your reserved seat between Montreal and Toronto is fast, transparent, and hassle-free.
                </p>
            </div>

            <!-- ============================================================ -->
            <!-- MOBILE ONLY (<md): Tailored Card Layout Matching Reference   -->
            <!-- ============================================================ -->
            <div class="md:hidden space-y-4">

                <!-- Mobile Card 1 -->
                <div
                    class="w-full rounded-3xl bg-white border border-slate-200/90 shadow-lg shadow-slate-900/5 overflow-hidden transition">
                    <div class="w-full overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/how-it-works-step1.jpg') }}" alt="Choose Your Route - PickMeRoute"
                            class="w-full h-auto object-cover block" />
                    </div>

                    <div class="p-4 sm:p-5 flex items-center justify-between gap-3 sm:gap-4 bg-white">
                        <div
                            class="w-11 h-11 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0 shadow-xs">
                            <svg class="w-5 h-5 text-[#16A34A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-[#111827] font-heading leading-snug">
                                Choose Your Route
                            </h3>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed mt-0.5">
                                Select your route and travel date. Choose Montreal to Toronto or Toronto to Montreal.
                            </p>
                        </div>

                        <div
                            class="w-8 h-8 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#16A34A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card 2 -->
                <div
                    class="w-full rounded-3xl bg-white border border-slate-200/90 shadow-lg shadow-slate-900/5 overflow-hidden transition">
                    <div class="w-full overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/how-it-works-step2.jpg') }}" alt="Book with Ease - PickMeRoute"
                            class="w-full h-auto object-cover block" />
                    </div>

                    <div class="p-4 sm:p-5 flex items-center justify-between gap-3 sm:gap-4 bg-white">
                        <div
                            class="w-11 h-11 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0 shadow-xs">
                            <svg class="w-5 h-5 text-[#16A34A]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7 11V4a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v7h1a3 3 0 0 1 3 3v4a2 2 0 0 1-2 2h-1v2a1 1 0 0 1-2 0v-2H8v2a1 1 0 0 1-2 0v-2H5a2 2 0 0 1-2-2v-4a3 3 0 0 1 3-3h1zm2 0h6V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v7zm-4 4a1 1 0 0 0-1 1v2h16v-2a1 1 0 0 0-1-1H5z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-[#111827] font-heading leading-snug">
                                Book with Ease
                            </h3>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed mt-0.5">
                                Choose your preferred passenger seat and complete your reservation in a few easy steps.
                            </p>
                        </div>

                        <div
                            class="w-8 h-8 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#16A34A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card 3 -->
                <div
                    class="w-full rounded-3xl bg-white border border-slate-200/90 shadow-lg shadow-slate-900/5 overflow-hidden transition">
                    <div class="w-full overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/how-it-works-step3.jpg') }}" alt="Ride & Pay Cash - PickMeRoute"
                            class="w-full h-auto object-cover block" />
                    </div>

                    <div class="p-4 sm:p-5 flex items-center justify-between gap-3 sm:gap-4 bg-white">
                        <div
                            class="w-11 h-11 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0 shadow-xs">
                            <svg class="w-5 h-5 text-[#16A34A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-[#111827] font-heading leading-snug">
                                Ride &amp; Pay Cash
                            </h3>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed mt-0.5">
                                Enjoy a comfortable journey and pay your driver directly when boarding.
                            </p>
                        </div>

                        <div
                            class="w-8 h-8 rounded-full bg-[#E8FBF0] text-[#16A34A] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#16A34A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mobile Action CTA Button -->
                <div class="pt-2">
                    <button type="button" onclick="handleGlobalBookNow()"
                        class="w-full min-h-[52px] rounded-full bg-[#16A34A] hover:bg-[#15803D] active:scale-[0.98] text-white font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-[#16A34A]/25 transition cursor-pointer">
                        <span>Reserve Your Seat Now</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- DESKTOP ONLY (md+): 100% Preserved Original Desktop Layout   -->
            <!-- ============================================================ -->
            <div class="hidden md:block">
                <!-- Stepper Timeline: Continuous Line with Centered Step Numbers -->
                <div class="relative mb-8">
                    <!-- Continuous connecting line passing through center of all 3 columns -->
                    <div class="absolute top-1/2 left-[16.666%] right-[16.666%] h-0.5 bg-slate-200/90 -translate-y-1/2 z-0"
                        aria-hidden="true"></div>

                    <!-- 3 Centered Number Nodes with White Background masking the line -->
                    <div class="grid grid-cols-3 gap-8 relative z-10">
                        <div class="flex justify-center">
                            <span
                                class="px-5 bg-[#F8FAFC] text-5xl lg:text-6xl font-black font-heading text-slate-300 select-none tracking-tight">01</span>
                        </div>
                        <div class="flex justify-center">
                            <span
                                class="px-5 bg-[#F8FAFC] text-5xl lg:text-6xl font-black font-heading text-slate-300 select-none tracking-tight">02</span>
                        </div>
                        <div class="flex justify-center">
                            <span
                                class="px-5 bg-[#F8FAFC] text-5xl lg:text-6xl font-black font-heading text-slate-300 select-none tracking-tight">03</span>
                        </div>
                    </div>
                </div>

                <!-- 3 Step Cards with Overlapping Info Boxes Matching Reference Image -->
                <div class="grid grid-cols-3 gap-8 pb-4">

                    <!-- Step 1 Card -->
                    <div class="group relative flex flex-col items-center">
                        <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                            <img src="{{ asset('images/service-intercity.jpg') }}"
                                alt="Select route and date for PickMeRoute shuttle"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                            <h3
                                class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                Choose Your Route
                            </h3>
                            <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Select Route A ({{ $routeA?->name ?? 'Montreal → Toronto' }}) or Route B
                                ({{ $routeB?->name ?? 'Toronto → Montreal' }}) and pick your travel
                                date.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 Card -->
                    <div class="group relative flex flex-col items-center">
                        <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                            <img src="{{ asset('images/service-airport.jpg') }}"
                                alt="Reserve your seat with interactive cabin diagram"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                            <h3
                                class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                Book with Ease
                            </h3>
                            <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Pick your exact seat (S1–S{{ $passengerSeatsCount }}) on our visual cabin diagram and
                                receive
                                instant booking
                                confirmation.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 Card -->
                    <div class="group relative flex flex-col items-center">
                        <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                            <img src="{{ asset('images/service-corporate.jpg') }}"
                                alt="Travel comfortably in Honda Odyssey with cash on boarding"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                            <h3
                                class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                Ride &amp; Pay Cash
                            </h3>
                            <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Board at your predefined transit hub, pay the driver directly in cash
                                (${{ number_format($regularFare, 0) }} CAD), and enjoy
                                the journey.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Desktop Action CTA -->
                <div class="mt-16 text-center">
                    <button type="button" onclick="handleGlobalBookNow()"
                        class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                        <span>Reserve Your Seat Now</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================== -->
    <!-- 2.5 SPECIAL PROMOTIONS & COUPONS SECTION -->
    <!-- ========================================== -->

    @if(!empty($promotionalCoupons))
        <section id="promotions"
            class="relative py-20 lg:py-28 bg-[#0B0F17] text-white overflow-hidden border-b border-slate-800 bg-cover bg-center"
            style="background-image: linear-gradient(180deg, rgba(11, 15, 23, 0.94) 0%, rgba(11, 15, 23, 0.86) 50%, rgba(11, 15, 23, 0.96) 100%), url('{{ asset('images/honda-odyssey-fleet-raw.jpg') }}');">

            <!-- Ambient Atmospheric Glows for Luminous Glass Effect -->
            <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-[#22C55E]/12 rounded-full blur-[140px] pointer-events-none"
                aria-hidden="true"></div>
            <div class="absolute bottom-1/4 right-1/4 w-[450px] h-[450px] bg-emerald-600/10 rounded-full blur-[120px] pointer-events-none"
                aria-hidden="true"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-14 md:mb-16 lg:mb-20 space-y-2.5 sm:space-y-3">
                    <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase">
                        PROMOTIONS &amp; DISCOUNT CODES
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight font-heading leading-tight drop-shadow-sm">
                        Exclusive Travel Deals &amp; Discounts
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                        Our standard regular flat rate is ${{ number_format($regularFare, 2) }} CAD. Apply active promotional
                        coupon codes during booking to enjoy our introductory launch rate of only
                        ${{ number_format($promotionalFare, 2) }} CAD!
                    </p>
                </div>

                <!-- Multi-Coupon Interactive Switcher Tabs (Displays 1 coupon at a time) -->
                @if(count($promotionalCoupons) > 1)
                    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-8 max-w-xl mx-auto">
                        @foreach($promotionalCoupons as $idx => $coupon)
                            <button type="button" onclick="switchCoupon({{ $idx }})" id="coupon-tab-btn-{{ $idx }}"
                                class="coupon-tab-btn inline-flex min-h-[44px] items-center gap-2 px-4 sm:px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all duration-200 border cursor-pointer {{ $idx === 0 ? 'bg-[#22C55E]/20 text-[#22C55E] border-[#22C55E]/50 shadow-lg shadow-[#22C55E]/10' : 'bg-white/[0.06] text-slate-300 border-white/15 hover:bg-white/[0.12] hover:text-white' }}">
                                <span>{{ $coupon['tab_label'] }}</span>
                                <span
                                    class="coupon-active-dot flex h-2 w-2 rounded-full bg-[#22C55E] {{ $idx === 0 ? '' : 'hidden' }}"></span>
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Voucher Cards Container (Strictly 1 Active Card Rendered at a time) -->
                <div class="max-w-4xl mx-auto">
                    @foreach($promotionalCoupons as $idx => $coupon)
                        <div id="coupon-card-{{ $idx }}"
                            class="coupon-deal-card {{ $idx === 0 ? 'block' : 'hidden' }} transition-opacity duration-300">

                            <!-- Mobile Compact Card Layout (Strictly 1:1 with media_1794218806234_669a0ee9.png) -->
                            <div
                                class="block lg:hidden relative rounded-3xl border border-white/20 bg-white/[0.08] backdrop-blur-2xl p-5 sm:p-6 shadow-2xl shadow-black/70 ring-1 ring-white/10 overflow-hidden">
                                <!-- Top Specular Highlight Edge -->
                                <div
                                    class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent pointer-events-none">
                                </div>
                                <!-- Soft Ambient Emerald Glow -->
                                <div
                                    class="absolute -right-16 -top-16 w-48 h-48 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none">
                                </div>

                                <div class="relative z-10">
                                    <!-- 1. Header: Active Launch Special + Deal Index -->
                                    <div class="flex items-center justify-between gap-3 mb-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black bg-[#22C55E]/20 text-[#22C55E] border border-[#22C55E]/40 uppercase tracking-wider backdrop-blur-md">
                                            {{ $coupon['tag'] }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-400 font-mono">
                                            Deal {{ $idx + 1 }} of {{ count($promotionalCoupons) }}
                                        </span>
                                    </div>

                                    <!-- 2. Headline -->
                                    <h3
                                        class="text-2xl sm:text-3xl font-black text-white font-heading tracking-tight drop-shadow-xs mt-2">
                                        {{ $coupon['headline'] }}
                                    </h3>

                                    <!-- 3. Short Description (User requirement #3) -->
                                    <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                                        {{ $coupon['description'] }}
                                    </p>

                                    <!-- 4. Price Comparison Box (User requirement #2 & #4) -->
                                    <div class="mt-4 rounded-2xl bg-black/40 border border-white/15 p-4 shadow-inner">
                                        <div class="flex items-start justify-between gap-3">
                                            <!-- Left: Regular Fare + Savings Badge below it -->
                                            <div>
                                                <span
                                                    class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-0.5">Regular
                                                    Fare</span>
                                                <del
                                                    class="text-base sm:text-lg font-bold text-slate-400 font-mono">{{ $coupon['regular_fare'] }}</del>
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#22C55E]/20 border border-[#22C55E]/30 text-[#22C55E] text-xs font-black font-mono">
                                                        {{ $coupon['savings_badge'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Right: Promo Rate ($55 CAD prominent) -->
                                            <div class="text-right">
                                                <span
                                                    class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-0.5">Promo
                                                    Rate</span>
                                                <span
                                                    class="text-3xl font-black text-[#22C55E] font-mono tracking-tight block">{{ $coupon['promo_fare'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Terms & Conditions (User requirement #6) -->
                                    <div
                                        class="mt-3.5 flex items-center gap-2 text-[11px] sm:text-xs text-slate-300 font-medium leading-tight">
                                        <span
                                            class="flex h-4 w-4 items-center justify-center rounded-full bg-[#22C55E]/20 text-[#22C55E] flex-shrink-0">
                                            <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <span>{{ $coupon['terms'] }}</span>
                                    </div>

                                    <!-- Divider -->
                                    <div class="my-4 border-t border-white/10"></div>

                                    <!-- 6. Coupon Code Area (User requirement #5) -->
                                    <div>
                                        <span
                                            class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-2">Your
                                            Promo Code</span>
                                        <div
                                            class="rounded-2xl border-2 border-dashed border-[#22C55E] bg-black/50 p-3 sm:p-3.5 flex items-center justify-between gap-3 shadow-inner">
                                            <span
                                                class="font-mono text-2xl sm:text-3xl font-black text-white tracking-widest pl-1">{{ $coupon['code'] }}</span>
                                            <button type="button" id="copy-btn-mob-{{ strtolower($coupon['code']) }}"
                                                onclick="copyPromoCode('{{ $coupon['code'] }}', 'copy-btn-mob-{{ strtolower($coupon['code']) }}')"
                                                class="inline-flex min-h-[38px] items-center justify-center gap-1.5 rounded-xl bg-white/10 hover:bg-white/20 active:scale-95 text-white px-3.5 py-2 text-xs font-bold transition border border-white/20 cursor-pointer shadow-xs flex-shrink-0">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                </svg>
                                                <span>Copy Code</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- 7. CTA Button -->
                                    <button type="button" onclick="openSeatPickerWithCoupon('{{ $coupon['code'] }}')"
                                        class="w-full inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] active:scale-[0.99] text-white px-5 py-3 text-sm sm:text-base font-bold transition duration-200 shadow-lg shadow-[#22C55E]/30 cursor-pointer mt-3.5">
                                        <span>Apply Code &amp; Book Now</span>
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>

                                    <!-- 8. Trust indicators -->
                                    <div class="flex items-center justify-between text-xs text-slate-400 px-1 mt-3">
                                        <span>Cash on boarding</span>
                                        <span>Instant confirmation</span>
                                    </div>

                                    <!-- Multi-coupon switcher controls if > 1 -->
                                    @if(count($promotionalCoupons) > 1)
                                        <div class="flex items-center justify-between pt-3 border-t border-white/10 mt-3">
                                            <button type="button"
                                                onclick="switchCoupon({{ ($idx - 1 + count($promotionalCoupons)) % count($promotionalCoupons) }})"
                                                class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1 cursor-pointer">
                                                <span>← Previous Deal</span>
                                            </button>
                                            <button type="button" onclick="switchCoupon({{ ($idx + 1) % count($promotionalCoupons) }})"
                                                class="text-xs text-[#22C55E] hover:text-emerald-400 font-bold transition flex items-center gap-1 cursor-pointer">
                                                <span>Next Deal →</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Desktop 2-Column Voucher with Ticket Cutout -->
                            <div
                                class="hidden lg:flex relative rounded-[36px] border border-white/20 bg-white/[0.08] backdrop-blur-2xl shadow-2xl shadow-black/70 ring-1 ring-white/10 overflow-hidden flex-row">
                                <!-- Top Specular Highlight Edge -->
                                <div
                                    class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent pointer-events-none">
                                </div>
                                <!-- Soft Ambient Emerald Glow inside Card -->
                                <div
                                    class="absolute -right-20 -top-20 w-56 h-56 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none">
                                </div>

                                <!-- Left: Voucher Core Details (62% width on desktop) -->
                                <div class="p-8 lg:p-10 flex-1 flex flex-col justify-between relative z-10">
                                    <div>
                                        <div class="flex items-center justify-between gap-3 mb-4">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-[#22C55E]/20 text-[#22C55E] border border-[#22C55E]/40 uppercase tracking-wider backdrop-blur-md">
                                                    {{ $coupon['tag'] }}
                                                </span>
                                                <span class="text-xs font-semibold text-slate-300">
                                                    {{ $coupon['route_tag'] }}
                                                </span>
                                            </div>
                                            <span class="text-xs font-bold text-slate-400 font-mono">
                                                Deal {{ $idx + 1 }} of {{ count($promotionalCoupons) }}
                                            </span>
                                        </div>

                                        <h3
                                            class="text-2xl sm:text-3xl font-black text-white font-heading tracking-tight drop-shadow-xs">
                                            {{ $coupon['headline'] }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-200 mt-2 leading-relaxed">
                                            {{ $coupon['description'] }}
                                        </p>

                                        <!-- Price Comparison Glass Box -->
                                        <div
                                            class="mt-5 rounded-2xl bg-black/30 border border-white/15 p-4 flex items-center justify-between gap-4 shadow-inner">
                                            <div>
                                                <span
                                                    class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-0.5">Regular
                                                    Base Fare</span>
                                                <del
                                                    class="text-base font-semibold text-slate-400 font-mono">{{ $coupon['regular_fare'] }}</del>
                                                <div class="mt-1.5">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#22C55E]/20 text-[#22C55E] text-xs font-black font-mono border border-[#22C55E]/30">
                                                        {{ $coupon['savings_badge'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span
                                                    class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-0.5">Promotional
                                                    Rate</span>
                                                <span
                                                    class="text-3xl font-black text-[#22C55E] font-mono tracking-tight">{{ $coupon['promo_fare'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="mt-6 pt-4 border-t border-white/15 text-xs text-slate-300 flex items-center gap-2">
                                        <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $coupon['terms'] }}</span>
                                    </div>
                                </div>

                                <!-- Desktop Vertical Perforated Line -->
                                <div
                                    class="h-full border-r-2 border-dashed border-white/20 relative py-6 flex flex-col justify-between items-center">
                                    <div
                                        class="absolute -top-4 -left-3 w-6 h-6 rounded-full bg-[#0B0F17] border border-white/20">
                                    </div>
                                    <div
                                        class="absolute -bottom-4 -left-3 w-6 h-6 rounded-full bg-[#0B0F17] border border-white/20">
                                    </div>
                                </div>

                                <!-- Right: Voucher Redemption Action Stub (38% width on desktop) -->
                                <div
                                    class="p-8 lg:p-10 lg:w-[340px] flex flex-col justify-center gap-4 bg-white/[0.04] backdrop-blur-md relative z-10">
                                    <div>
                                        <span
                                            class="text-[10px] uppercase font-bold text-slate-300 block tracking-wider mb-2">Promotional
                                            Coupon Code</span>
                                        <div
                                            class="rounded-2xl border-2 border-dashed border-[#22C55E] bg-black/40 backdrop-blur-md p-3.5 flex items-center justify-between gap-2 shadow-inner">
                                            <span
                                                class="font-mono text-2xl font-black text-white tracking-widest pl-1">{{ $coupon['code'] }}</span>
                                            <button type="button" id="copy-btn-desk-{{ strtolower($coupon['code']) }}"
                                                onclick="copyPromoCode('{{ $coupon['code'] }}', 'copy-btn-desk-{{ strtolower($coupon['code']) }}')"
                                                class="inline-flex min-h-[38px] items-center justify-center gap-1.5 rounded-xl bg-white/15 hover:bg-white/25 active:scale-95 text-white px-3 py-1.5 text-xs font-bold transition border border-white/20 backdrop-blur-md cursor-pointer shadow-xs">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                </svg>
                                                <span>Copy Code</span>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="button" onclick="openSeatPickerWithCoupon('{{ $coupon['code'] }}')"
                                        class="w-full inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] active:scale-[0.99] text-white px-5 py-3 text-sm font-black transition duration-200 shadow-lg shadow-[#22C55E]/30 cursor-pointer">
                                        <span>Apply Code &amp; Book Now</span>
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>

                                    <div class="flex items-center justify-between text-xs text-slate-400 px-1">
                                        <span>Cash on boarding</span>
                                        <span>Instant confirmation</span>
                                    </div>

                                    <!-- Prev/Next switcher controls for convenience -->
                                    @if(count($promotionalCoupons) > 1)
                                        <div class="flex items-center justify-between pt-3 border-t border-white/10 mt-1">
                                            <button type="button"
                                                onclick="switchCoupon({{ ($idx - 1 + count($promotionalCoupons)) % count($promotionalCoupons) }})"
                                                class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1 cursor-pointer">
                                                <span>← Previous Deal</span>
                                            </button>
                                            <button type="button" onclick="switchCoupon({{ ($idx + 1) % count($promotionalCoupons) }})"
                                                class="text-xs text-[#22C55E] hover:text-emerald-400 font-bold transition flex items-center gap-1 cursor-pointer">
                                                <span>Next Deal →</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function switchCoupon(targetIdx) {
                    const cards = document.querySelectorAll('.coupon-deal-card');
                    const buttons = document.querySelectorAll('.coupon-tab-btn');
                    cards.forEach((card, idx) => {
                        if (idx === targetIdx) {
                            card.classList.remove('hidden');
                            card.classList.add('block');
                        } else {
                            card.classList.remove('block');
                            card.classList.add('hidden');
                        }
                    });
                    buttons.forEach((btn, idx) => {
                        const dot = btn.querySelector('.coupon-active-dot');
                        if (idx === targetIdx) {
                            btn.classList.add('bg-[#22C55E]/20', 'text-[#22C55E]', 'border-[#22C55E]/50', 'shadow-lg', 'shadow-[#22C55E]/10');
                            btn.classList.remove('bg-white/[0.06]', 'text-slate-300', 'border-white/15');
                            if (dot) dot.classList.remove('hidden');
                        } else {
                            btn.classList.remove('bg-[#22C55E]/20', 'text-[#22C55E]', 'border-[#22C55E]/50', 'shadow-lg', 'shadow-[#22C55E]/10');
                            btn.classList.add('bg-white/[0.06]', 'text-slate-300', 'border-white/15');
                            if (dot) dot.classList.add('hidden');
                        }
                    });
                }
            </script>
        </section>
    @endif



    <!-- Pre-Footer Action Banner (Light Section maintaining Dark-Light-Dark rhythm) -->
    <section id="help-and-booking" class="relative py-14 sm:py-20 lg:py-24 bg-[#F8FAFC] border-b border-slate-200/70 overflow-hidden">
        <!-- Ambient Atmosphere -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-[#22C55E]/[0.04] rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Pre-Footer Action Banner with FAQ Link & Fast Reservation Button -->
            <div class="rounded-3xl bg-gradient-to-br from-[#111827] to-[#0B0F17] text-white p-7 sm:p-10 lg:p-12 border border-slate-800 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-20 -bottom-20 w-72 h-72 bg-[#22C55E]/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="text-center lg:text-left space-y-2.5 max-w-xl">
                        <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase block">
                            HELP CENTER &amp; RESERVATION
                        </span>
                        <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading tracking-tight leading-tight">
                            Have Questions Before Traveling?
                        </h3>
                        <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                            Read our complete FAQ guide covering cash payment upon boarding, luggage rules, and vehicle amenities, or reserve your seat instantly.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('faq') }}"
                                class="inline-flex items-center gap-2 text-sm font-bold text-[#22C55E] hover:text-[#16A34A] transition group">
                                <span>Read Full FAQ &amp; Policy Guide</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3.5 w-full lg:w-auto">
                        <a href="{{ route('faq') }}"
                            class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 text-white px-6 py-3 text-sm font-bold border border-white/20 transition cursor-pointer">
                            <span>Browse All FAQs</span>
                        </a>
                        <button type="button" onclick="handleGlobalBookNow()"
                            class="w-full sm:w-auto inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-7 py-3 text-sm font-bold shadow-lg shadow-[#22C55E]/30 transition cursor-pointer">
                            <span>Reserve Your Seat</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

        </div>
    </section>
@endsection