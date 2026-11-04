<!-- Dynamic Navigation Header: Transparent over dark hero initially, transforms to floating frosted pill on scroll -->
<style>
    /* Scrolled header styling for high contrast readability */
    #site-header.is-scrolled #user-profile-btn,
    #header-inner.header-scrolled #user-profile-btn,
    .is-scrolled #user-profile-btn,
    .header-scrolled #user-profile-btn {
        border-color: #CBD5E1 !important;
        background-color: #F1F5F9 !important;
        color: #0F172A !important;
    }
    #site-header.is-scrolled #user-profile-btn:hover,
    #header-inner.header-scrolled #user-profile-btn:hover,
    .is-scrolled #user-profile-btn:hover,
    .header-scrolled #user-profile-btn:hover {
        background-color: #E2E8F0 !important;
        border-color: #94A3B8 !important;
    }
    #site-header.is-scrolled #user-profile-name,
    #header-inner.header-scrolled #user-profile-name,
    .is-scrolled #user-profile-name,
    .header-scrolled #user-profile-name,
    #site-header.is-scrolled #user-profile-btn span#user-profile-name,
    #header-inner.header-scrolled #user-profile-btn span#user-profile-name,
    .is-scrolled #user-profile-btn span#user-profile-name,
    .header-scrolled #user-profile-btn span#user-profile-name {
        color: #0F172A !important;
    }
    #site-header.is-scrolled #user-profile-chevron,
    #header-inner.header-scrolled #user-profile-chevron,
    .is-scrolled #user-profile-chevron,
    .header-scrolled #user-profile-chevron {
        color: #334155 !important;
        stroke: #334155 !important;
    }
    #site-header.is-scrolled #header-signin-link,
    #header-inner.header-scrolled #header-signin-link,
    .is-scrolled #header-signin-link,
    .header-scrolled #header-signin-link {
        color: #0F172A !important;
    }
    #site-header.is-scrolled #header-signin-link:hover,
    #header-inner.header-scrolled #header-signin-link:hover,
    .is-scrolled #header-signin-link:hover,
    .header-scrolled #header-signin-link:hover {
        color: #16A34A !important;
    }
    #site-header.is-scrolled .header-nav-link,
    #header-inner.header-scrolled .header-nav-link,
    .is-scrolled .header-nav-link,
    .header-scrolled .header-nav-link {
        color: #334155 !important;
    }
    #site-header.is-scrolled .header-nav-link:hover,
    #header-inner.header-scrolled .header-nav-link:hover,
    .is-scrolled .header-nav-link:hover,
    .header-scrolled .header-nav-link:hover {
        color: #16A34A !important;
    }
    #site-header.is-scrolled #header-brand-logo .font-heading,
    #header-inner.header-scrolled #header-brand-logo .font-heading,
    .is-scrolled #header-brand-logo .font-heading,
    .header-scrolled #header-brand-logo .font-heading {
        color: #111827 !important;
    }
</style>
<header id="site-header" class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-4 sm:pt-6">
    <div id="header-inner" class="mx-auto max-w-7xl rounded-full bg-white/0 backdrop-blur-none border border-transparent shadow-none px-3 sm:px-4 py-2.5 flex items-center justify-between pointer-events-auto transition-all duration-300 ease-out">
        
        <!-- Brand Wordmark (Automotive Motion Logo) -->
        <a href="{{ route('home') }}" class="group flex items-center min-h-[44px] py-1 rounded-full focus:outline-none focus:ring-2 focus:ring-[#22C55E]" aria-label="Oliver Transport Homepage">
            <x-brand-logo size="sm" :inverted="true" id="header-brand-logo" />
        </a>

        <!-- Desktop Navigation Links: Home, Services, About, Contact -->
        <nav class="hidden md:flex items-center gap-7 lg:gap-9 text-sm font-semibold" aria-label="Primary Navigation">
            <a href="{{ route('home') }}" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Home
            </a>
            <a href="#services" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Services
            </a>
            <a href="{{ route('home') }}#promotions" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Promotions
            </a>
            <a href="{{ route('contact') }}" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Contact
            </a>
        </nav>

        <!-- Desktop Actions: Profile Dropdown or Sign In / Book Now -->
        <div class="hidden md:flex items-center gap-3">
            @auth
                @php
                    $dashboardRoute = auth()->user()->isRider() 
                        ? route('rider.dashboard') 
                        : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard'));
                @endphp

                <!-- Book Now CTA Button -->
                <button type="button" onclick="handleGlobalBookNow()" 
                   class="inline-flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] hover:bg-[#16A34A] px-5 py-2 text-xs sm:text-sm font-bold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                    Book Now
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" id="user-profile-menu-container">
                    <button type="button" id="user-profile-btn" onclick="toggleUserProfileDropdown()"
                        class="inline-flex min-h-[44px] items-center gap-2 rounded-full border border-white/20 bg-white/10 hover:bg-white/20 px-3 py-1.5 text-xs sm:text-sm font-bold text-white transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer select-none"
                        aria-expanded="false" aria-haspopup="true">
                        <!-- User Initial Avatar Circle -->
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#22C55E] text-white text-xs font-black shadow-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span id="user-profile-name" class="max-w-[100px] truncate hidden lg:inline-block font-semibold">
                            {{ auth()->user()->name }}
                        </span>
                        <!-- Chevron Icon -->
                        <svg class="h-4 w-4 text-slate-300 transition-transform duration-200" id="user-profile-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Card -->
                    <div id="user-profile-dropdown"
                        class="absolute right-0 mt-2 w-64 rounded-2xl bg-[#111827] border border-slate-700/80 shadow-2xl p-2 hidden z-50 text-white divide-y divide-slate-800">
                        
                        <!-- User Identity Header -->
                        <div class="px-3 py-2.5">
                            <div class="font-bold text-sm text-white truncate">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
                            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#22C55E]/15 text-[#22C55E] border border-[#22C55E]/30">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>

                        <!-- Navigation Items -->
                        <div class="py-1.5 space-y-0.5">
                            <a href="{{ $dashboardRoute }}" 
                               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#22C55E] transition">
                                <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            @if(auth()->user()->isPassenger())
                                <a href="{{ route('passenger.bookings.index') }}" 
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#22C55E] transition">
                                    <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>My Reservations</span>
                                </a>
                            @endif

                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-[#22C55E] transition">
                                <svg class="h-4 w-4 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profile Settings</span>
                            </a>
                        </div>

                        <!-- Sign Out Action -->
                        <div class="pt-1.5">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" 
                                    class="flex w-full items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-red-300 hover:bg-red-950/40 hover:text-red-200 transition cursor-pointer">
                                    <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @else
                <a id="header-signin-link" href="{{ route('login') }}" 
                   class="header-signin-link inline-flex min-h-[44px] items-center justify-center text-xs sm:text-sm font-semibold text-white/90 hover:text-[#22C55E] transition px-3 py-1">
                    Sign In
                </a>
                <button type="button" onclick="handleGlobalBookNow()" 
                   class="inline-flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] hover:bg-[#16A34A] px-5 py-2 text-xs sm:text-sm font-bold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                    Book Now
                </button>
            @endauth
        </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="flex md:hidden items-center gap-2">
            <button id="mobile-menu-toggle" 
                    type="button" 
                    class="inline-flex min-h-[40px] min-w-[40px] items-center justify-center rounded-full border border-white/20 bg-white/10 text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-[#22C55E] transition"
                    aria-expanded="false" 
                    aria-controls="mobile-menu"
                    aria-label="Toggle navigation menu">
                <svg id="menu-open-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="menu-close-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="hidden md:hidden mx-auto max-w-7xl mt-2 rounded-3xl border border-slate-200/90 bg-[#111827]/95 backdrop-blur-2xl p-5 space-y-3 shadow-2xl pointer-events-auto">
        <nav class="flex flex-col space-y-1 font-semibold text-white" aria-label="Mobile Navigation">
            <a href="{{ route('home') }}" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                Home
            </a>
            <a href="#services" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                Services
            </a>
            <a href="{{ route('home') }}#promotions" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                Promotions
            </a>
            <a href="{{ route('contact') }}" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                Contact
            </a>
        </nav>

        <div class="pt-4 border-t border-white/10 flex flex-col gap-2.5">
            @auth
                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-white/5 border border-white/10">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#22C55E] text-white text-xs font-black">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-bold text-white block truncate">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-[#22C55E] uppercase font-black block">{{ auth()->user()->role }}</span>
                    </div>
                </div>

                <button type="button" onclick="handleGlobalBookNow()"
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-4 py-2.5 text-sm font-bold text-white transition cursor-pointer">
                    Book Now
                </button>

                <a href="{{ $dashboardRoute }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white hover:bg-white/10 transition">
                    Dashboard
                </a>

                @if(auth()->user()->isPassenger())
                    <a href="{{ route('passenger.bookings.index') }}" 
                       class="flex min-h-[44px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white hover:bg-white/10 transition">
                        My Reservations
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white hover:bg-white/10 transition">
                    Profile Settings
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="flex w-full min-h-[40px] items-center justify-center rounded-full border border-red-500/30 bg-red-950/20 px-4 py-2 text-xs font-semibold text-red-300 hover:bg-red-950/40 transition cursor-pointer">
                        Sign Out
                    </button>
                </form>
            @else
                <button type="button" onclick="handleGlobalBookNow()" 
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition cursor-pointer">
                    Book Now
                </button>
                <a href="{{ route('login') }}" 
                   class="flex min-h-[40px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white/80 hover:bg-white/10 transition">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</header>
