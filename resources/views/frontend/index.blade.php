@extends('frontend.layout.app')

@section('title', 'Oliver Transport — Daily Montreal ↔ Toronto Passenger Shuttle')

@section('content')
    <!-- Hero Section: Daylight Highway Ride Video Background with Luxury Floating Booking Widget (Light Theme) -->
    <section
        class="relative min-h-[92vh] flex items-center justify-center overflow-hidden bg-[#F8FAFC] pt-28 pb-16 sm:pt-32 sm:pb-20 lg:pt-36 lg:pb-24 border-b border-slate-200/80">

        <!-- Background Car Ride Video Loop with Daylight Key Treatment -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <video autoplay muted loop playsinline poster="{{ asset('images/hero-video-poster.jpg') }}"
                class="w-full h-full object-cover scale-105">
                <source src="{{ asset('videos/hero-odyssey-loop.mp4') }}" type="video/mp4">
                <source src="{{ asset('videos/hero-highway-loop.mp4') }}" type="video/mp4">
            </video>
            <!-- Cinematic Daylight Overlay: subtle white on left for contrast, open center/right so video blurs through frosted glass card -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/50 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#F8FAFC]/90 via-transparent to-white/30"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">

                <!-- LEFT SIDE: Spacious, High-Impact Brand Messaging (approx 50%) -->
                <div class="lg:w-[50%] w-full flex flex-col justify-center text-left">

                    <!-- Clean Minimal Eyebrow Pill -->
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-[#22C55E]/10 border border-[#22C55E]/25 px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-[#16A34A] w-fit mb-5 shadow-xs">
                        <span class="h-2 w-2 rounded-full bg-[#22C55E] animate-pulse"></span>
                        <span>Premium Intercity Passenger Shuttle</span>
                    </div>

                    <!-- Spacious, Confident Headline -->
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black tracking-tight text-slate-900 leading-[1.08] font-heading">
                        Your Journey, <br />
                        <span class="text-[#22C55E]">Our Priority.</span>
                    </h1>

                    <!-- Elegant Subtitle -->
                    <p class="mt-5 text-xl sm:text-2xl font-bold text-slate-800 leading-snug">
                        Travel in Comfort. Arrive in Style.
                    </p>

                    <!-- Concise Description with Room to Breathe -->
                    <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-normal">
                        Experience reliable, comfortable and professional transportation with Oliver Transport. Scheduled
                        daily passenger shuttle service connecting Montreal and Toronto with guaranteed reserved seating and
                        cash settlement on boarding.
                    </p>

                    <!-- Minimal Elegant Service Summary Line -->
                    <div class="mt-8 flex flex-wrap items-center gap-3 text-xs font-bold text-slate-700">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/80 border border-slate-200/80 px-3 py-1.5 shadow-xs backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>
                            Montreal • Toronto • Montreal
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/80 border border-slate-200/80 px-3 py-1.5 shadow-xs backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>
                            Daily Fixed Schedule
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/80 border border-slate-200/80 px-3 py-1.5 shadow-xs backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>
                            $65 CAD Flat Fare
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/80 border border-slate-200/80 px-3 py-1.5 shadow-xs backdrop-blur-sm text-slate-500">
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                            Honda Odyssey (Plate: RAJIA) • 6 Passenger Seats
                        </span>
                    </div>
                </div>

                <!-- RIGHT SIDE: Luxury Frosted Glass Booking Card (Video visible behind) -->
                <div class="lg:w-[46%] w-full flex justify-center lg:justify-end">
                    <div
                        class="w-full max-w-md rounded-3xl p-6 sm:p-7 shadow-2xl shadow-slate-950/15 border border-white/70 bg-white/55 backdrop-blur-2xl transition duration-200">

                        <!-- Top Route Tabs Navigation -->
                        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-200/60" role="tablist">
                            <!-- Route A Pill Tab -->
                            <button id="tab-btn-route-a" type="button" role="tab" aria-selected="true"
                                onclick="switchHeroRoute('route-a')"
                                class="route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#22C55E] text-white shadow-xs cursor-pointer text-center">
                                <span>Route A (Mtl → Tor)</span>
                            </button>

                            <!-- Route B Tab -->
                            <button id="tab-btn-route-b" type="button" role="tab" aria-selected="false"
                                onclick="switchHeroRoute('route-b')"
                                class="route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-700 hover:text-slate-900 bg-white/80 hover:bg-white border border-slate-200/60 cursor-pointer text-center">
                                <span>Route B (Tor → Mtl)</span>
                            </button>
                        </div>

                        <!-- Booking Form with Uber-Style Dropdowns -->
                        <form id="hero-booking-form" action="{{ route('login') }}" method="GET" class="mt-4 space-y-3">

                            <!-- 1. Pick Up Address Input (Uber-Style Dropdown) -->
                            <div class="relative" id="pickup-field-wrapper">
                                <div onclick="togglePickupDropdown()"
                                    class="rounded-2xl border border-slate-200/80 bg-white/90 hover:bg-white focus-within:bg-white focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition cursor-pointer p-3.5 flex items-center gap-3 shadow-xs select-none">

                                    <!-- Left Pin: Black ring with dot (Uber Pickup Pin) -->
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="h-3 w-3 rounded-full border-2 border-slate-900 bg-white ring-2 ring-slate-900/10"></span>
                                    </div>

                                    <!-- Center: Label and Selected Text -->
                                    <div class="flex-1 min-w-0">
                                        <span id="label-pickup"
                                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 leading-none mb-1">
                                            Pickup location
                                        </span>
                                        <span id="pickup-display-text"
                                            class="block text-sm sm:text-base font-bold text-slate-900 truncate leading-snug">
                                            Station Métro Namur (Montreal)
                                        </span>
                                        <input type="hidden" name="from" id="pickup_location" value="namur">
                                    </div>

                                    <!-- Right: Navigation Arrow (as in user reference image) -->
                                    <div class="text-slate-400 hover:text-slate-700 transition flex-shrink-0">
                                        <svg class="h-4 w-4 transform -rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Uber-Style Floating Dropdown Menu -->
                                <div id="pickup-dropdown-menu"
                                    class="absolute left-0 right-0 top-full mt-2 z-50 rounded-2xl bg-white shadow-2xl border border-slate-200/90 divide-y divide-slate-100 hidden overflow-hidden">

                                    <div
                                        class="px-4 py-2 bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                                        Corridor Departure Hubs
                                    </div>

                                    <!-- Station 1: Montreal Namur -->
                                    <div onclick="selectPickup('namur', 'Station Métro Namur (Montreal)', 'route-a')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-slate-50 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
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
                                                    class="font-bold text-slate-900 text-sm sm:text-base leading-tight">Station
                                                    Métro Namur</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-[#16A34A] bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Route
                                                    A</span>
                                            </div>
                                            <span class="text-xs text-slate-500 block mt-0.5">Montreal • Route A Departure
                                                Hub (6:30 AM EST)</span>
                                        </div>
                                    </div>

                                    <!-- Station 2: Toronto Yorkdale -->
                                    <div onclick="selectPickup('yorkdale', 'Yorkdale Mall (Toronto)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-slate-50 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
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
                                                    class="font-bold text-slate-900 text-sm sm:text-base leading-tight">Yorkdale
                                                    Mall</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-100">Route
                                                    B</span>
                                            </div>
                                            <span class="text-xs text-slate-500 block mt-0.5">Toronto • Route B 1st Pickup
                                                (12:15 PM EST)</span>
                                        </div>
                                    </div>

                                    <!-- Station 3: Toronto Yonge -->
                                    <div onclick="selectPickup('yonge', 'Yonge Station (Toronto)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-slate-50 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
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
                                                    class="font-bold text-slate-900 text-sm sm:text-base leading-tight">Yonge
                                                    Station</span>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-wider text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-100">Route
                                                    B</span>
                                            </div>
                                            <span class="text-xs text-slate-500 block mt-0.5">Toronto • Route B 2nd Pickup
                                                (1:15 PM EST)</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- 2. Drop Off Address Input (Uber-Style Dropdown) -->
                            <div class="relative" id="dest-field-wrapper">
                                <div onclick="toggleDestDropdown()"
                                    class="rounded-2xl border border-slate-200/80 bg-white/90 hover:bg-white focus-within:bg-white focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition cursor-pointer p-3.5 flex items-center gap-3 shadow-xs select-none">

                                    <!-- Left Pin: Solid square (Uber Dropoff Pin) -->
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0">
                                        <span class="h-2.5 w-2.5 rounded-[2px] bg-slate-900"></span>
                                    </div>

                                    <!-- Center: Label and Selected Text -->
                                    <div class="flex-1 min-w-0">
                                        <span id="label-destination"
                                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 leading-none mb-1">
                                            Drop-off location
                                        </span>
                                        <span id="dest-display-text"
                                            class="block text-sm sm:text-base font-bold text-slate-900 truncate leading-snug">
                                            Yorkdale Mall &amp; Yonge Station (Toronto)
                                        </span>
                                        <input type="hidden" name="to" id="destination_location" value="toronto">
                                    </div>

                                    <!-- Right: Dropdown Chevron -->
                                    <div class="text-slate-400 hover:text-slate-700 transition flex-shrink-0">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Uber-Style Floating Dropdown Menu -->
                                <div id="dest-dropdown-menu"
                                    class="absolute left-0 right-0 top-full mt-2 z-50 rounded-2xl bg-white shadow-2xl border border-slate-200/90 divide-y divide-slate-100 hidden overflow-hidden">

                                    <div
                                        class="px-4 py-2 bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                                        Corridor Destination Hubs
                                    </div>

                                    <!-- Toronto Dropoffs -->
                                    <div onclick="selectDestination('toronto', 'Yorkdale Mall & Yonge Station (Toronto)', 'route-a')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-slate-50 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-bold text-slate-900 text-sm sm:text-base leading-tight block">Yorkdale
                                                Mall &amp; Yonge Station</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Toronto Drop-offs • Hwy 401
                                                &amp; TTC Subway Interchange</span>
                                        </div>
                                    </div>

                                    <!-- Montreal Dropoff -->
                                    <div onclick="selectDestination('montreal', 'Station Métro Namur (Montreal)', 'route-b')"
                                        class="flex items-center gap-3.5 px-4 py-3 hover:bg-slate-50 transition cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span
                                                class="font-bold text-slate-900 text-sm sm:text-base leading-tight block">Station
                                                Métro Namur</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Montreal Final Drop-off (~7:15
                                                PM EST)</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- 3. Travel Date Input -->
                            <div
                                class="rounded-2xl border border-slate-200/80 bg-white/90 hover:bg-white focus-within:bg-white focus-within:ring-2 focus-within:ring-[#22C55E] focus-within:border-transparent transition p-3.5 flex items-center gap-3 shadow-xs">
                                <div class="h-6 w-6 flex items-center justify-center flex-shrink-0 text-slate-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label for="travel_date" id="label-travel-date"
                                        class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 leading-none mb-1">
                                        Travel Date
                                    </label>
                                    <input id="travel_date" name="date" type="date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full bg-transparent text-sm sm:text-base font-bold text-slate-900 focus:outline-none cursor-pointer" />
                                </div>
                            </div>

                            <!-- 4. Fixed Departure Time (Corridor schedule) -->
                            <div
                                class="rounded-2xl border border-slate-200/80 bg-white/90 p-3.5 flex items-center justify-between shadow-xs">
                                <div class="flex items-center gap-3">
                                    <div class="h-6 w-6 flex items-center justify-center flex-shrink-0 text-[#22C55E]">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span
                                            class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 leading-none mb-1">
                                            Fixed Departure Time
                                        </span>
                                        <span id="hero-schedule-display"
                                            class="text-sm sm:text-base font-black text-slate-900 leading-snug">
                                            <span id="hero-schedule-text">6:30 AM Daily</span>
                                        </span>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-700 border border-slate-200/60">
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
                                        class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-slate-900 hover:bg-black text-white px-6 py-3.5 text-base font-bold shadow-md hover:shadow-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-slate-900 text-center">
                                        <span>Go to Dashboard</span>
                                        <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @else
                                    <button type="button" onclick="openAuthModal()"
                                        class="inline-flex min-h-[50px] w-full items-center justify-center gap-2 rounded-2xl bg-slate-900 hover:bg-black text-white px-6 py-3.5 text-base font-bold shadow-md hover:shadow-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-slate-900 text-center cursor-pointer">
                                        <span>Reserve Now</span>
                                        <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
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

    <!-- Anchor for Navigation Links -->
    <div id="services"></div>
    <div id="fleet"></div>

    <!-- Route Schedules Section -->
    <section id="schedule" class="py-20 lg:py-28 bg-surface-subtle border-b border-surface-border">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <x-section-heading eyebrow="Corridors &amp; Schedules" title="Fixed Daily Timetable &amp; Predefined Stations"
                subtitle="Travel between Montreal and Toronto with scheduled pickup and drop-off hubs located at major transit connections in each city." />

            <!-- Two Attractive Route Schedule Presentations -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                <!-- Route A Card -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 sm:p-10 shadow-xs">
                    <div class="flex items-center justify-between border-b border-surface-border pb-5">
                        <div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                                Route A • Morning Service
                            </span>
                            <h3 class="mt-2 text-2xl font-black text-content-primary sm:text-3xl">
                                Montreal → Toronto
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Departure
                                Time</span>
                            <span class="font-mono text-2xl font-black text-brand-green sm:text-3xl">6:30 AM</span>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-content-secondary leading-relaxed">
                        Daily morning departure from Montreal connecting directly to prime transit hubs in Toronto.
                    </p>

                    <!-- Station Timeline -->
                    <div
                        class="mt-8 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
                        <!-- Origin: Namur -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-green text-white text-xs font-bold ring-4 ring-white">
                                1
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">Origin
                                    Departure Hub • 6:30 AM</span>
                                <h4 class="text-base font-bold text-content-primary">Station Métro Namur</h4>
                                <p class="text-xs text-content-muted mt-0.5">Montreal, QC • Direct Orange Line subway access
                                </p>
                            </div>
                        </div>

                        <!-- Drop-off 1: Yorkdale -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                2
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">First
                                    Drop-off Station</span>
                                <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • TTC Subway Line 1 &amp; highway
                                    terminal</p>
                            </div>
                        </div>

                        <!-- Drop-off 2: Yonge Station -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                3
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Second
                                    Drop-off Station</span>
                                <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • TTC Line 1 &amp; Line 2 hub
                                    connection</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-8 pt-5 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
                        <span>Schedule: <strong>Daily, 7 days/week</strong></span>
                        <span>Timezone: <strong>America/Toronto (ET)</strong></span>
                    </div>
                </div>

                <!-- Route B Card -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 sm:p-10 shadow-xs">
                    <div class="flex items-center justify-between border-b border-surface-border pb-5">
                        <div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-charcoal px-3 py-1 text-xs font-bold uppercase tracking-wider text-white">
                                Route B • Afternoon Service
                            </span>
                            <h3 class="mt-2 text-2xl font-black text-content-primary sm:text-3xl">
                                Toronto → Montreal
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">First
                                Pickup</span>
                            <span class="font-mono text-2xl font-black text-content-primary sm:text-3xl">12:15 PM</span>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-content-secondary leading-relaxed">
                        Daily afternoon return trip from central Toronto pick-up points back to Montreal.
                    </p>

                    <!-- Station Timeline -->
                    <div
                        class="mt-8 space-y-6 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-surface-border">
                        <!-- Pickup 1: Yorkdale -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                                1
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">First Pickup
                                    Hub • 12:15 PM</span>
                                <h4 class="text-base font-bold text-content-primary">Yorkdale Mall</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • Designated passenger boarding
                                    location</p>
                            </div>
                        </div>

                        <!-- Pickup 2: Yonge Station -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-brand-charcoal text-white text-xs font-bold ring-4 ring-white">
                                2
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-green block">Second
                                    Pickup Hub • 1:15 PM</span>
                                <h4 class="text-base font-bold text-content-primary">Yonge Station</h4>
                                <p class="text-xs text-content-muted mt-0.5">Toronto, ON • Designated passenger boarding
                                    location</p>
                            </div>
                        </div>

                        <!-- Terminus: Montreal -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-surface-subtle text-content-primary text-xs font-bold border border-surface-border ring-4 ring-white">
                                3
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-content-muted block">Final
                                    Destination Terminus</span>
                                <h4 class="text-base font-bold text-content-primary">Montreal</h4>
                                <p class="text-xs text-content-muted mt-0.5">Estimated arrival ~7:15 PM ET (subject to
                                    highway traffic)</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-8 pt-5 border-t border-surface-border flex items-center justify-between text-xs text-content-muted">
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

            <x-section-heading eyebrow="Transparent Pricing" title="Simple Flat Rate. No Surprises."
                subtitle="One predictable fare per passenger per trip, regardless of which predefined stations you travel between. Settle with physical cash directly upon boarding." />

            <!-- Pricing Focus Container -->
            <div class="mx-auto max-w-4xl rounded-3xl border border-surface-border bg-surface-card p-8 sm:p-12 shadow-xs">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:items-center">

                    <!-- Left: Rate Summary (5 cols) -->
                    <div class="md:col-span-5 text-center md:text-left md:border-r md:border-surface-border md:pr-8">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-brand-green-subtle px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20">
                            Standard Fare
                        </span>

                        <div class="mt-4 flex items-baseline justify-center md:justify-start gap-1">
                            <span
                                class="font-mono text-5xl sm:text-6xl font-black tracking-tight text-content-primary">$65</span>
                            <span class="text-xl font-bold text-content-secondary">CAD</span>
                            <span class="text-xs text-content-muted">/ trip</span>
                        </div>

                        <p class="mt-3 text-sm text-content-secondary leading-relaxed">
                            Fixed rate per passenger per trip between Montreal and Toronto. No hidden ticketing fees, no
                            surge pricing, and no credit card needed to reserve.
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
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Personal Seat Choice:</strong> Visually choose your physical seat (S1 front
                                    passenger window, or S2–S6 rear cabin) when booking.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Commercial Minivan Fleet:</strong> Travel in our silver Honda Odyssey minivan
                                    (Ontario license plate RAJIA).</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Multi-Seat Reservations:</strong> Book 1 to 6 seats in a single reservation
                                    under one passenger account.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-5 w-5 flex-shrink-0 text-brand-green mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span><strong>Cash Payment Upon Boarding:</strong> Pay the driver directly in cash when boarding ($65 CAD flat fare). Confirm your booking online with zero upfront card payment.</span>
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

            <x-section-heading eyebrow="Service Standards" title="Why Travel with Oliver Transport"
                subtitle="Designed for passengers who appreciate scheduled consistency, individual seat selection, and straightforward cash settlement." />

            <!-- 4 Verified Core Service Pillars -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">

                <!-- Pillar 1 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Daily Fixed Schedule</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Operating 7 days a week, 365 days a year. Depart Montreal at 6:30 AM or return from Toronto at 12:15
                        PM and 1:15 PM.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Visual Seat Selection</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Hand-pick your exact physical seat (S1 front window or S2–S6 rear rows) on our cabin map. The system
                        never auto-assigns an alternate seat.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Transit Subway Hubs</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Predefined stations at Station Métro Namur (Orange Line, Montreal), Yorkdale Mall (Line 1), and
                        Yonge Station (Lines 1 &amp; 2) in Toronto.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="flex flex-col rounded-3xl border border-surface-border bg-white p-7 shadow-xs">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-green-subtle text-brand-green mb-5">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-content-primary">Cash Settlement at Boarding</h3>
                    <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                        Zero upfront electronic credit card transactions required to reserve. Settle your fare directly with
                        the driver in physical cash when boarding.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Guest Authentication Required Modal -->
    <div id="auth-booking-modal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-md hidden transition-opacity duration-200"
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
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-[#22C55E] mb-5 border border-emerald-100">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>

            <!-- Heading & Copy -->
            <div class="text-center">
                <h3 id="auth-modal-title" class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
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