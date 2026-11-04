@extends('frontend.layout.app')

@section('content')
    <!-- Executive Passenger Hero Header Section with High-Visibility Highway Corridor Background & Balanced Overlay -->
    <section id="passenger-hero-section" class="relative overflow-hidden bg-slate-950 pt-32 sm:pt-36 lg:pt-40 pb-8 sm:pb-10 lg:pb-12 border-b border-slate-800 text-white select-none">
        
        <!-- Scenic Intercity Corridor Image Background (Clearly Visible & High Quality) -->
        <div class="absolute inset-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ asset('images/service-intercity.jpg') }}" 
                 alt="Oliver Transport Corridor" 
                 class="w-full h-full object-cover object-center scale-105 filter brightness-[0.72] contrast-[1.08] saturate-110" />
            <!-- Balanced Luminous Cinematic Gradients for Crisp Text Contrast without Darkening the Scenery -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/82 via-slate-950/55 to-slate-950/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/20"></div>
        </div>

        <!-- Ambient Subtle Emerald Glow in Background -->
        <div class="absolute top-4 right-1/4 w-96 h-96 bg-[#22C55E]/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Top Hero Row: Generous Breathing Room and Spacing -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 pb-8">
                
                <!-- Left: User Identity & Page Heading with Spacious Layout -->
                <div class="flex items-start sm:items-center gap-5 sm:gap-6">
                    <!-- Prominent User Avatar Initial with Vivid Emerald Glow -->
                    <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-3xl bg-gradient-to-br from-[#22C55E] to-[#16A34A] text-white flex items-center justify-center font-black text-2xl sm:text-3xl shadow-xl shadow-[#22C55E]/30 flex-shrink-0 ring-4 ring-emerald-400/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                    </div>

                    <div class="space-y-1.5">
                        <!-- Role & Corridor Badges -->
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500/25 text-emerald-300 border border-emerald-400/30 backdrop-blur-md">
                                <span class="h-2 w-2 rounded-full bg-[#22C55E] animate-pulse"></span>
                                <span>{{ (auth()->check() && auth()->user()->isRider()) ? 'Driver Panel' : 'Passenger Portal' }}</span>
                            </span>
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline">•</span>
                            <span class="text-xs font-semibold text-slate-200 hidden sm:inline drop-shadow-xs">Montreal ↔ Toronto Express Corridor</span>
                        </div>

                        <!-- Dynamic Page Title with Executive Typography -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tight font-heading text-white leading-tight drop-shadow-sm">
                            @hasSection('hero_title')
                                @yield('hero_title')
                            @else
                                Welcome back, {{ auth()->user()->name ?? 'Passenger' }}
                            @endif
                        </h1>

                        <!-- Dynamic Subtitle / Metadata Chips with Generous Spacing -->
                        <div class="pt-1.5 flex flex-wrap items-center gap-2.5 text-xs sm:text-sm text-slate-200">
                            @hasSection('hero_meta')
                                @yield('hero_meta')
                            @else
                                <span class="inline-flex items-center gap-2 bg-white/15 text-slate-100 border border-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-xl font-medium shadow-xs">
                                    <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ auth()->user()->email ?? '' }}</span>
                                </span>
                                @if(auth()->check() && auth()->user()->phone)
                                    <span class="inline-flex items-center gap-2 bg-white/15 text-slate-100 border border-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-xl font-medium shadow-xs">
                                        <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ auth()->user()->phone }}</span>
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Action CTA Buttons with Prominent Touch Targets -->
                <div class="flex-shrink-0">
                    @hasSection('hero_action')
                        @yield('hero_action')
                    @else
                        <button type="button" onclick="handleGlobalBookNow()" 
                           class="inline-flex min-h-[52px] items-center justify-center gap-2.5 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-7 py-3.5 text-sm sm:text-base font-bold shadow-xl shadow-[#22C55E]/30 transition hover:scale-[1.02] cursor-pointer">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Book New Journey</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Integrated Navigation Tab Strip with Spacious Frosted Pill Styling -->
            <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-white/20 flex items-center gap-2.5 sm:gap-3 overflow-x-auto select-none no-scrollbar">
                @if(auth()->check() && auth()->user()->isPassenger())
                    <!-- Overview Tab -->
                    <a href="{{ route('passenger.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition {{ request()->routeIs('passenger.dashboard') ? 'bg-[#22C55E] text-slate-950 font-black shadow-md' : 'bg-white/10 text-white hover:bg-white/20 border border-white/15 backdrop-blur-md' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Overview</span>
                    </a>

                    <!-- My Reservations Tab -->
                    <a href="{{ route('passenger.bookings.index') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition {{ request()->routeIs('passenger.bookings.*') ? 'bg-[#22C55E] text-slate-950 font-black shadow-md' : 'bg-white/10 text-white hover:bg-white/20 border border-white/15 backdrop-blur-md' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <span>My Reservations</span>
                        @if(isset($totalBookingsCount) && $totalBookingsCount > 0)
                            <span class="ml-1 px-2.5 py-0.5 rounded-full text-[11px] font-black {{ request()->routeIs('passenger.bookings.*') ? 'bg-slate-950 text-white' : 'bg-white/20 text-white' }}">
                                {{ $totalBookingsCount }}
                            </span>
                        @endif
                    </a>
                @elseif(auth()->check() && auth()->user()->isRider())
                    <!-- Driver Manifest Tab -->
                    <a href="{{ route('rider.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition {{ request()->routeIs('rider.dashboard') ? 'bg-[#22C55E] text-slate-950 font-black shadow-md' : 'bg-white/10 text-white hover:bg-white/20 border border-white/15 backdrop-blur-md' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Driver Operational Panel</span>
                    </a>
                @endif

                <!-- Profile Settings Tab (Unified for Passenger & Rider) -->
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition {{ request()->routeIs('profile.edit') ? 'bg-[#22C55E] text-slate-950 font-black shadow-md' : 'bg-white/10 text-white hover:bg-white/20 border border-white/15 backdrop-blur-md' }}">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile Settings</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Main Passenger Content Area: Crisp Light Theme Background with Responsive Margin & Padding -->
    <div class="bg-[#F8FAFC] py-10 sm:py-14 min-h-[60vh]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @yield('passenger_content')
            {{ $slot ?? '' }}
        </div>
    </div>
@endsection
