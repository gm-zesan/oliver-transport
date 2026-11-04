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
                    <div class="mb-5 sm:mb-6">
                        <span class="text-xs sm:text-sm font-extrabold uppercase tracking-[0.22em] text-[#22C55E]">PREMIUM
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
                                                    class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] bg-[#22C55E]/15 px-2 py-0.5 rounded-full border border-[#22C55E]/30">Route
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
                                                    class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] bg-[#22C55E]/15 px-2 py-0.5 rounded-full border border-[#22C55E]/30">Route
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

    <section id="services" class="relative py-24 lg:py-32 bg-white border-b border-slate-100 overflow-hidden">
        <!-- Luxury Ambient Radial Glow (Oliver Green aura) -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/5 rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute bottom-0 left-10 w-80 h-80 bg-slate-100/60 rounded-full blur-2xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: Standardized Centered with Eyebrow, Title & Subtitle -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 space-y-3">
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

            <!-- 2 Core Services Grid: Route A & Route B (Realistic 3-Location Ride-Share) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                <!-- Service 1: Route A — Montreal to Toronto -->
                <div
                    class="group relative rounded-3xl bg-white p-6 sm:p-7 flex flex-col sm:flex-row items-stretch gap-6 border border-slate-200/80 shadow-sm hover:shadow-2xl hover:shadow-[#22C55E]/10 hover:border-[#22C55E]/50 transition-all duration-300">
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
                                    $65 <span class="text-xs font-semibold text-slate-500">CAD</span>
                                </span>
                            </div>

                            <h3
                                class="text-2xl font-bold text-[#111827] tracking-tight font-heading group-hover:text-[#16A34A] transition-colors">
                                Montreal → Toronto
                            </h3>

                            <div class="mt-4 space-y-2.5 text-xs sm:text-sm text-slate-700">
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
                                    <span>Cash payment upon boarding with driver ($65 CAD)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/70 flex items-center justify-between">
                            <a href="#booking-panel" onclick="switchHeroRoute('route-a')"
                                class="inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold transition duration-200 shadow-sm hover:shadow-md cursor-pointer">
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
                    class="group relative rounded-3xl bg-white p-6 sm:p-7 flex flex-col sm:flex-row items-stretch gap-6 border border-slate-200/80 shadow-sm hover:shadow-2xl hover:shadow-[#22C55E]/10 hover:border-[#22C55E]/50 transition-all duration-300">
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
                                    $65 <span class="text-xs font-semibold text-slate-500">CAD</span>
                                </span>
                            </div>

                            <h3
                                class="text-2xl font-bold text-[#111827] tracking-tight font-heading group-hover:text-[#16A34A] transition-colors">
                                Toronto → Montreal
                            </h3>

                            <div class="mt-4 space-y-2.5 text-xs sm:text-sm text-slate-700">
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
                                    <span>Cash payment upon boarding with driver ($65 CAD)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/70 flex items-center justify-between">
                            <a href="#booking-panel" onclick="switchHeroRoute('route-b')"
                                class="inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold transition duration-200 shadow-sm hover:shadow-md cursor-pointer">
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

    <section id="how-it-works" class="relative py-24 lg:py-32 bg-[#F8FAFC] border-b border-slate-200/80 overflow-hidden">
        <!-- Ambient Atmosphere Subtle Tint -->
        <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-[#22C55E]/[0.03] blur-3xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: Standardized Centered with Eyebrow, Title & Subtitle -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 space-y-3">
                <div>
                    <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                        SIMPLE 3-STEP PROCESS
                    </span>
                </div>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    How It Works
                </h2>
                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto">
                    Booking your reserved seat between Montreal and Toronto is fast, transparent, and hassle-free.
                </p>
            </div>

            <!-- Stepper Timeline: Continuous Line with Centered Step Numbers -->
            <div class="hidden md:block relative mb-8">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8 pb-4">

                <!-- Step 1 Card -->
                <div class="group relative flex flex-col items-center">
                    <!-- Mobile Number Indicator -->
                    <div class="md:hidden flex items-center justify-center mb-3">
                        <span class="text-4xl font-black font-heading text-slate-300">01</span>
                    </div>

                    <!-- Image Frame -->
                    <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                        <img src="{{ asset('images/service-intercity.jpg') }}"
                            alt="Select route and date for Oliver Transport shuttle"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                        </div>
                    </div>

                    <!-- Overlapping White Floating Card (Matching Reference Image) -->
                    <div
                        class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                        <h3
                            class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                            Choose Your Route
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                            Select Route A (Montreal → Toronto) or Route B (Toronto → Montreal) and pick your travel
                            date.
                        </p>
                    </div>
                </div>

                <!-- Step 2 Card -->
                <div class="group relative flex flex-col items-center">
                    <!-- Mobile Number Indicator -->
                    <div class="md:hidden flex items-center justify-center mb-3">
                        <span class="text-4xl font-black font-heading text-slate-300">02</span>
                    </div>

                    <!-- Image Frame -->
                    <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                        <img src="{{ asset('images/service-airport.jpg') }}"
                            alt="Reserve your seat with interactive cabin diagram"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                        </div>
                    </div>

                    <!-- Overlapping White Floating Card (Matching Reference Image) -->
                    <div
                        class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                        <h3
                            class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                            Book with Ease
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                            Pick your exact seat (S1–S6) on our visual cabin diagram and receive instant booking
                            confirmation.
                        </p>
                    </div>
                </div>

                <!-- Step 3 Card -->
                <div class="group relative flex flex-col items-center">
                    <!-- Mobile Number Indicator -->
                    <div class="md:hidden flex items-center justify-center mb-3">
                        <span class="text-4xl font-black font-heading text-slate-300">03</span>
                    </div>

                    <!-- Image Frame -->
                    <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-md bg-slate-900 relative">
                        <img src="{{ asset('images/service-corporate.jpg') }}"
                            alt="Travel comfortably in Honda Odyssey with cash on boarding"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                        </div>
                    </div>

                    <!-- Overlapping White Floating Card (Matching Reference Image) -->
                    <div
                        class="-mt-12 w-[88%] sm:w-[84%] rounded-2xl bg-white p-6 sm:p-7 shadow-xl shadow-slate-900/5 border border-slate-200/80 text-center relative z-10 group-hover:border-[#22C55E]/50 group-hover:shadow-2xl group-hover:shadow-[#22C55E]/10 transition-all duration-300">
                        <h3
                            class="text-lg sm:text-xl font-bold text-[#111827] font-heading tracking-tight group-hover:text-[#16A34A] transition-colors">
                            Ride &amp; Pay Cash
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                            Board at your predefined transit hub, pay the driver directly in cash ($65 CAD), and enjoy
                            the journey.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Action CTA -->
            <div class="mt-16 text-center">
                <a href="#booking-panel"
                    class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]">
                    <span>Reserve Your Seat Now</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

        </div>
    </section>

    <section id="why-us"
        class="relative py-28 lg:py-36 bg-[#0B0F17] overflow-hidden border-b border-slate-800 text-white bg-cover bg-no-repeat bg-[center_left]"
        style="background-image: url('{{ asset('images/why-us-luxury-transport-flipped.jpg') }}'); background-position: left center; background-size: cover;">

        <!-- Dark Vignette Overlay: Crystal-clear on left so car front & headlights shine, deep dark backdrop on right behind card -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#0B0F17]/50 to-[#0B0F17]/95 pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0B0F17] via-transparent to-[#0B0F17]/70 pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex flex-col lg:flex-row items-center justify-end">

                <!-- RIGHT SIDE: Translucent Frosted Glass Card (Clean, Uncluttered, Pure Elegance) -->
                <div class="w-full lg:w-[500px] xl:w-[540px]">
                    <div
                        class="rounded-3xl bg-[#0B0F17]/85 backdrop-blur-2xl border border-white/10 p-7 sm:p-9 lg:p-11 shadow-2xl shadow-black/90">

                        <!-- Pure Text Category Label (No Pill, No Badge, No Dot) -->
                        <div class="space-y-3 mb-6">
                            <div>
                                <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase">
                                    WHY CHOOSE US
                                </span>
                            </div>

                            <h2
                                class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight font-heading leading-tight">
                                Why Select Us for Your Journey
                            </h2>

                            <p class="text-sm text-slate-300 leading-relaxed">
                                Premium comfort, guaranteed seating, and reliable daily intercity transit.
                            </p>
                        </div>

                        <!-- Clean Accordion List -->
                        <div class="mt-8 space-y-3.5 divide-y divide-white/10">

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
                                    Guaranteed flat fare of $65 CAD per passenger per trip with zero hidden fees,
                                    zero surge pricing, and cash payment on boarding.
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
                                    Daily fixed departures 7 days a week, 365 days a year: 6:30 AM from
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
                                    Direct service connecting Station Métro Namur in Montreal with Yorkdale Mall
                                    and Yonge Station in Toronto.
                                </div>
                            </details>

                        </div>

                        <!-- CTA Button -->
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <a href="#booking-panel"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm font-bold shadow-lg shadow-[#22C55E]/20 transition-all duration-200 cursor-pointer min-h-[48px]">
                                <span>Reserve Your Seat</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. DEDICATED FLEET (Executive Fleet - Honda Odyssey) -->
    <!-- Option 2: Full-Width Cinematic Panoramic Stage -->
    <!-- ========================================== -->
    <section id="about" class="relative py-24 lg:py-32 bg-[#F8FAFC] border-b border-slate-200/80 overflow-hidden">
        <!-- Ambient Atmosphere Subtle Tint -->
        <div class="absolute top-1/2 left-1/3 w-96 h-96 bg-[#22C55E]/[0.03] rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10">

            <!-- Section Header: Centered on Top -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
                <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                    EXECUTIVE FLEET
                </span>

                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    Travel in the Honda Odyssey
                </h2>

                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto font-normal">
                    Daily scheduled shuttle connecting Montreal and Toronto. Enjoy guaranteed reserved seating, generous
                    luggage space, and smooth highway comfort for only $65 CAD flat fare.
                </p>
            </div>

            <!-- Cinematic Panoramic Vehicle Stage -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 bg-slate-950 group">

                <!-- High-Definition Panoramic Image -->
                <div class="relative h-[340px] sm:h-[440px] lg:h-[520px] w-full overflow-hidden">
                    <img src="{{ asset('images/honda-odyssey-fleet-raw.jpg') }}"
                        alt="Oliver Transport Commercial Silver Honda Odyssey Minivan with Ontario Plate RAJIA and Toronto Skyline"
                        class="w-full h-full object-cover object-[center_60%] group-hover:scale-[1.02] transition-transform duration-700 ease-out" />

                    <!-- Cinematic Vignette Gradients for Legibility & Drama -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/40 via-transparent to-slate-950/40"></div>

                    <!-- Bottom Floating Content Bar inside the Panoramic Stage -->
                    <div
                        class="absolute bottom-0 inset-x-0 p-6 sm:p-8 lg:p-10 flex flex-col md:flex-row md:items-end justify-between gap-6 z-10">
                        <div class="space-y-2 text-white max-w-lg">
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-md px-3 py-1 text-xs font-bold text-white border border-white/20">
                                <span>Commercial Plate: RAJIA</span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white font-heading">
                                Silver Honda Odyssey Express
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                                Daily intercity express transit between Montreal and Toronto. Professional chauffeur, quiet
                                ride, and generous legroom.
                            </p>
                        </div>

                        <!-- CTA Button on Banner -->
                        <div class="flex-shrink-0">
                            <a href="#booking-panel"
                                class="inline-flex min-h-[48px] items-center justify-center gap-2.5 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-lg shadow-[#22C55E]/30 transition cursor-pointer">
                                <span>Reserve Your Seat Now</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 6 Key Fleet Features Grid (Floating Clean White Cards Below Stage) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mt-6">

                <!-- Card 1 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">6 Passenger Seats</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">Individual Booking</span>
                </div>

                <!-- Card 2 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Clean Tinted Windows</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">Privacy &amp; Shade</span>
                </div>

                <!-- Card 3 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v18m9-9H3m15.364 6.364l-12.728-12.728m12.728 0L5.636 17.657" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Tri-Zone Climate Control</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">AC &amp; Heating</span>
                </div>

                <!-- Card 4 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">USB Charging Ports</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">Fast Power Output</span>
                </div>

                <!-- Card 5 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Generous Luggage Allowance</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">1 Large + 1 Handbag</span>
                </div>

                <!-- Card 6 -->
                <div
                    class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center shadow-xs hover:border-[#22C55E]/40 hover:shadow-md transition group">
                    <div
                        class="mx-auto h-10 w-10 rounded-full bg-[#F0FDF4] text-[#16A34A] flex items-center justify-center mb-2.5 group-hover:bg-[#22C55E] group-hover:text-white transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Cash Payment Upon Boarding</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">$65 CAD • Pay the driver directly in cash when
                        boarding</span>
                </div>

            </div>

        </div>
    </section>

    <section id="faq" class="relative py-24 lg:py-32 bg-[#F8FAFC] border-b border-slate-200/70 overflow-hidden">
        <!-- Ambient FAQ Atmosphere -->
        <div class="absolute top-0 left-1/3 w-96 h-96 bg-[#22C55E]/[0.03] rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: Standardized Centered with Eyebrow, Title & Subtitle -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 space-y-3">
                <div>
                    <span class="text-xs font-black tracking-widest text-[#16A34A] uppercase">
                        HELP &amp; CORRIDOR GUIDE
                    </span>
                </div>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                    Frequently Asked Questions
                </h2>
                <p class="text-base sm:text-lg text-[#64748B] leading-relaxed max-w-2xl mx-auto">
                    Everything you need to know about our daily Montreal ↔ Toronto
                    passenger
                    shuttle, stations, and cash settlement.
                </p>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details
                    class="group rounded-2xl border border-slate-200/80 bg-white p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 hover:shadow-sm transition-all duration-200">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>How do I pay for my trip?</span>
                        <span
                            class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        Payment is simple and cash-only ($65 CAD flat fare). You pay
                        the driver directly upon boarding the vehicle. No online payment or upfront credit card deposit is
                        needed.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details
                    class="group rounded-2xl border border-slate-200/80 bg-white p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 hover:shadow-sm transition-all duration-200">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>Where are the exact pickup and drop-off stations?</span>
                        <span
                            class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        We operate strictly between 3 predefined transit hubs:
                        <strong class="text-slate-900 font-semibold">Station Métro Namur</strong> in Montreal, and <strong
                            class="text-slate-900 font-semibold">Yorkdale Mall</strong> and
                        <strong class="text-slate-900 font-semibold">Yonge Station</strong> in Toronto. All locations
                        provide seamless connections to subway lines and major highways.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details
                    class="group rounded-2xl border border-slate-200/80 bg-white p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 hover:shadow-sm transition-all duration-200">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>What are the daily departure times?</span>
                        <span
                            class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        <strong class="text-slate-900 font-semibold">Route A (Montreal → Toronto):</strong> Departs Station
                        Métro Namur at 6:30 AM EST daily.<br />
                        <strong class="text-slate-900 font-semibold">Route B (Toronto → Montreal):</strong> Pickups at
                        Yorkdale Mall at 12:15 PM EST and Yonge Station at 1:15 PM EST, arriving in Montreal around 7:15 PM
                        EST.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details
                    class="group rounded-2xl border border-slate-200/80 bg-white p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 hover:shadow-sm transition-all duration-200">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>Can I book multiple seats or choose my seat?</span>
                        <span
                            class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        Yes! You can reserve from 1 to 6 seats in our Honda Odyssey. Our system provides visual seat
                        selection so you and your companions sit together.
                    </p>
                </details>

                <!-- FAQ 5 -->
                <details
                    class="group rounded-2xl border border-slate-200/80 bg-white p-6 open:border-[#22C55E]/50 open:shadow-lg open:shadow-[#22C55E]/5 hover:border-[#22C55E]/40 hover:shadow-sm transition-all duration-200">
                    <summary
                        class="flex cursor-pointer items-center justify-between text-base sm:text-lg font-bold text-[#111827] select-none">
                        <span>How can I reach customer support?</span>
                        <span
                            class="ml-4 flex h-7 w-7 items-center justify-center rounded-full bg-slate-200/70 text-slate-700 group-open:bg-[#22C55E] group-open:text-white transition">
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        You can reach us directly via telephone, SMS, or WhatsApp at
                        <strong class="font-mono text-slate-900 font-bold">647-655-1884</strong> or visit our dedicated <a
                            href="{{ route('contact') }}"
                            class="text-[#16A34A] underline font-bold hover:text-[#15803D]">Contact Page</a>.
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
        <div class="fixed inset-0" onclick="closeAuthModal()" aria-hidden="true">
        </div>

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
                    Please sign in to your passenger account or register if you're
                    new to select
                    your seats on our
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
                    Pay directly in cash to the driver upon boarding ($65 CAD flat
                    fare).
                </p>
            </div>

        </div>
    </div>
@endsection