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
            <div class="absolute inset-0 bg-gradient-to-r from-[#111827]/65 via-[#111827]/40 to-black/20"></div>
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
                    <div
                        class="w-full max-w-md rounded-3xl p-6 sm:p-7 shadow-2xl shadow-black/50 border border-white/15 bg-[#111827]/75 backdrop-blur-2xl transition duration-200">

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

    <!-- 2. OUR SERVICES SECTION: Layout Matching Reference Image 2 (2x2 Horizontal Cards) -->
    <section id="services" class="py-20 lg:py-28 bg-white border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Header: 2 Columns Matching Reference Image 2 -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-evenly gap-6 mb-12 sm:mb-16">
                <div>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#111827] tracking-tight font-heading">
                        Services
                    </h2>
                </div>
                <p class="text-sm sm:text-base text-[#64748B] max-w-md leading-relaxed md:text-right">
                    We invite you to try our services, and we personally guarantee that you will be completely satisfied.
                </p>
            </div>

            <!-- 2x2 Grid of Horizontal Cards Matching Reference Image 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                <!-- Card 1: Airport transfers -->
                <div
                    class="rounded-[2rem] bg-[#F1F3F7] p-5 sm:p-6 flex flex-col sm:flex-row items-stretch gap-5 sm:gap-6 border border-slate-200/60 shadow-xs hover:shadow-xl hover:border-[#22C55E]/40 transition-all duration-300">
                    <div class="w-full sm:w-[48%] h-48 sm:h-auto min-h-[180px] rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/service-airport.jpg') }}" alt="Oliver Transport Airport Transfer Service"
                            class="w-full h-full object-cover rounded-2xl" />
                    </div>
                    <div class="w-full sm:w-[52%] flex flex-col justify-between py-1">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#111827] tracking-tight font-heading">
                                Airport transfers
                            </h3>
                            <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                With additional wait time and flight tracking in case of delays, our service is optimized to
                                make every airport transfer a breeze.
                            </p>
                        </div>
                        <div class="mt-5">
                            <a href="#contact"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Intercity trips -->
                <div
                    class="rounded-[2rem] bg-[#F1F3F7] p-5 sm:p-6 flex flex-col sm:flex-row items-stretch gap-5 sm:gap-6 border border-slate-200/60 shadow-xs hover:shadow-xl hover:border-[#22C55E]/40 transition-all duration-300">
                    <div class="w-full sm:w-[48%] h-48 sm:h-auto min-h-[180px] rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/service-intercity.jpg') }}"
                            alt="Oliver Transport Intercity Trips Montreal to Toronto"
                            class="w-full h-full object-cover rounded-2xl" />
                    </div>
                    <div class="w-full sm:w-[52%] flex flex-col justify-between py-1">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#111827] tracking-tight font-heading">
                                Intercity trips
                            </h3>
                            <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Your stressfree solution for traveling between Montreal and Toronto with guaranteed reserved
                                seating, daily schedules, and professional chauffeurs.
                            </p>
                        </div>
                        <div class="mt-5">
                            <a href="#contact"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Wedding events -->
                <div
                    class="rounded-[2rem] bg-[#F1F3F7] p-5 sm:p-6 flex flex-col sm:flex-row items-stretch gap-5 sm:gap-6 border border-slate-200/60 shadow-xs hover:shadow-xl hover:border-[#22C55E]/40 transition-all duration-300">
                    <div class="w-full sm:w-[48%] h-48 sm:h-auto min-h-[180px] rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/service-special-events.jpg') }}"
                            alt="Oliver Transport Wedding &amp; Special Events Chauffeur"
                            class="w-full h-full object-cover rounded-2xl" />
                    </div>
                    <div class="w-full sm:w-[52%] flex flex-col justify-between py-1">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#111827] tracking-tight font-heading">
                                Wedding events
                            </h3>
                            <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Our friendly, and attentive service combined with thorough attention to detail ensure you
                                can
                                truly relax and enjoy your special day.
                            </p>
                        </div>
                        <div class="mt-5">
                            <a href="#contact"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Business Meeting -->
                <div
                    class="rounded-[2rem] bg-[#F1F3F7] p-5 sm:p-6 flex flex-col sm:flex-row items-stretch gap-5 sm:gap-6 border border-slate-200/60 shadow-xs hover:shadow-xl hover:border-[#22C55E]/40 transition-all duration-300">
                    <div class="w-full sm:w-[48%] h-48 sm:h-auto min-h-[180px] rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/service-corporate.jpg') }}"
                            alt="Oliver Transport Business Meeting Corporate Travel"
                            class="w-full h-full object-cover rounded-2xl" />
                    </div>
                    <div class="w-full sm:w-[52%] flex flex-col justify-between py-1">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#111827] tracking-tight font-heading">
                                Business Meeting
                            </h3>
                            <p class="mt-2.5 text-xs sm:text-sm text-[#64748B] leading-relaxed">
                                Focus on your meeting with your partners, forget about the road and the car, which will
                                distract
                                your thoughts. We handle everything.
                            </p>
                        </div>
                        <div class="mt-5">
                            <a href="#contact"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs font-bold transition duration-200 shadow-xs">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. WHY CHOOSE US SECTION: Soft Green-Tinted (#F0FDF4) Background with 4 Benefits -->
    <section id="why-us" class="py-20 lg:py-28 bg-[#F0FDF4] border-b border-[#22C55E]/15">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Heading & Description -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
                <span class="inline-block text-xs font-black tracking-widest text-[#16A34A] uppercase mb-3">
                    WHY CHOOSE US
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading">
                    Travel with Confidence
                </h2>
                <p class="mt-4 text-base sm:text-lg text-[#64748B] leading-relaxed">
                    At Oliver Transport, we are committed to delivering exceptional transportation services with
                    professionalism, reliability and comfort.
                </p>
            </div>

            <!-- 4 Benefit Items Arranged Horizontally with Thin Separators -->
            <div class="rounded-3xl bg-white border border-[#22C55E]/20 p-8 sm:p-12 shadow-sm">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-0 lg:divide-x lg:divide-slate-200/80">

                    <!-- Benefit 1: Professional Drivers -->
                    <div class="lg:px-8 flex flex-col items-center text-center">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-4 border border-[#22C55E]/25">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1F2937] font-heading">Professional Drivers</h3>
                        <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                            Experienced and courteous drivers.
                        </p>
                    </div>

                    <!-- Benefit 2: Premium Vehicles -->
                    <div class="lg:px-8 flex flex-col items-center text-center">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-4 border border-[#22C55E]/25">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1F2937] font-heading">Premium Vehicles</h3>
                        <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                            Well-maintained luxury cars.
                        </p>
                    </div>

                    <!-- Benefit 3: On-Time Service -->
                    <div class="lg:px-8 flex flex-col items-center text-center">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-4 border border-[#22C55E]/25">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1F2937] font-heading">On-Time Service</h3>
                        <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                            Always on schedule.
                        </p>
                    </div>

                    <!-- Benefit 4: Reliable Service -->
                    <div class="lg:px-8 flex flex-col items-center text-center">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center mb-4 border border-[#22C55E]/25">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1F2937] font-heading">Reliable Service</h3>
                        <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                            Your trust, our priority.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- 4. ABOUT OLIVER TRANSPORT SECTION: Clean White (#FFFFFF) 2-Column Layout -->
    <section id="about" class="py-20 lg:py-28 bg-white border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <!-- Left Column: Authentic Vehicle Image & Fleet Badge -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100">
                        <img src="{{ asset('images/oliver-transport-van.jpg') }}"
                            alt="Oliver Transport Commercial Silver Honda Odyssey Chauffeur Minivan"
                            class="w-full h-full object-cover aspect-[4/3]" />

                        <!-- Verified Fleet Overlay Badge -->
                        <div
                            class="absolute bottom-4 left-4 right-4 rounded-2xl bg-[#111827]/85 backdrop-blur-md p-4 border border-white/10 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-wider text-[#22C55E] block">Operating
                                        Fleet</span>
                                    <h4 class="text-sm sm:text-base font-bold text-white">Honda Odyssey</h4>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-slate-400 block">Ontario Commercial</span>
                                    <span
                                        class="font-mono text-xs font-black text-[#22C55E] bg-white/10 px-2 py-0.5 rounded-md">RAJIA</span>
                                </div>
                            </div>
                            <div
                                class="mt-2 pt-2 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                                <span>6 Passenger Seats</span>
                                <span>Montreal ↔ Toronto Corridor</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Narrative & Learn More CTA -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-block text-xs font-black tracking-widest text-[#22C55E] uppercase">
                        ABOUT OLIVER TRANSPORT
                    </span>

                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading leading-tight">
                        More Than Just a Ride
                    </h2>

                    <p class="text-base sm:text-lg text-[#64748B] leading-relaxed">
                        We provide premium transportation solutions designed around your comfort, convenience and peace of
                        mind.
                    </p>

                    <p class="text-sm sm:text-base text-[#1F2937] leading-relaxed">
                        Oliver Transport operates daily scheduled intercity passenger transportation connecting Montreal and
                        Toronto. With fixed departure timetables, individual seat selection on an interactive vehicle map,
                        and cash settlement upon boarding, we deliver straightforward, reliable chauffeur journeys for
                        business, leisure, and personal travel.
                    </p>

                    <div class="pt-2">
                        <a href="#contact"
                            class="inline-flex min-h-[48px] items-center justify-center rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]">
                            Learn More
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. CONTACT US SECTION: Light Background (#F8FAFC) with Cards & Form -->
    <section id="contact" class="py-20 lg:py-28 bg-[#F8FAFC] border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Section Heading -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
                <span class="inline-block text-xs font-black tracking-widest text-[#22C55E] uppercase mb-3">
                    CONTACT US
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#111827] tracking-tight font-heading">
                    Get in Touch
                </h2>
                <p class="mt-4 text-base sm:text-lg text-[#64748B] leading-relaxed">
                    Have a question or need help planning your journey? Contact our team.
                </p>
            </div>

            <!-- Two-Column Grid: Contact Information & Inquiry Form -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                <!-- Left Column: Verified Contact Cards (5 cols) -->
                <div class="lg:col-span-5 space-y-5">

                    <!-- Phone Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-start gap-4">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Direct Telephone /
                                SMS</span>
                            <a href="tel:6476551884"
                                class="text-lg font-bold text-[#1F2937] hover:text-[#22C55E] transition mt-0.5 block font-mono">
                                647-655-1884
                            </a>
                            <span class="text-xs text-[#64748B] mt-0.5 block">Call, Text, or WhatsApp available
                                daily.</span>
                        </div>
                    </div>

                    <!-- Email Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-start gap-4">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Email
                                Support</span>
                            <a href="mailto:info@olivertransport.ca"
                                class="text-base font-bold text-[#1F2937] hover:text-[#22C55E] transition mt-0.5 block">
                                info@olivertransport.ca
                            </a>
                            <span class="text-xs text-[#64748B] mt-0.5 block">Booking confirmations and passenger
                                inquiries.</span>
                        </div>
                    </div>

                    <!-- Stations Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-start gap-4">
                        <div
                            class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Predefined
                                Corridor Stations</span>
                            <h4 class="font-bold text-[#1F2937] mt-1">Station Métro Namur</h4>
                            <p class="text-xs text-[#64748B]">Montreal, QC • Route A (Montreal → Toronto • 6:30 AM)</p>
                            <h4 class="font-bold text-[#1F2937] mt-3">Yorkdale Mall &amp; Yonge Station</h4>
                            <p class="text-xs text-[#64748B]">Toronto, ON • Route B (Toronto → Montreal • 12:15 PM &amp;
                                1:15 PM)</p>
                        </div>
                    </div>

                    <!-- Cash Settlement Note -->
                    <div class="rounded-2xl bg-[#F0FDF4] border border-[#22C55E]/30 p-4 text-xs text-[#1F2937]">
                        <span class="font-bold text-[#16A34A] block mb-0.5">Cash Payment Upon Boarding</span>
                        Pay the driver directly in cash when boarding ($65 CAD flat fare). Zero upfront electronic credit
                        card payment required.
                    </div>

                </div>

                <!-- Right Column: Contact Inquiry Form (7 cols) -->
                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-7 sm:p-10 shadow-xs">
                        <h3 class="text-2xl font-black text-[#111827] font-heading mb-2">Send an Inquiry</h3>
                        <p class="text-sm text-[#64748B] mb-8">Leave us a message regarding private trips, route schedules,
                            or group bookings.</p>

                        <form action="#" method="POST"
                            onsubmit="event.preventDefault(); alert('Thank you for reaching out to Oliver Transport. We will contact you promptly at your provided details.');"
                            class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="contact-name"
                                        class="block text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1.5">Full
                                        Name</label>
                                    <input id="contact-name" type="text" required placeholder="Your full name"
                                        class="w-full rounded-2xl border border-slate-200 bg-[#F8FAFC] px-4 py-3 text-base text-[#1F2937] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                                </div>
                                <div>
                                    <label for="contact-phone"
                                        class="block text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1.5">Phone
                                        Number</label>
                                    <input id="contact-phone" type="tel" required placeholder="647-xxx-xxxx"
                                        class="w-full rounded-2xl border border-slate-200 bg-[#F8FAFC] px-4 py-3 text-base text-[#1F2937] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                                </div>
                            </div>

                            <div>
                                <label for="contact-email"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1.5">Email
                                    Address</label>
                                <input id="contact-email" type="email" required placeholder="your.email@example.com"
                                    class="w-full rounded-2xl border border-slate-200 bg-[#F8FAFC] px-4 py-3 text-base text-[#1F2937] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                            </div>

                            <div>
                                <label for="contact-message"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1.5">Your
                                    Message</label>
                                <textarea id="contact-message" rows="4" required
                                    placeholder="Tell us about your journey plans or inquiry..."
                                    class="w-full rounded-2xl border border-slate-200 bg-[#F8FAFC] px-4 py-3 text-base text-[#1F2937] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition"></textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="inline-flex min-h-[48px] w-full sm:w-auto items-center justify-center rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-base font-bold shadow-md hover:shadow-lg transition cursor-pointer">
                                    Send Inquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

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