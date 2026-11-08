<header class="sticky top-0 z-50 border-b border-surface-border bg-white/95 backdrop-blur-md shadow-xs">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
        <!-- Brand Logo Area -->
        <a href="{{ route('home') }}" class="group flex items-center min-h-[44px] min-w-[44px] py-1 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-green" aria-label="Oliver Transport Homepage">
            <x-brand-logo size="md" />
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-content-secondary" aria-label="Primary Navigation">
            <a href="#routes" class="hover:text-brand-green transition py-2 focus:outline-none focus:ring-2 focus:ring-brand-green rounded-md">
                Routes &amp; Schedule
            </a>
            <a href="#fares" class="hover:text-brand-green transition py-2 focus:outline-none focus:ring-2 focus:ring-brand-green rounded-md">
                Fares
            </a>
            <a href="#how-it-works" class="hover:text-brand-green transition py-2 focus:outline-none focus:ring-2 focus:ring-brand-green rounded-md">
                How It Works
            </a>
            <a href="#why-us" class="hover:text-brand-green transition py-2 focus:outline-none focus:ring-2 focus:ring-brand-green rounded-md">
                Why Oliver
            </a>
            <a href="#contact" class="hover:text-brand-green transition py-2 focus:outline-none focus:ring-2 focus:ring-brand-green rounded-md">
                Contact
            </a>
        </nav>

        <!-- Desktop Action Controls -->
        <div class="hidden md:flex items-center gap-3">
            <!-- Quick Call Support Pill -->
            <a href="tel:6476551884" 
               class="inline-flex min-h-[44px] items-center gap-2 rounded-xl border border-surface-border bg-surface-subtle px-3.5 py-2 text-xs font-bold text-content-primary hover:border-brand-green hover:text-brand-green transition focus:outline-none focus:ring-2 focus:ring-brand-green"
               title="Call or Text Customer Support">
                <svg class="h-3.5 w-3.5 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>647-655-1884</span>
            </a>

            @auth
                @php
                    $dashboardRoute = auth()->user()->isRider() 
                        ? route('rider.dashboard') 
                        : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.bookings.index'));
                    $dashboardLabel = auth()->user()->isRider() 
                        ? 'Driver Panel' 
                        : (auth()->user()->isOperator() ? 'Dashboard' : 'My Reservations');
                @endphp
                <a href="{{ $dashboardRoute }}" 
                   class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl bg-brand-charcoal px-4 py-2.5 text-sm font-bold text-white hover:bg-brand-charcoal-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                    {{ $dashboardLabel }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-surface-border bg-white px-3.5 py-2 text-sm font-semibold text-content-secondary hover:bg-surface-subtle hover:text-content-primary transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-surface-border bg-white px-4 py-2 text-sm font-semibold text-content-primary hover:bg-surface-subtle transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                    Sign In
                </a>
                <a href="{{ route('login') }}" 
                   class="inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-xl bg-brand-green px-5 py-2.5 text-sm font-bold text-white shadow-xs hover:bg-brand-green-hover transition focus:outline-none focus:ring-2 focus:ring-brand-green">
                    Book Your Seat
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Toggle Button (Min 44x44px touch target) -->
        <div class="flex md:hidden items-center gap-2">
            <a href="tel:6476551884" 
               class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-surface-border bg-surface-subtle text-brand-green hover:bg-slate-200 transition"
               aria-label="Call Customer Support">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </a>

            <button id="mobile-menu-toggle" 
                    type="button" 
                    class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-surface-border bg-surface-subtle text-content-primary hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green transition"
                    aria-expanded="false" 
                    aria-controls="mobile-menu"
                    aria-label="Toggle navigation menu">
                <svg id="menu-open-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="menu-close-icon" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-surface-border bg-white px-4 pt-3 pb-6 space-y-3 shadow-lg">
        <nav class="flex flex-col space-y-1 font-semibold text-content-secondary" aria-label="Mobile Navigation">
            <a href="#routes" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-lg hover:bg-surface-subtle hover:text-brand-green transition">
                Routes &amp; Schedule
            </a>
            <a href="#fares" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-lg hover:bg-surface-subtle hover:text-brand-green transition">
                Fares
            </a>
            <a href="#how-it-works" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-lg hover:bg-surface-subtle hover:text-brand-green transition">
                How It Works
            </a>
            <a href="#why-us" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-lg hover:bg-surface-subtle hover:text-brand-green transition">
                Why Oliver
            </a>
            <a href="#contact" class="mobile-nav-link flex items-center min-h-[44px] px-3 rounded-lg hover:bg-surface-subtle hover:text-brand-green transition">
                Contact
            </a>
        </nav>

        <div class="pt-4 border-t border-surface-border flex flex-col gap-2.5">
            @auth
                <a href="{{ $dashboardRoute }}" 
                   class="flex min-h-[48px] items-center justify-center rounded-xl bg-brand-charcoal px-4 py-3 text-base font-bold text-white hover:bg-brand-charcoal-hover transition">
                    {{ $dashboardLabel }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="flex w-full min-h-[44px] items-center justify-center rounded-xl border border-surface-border bg-surface-subtle px-4 py-2.5 text-sm font-semibold text-content-secondary hover:bg-slate-200 transition">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="flex min-h-[48px] items-center justify-center rounded-xl bg-brand-green px-5 py-3 text-base font-bold text-white shadow-xs hover:bg-brand-green-hover transition">
                    Book Your Seat
                </a>
                <a href="{{ route('login') }}" 
                   class="flex min-h-[44px] items-center justify-center rounded-xl border border-surface-border bg-surface-subtle px-4 py-2.5 text-sm font-semibold text-content-primary hover:bg-slate-200 transition">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');

        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                menu.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    menu.classList.add('hidden');
                    openIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                });
            });
        }
    });
</script>
