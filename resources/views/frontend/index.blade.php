@extends('frontend.layout.app')

@section('title', 'Oliver Transport — Daily Montreal ↔ Toronto Passenger Shuttle')

@section('content')
    <!-- 1. HERO SECTION: Cinematic Video Background with Dark Gradient Overlay & Glass Booking Panel -->
    <section
        class="relative min-h-[92vh] flex items-center justify-center overflow-hidden bg-[#111827] pt-28 pb-16 sm:pt-32 sm:pb-20 lg:pt-36 lg:pb-24 border-b border-slate-800">

        <!-- Background Video Loop with Dark Cinematic Overlay -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <video autoplay muted loop playsinline poster="{{ asset('images/hero-video-poster.jpg') }}"
                class="w-full h-full object-cover scale-105">
                <source src="{{ asset('videos/hero-odyssey-loop.mp4') }}" type="video/mp4">
                <source src="{{ asset('videos/hero-highway-loop.mp4') }}" type="video/mp4">
            </video>
            <!-- Refined Lighter Cinematic Overlay for Maximum Luminous Visibility & Clarity -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#111827]/70 via-[#111827]/50 to-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/70 via-transparent to-black/20"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">

                <!-- LEFT SIDE: Spacious, High-Impact Brand Messaging (approx 50%) -->
                <div class="lg:w-[50%] w-full flex flex-col justify-center text-left">

                    <!-- Eyebrow matching Reference Image 1: Green horizontal line + uppercase text -->
                    <div class="flex items-center gap-3.5 mb-5 sm:mb-6">
                        <span class="w-10 sm:w-12 h-1 bg-[#22C55E] rounded-full inline-block"></span>
                        <span class="text-xs sm:text-sm font-extrabold uppercase tracking-[0.22em] text-white">PREMIUM
                            TRANSPORTATION SERVICE</span>
                    </div>

                    <!-- Main Heading matching Reference Image 1 -->
                    <h1
                        class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-black tracking-tight text-white leading-[1.04] font-heading drop-shadow-sm">
                        Your Journey,<br />
                        <span class="text-[#22C55E]">Our Priority.</span>
                    </h1>

                    <!-- Subtitle matching Reference Image 1 -->
                    <p
                        class="mt-5 sm:mt-6 text-xl sm:text-2xl lg:text-3xl font-bold text-white tracking-tight leading-snug drop-shadow-sm">
                        Travel in Comfort. Arrive in Style.
                    </p>

                    <!-- Description with Green Vertical Line matching Reference Image 1 -->
                    <div class="mt-6 sm:mt-7 flex items-stretch gap-3.5 sm:gap-4">
                        <span class="w-1 bg-[#22C55E] rounded-full flex-shrink-0"></span>
                        <p class="text-sm sm:text-base text-slate-200 leading-relaxed font-normal max-w-lg drop-shadow-sm">
                            Experience reliable, comfortable and<br class="hidden sm:inline" />
                            professional transportation with Oliver Transport.
                        </p>
                    </div>
                </div>

                <!-- RIGHT SIDE: Translucent Glass Booking Form -->
                <div class="lg:w-[46%] w-full flex justify-center lg:justify-end">
                    <div id="booking-panel"
                        class="w-full max-w-md rounded-3xl p-6 sm:p-7 shadow-2xl shadow-black/50 border border-white/15 bg-[#111827]/50 backdrop-blur-2xl transition duration-200">

                        <!-- Top Route Tabs Navigation -->
                        <div class="flex items-center gap-2.5 pb-4 border-b border-white/10" role="tablist">
                            <!-- Route A Pill Tab -->
                            <button id="tab-btn-route-a" type="button" role="tab" aria-selected="true"
                                onclick="switchHeroRoute('route-a')"
                                class="route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#22C55E] text-white shadow-xs cursor-pointer text-center">
                                <span>Route A: Montreal → Toronto</span>
                            </button>

                            <!-- Route B Tab -->
                            <button id="tab-btn-route-b" type="button" role="tab" aria-selected="false"
                                onclick="switchHeroRoute('route-b')"
                                class="route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-300 hover:text-white bg-white/10 hover:bg-white/15 border border-white/10 cursor-pointer text-center">
                                <span>Route B: Toronto → Montreal</span>
                            </button>
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
                                            Pickup location
                                        </span>
                                        <span id="pickup-display-text"
                                            class="block text-sm sm:text-base font-bold text-white truncate leading-snug">
                                            Station Métro Namur (Montreal)
                                        </span>
                                        <input type="hidden" name="from" id="pickup_location" value="namur">
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
                                        Corridor Departure Hubs
                                    </div>

                                    <!-- Station 1: Montreal Namur -->
                                    <div onclick="selectPickup('namur', 'Station Métro Namur (Montreal)', 'route-a')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#22C55E]/20 text-[#22C55E] flex items-center justify-center flex-shrink-0 shadow-xs">
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
                                                    class="font-bold text-white text-sm sm:text-base leading-tight">Station
                                                    Métro Namur</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] bg-[#22C55E]/15 px-2 py-0.5 rounded-full border border-[#22C55E]/30">Route
                                                    A</span>
                                            </div>
                                            <span class="text-xs text-slate-400 block mt-0.5">Montreal • Route A Departure
                                                Hub (6:30 AM EST)</span>
                                        </div>
                                    </div>

                                    <!-- Station 2: Toronto Yorkdale -->
                                    <div onclick="selectPickup('yorkdale', 'Yorkdale Mall (Toronto)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
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
                                                    class="font-bold text-white text-sm sm:text-base leading-tight">Yorkdale
                                                    Mall</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-sky-400 bg-sky-950/60 px-2 py-0.5 rounded-full border border-sky-800/60">Route
                                                    B</span>
                                            </div>
                                            <span class="text-xs text-slate-400 block mt-0.5">Toronto • Route B 1st Pickup
                                                (12:15 PM EST)</span>
                                        </div>
                                    </div>

                                    <!-- Station 3: Toronto Yonge -->
                                    <div onclick="selectPickup('yonge', 'Yonge Station (Toronto)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="font-bold text-white text-sm sm:text-base leading-tight">Yonge
                                                    Station</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-sky-400 bg-sky-950/60 px-2 py-0.5 rounded-full border border-sky-800/60">Route
                                                    B</span>
                                            </div>
                                            <span class="text-xs text-slate-400 block mt-0.5">Toronto • Route B 2nd Pickup
                                                (1:15 PM EST)</span>
                                        </div>
                                    </div>

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
                                            Drop-off location
                                        </span>
                                        <span id="dest-display-text"
                                            class="block text-sm sm:text-base font-bold text-white truncate leading-snug">
                                            Yorkdale Mall &amp; Yonge Station (Toronto)
                                        </span>
                                        <input type="hidden" name="to" id="destination_location" value="toronto">
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
                                        Corridor Destination Hubs
                                    </div>

                                    <!-- Toronto Dropoffs -->
                                    <div onclick="selectDestination('toronto', 'Yorkdale Mall & Yonge Station (Toronto)', 'route-a')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#22C55E]/20 text-[#22C55E] flex items-center justify-center flex-shrink-0 shadow-xs">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-bold text-white text-sm sm:text-base leading-tight block">Yorkdale
                                                Mall &amp; Yonge Station</span>
                                            <span class="text-xs text-slate-400 block mt-0.5">Toronto Drop-offs • Hwy 401
                                                &amp; TTC Subway Interchange</span>
                                        </div>
                                    </div>

                                    <!-- Montreal Dropoff -->
                                    <div onclick="selectDestination('montreal', 'Station Métro Namur (Montreal)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-white/5 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-bold text-white text-sm sm:text-base leading-tight block">Station
                                                Métro Namur</span>
                                            <span class="text-xs text-slate-400 block mt-0.5">Montreal Final Drop-off (~7:15
                                                PM EST)</span>
                                        </div>
                                    </div>

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
                                        <span
                                            class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 leading-none mb-1">
                                            Fixed Departure Time
                                        </span>
                                        <span id="hero-schedule-display"
                                            class="text-sm sm:text-base font-black text-white leading-snug">
                                            <span id="hero-schedule-text">6:30 AM Daily</span>
                                        </span>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-bold text-slate-300 border border-white/10">
                                    Fixed Schedule
                                </span>
                            </div>

                            <!-- 5. Reserve Now Button -->
                            <div class="pt-2">
                                @auth
                                    @php
                                        $dashboardLink = auth()->user()->isRider()
                                            ? route('rider.dashboard')
                                            : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard'));
                                    @endphp
                                    <a href="{{ $dashboardLink }}"
                                        class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3.5 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center">
                                        <span>Go to Dashboard</span>
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @else
                                    <button type="button" onclick="openAuthModal()"
                                        class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3.5 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center cursor-pointer">
                                        <span>Reserve Now</span>
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

    <!-- 2. OUR SERVICES SECTION: Realistic 3-Location Intercity Ride-Share Services (Route A & Route B) -->
    <section id="services" class="py-20 lg:py-28 bg-white border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: 2 Columns with justify-evenly on desktop -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-evenly gap-6 mb-12 sm:mb-16">
                <div>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#111827] tracking-tight font-heading">
                        Services
                    </h2>
                </div>
                <p class="text-sm sm:text-base text-[#64748B] max-w-md leading-relaxed md:text-right font-medium">
                    Fixed-schedule daily passenger ride-share connecting our 3 primary hubs across Montreal and Toronto.
                </p>
            </div>

            <!-- 2 Core Services Grid: Route A & Route B (Realistic 3-Location Ride-Share) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                <!-- Service 1: Route A — Montreal to Toronto -->
                <div
                    class="group relative rounded-3xl bg-[#F8FAFC] p-6 sm:p-7 flex flex-col sm:flex-row items-stretch gap-6 border border-slate-200/90 shadow-xs hover:bg-white hover:border-[#22C55E]/50 transition-all duration-300">
                    <div
                        class="w-full sm:w-[46%] h-56 sm:h-auto min-h-[220px] rounded-2xl overflow-hidden flex-shrink-0 bg-slate-900">
                        <img src="{{ asset('images/service-intercity.jpg') }}"
                            alt="Oliver Transport Route A: Montreal to Toronto Shuttle"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                    </div>
                    <div class="w-full sm:w-[54%] flex flex-col justify-between py-1">
                        <div>
                            <div class="flex items-baseline justify-between gap-3 mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#16A34A]">
                                    Route A • Daily Service
                                </span>
                                <span class="text-sm font-black text-slate-900 font-mono">
                                    <span class="text-xs font-semibold text-slate-500">CAD</span>
                                </span>
                            </div>

                            <h3
                                class="text-2xl font-black text-[#111827] tracking-tight font-heading group-hover:text-[#16A34A] transition-colors">
                                Montreal → Toronto
                            </h3>

                            <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                                Daily morning passenger ride-share connecting Montreal directly to Toronto. Board at Station
                                Métro Namur with drop-offs at Yorkdale Mall and Yonge Station.
                            </p>

                            <div class="mt-4 space-y-2 text-xs sm:text-sm text-slate-700">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span><strong>Pickup:</strong> Station Métro Namur at 6:30 AM</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span><strong>Drop-offs:</strong> Yorkdale Mall &amp; Yonge Station</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span>Cash payment upon boarding with driver ( CAD)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/70 flex items-center justify-between">
                            <a href="#booking-panel" onclick="switchHeroRoute('route-a')"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-5 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                <span>Book Route A</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            <span class="text-xs font-semibold text-slate-500">6 Passenger Seats</span>
                        </div>
                    </div>
                </div>

                <!-- Service 2: Route B — Toronto to Montreal -->
                <div
                    class="group relative rounded-3xl bg-[#F8FAFC] p-6 sm:p-7 flex flex-col sm:flex-row items-stretch gap-6 border border-slate-200/90 shadow-xs hover:bg-white hover:border-[#22C55E]/50 transition-all duration-300">
                    <div
                        class="w-full sm:w-[46%] h-56 sm:h-auto min-h-[220px] rounded-2xl overflow-hidden flex-shrink-0 bg-slate-900">
                        <img src="{{ asset('images/service-corporate.jpg') }}"
                            alt="Oliver Transport Route B: Toronto to Montreal Shuttle"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                    </div>
                    <div class="w-full sm:w-[54%] flex flex-col justify-between py-1">
                        <div>
                            <div class="flex items-baseline justify-between gap-3 mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#16A34A]">
                                    Route B • Daily Service
                                </span>
                                <span class="text-sm font-black text-slate-900 font-mono">
                                    <span class="text-xs font-semibold text-slate-500">CAD</span>
                                </span>
                            </div>

                            <h3
                                class="text-2xl font-black text-[#111827] tracking-tight font-heading group-hover:text-[#16A34A] transition-colors">
                                Toronto → Montreal
                            </h3>

                            <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                                Daily afternoon return passenger ride-share connecting Toronto to Montreal. Board at
                                Yorkdale Mall or Yonge Station with final drop-off at Station Métro Namur.
                            </p>

                            <div class="mt-4 space-y-2 text-xs sm:text-sm text-slate-700">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span><strong>Pickups:</strong> Yorkdale (12:15 PM) &amp; Yonge (1:15 PM)</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span><strong>Drop-off:</strong> Station Métro Namur (~7:15 PM EST)</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#16A34A] flex-shrink-0">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span>Cash payment upon boarding with driver ( CAD)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/70 flex items-center justify-between">
                            <a href="#booking-panel" onclick="switchHeroRoute('route-b')"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-5 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                <span>Book Route B</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            <span class="text-xs font-semibold text-slate-500">6 Passenger Seats</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. WHY CHOOSE US SECTION: Premium Two-Part Layout (Left Intro + Right 2x2 Benefits Grid) -->
    <section id="why-us" class="py-20 lg:py-28 bg-[#F0FDF4] border-b border-[#22C55E]/15">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <!-- LEFT SIDE – Introduction (5 cols) -->
                <div class="lg:col-span-5 space-y-6 text-left">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-1 bg-[#22C55E] rounded-full inline-block"></span>
                        <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                            WHY CHOOSE US
                        </span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                        Travel with Confidence
                    </h2>

                    <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-md">
                        At Oliver Transport, we believe every journey should be comfortable, reliable, and stress-free. Our commitment to professional service ensures you enjoy a better travel experience every time.
                    </p>

                    <div class="pt-2">
                        <a href="#booking-panel"
                            class="inline-flex items-center gap-2 text-sm sm:text-base font-bold text-[#111827] hover:text-[#16A34A] transition group">
                            <span>Learn More</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>

                <!-- RIGHT SIDE – Four Key Benefits: Clean 2x2 Grid with Subtle Dividers (7 cols) -->
                <div class="lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-slate-200/80 rounded-3xl overflow-hidden border border-slate-200/80 shadow-xs">

                        <!-- Benefit 1: Professional Drivers -->
                        <div class="group bg-white p-7 sm:p-8 hover:bg-[#F8FAFC] transition-colors duration-200 flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-5 border border-[#22C55E]/20 group-hover:scale-105 transition-transform">
                                    <!-- Steering Wheel Icon -->
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="12" cy="12" r="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14.5V21M9.5 12H3M21 12h-6.5" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-black text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                    Professional Drivers
                                </h3>
                                <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                    Experienced, courteous, and dedicated drivers who put your comfort first.
                                </p>
                            </div>
                        </div>

                        <!-- Benefit 2: Premium Comfort -->
                        <div class="group bg-white p-7 sm:p-8 hover:bg-[#F8FAFC] transition-colors duration-200 flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-5 border border-[#22C55E]/20 group-hover:scale-105 transition-transform">
                                    <!-- Premium Comfort / Armchair Icon -->
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 11V7a3 3 0 013-3h8a3 3 0 013 3v4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 11a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 19v2M18 19v2" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-black text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                    Premium Comfort
                                </h3>
                                <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                    Enjoy a comfortable journey with carefully maintained vehicles.
                                </p>
                            </div>
                        </div>

                        <!-- Benefit 3: Always On Time -->
                        <div class="group bg-white p-7 sm:p-8 hover:bg-[#F8FAFC] transition-colors duration-200 flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-5 border border-[#22C55E]/20 group-hover:scale-105 transition-transform">
                                    <!-- Clock / Punctuality Icon -->
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-black text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                    Always On Time
                                </h3>
                                <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                    We value your time and aim to make every journey punctual and smooth.
                                </p>
                            </div>
                        </div>

                        <!-- Benefit 4: Reliable Service -->
                        <div class="group bg-white p-7 sm:p-8 hover:bg-[#F8FAFC] transition-colors duration-200 flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-5 border border-[#22C55E]/20 group-hover:scale-105 transition-transform">
                                    <!-- Shield Check Icon -->
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg sm:text-xl font-black text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                                    Reliable Service
                                </h3>
                                <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                    Dependable transportation with a focus on safety and customer satisfaction.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. VEHICLE SHOWCASE SECTION: Inspired by Reference Image 87756ac6.jpg (Wide Vehicle Spec Card) -->
    <section id="about" class="py-20 lg:py-28 bg-[#F8FAFC] border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-16">
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#111827] tracking-tight font-heading">
                    Only  / seat
                </h2>
                <p class="mt-3.5 text-base sm:text-lg text-[#64748B] leading-relaxed">
                    Enjoy guaranteed reserved seating, generous luggage space, and smooth highway comfort in our executive minivan.
                </p>
                <div class="mt-4">
                    <a href="#booking-panel"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                        Open Fleet
                    </a>
                </div>
            </div>

            <!-- Wide Vehicle Feature Card Matching Reference Image 87756ac6.jpg -->
            <div class="rounded-3xl bg-white border border-slate-200/90 p-8 sm:p-12 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                    <!-- Left: Vehicle Name, Specs Checklist, and Reserve CTA (6 cols) -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-[#16A34A] block mb-1">
                                Operating Fleet Profile
                            </span>
                            <h3 class="text-3xl sm:text-4xl font-black text-[#111827] tracking-tight font-heading">
                                Honda Odyssey
                            </h3>
                            <p class="text-xs text-slate-500 font-medium mt-1">
                                Silver Minivan • Commercial Ontario Plate: <strong class="font-mono text-slate-900 font-black">RAJIA</strong>
                            </p>
                        </div>

                        <!-- 2-Column Feature Checklist Matching Reference Image -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-700">
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>6 Passenger Seats</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Clean Tinted Windows</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Tri-Zone Climate Control</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>USB Charging Ports</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Generous Luggage Allowance</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Cash Payment Upon Boarding</span>
                            </div>
                        </div>

                        <!-- Price and Cash Payment Banner -->
                        <div class="rounded-2xl bg-[#F0FDF4] border border-[#22C55E]/30 p-4 text-xs text-slate-800 leading-relaxed">
                            Pay the driver directly in cash when boarding ( CAD flat fare). Zero upfront electronic deposit or prepayment needed.
                        </div>

                        <!-- Action Button -->
                        <div class="pt-2">
                            <a href="#booking-panel"
                                class="inline-flex min-h-[48px] items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-8 py-3 text-sm font-bold shadow-sm transition duration-200 cursor-pointer">
                                Reserve Now
                            </a>
                        </div>
                    </div>

                    <!-- Right: Authentic Vehicle Showcase Image (6 cols) -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative rounded-2xl overflow-hidden shadow-lg border border-slate-100 bg-slate-100">
                            <img src="{{ asset('images/oliver-transport-van.jpg') }}"
                                alt="Oliver Transport Commercial Silver Honda Odyssey Chauffeur Minivan Plate RAJIA"
                                class="w-full h-full object-cover aspect-[4/3]" />

                            <!-- Bottom Floating Strip -->
                            <div class="absolute bottom-3 left-3 right-3 rounded-xl bg-slate-950/85 backdrop-blur-md px-4 py-2.5 text-white flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">License Plate</span>
                                    <span class="font-mono font-black text-[#22C55E]">RAJIA</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Fixed Corridor</span>
                                    <span class="font-semibold text-white">Montreal ↔ Toronto</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- 4. FAQ / CORRIDOR GUIDELINES SECTION: Inspired by Reference Image 304beb44.jpg -->
    <section id="faq" class="py-20 lg:py-28 bg-white border-b border-slate-200/80">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <!-- Section Heading -->
            <div class="text-center max-w-2xl mx-auto mb-14 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading">
                    Frequently Asked Questions
                </h2>
                <p class="mt-3.5 text-sm sm:text-base text-[#64748B] leading-relaxed">
                    Everything you need to know about our daily Montreal ↔ Toronto passenger shuttle.
                </p>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-4">

                <!-- FAQ 1 -->
                <details class="group rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-6 open:bg-white open:border-[#22C55E]/40 open:shadow-md transition-all duration-200">
                    <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>How do I pay for my trip?</span>
                        <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                        Payment is simple and cash-only ( CAD flat fare). You pay the driver directly upon boarding the vehicle. No online payment or upfront credit card deposit is needed.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details class="group rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-6 open:bg-white open:border-[#22C55E]/40 open:shadow-md transition-all duration-200">
                    <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>Where are the exact pickup and drop-off stations?</span>
                        <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                        We operate strictly between 3 predefined transit hubs: <strong>Station Métro Namur</strong> in Montreal, and <strong>Yorkdale Mall</strong> and <strong>Yonge Station</strong> in Toronto. All locations provide seamless connections to subway lines and major highways.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-6 open:bg-white open:border-[#22C55E]/40 open:shadow-md transition-all duration-200">
                    <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>What are the daily departure times?</span>
                        <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                        <strong>Route A (Montreal → Toronto):</strong> Departs Station Métro Namur at 6:30 AM EST daily.<br />
                        <strong>Route B (Toronto → Montreal):</strong> Pickups at Yorkdale Mall at 12:15 PM EST and Yonge Station at 1:15 PM EST, arriving in Montreal around 7:15 PM EST.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details class="group rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-6 open:bg-white open:border-[#22C55E]/40 open:shadow-md transition-all duration-200">
                    <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>Can I book multiple seats or choose my seat?</span>
                        <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                        Yes! You can reserve from 1 to 6 seats in our Honda Odyssey. Our system provides visual seat selection so you and your companions sit together.
                    </p>
                </details>

                <!-- FAQ 5 -->
                <details class="group rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-6 open:bg-white open:border-[#22C55E]/40 open:shadow-md transition-all duration-200">
                    <summary class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>How can I reach customer support?</span>
                        <span class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                        You can reach us directly via telephone, SMS, or WhatsApp at <strong class="font-mono text-slate-900 font-bold">647-655-1884</strong> or visit our dedicated <a href="{{ route('contact') }}" class="text-[#16A34A] underline font-bold hover:text-[#15803D]">Contact Page</a>.
                    </p>
                </details>

            </div>

        </div>
    </section>

    <!-- Guest Authentication Required Modal -->
    <div id="auth-booking-modal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md hidden transition-opacity duration-200"
        role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">

        <!-- Backdrop clickable area -->
        <div class="fixed inset-0" onclick="closeAuthModal()" aria-hidden="true"></div>

        <!-- Modal Card Container -->
        <div
            class="relative w-full max-w-md rounded-3xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-100 z-10 transform transition-all">

            <!-- Close Button -->
            <button type="button" onclick="closeAuthModal()"
                class="absolute top-5 right-5 inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]"
                aria-label="Close modal">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Brand Icon -->
            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F0FDF4] text-[#22C55E] mb-5 border border-[#22C55E]/20">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>

            <!-- Heading & Copy -->
            <div class="text-center">
                <h3 id="auth-modal-title" class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-heading">
                    Sign In to Book Your Seat
                </h3>
                <p class="mt-2.5 text-sm text-slate-600 leading-relaxed">
                    Please sign in to your passenger account or register if you're new to select your seats on our
                    interactive Honda Odyssey cabin map and confirm your trip.
                </p>
            </div>

            <!-- Action CTAs -->
            <div class="mt-7 space-y-3">
                <a href="{{ route('login') }}"
                    class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-base font-bold shadow-md hover:shadow-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center">
                    <span>Sign In</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                <a href="{{ route('register') }}"
                    class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 px-6 py-3 text-sm sm:text-base font-bold border border-slate-200/80 transition duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 text-center">
                    <span>Create an Account</span>
                </a>
            </div>

            <!-- Notice in Modal -->
            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Pay directly in cash to the driver upon boarding ($65 CAD flat fare).
                </p>
            </div>

        </div>
    </div>
@endsection