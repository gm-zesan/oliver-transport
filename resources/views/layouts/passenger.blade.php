@extends('frontend.layout.app')

@section('content')
    <!-- Executive Passenger Hero Header Section with High-Visibility Highway Corridor Background & Airy Spacious Layout -->
    <section id="passenger-hero-section" class="relative overflow-hidden bg-slate-950 pt-28 sm:pt-36 lg:pt-40 pb-10 sm:pb-14 lg:pb-16 border-b border-slate-800 text-white select-none">
        
        <!-- Scenic Intercity Corridor Image Background (Clearly Visible & High Quality) -->
        <div class="absolute inset-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ asset('images/service-intercity.jpg') }}" 
                 alt="PickMeRoute Corridor" 
                 class="w-full h-full object-cover object-center scale-105 filter brightness-[0.70] contrast-[1.10] saturate-110" />
            <!-- Balanced Luminous Cinematic Gradients for Crisp Text Contrast -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/88 via-slate-950/65 to-slate-950/45"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-transparent to-black/30"></div>
        </div>

        <!-- Ambient Subtle Emerald Glow in Background -->
        <div class="absolute top-4 right-1/4 w-96 h-96 bg-[#22C55E]/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Top Hero Row: Clean, Spacious & Uncluttered Layout -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                
                <!-- Left: User Identity & Welcome Heading -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Prominent User Avatar Initial with Vivid Emerald Glow -->
                    <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-[#22C55E] to-[#16A34A] text-white flex items-center justify-center font-black text-xl sm:text-2xl shadow-lg shadow-[#22C55E]/30 flex-shrink-0 ring-4 ring-emerald-400/25">
                        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                    </div>

                    <div>
                        <!-- Dynamic Welcome Heading -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight font-heading text-white leading-tight drop-shadow-sm">
                            @hasSection('hero_title')
                                @yield('hero_title')
                            @else
                                {{ __('Welcome, :name', ['name' => auth()->user()->name ?? __('Passenger')]) }}
                            @endif
                        </h1>

                        @hasSection('hero_meta')
                            <div class="pt-1 text-xs sm:text-sm text-slate-300">
                                @yield('hero_meta')
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Action CTA / Booking Button -->
                <div class="flex-shrink-0">
                    @hasSection('hero_action')
                        @yield('hero_action')
                    @else
                        <button type="button" onclick="handleGlobalBookNow()" 
                           class="inline-flex min-h-[48px] sm:min-h-[52px] items-center justify-center gap-2.5 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 sm:px-7 py-3 sm:py-3.5 text-sm sm:text-base font-bold shadow-xl shadow-[#22C55E]/30 transition hover:scale-[1.02] cursor-pointer">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>{{ __('Book New Journey') }}</span>
                        </button>
                    @endif
                </div>
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
