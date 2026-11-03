<!-- Dynamic Navigation Header: Transparent over dark hero initially, transforms to floating frosted pill on scroll -->
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
            <a href="{{ route('home') }}#about" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                About
            </a>
            <a href="{{ route('contact') }}" class="header-nav-link text-white/90 hover:text-[#22C55E] transition py-1 focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-md">
                Contact
            </a>
        </nav>

        <!-- Desktop Actions: Sign In / Book Now (or Dashboard / Sign Out) -->
        <div class="hidden md:flex items-center gap-3">
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
                            class="header-signin-link inline-flex min-h-[38px] items-center justify-center text-xs font-semibold text-white/80 hover:text-white transition px-2 py-1">
                        Sign Out
                    </button>
                </form>
            @else
                <a id="header-signin-link" href="{{ route('login') }}" 
                   class="header-signin-link inline-flex min-h-[38px] items-center justify-center text-xs sm:text-sm font-semibold text-white/90 hover:text-[#22C55E] transition px-2.5 py-1">
                    Sign In
                </a>
                <a href="{{ route('login') }}" 
                   class="inline-flex min-h-[38px] items-center justify-center rounded-full bg-[#22C55E] hover:bg-[#16A34A] px-5 py-2 text-xs sm:text-sm font-bold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#22C55E]">
                    Book Now
                </a>
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
            <a href="{{ route('home') }}#about" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                About
            </a>
            <a href="{{ route('contact') }}" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-xl hover:bg-white/10 hover:text-[#22C55E] transition">
                Contact
            </a>
        </nav>

        <div class="pt-4 border-t border-white/10 flex flex-col gap-2.5">
            @auth
                <a href="{{ $dashboardRoute }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-4 py-2.5 text-sm font-bold text-white transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="flex w-full min-h-[40px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white/80 hover:bg-white/10 transition">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-full bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition">
                    Book Now
                </a>
                <a href="{{ route('login') }}" 
                   class="flex min-h-[40px] items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs font-semibold text-white/80 hover:bg-white/10 transition">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</header>
