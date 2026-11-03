<!-- Dynamic Navigation Header: Normal & hero-aligned initially, transforms to floating pill capsule on scroll -->
<header id="site-header" class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-4 sm:pt-6">
    <div id="header-inner" class="mx-auto max-w-7xl rounded-full bg-white/0 backdrop-blur-none border border-slate-200/0 shadow-none px-3 sm:px-4 py-2.5 flex items-center justify-between pointer-events-auto transition-all duration-300 ease-out">
        
        <!-- Brand Wordmark (Vertical Logo) -->
        <a href="{{ route('home') }}" class="group flex items-center min-h-[44px] py-1 rounded-full focus:outline-none focus:ring-2 focus:ring-[#22C55E]" aria-label="Oliver Transport Homepage">
            <x-brand-logo size="sm" :inverted="false" />
        </a>

        <!-- Desktop Navigation Links: Home, Services, Fleet, FAQ, Contact -->
        <nav class="hidden md:flex items-center gap-7 lg:gap-9 text-sm font-semibold text-slate-700" aria-label="Primary Navigation">
            <a href="{{ route('home') }}" class="hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Home
            </a>
            <a href="#services" class="hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Services
            </a>
            <a href="#fleet" class="hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Fleet
            </a>
            <a href="#faq" class="hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                FAQ
            </a>
            <a href="#contact" class="hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Contact
            </a>
        </nav>

        <!-- Desktop Actions: Search Pill, Sign In / Book Now & Black Profile Icon -->
        <div class="hidden md:flex items-center gap-3">
            <!-- Search Pill Capsule (Reference Style) -->
            <div class="relative hidden lg:flex items-center">
                <svg class="h-3.5 w-3.5 absolute left-3 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" 
                       placeholder="Search..." 
                       class="rounded-full bg-slate-50 border border-slate-200/80 pl-8 pr-3.5 py-1.5 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#22C55E] w-28 focus:w-40 transition-all" />
            </div>

            @auth
                @php
                    $dashboardRoute = auth()->user()->isRider() 
                        ? route('rider.dashboard') 
                        : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard'));
                @endphp
                <a href="{{ $dashboardRoute }}" 
                   class="inline-flex min-h-[38px] items-center justify-center rounded-full bg-[#22C55E] hover:bg-[#16A34A] px-4 py-2 text-xs font-bold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex min-h-[38px] items-center justify-center text-xs font-semibold text-slate-600 hover:text-slate-900 transition px-2 py-1">
                        Sign Out
                    </button>
                </form>
                <a href="{{ $dashboardRoute }}" 
                   class="h-9 w-9 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-black transition shadow-xs" 
                   aria-label="Account Profile">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex min-h-[38px] items-center justify-center text-xs sm:text-sm font-semibold text-slate-700 hover:text-[#22C55E] transition px-2.5 py-1">
                    Sign In
                </a>
                <a href="{{ route('login') }}" 
                   class="inline-flex min-h-[38px] items-center justify-center rounded-full bg-[#22C55E] hover:bg-[#16A34A] px-4 py-2 text-xs sm:text-sm font-bold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]">
                    Book Now
                </a>
                <a href="{{ route('login') }}" 
                   class="h-9 w-9 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-black transition shadow-xs" 
                   aria-label="Account Login">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="flex md:hidden items-center gap-2">
            <button id="mobile-menu-toggle" 
                    type="button" 
                    class="inline-flex min-h-[40px] min-w-[40px] items-center justify-center rounded-full border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#22C55E] transition"
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
    <div id="mobile-menu" class="hidden md:hidden mx-auto max-w-7xl mt-2 rounded-3xl border border-slate-200 bg-white/95 backdrop-blur-xl p-5 space-y-3 shadow-xl pointer-events-auto">
        <nav class="flex flex-col space-y-1 font-semibold text-slate-800" aria-label="Mobile Navigation">
            <a href="{{ route('home') }}" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-slate-100 hover:text-[#22C55E] transition">
                Home
            </a>
            <a href="#services" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-slate-100 hover:text-[#22C55E] transition">
                Services
            </a>
            <a href="#fleet" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-slate-100 hover:text-[#22C55E] transition">
                Fleet
            </a>
            <a href="#faq" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-slate-100 hover:text-[#22C55E] transition">
                FAQ
            </a>
            <a href="#contact" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-slate-100 hover:text-[#22C55E] transition">
                Contact
            </a>
        </nav>

        <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5">
            @auth
                <a href="{{ $dashboardRoute }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-4 py-2.5 text-sm font-bold text-white transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="flex w-full min-h-[40px] items-center justify-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition">
                    Book Now
                </a>
                <a href="{{ route('login') }}" 
                   class="flex min-h-[40px] items-center justify-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</header>
