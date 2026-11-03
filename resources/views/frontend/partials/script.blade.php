<!-- Interactive Frontend Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dynamic Header Scroll Transition (Normal at top, floating pill capsule on scroll)
        const siteHeader = document.getElementById('site-header');
        const headerInner = document.getElementById('header-inner');
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');
        let isScrolled = false;

        const updateHeaderStyles = (scrolled) => {
            if (!siteHeader || !headerInner) return;
            const isMenuOpen = menu && !menu.classList.contains('hidden');

            if (scrolled || isMenuOpen) {
                siteHeader.className = 'fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-2.5 sm:pt-3.5';
                headerInner.className = 'mx-auto max-w-7xl rounded-full transition-all duration-300 ease-out pointer-events-auto flex items-center justify-between py-2.5 px-4 sm:px-6 bg-white/95 backdrop-blur-xl border border-slate-200/80 shadow-lg shadow-slate-900/5';
            } else {
                siteHeader.className = 'fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-4 sm:pt-6';
                headerInner.className = 'mx-auto max-w-7xl rounded-full transition-all duration-300 ease-out pointer-events-auto flex items-center justify-between py-2.5 px-3 sm:px-4 bg-white/0 backdrop-blur-none border border-slate-200/0 shadow-none';
            }
        };

        const onScroll = () => {
            const shouldScroll = window.scrollY > 20;
            if (shouldScroll !== isScrolled) {
                isScrolled = shouldScroll;
                updateHeaderStyles(isScrolled);
            }
        };

        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // Mobile Navigation Toggle
        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                menu.classList.toggle('hidden');
                if (openIcon) openIcon.classList.toggle('hidden');
                if (closeIcon) closeIcon.classList.toggle('hidden');
                updateHeaderStyles(isScrolled);
            });

            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    menu.classList.add('hidden');
                    if (openIcon) openIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    updateHeaderStyles(isScrolled);
                });
            });
        }

        // Close Dropdowns on Click Outside
        document.addEventListener('click', function (e) {
            const pickupWrapper = document.getElementById('pickup-field-wrapper');
            const destWrapper = document.getElementById('dest-field-wrapper');
            const pickupMenu = document.getElementById('pickup-dropdown-menu');
            const destMenu = document.getElementById('dest-dropdown-menu');

            if (pickupWrapper && !pickupWrapper.contains(e.target)) {
                if (pickupMenu) pickupMenu.classList.add('hidden');
            }

            if (destWrapper && !destWrapper.contains(e.target)) {
                if (destMenu) destMenu.classList.add('hidden');
            }
        });

        // Close Modal with Escape Key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAuthModal();
                closeAllDropdowns();
            }
        });
    });

    // Uber-Style Custom Dropdown Controls
    function togglePickupDropdown() {
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        const destMenu = document.getElementById('dest-dropdown-menu');
        if (destMenu) destMenu.classList.add('hidden');
        if (pickupMenu) pickupMenu.classList.toggle('hidden');
    }

    function toggleDestDropdown() {
        const destMenu = document.getElementById('dest-dropdown-menu');
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        if (pickupMenu) pickupMenu.classList.add('hidden');
        if (destMenu) destMenu.classList.toggle('hidden');
    }

    function closeAllDropdowns() {
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        const destMenu = document.getElementById('dest-dropdown-menu');
        if (pickupMenu) pickupMenu.classList.add('hidden');
        if (destMenu) destMenu.classList.add('hidden');
    }

    function selectPickup(val, displayText, route) {
        const input = document.getElementById('pickup_location');
        const textDisplay = document.getElementById('pickup-display-text');
        const destInput = document.getElementById('destination_location');
        const destText = document.getElementById('dest-display-text');
        const scheduleText = document.getElementById('hero-schedule-text');

        if (input) input.value = val;
        if (textDisplay) textDisplay.textContent = displayText;

        closeAllDropdowns();

        if (route === 'route-a' || val === 'namur') {
            setRouteTabStyles('route-a');
            if (destInput) destInput.value = 'toronto';
            if (destText) destText.textContent = 'Yorkdale Mall & Yonge Station (Toronto)';
            if (scheduleText) scheduleText.textContent = '6:30 AM Daily';
        } else {
            setRouteTabStyles('route-b');
            if (destInput) destInput.value = 'montreal';
            if (destText) destText.textContent = 'Station Métro Namur (Montreal)';
            if (scheduleText) scheduleText.textContent = '12:15 PM & 1:15 PM Daily';
        }
    }

    function selectDestination(val, displayText, route) {
        const input = document.getElementById('destination_location');
        const textDisplay = document.getElementById('dest-display-text');
        const pickupInput = document.getElementById('pickup_location');
        const pickupText = document.getElementById('pickup-display-text');
        const scheduleText = document.getElementById('hero-schedule-text');

        if (input) input.value = val;
        if (textDisplay) textDisplay.textContent = displayText;

        closeAllDropdowns();

        if (route === 'route-a' || val === 'toronto') {
            setRouteTabStyles('route-a');
            if (pickupInput && pickupInput.value !== 'namur') {
                pickupInput.value = 'namur';
                if (pickupText) pickupText.textContent = 'Station Métro Namur (Montreal)';
            }
            if (scheduleText) scheduleText.textContent = '6:30 AM Daily';
        } else {
            setRouteTabStyles('route-b');
            if (pickupInput && pickupInput.value === 'namur') {
                pickupInput.value = 'yorkdale';
                if (pickupText) pickupText.textContent = 'Yorkdale Mall (Toronto)';
            }
            if (scheduleText) scheduleText.textContent = '12:15 PM & 1:15 PM Daily';
        }
    }

    // Direction Switcher in Hero section (Route Tabs)
    function switchHeroRoute(route) {
        setRouteTabStyles(route);
        closeAllDropdowns();

        const pickupInput = document.getElementById('pickup_location');
        const pickupText = document.getElementById('pickup-display-text');
        const destInput = document.getElementById('destination_location');
        const destText = document.getElementById('dest-display-text');
        const scheduleText = document.getElementById('hero-schedule-text');

        if (route === 'route-a') {
            if (pickupInput) pickupInput.value = 'namur';
            if (pickupText) pickupText.textContent = 'Station Métro Namur (Montreal)';
            if (destInput) destInput.value = 'toronto';
            if (destText) destText.textContent = 'Yorkdale Mall & Yonge Station (Toronto)';
            if (scheduleText) scheduleText.textContent = '6:30 AM Daily';
        } else {
            if (pickupInput) pickupInput.value = 'yorkdale';
            if (pickupText) pickupText.textContent = 'Yorkdale Mall (Toronto)';
            if (destInput) destInput.value = 'montreal';
            if (destText) destText.textContent = 'Station Métro Namur (Montreal)';
            if (scheduleText) scheduleText.textContent = '12:15 PM & 1:15 PM Daily';
        }
    }

    function setRouteTabStyles(route) {
        const btnA = document.getElementById('tab-btn-route-a');
        const btnB = document.getElementById('tab-btn-route-b');
        if (!btnA || !btnB) return;

        if (route === 'route-a') {
            btnA.className = 'route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#22C55E] text-white shadow-xs cursor-pointer text-center';
            btnA.setAttribute('aria-selected', 'true');

            btnB.className = 'route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-700 hover:text-slate-900 bg-white/80 hover:bg-white border border-slate-200/60 cursor-pointer text-center';
            btnB.setAttribute('aria-selected', 'false');
        } else {
            btnB.className = 'route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#22C55E] text-white shadow-xs cursor-pointer text-center';
            btnB.setAttribute('aria-selected', 'true');

            btnA.className = 'route-tab-btn flex-1 py-2.5 px-3.5 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-700 hover:text-slate-900 bg-white/80 hover:bg-white border border-slate-200/60 cursor-pointer text-center';
            btnA.setAttribute('aria-selected', 'false');
        }
    }

    // Modal Control Functions
    function openAuthModal() {
        const modal = document.getElementById('auth-booking-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeAuthModal() {
        const modal = document.getElementById('auth-booking-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
</script>

@stack('scripts')
