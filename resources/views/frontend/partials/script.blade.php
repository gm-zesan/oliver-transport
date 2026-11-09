<!-- Interactive Frontend Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dynamic Header Scroll Transition (Transparent over dark hero at top, floating frosted pill on scroll)
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
            const navLinks = document.querySelectorAll('.header-nav-link');
            const signinLink = document.getElementById('header-signin-link');
            const userProfileBtn = document.getElementById('user-profile-btn');
            const userProfileName = document.getElementById('user-profile-name');
            const userProfileChevron = document.getElementById('user-profile-chevron');
            const brandTitle = document.querySelector('#header-brand-logo .font-heading') || document.querySelector('#header-inner .font-heading');

            if (scrolled || isMenuOpen) {
                siteHeader.className = 'fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-2.5 sm:pt-3.5 is-scrolled';
                headerInner.className = 'mx-auto max-w-7xl rounded-full transition-all duration-300 ease-out pointer-events-auto flex items-center justify-between py-2.5 px-4 sm:px-6 bg-white/95 backdrop-blur-xl border border-slate-200/80 shadow-lg shadow-slate-900/5 header-scrolled';

                navLinks.forEach(link => {
                    link.classList.remove('text-white/90');
                    link.classList.add('text-slate-700');
                });
                if (brandTitle) {
                    brandTitle.classList.remove('text-white');
                    brandTitle.classList.add('text-[#111827]');
                }
                if (signinLink) {
                    signinLink.classList.remove('text-white/80', 'text-white/90', 'text-white');
                    signinLink.classList.add('text-slate-700');
                    signinLink.style.color = '#0F172A';
                }
                if (userProfileBtn) {
                    userProfileBtn.classList.remove('border-white/20', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                    userProfileBtn.classList.add('border-slate-300', 'bg-slate-100', 'hover:bg-slate-200', 'text-slate-900');
                    userProfileBtn.style.color = '#0F172A';
                    userProfileBtn.style.backgroundColor = '#F1F5F9';
                    userProfileBtn.style.borderColor = '#CBD5E1';
                }
                if (userProfileName) {
                    userProfileName.classList.remove('text-white');
                    userProfileName.classList.add('text-slate-900');
                    userProfileName.style.color = '#0F172A';
                }
                if (userProfileChevron) {
                    userProfileChevron.classList.remove('text-slate-300');
                    userProfileChevron.classList.add('text-slate-700');
                    userProfileChevron.style.color = '#334155';
                    userProfileChevron.style.stroke = '#334155';
                }
                if (toggleBtn) {
                    toggleBtn.className = 'inline-flex min-h-[40px] min-w-[40px] items-center justify-center rounded-full border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#22C55E] transition';
                }
            } else {
                siteHeader.className = 'fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300 ease-out pt-4 sm:pt-6';
                headerInner.className = 'mx-auto max-w-7xl rounded-full transition-all duration-300 ease-out pointer-events-auto flex items-center justify-between py-2.5 px-3 sm:px-4 bg-white/0 backdrop-blur-none border border-transparent shadow-none';

                navLinks.forEach(link => {
                    link.classList.remove('text-slate-700');
                    link.classList.add('text-white/90');
                    link.style.color = '';
                });
                if (brandTitle) {
                    brandTitle.classList.remove('text-[#111827]');
                    brandTitle.classList.add('text-white');
                }
                if (signinLink) {
                    signinLink.classList.remove('text-slate-700', 'text-slate-900');
                    signinLink.classList.add('text-white/80');
                    signinLink.style.color = '';
                }
                if (userProfileBtn) {
                    userProfileBtn.classList.remove('border-slate-300', 'bg-slate-100', 'hover:bg-slate-200', 'text-slate-900');
                    userProfileBtn.classList.add('border-white/20', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                    userProfileBtn.style.color = '';
                    userProfileBtn.style.backgroundColor = '';
                    userProfileBtn.style.borderColor = '';
                }
                if (userProfileName) {
                    userProfileName.classList.remove('text-slate-900');
                    userProfileName.classList.add('text-white');
                    userProfileName.style.color = '';
                }
                if (userProfileChevron) {
                    userProfileChevron.classList.remove('text-slate-600', 'text-slate-700');
                    userProfileChevron.classList.add('text-slate-300');
                    userProfileChevron.style.color = '';
                    userProfileChevron.style.stroke = '';
                }
                if (toggleBtn) {
                    toggleBtn.className = 'inline-flex min-h-[40px] min-w-[40px] items-center justify-center rounded-full border border-white/20 bg-white/10 text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-[#22C55E] transition';
                }
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
        updateHeaderStyles(window.scrollY > 20);

        // Mobile-Only Scroll Assist to Booking Panel
        // When on a mobile viewport (<1024px), a slight initial scroll/swipe downward smoothly brings #booking-panel into view.
        // Once snapped, normal scrolling is 100% free and uninterrupted for the rest of the page.
        const bookingPanelEl = document.getElementById('booking-panel');
        const mobileQuickJumpBtn = document.getElementById('mobile-quick-jump-btn');

        if (bookingPanelEl) {
            let hasSnappedToBooking = window.scrollY > 150;
            let isAutoScrolling = false;
            let touchStartY = 0;

            const smoothScrollToBooking = () => {
                if (isAutoScrolling) return;
                hasSnappedToBooking = true;
                isAutoScrolling = true;

                const headerOffset = 76;
                const panelTop = bookingPanelEl.getBoundingClientRect().top + window.pageYOffset;
                const targetY = Math.max(0, panelTop - headerOffset);

                window.scrollTo({
                    top: targetY,
                    behavior: 'smooth'
                });

                setTimeout(() => {
                    isAutoScrolling = false;
                }, 750);
            };

            // Touch start detection on mobile screens
            window.addEventListener('touchstart', (e) => {
                if (window.innerWidth >= 1024) return;
                if (e.touches && e.touches.length === 1) {
                    touchStartY = e.touches[0].clientY;
                }
            }, { passive: true });

            // Touch move detection: slight downward drag from top hero area triggers smooth snap
            window.addEventListener('touchmove', (e) => {
                if (window.innerWidth >= 1024) return;
                if (hasSnappedToBooking || isAutoScrolling) return;
                if (window.location.hash && window.location.hash !== '#booking-panel') return;

                if (e.touches && e.touches.length === 1) {
                    const currentTouchY = e.touches[0].clientY;
                    const diffY = touchStartY - currentTouchY; // positive = dragging upward = scrolling downward

                    if (window.scrollY < 60 && diffY > 20) {
                        smoothScrollToBooking();
                    }
                }
            }, { passive: true });

            // Scroll listener for trackpad, wheel, or browser fling
            window.addEventListener('scroll', () => {
                if (window.innerWidth >= 1024) return;

                const currentY = window.scrollY;

                // Reset assist if user scrolls back to the very top
                if (currentY <= 15) {
                    hasSnappedToBooking = false;
                    return;
                }

                if (window.location.hash && window.location.hash !== '#booking-panel') return;

                // Trigger smooth snap when user begins scrolling down from top
                if (!hasSnappedToBooking && !isAutoScrolling && currentY > 25 && currentY < 220) {
                    smoothScrollToBooking();
                }
            }, { passive: true });

            // Direct tap on mobile quick jump button
            if (mobileQuickJumpBtn) {
                mobileQuickJumpBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    smoothScrollToBooking();
                });
            }
        }

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
            const profileContainer = document.getElementById('user-profile-menu-container');
            const profileDropdown = document.getElementById('user-profile-dropdown');

            if (pickupWrapper && !pickupWrapper.contains(e.target)) {
                if (pickupMenu) pickupMenu.classList.add('hidden');
            }

            if (destWrapper && !destWrapper.contains(e.target)) {
                if (destMenu) destMenu.classList.add('hidden');
            }

            if (profileContainer && !profileContainer.contains(e.target)) {
                if (profileDropdown) profileDropdown.classList.add('hidden');
            }
        });

        // Close Modal & Dropdowns with Escape Key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAuthModal();
                closeSeatPickerModal();
                closeAllDropdowns();
                const profileDropdown = document.getElementById('user-profile-dropdown');
                if (profileDropdown) profileDropdown.classList.add('hidden');
            }
        });

        // Restore pending booking state if user just logged in (Deferred Auth Flow)
        const pendingRaw = sessionStorage.getItem('pickme_pending_booking') || sessionStorage.getItem('oliver_pending_booking');
        if (pendingRaw) {
            @auth
                @if(auth()->user()->isPassenger())
                    try {
                        const pending = JSON.parse(pendingRaw);
                        if (pending && pending.seats && pending.seats.length > 0) {
                            currentModalPickup = pending.pickup || 'namur';
                            currentModalDropoff = pending.dropoff || 'yorkdale';
                            currentModalDirection = pending.direction || 'MTL_TO_TOR';
                            selectedSeatNumbers = pending.seats;

                            openSeatPickerModal(null, pending.coupon_code);

                            const datePicker = document.getElementById('modal-date-picker');
                            if (datePicker && pending.date) {
                                datePicker.value = pending.date;
                            }

                            // Jump directly to Step 3 Review & Confirm
                            setTimeout(() => {
                                goToWizardStep(3);
                            }, 600);
                        }
                    } catch (e) {
                        console.error('Error restoring pending booking', e);
                    }
                @endif
            @endauth
        }
    });

    // Profile Dropdown Toggle
    function toggleUserProfileDropdown() {
        const dropdown = document.getElementById('user-profile-dropdown');
        const chevron = document.getElementById('user-profile-chevron');
        if (!dropdown) return;

        dropdown.classList.toggle('hidden');
        if (chevron) {
            chevron.classList.toggle('rotate-180');
        }
    }

    // Role Restriction Modal controls
    function openRoleRestrictionModal() {
        const modal = document.getElementById('role-restriction-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeRoleRestrictionModal() {
        const modal = document.getElementById('role-restriction-modal');
        if (modal) modal.classList.add('hidden');
    }

    // Global Booking Trigger: opens login modal for guests, booking modal for passengers, or role restriction modal for drivers
    function handleGlobalBookNow(preferredRoute = null, promoCode = null) {
        @auth
            @if(auth()->user()->isPassenger())
                openSeatPickerModal(preferredRoute, promoCode);
            @else
                openRoleRestrictionModal();
            @endif
        @else
            openAuthModal();
        @endauth
    }

    // Quick open seat picker with promo code
    function openSeatPickerWithCoupon(promoCode) {
        handleGlobalBookNow(null, promoCode);
    }

    // Copy Promo Code to Clipboard with Feedback
    function copyPromoCode(code, btnId) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(code).then(() => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span>Copied! ✓</span>';
                    btn.classList.add('bg-[#16A34A]');
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('bg-[#16A34A]');
                    }, 2000);
                }
            });
        }
    }

    // Uber-Style Custom Dropdown Controls for Homepage Hero
    function togglePickupDropdown() {
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        const destMenu = document.getElementById('dest-dropdown-menu');
        if (destMenu) destMenu.classList.add('hidden');
        if (pickupMenu) pickupMenu.classList.toggle('hidden');
    }

    function toggleDestDropdown() {
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        const destMenu = document.getElementById('dest-dropdown-menu');
        if (pickupMenu) pickupMenu.classList.add('hidden');
        if (destMenu) destMenu.classList.toggle('hidden');
    }

    function closeAllDropdowns() {
        const pickupMenu = document.getElementById('pickup-dropdown-menu');
        const destMenu = document.getElementById('dest-dropdown-menu');
        if (pickupMenu) pickupMenu.classList.add('hidden');
        if (destMenu) destMenu.classList.add('hidden');
    }

    // -------------------------------------------------------------
    // Oliver Transport Corridor Stations & Fixed Timetable Mapping
    // (Loaded dynamically from database configuration or fallback)
    // -------------------------------------------------------------
    const DEFAULT_CORRIDOR_STATIONS = {
        namur: {
            code: 'namur',
            name: 'Station Métro Namur',
            city: 'Montreal',
            departTime: '6:30 AM',
            arrivalTime: '~7:15 PM',
            label: 'Station Métro Namur (Montreal)',
        },
        yorkdale: {
            code: 'yorkdale',
            name: 'Yorkdale Mall',
            city: 'Toronto',
            departTime: '12:15 PM',
            arrivalTime: '~12:15 PM',
            label: 'Yorkdale Mall (Toronto)',
        },
        yonge: {
            code: 'yonge',
            name: 'Yonge Station',
            city: 'Toronto',
            departTime: '1:15 PM',
            arrivalTime: '~1:15 PM',
            label: 'Yonge Station (Toronto)',
        }
    };
    const appConfig = window.PICKME_CONFIG || window.OLIVER_CONFIG;
    const CORRIDOR_STATIONS = (appConfig && appConfig.stations) ? appConfig.stations : DEFAULT_CORRIDOR_STATIONS;

    function getValidDropoffs(pickupCode) {
        if (pickupCode === 'namur') {
            return [
                { code: 'yorkdale', name: 'Yorkdale Mall (Toronto)', time: '~12:15 PM', label: 'Yorkdale Mall • 1st Drop-off (~12:15 PM)' },
                { code: 'yonge', name: 'Yonge Station (Toronto)', time: '~1:15 PM', label: 'Yonge Station • 2nd Drop-off (~1:15 PM)' }
            ];
        } else if (pickupCode === 'yorkdale') {
            return [
                { code: 'namur', name: 'Station Métro Namur (Montreal)', time: '~7:15 PM', label: 'Station Métro Namur • Final Drop-off (~7:15 PM)' },
                { code: 'yonge', name: 'Yonge Station (Toronto)', time: '~1:15 PM', label: 'Yonge Station • 2nd Pickup Stop (~1:15 PM)' }
            ];
        } else if (pickupCode === 'yonge') {
            return [
                { code: 'namur', name: 'Station Métro Namur (Montreal)', time: '~7:15 PM', label: 'Station Métro Namur • Final Drop-off (~7:15 PM)' }
            ];
        }
        return [
            { code: 'yorkdale', name: 'Yorkdale Mall (Toronto)', time: '~12:15 PM', label: 'Yorkdale Mall (Toronto)' }
        ];
    }

    function getRouteDirection(pickupCode, dropoffCode) {
        if (pickupCode === 'namur') {
            return 'MTL_TO_TOR';
        }
        return 'TOR_TO_MTL';
    }

    function selectPickup(val) {
        const station = CORRIDOR_STATIONS[val] || CORRIDOR_STATIONS.namur;
        const input = document.getElementById('pickup_location');
        const textDisplay = document.getElementById('pickup-display-text');
        if (input) input.value = station.code;
        if (textDisplay) textDisplay.textContent = station.label;

        // Auto-adjust drop-off options and select a valid destination
        const destInput = document.getElementById('destination_location');
        const destText = document.getElementById('dest-display-text');
        const validDropoffs = getValidDropoffs(station.code);

        let currentDest = destInput ? destInput.value : '';
        const isValid = validDropoffs.some(d => d.code === currentDest);
        if (!isValid && validDropoffs.length > 0) {
            currentDest = validDropoffs[0].code;
            if (destInput) destInput.value = currentDest;
            if (destText) destText.textContent = validDropoffs[0].name;
        }

        updateHeroDestDropdownVisibility(station.code);
        updateHeroRouteAndSchedule();
        closeAllDropdowns();
    }

    function selectDestination(val) {
        const destInput = document.getElementById('destination_location');
        const destText = document.getElementById('dest-display-text');
        const pickupInput = document.getElementById('pickup_location');
        const pickupVal = pickupInput ? pickupInput.value : 'namur';

        const validDropoffs = getValidDropoffs(pickupVal);
        const selectedOption = validDropoffs.find(d => d.code === val) || CORRIDOR_STATIONS[val];

        if (destInput) destInput.value = val;
        if (destText && selectedOption) destText.textContent = selectedOption.name || selectedOption.label;

        updateHeroRouteAndSchedule();
        closeAllDropdowns();
    }

    function updateHeroDestDropdownVisibility(pickupCode) {
        const optYorkdale = document.getElementById('hero-dest-opt-yorkdale');
        const optYonge = document.getElementById('hero-dest-opt-yonge');
        const optNamur = document.getElementById('hero-dest-opt-namur');

        if (optYorkdale) optYorkdale.classList.toggle('hidden', pickupCode === 'yorkdale');
        if (optYonge) optYonge.classList.toggle('hidden', pickupCode === 'yonge');
        if (optNamur) optNamur.classList.toggle('hidden', pickupCode === 'namur');
    }

    function updateHeroRouteAndSchedule() {
        const pickupVal = document.getElementById('pickup_location')?.value;
        const destVal = document.getElementById('destination_location')?.value;

        const routeBadge = document.getElementById('hero-route-badge');
        const scheduleBadge = document.getElementById('hero-schedule-badge');
        const scheduleText = document.getElementById('hero-schedule-text');
        const scheduleLabel = document.getElementById('hero-schedule-label');
        const routeTag = document.getElementById('hero-route-tag');

        if (!pickupVal || !destVal) {
            if (routeBadge) routeBadge.textContent = 'Select Stations';
            if (scheduleBadge) scheduleBadge.textContent = 'Daily Departures';
            if (scheduleLabel) scheduleLabel.textContent = 'Fixed Departure Time';
            if (scheduleText) scheduleText.textContent = 'Select stations above';
            if (routeTag) routeTag.textContent = 'Montreal ↔ Toronto Corridor';
            return;
        }

        const direction = getRouteDirection(pickupVal, destVal);
        const pickupStation = CORRIDOR_STATIONS[pickupVal] || CORRIDOR_STATIONS.namur;

        if (direction === 'MTL_TO_TOR') {
            const departTime = pickupStation?.departTime || '6:30 AM';
            const stationName = pickupStation?.name || 'Station Métro Namur';
            if (routeBadge) routeBadge.textContent = 'Montreal → Toronto';
            if (scheduleBadge) scheduleBadge.textContent = `${departTime} Daily`;
            if (scheduleLabel) scheduleLabel.textContent = 'Fixed Departure Time';
            if (scheduleText) scheduleText.textContent = `${departTime} (${stationName})`;
            if (routeTag) routeTag.textContent = 'Montreal → Toronto';
        } else {
            if (routeBadge) routeBadge.textContent = 'Toronto → Montreal';
            const defaultTime = pickupVal === 'yonge' ? '1:15 PM' : '12:15 PM';
            const departTime = pickupStation?.departTime || defaultTime;
            const stationName = pickupStation?.name || (pickupVal === 'yonge' ? 'Yonge Station' : 'Yorkdale Mall');
            if (scheduleBadge) scheduleBadge.textContent = `${departTime} Daily`;
            if (scheduleLabel) scheduleLabel.textContent = 'Fixed Pick-up Time';
            if (scheduleText) scheduleText.textContent = `${departTime} (${stationName})`;
            if (routeTag) routeTag.textContent = 'Toronto → Montreal';
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

    // -------------------------------------------------------------
    // Oliver Transport 3-Step Unified Booking Wizard State & Controls
    // Step 1: Journey | Step 2: Seats | Step 3: Review & Confirm
    // -------------------------------------------------------------
    let currentWizardStep = 1;
    let currentModalPickup = 'namur';
    let currentModalDropoff = 'yorkdale';
    let currentModalDirection = 'MTL_TO_TOR';
    let currentTrip = null;
    const DEFAULT_HONDA_ODYSSEY_SEATS = [
        { id: 1, seat_number: 'S1', is_available: true, is_driver_seat: false },
        { id: 2, seat_number: 'S2', is_available: true, is_driver_seat: false },
        { id: 3, seat_number: 'S3', is_available: true, is_driver_seat: false },
        { id: 4, seat_number: 'S4', is_available: true, is_driver_seat: false },
        { id: 5, seat_number: 'S5', is_available: true, is_driver_seat: false },
        { id: 6, seat_number: 'S6', is_available: true, is_driver_seat: false },
    ];
    let selectedSeatNumbers = [];
    let seatMapData = [...DEFAULT_HONDA_ODYSSEY_SEATS];
    let baseUnitFare = (appConfig && appConfig.regularFare) ? parseFloat(appConfig.regularFare) : 65.00;
    let appliedCoupon = null;
    let currentBoardingStopId = null;
    let currentDropoffStopId = null;
    let seatHoldTimerInterval = null;
    let seatHoldSecondsLeft = 300; // 5-minute seat hold

    function openSeatPickerModal(preferredRoute = null, promoCode = null) {
        @guest
            openAuthModal();
            return;
        @endguest

        const modal = document.getElementById('seat-picker-modal');
        if (!modal) return;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Clear previous state
        selectedSeatNumbers = [];
        appliedCoupon = null;
        updateSelectedSeatsUI();
        clearSeatPickerError();
        clearCouponFeedback();

        const heroPickup = document.getElementById('pickup_location')?.value;
        const heroDropoff = document.getElementById('destination_location')?.value;

        // Determine initial pickup & dropoff
        if (preferredRoute === 'route-a' || preferredRoute === 'MTL_TO_TOR') {
            currentModalPickup = 'namur';
            currentModalDropoff = 'yorkdale';
        } else if (preferredRoute === 'route-b' || preferredRoute === 'TOR_TO_MTL') {
            currentModalPickup = 'yorkdale';
            currentModalDropoff = 'namur';
        } else if (heroPickup && heroDropoff) {
            currentModalPickup = heroPickup;
            currentModalDropoff = heroDropoff;
        } else if (heroPickup) {
            currentModalPickup = heroPickup;
            currentModalDropoff = '';
        } else {
            currentModalPickup = '';
            currentModalDropoff = '';
        }

        currentModalDirection = getRouteDirection(currentModalPickup, currentModalDropoff);

        // Sync modal date input with hero travel_date if available
        const heroDate = document.getElementById('travel_date')?.value;
        const modalDatePicker = document.getElementById('modal-date-picker');
        if (modalDatePicker && heroDate) {
            modalDatePicker.value = heroDate;
        }

        // If promo code provided, pre-fill it
        const couponInput = document.getElementById('coupon-code-input');
        if (couponInput) {
            couponInput.value = promoCode ? promoCode.toUpperCase() : '';
        }

        populateModalStationSelects();
        fetchModalTripData();
        goToWizardStep(1);
    }

    function closeSeatPickerModal() {
        const modal = document.getElementById('seat-picker-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
        stopSeatHoldTimer();
    }

    // Wizard Step Navigation Controller
    function goToWizardStep(step) {
        clearSeatPickerError();

        // Validation: Step 1 -> Step 2
        if (step === 2) {
            if (!currentModalPickup || !currentModalDropoff || currentModalPickup === currentModalDropoff) {
                showSeatPickerError('Please choose valid and different pickup and drop-off stations.');
                return;
            }
            if (!currentTrip) {
                fetchModalTripData();
            }
            startSeatHoldTimer();
            renderSeatTiles();
            updateSelectedSeatsUI();
        }

        // Validation: Step 2 -> Step 3
        if (step === 3) {
            if (selectedSeatNumbers.length === 0) {
                showSeatPickerError('Please tap and select at least 1 seat before proceeding.');
                return;
            }
            if (!currentTrip) {
                fetchModalTripData();
            }
            populateStep3Review();
        }

        currentWizardStep = step;

        // Toggle Step Container Panels
        for (let i = 1; i <= 3; i++) {
            const panel = document.getElementById(`wizard-step-${i}`);
            if (panel) {
                if (i === step) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            }
        }

        // Update Modal Header Title
        const titleEl = document.getElementById('wizard-modal-title');
        if (titleEl) {
            if (step === 1) titleEl.textContent = 'Step 1 of 3 — Choose Your Journey';
            else if (step === 2) titleEl.textContent = 'Step 2 of 3 — Select Minivan Seats';
            else if (step === 3) titleEl.textContent = 'Step 3 of 3 — Review & Confirm';
        }

        // Update Progress Indicator Tabs
        updateProgressBarUI(step);
    }

    function updateProgressBarUI(currentStep) {
        for (let i = 1; i <= 3; i++) {
            const badge = document.getElementById(`step-badge-${i}`);
            const label = document.getElementById(`step-label-${i}`);

            if (!badge) continue;

            if (i < currentStep) {
                // Completed step: Green checkmark
                badge.className = 'flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-[#22C55E] text-white shadow-xs';
                badge.innerHTML = '✓';
                if (label) label.className = 'text-xs font-bold text-[#16A34A] group-hover:underline';
            } else if (i === currentStep) {
                // Active step: Highlighted green
                badge.className = 'flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-[#22C55E] text-white shadow-md ring-2 ring-[#22C55E]/30';
                badge.textContent = i;
                if (label) label.className = 'text-xs font-bold text-slate-900';
            } else {
                // Inactive step: Subtle slate
                badge.className = 'flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-white text-slate-400 border border-slate-200 shadow-xs';
                badge.textContent = i;
                if (label) label.className = 'text-xs font-bold text-slate-400 group-hover:text-slate-600';
            }
        }

        const div1 = document.getElementById('step-divider-1');
        const div2 = document.getElementById('step-divider-2');
        if (div1) {
            div1.className = currentStep >= 2 ? 'flex-1 h-0.5 mx-2 sm:mx-3 bg-[#22C55E] transition-colors' : 'flex-1 h-0.5 mx-2 sm:mx-3 bg-slate-200 transition-colors';
        }
        if (div2) {
            div2.className = currentStep >= 3 ? 'flex-1 h-0.5 mx-2 sm:mx-3 bg-[#22C55E] transition-colors' : 'flex-1 h-0.5 mx-2 sm:mx-3 bg-slate-200 transition-colors';
        }
    }

    // 5-Minute Seat Hold Countdown Timer
    function startSeatHoldTimer() {
        if (seatHoldTimerInterval) return;
        seatHoldSecondsLeft = 300; // 5 minutes
        updateSeatHoldTimerDisplay();

        seatHoldTimerInterval = setInterval(() => {
            seatHoldSecondsLeft--;
            if (seatHoldSecondsLeft <= 0) {
                stopSeatHoldTimer();
                showSeatPickerError('Seat hold timer expired. Refreshing real-time availability.');
                if (currentTrip) {
                    loadSeatAvailability(currentTrip.id, currentBoardingStopId, currentDropoffStopId);
                }
                startSeatHoldTimer();
            } else {
                updateSeatHoldTimerDisplay();
            }
        }, 1000);
    }

    function stopSeatHoldTimer() {
        if (seatHoldTimerInterval) {
            clearInterval(seatHoldTimerInterval);
            seatHoldTimerInterval = null;
        }
    }

    function updateSeatHoldTimerDisplay() {
        const display = document.getElementById('seat-hold-timer-display');
        if (!display) return;
        const mins = Math.floor(seatHoldSecondsLeft / 60);
        const secs = seatHoldSecondsLeft % 60;
        display.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }

    function populateModalStationSelects() {
        const pickupSelect = document.getElementById('modal-pickup-select');
        const dropoffSelect = document.getElementById('modal-dropoff-select');
        if (!pickupSelect || !dropoffSelect) return;

        pickupSelect.value = currentModalPickup || '';

        if (!currentModalPickup) {
            dropoffSelect.innerHTML = '<option value="" disabled selected>Select destination station...</option>';
            dropoffSelect.value = '';
            updateModalJourneyBanner();
            return;
        }

        const validDropoffs = getValidDropoffs(currentModalPickup);
        dropoffSelect.innerHTML = '<option value="" disabled' + (!currentModalDropoff ? ' selected' : '') + '>Select destination station...</option>';
        validDropoffs.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.code;
            opt.textContent = `${d.name} (${d.time})`;
            if (d.code === currentModalDropoff) {
                opt.selected = true;
            }
            dropoffSelect.appendChild(opt);
        });

        const isCurrentDropoffValid = validDropoffs.some(d => d.code === currentModalDropoff);
        if (isCurrentDropoffValid) {
            dropoffSelect.value = currentModalDropoff;
        } else {
            currentModalDropoff = '';
            dropoffSelect.value = '';
        }

        updateModalJourneyBanner();
    }

    function onModalPickupChange() {
        const pickupSelect = document.getElementById('modal-pickup-select');
        if (!pickupSelect) return;
        currentModalPickup = pickupSelect.value;

        selectedSeatNumbers = [];
        updateSelectedSeatsUI();
        clearSeatPickerError();

        populateModalStationSelects();
        currentModalDirection = getRouteDirection(currentModalPickup, currentModalDropoff);
        fetchModalTripData();
    }

    function onModalDropoffChange() {
        const dropoffSelect = document.getElementById('modal-dropoff-select');
        if (!dropoffSelect) return;
        currentModalDropoff = dropoffSelect.value;

        selectedSeatNumbers = [];
        updateSelectedSeatsUI();
        clearSeatPickerError();

        currentModalDirection = getRouteDirection(currentModalPickup, currentModalDropoff);
        updateModalJourneyBanner();
        mapStationStopIds();
        if (currentTrip) {
            loadSeatAvailability(currentTrip.id, currentBoardingStopId, currentDropoffStopId);
        } else if (currentModalPickup && currentModalDropoff) {
            fetchModalTripData();
        }
    }

    function updateModalJourneyBanner() {
        const routeDisplay = document.getElementById('step1-route-display') || document.getElementById('modal-route-display');
        const pickupTimeDisplay = document.getElementById('step1-pickup-time-display') || document.getElementById('modal-pickup-time-display');
        const dropoffTimeDisplay = document.getElementById('step1-dropoff-time-display') || document.getElementById('modal-dropoff-time-display');

        if (!currentModalPickup || !currentModalDropoff) {
            if (routeDisplay) routeDisplay.textContent = 'Choose Stations Above';
            if (pickupTimeDisplay) pickupTimeDisplay.textContent = '--:--';
            if (dropoffTimeDisplay) dropoffTimeDisplay.textContent = '--:--';
            return;
        }

        const pickupStation = CORRIDOR_STATIONS[currentModalPickup] || CORRIDOR_STATIONS.namur;
        const validDropoffs = getValidDropoffs(currentModalPickup);
        const dropoffOption = validDropoffs.find(d => d.code === currentModalDropoff) || validDropoffs[0];

        const direction = getRouteDirection(currentModalPickup, currentModalDropoff);
        if (routeDisplay) {
            routeDisplay.textContent = (direction === 'MTL_TO_TOR')
                ? 'Montreal → Toronto'
                : 'Toronto → Montreal';
        }

        if (pickupTimeDisplay) {
            pickupTimeDisplay.textContent = pickupStation.departTime;
        }

        if (dropoffTimeDisplay) {
            dropoffTimeDisplay.textContent = dropoffOption ? dropoffOption.time : '~12:15 PM';
        }
    }

    function onModalDateChange() {
        selectedSeatNumbers = [];
        updateSelectedSeatsUI();
        clearSeatPickerError();
        fetchModalTripData();
    }

    function fetchModalTripData() {
        if (!currentModalPickup || !currentModalDropoff) {
            currentTrip = null;
            clearSeatPickerError();
            return;
        }

        const dateVal = document.getElementById('modal-date-picker')?.value || new Date().toISOString().split('T')[0];
        currentModalDirection = getRouteDirection(currentModalPickup, currentModalDropoff);

        fetch(`/api/trips/available?direction=${encodeURIComponent(currentModalDirection)}&pickup=${encodeURIComponent(currentModalPickup)}&dropoff=${encodeURIComponent(currentModalDropoff)}&date=${encodeURIComponent(dateVal)}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (!data.trips || data.trips.length === 0) {
                    showSeatPickerError('No scheduled trips found for this date.');
                    return;
                }

                clearSeatPickerError();
                currentTrip = data.trips[0];
                baseUnitFare = parseFloat(currentTrip.unit_fare || (appConfig ? appConfig.regularFare : 65.00));

                const rateIndicator = document.getElementById('step1-rate-indicator') || document.getElementById('modal-current-rate-indicator');
                if (rateIndicator) {
                    rateIndicator.textContent = `$${baseUnitFare.toFixed(2)} CAD Base`;
                }

                mapStationStopIds();
                loadSeatAvailability(currentTrip.id, currentBoardingStopId, currentDropoffStopId);

                // If coupon code was already entered or prefilled, auto-reapply
                const couponInput = document.getElementById('coupon-code-input');
                if (couponInput && couponInput.value.trim() && selectedSeatNumbers.length > 0) {
                    applyCouponCode();
                } else if (currentWizardStep === 3) {
                    populateStep3Review();
                }
            })
            .catch(() => {
                showSeatPickerError('Unable to load trip schedule. Please check your network connection.');
            });
    }

    function mapStationStopIds() {
        if (!currentTrip || !currentTrip.route || !currentTrip.route.stops) return;
        const stops = currentTrip.route.stops;

        let boardingStop = null;
        if (currentModalPickup === 'namur') {
            boardingStop = stops.find(s => s.name.includes('Namur') || s.name.includes('Montreal'));
        } else if (currentModalPickup === 'yorkdale') {
            boardingStop = stops.find(s => s.name.includes('Yorkdale'));
        } else if (currentModalPickup === 'yonge') {
            boardingStop = stops.find(s => s.name.includes('Yonge'));
        }
        currentBoardingStopId = boardingStop ? boardingStop.id : stops[0]?.id;

        let dropoffStop = null;
        if (currentModalDropoff === 'namur') {
            dropoffStop = stops.find(s => s.name.includes('Namur') || s.name.includes('Montreal'));
        } else if (currentModalDropoff === 'yorkdale') {
            dropoffStop = stops.find(s => s.name.includes('Yorkdale'));
        } else if (currentModalDropoff === 'yonge') {
            dropoffStop = stops.find(s => s.name.includes('Yonge'));
        }
        currentDropoffStopId = dropoffStop ? dropoffStop.id : stops[stops.length - 1]?.id;
    }

    function loadSeatAvailability(tripId, boardingStopId, dropoffStopId) {
        let url = `/api/trips/${tripId}/seats`;
        if (boardingStopId && dropoffStopId) {
            url += `?boarding_stop_id=${boardingStopId}&dropoff_stop_id=${dropoffStopId}`;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.seats && data.seats.length > 0) {
                    seatMapData = data.seats;
                }
                renderSeatTiles();

                // If coupon was prefilled, auto-apply it
                const couponInput = document.getElementById('coupon-code-input');
                if (couponInput && couponInput.value.trim() && selectedSeatNumbers.length > 0) {
                    applyCouponCode();
                }
            })
            .catch(() => {
                showSeatPickerError('Unable to retrieve real-time cabin seat availability.');
            });
    }

    function renderSeatTiles() {
        const seatKeys = ['S1', 'S2', 'S3', 'S4', 'S5', 'S6'];
        seatKeys.forEach(seatNum => {
            const btn = document.getElementById(`seat-btn-${seatNum}`);
            if (!btn) return;

            const seat = seatMapData.find(s => s.seat_number === seatNum) || {
                id: parseInt(seatNum.replace(/\D/g, '')) || 1,
                seat_number: seatNum,
                is_available: true,
                is_driver_seat: false
            };

            const isSelected = selectedSeatNumbers.includes(seatNum);

            if (seat.is_available === false) {
                btn.disabled = true;
                btn.className = 'seat-select-btn rounded-2xl border-2 border-slate-200 bg-slate-100 text-slate-400 p-2 text-center opacity-60 cursor-not-allowed select-none min-h-[56px] flex flex-col items-center justify-center line-through';
                const label = btn.querySelector('.seat-label');
                if (label) label.textContent = `${seatNum} (Occupied)`;
                const sub = btn.querySelector('.seat-sub');
                if (sub) sub.className = 'seat-sub text-[8px] text-slate-400 block';
            } else if (isSelected) {
                btn.disabled = false;
                btn.className = 'seat-select-btn rounded-2xl border-2 border-[#16A34A] bg-[#22C55E] text-white p-2 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-md shadow-[#22C55E]/25';
                const label = btn.querySelector('.seat-label');
                if (label) label.textContent = `✓ ${seatNum}`;
                const sub = btn.querySelector('.seat-sub');
                if (sub) sub.className = 'seat-sub text-[8px] text-emerald-100 block';
            } else {
                btn.disabled = false;
                btn.className = 'seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 text-slate-800 p-2 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs';
                const label = btn.querySelector('.seat-label');
                if (label) label.textContent = `Seat ${seatNum}`;
                const sub = btn.querySelector('.seat-sub');
                if (sub) sub.className = 'seat-sub text-[8px] text-slate-500 block';
            }
        });
    }

    function toggleSeatSelection(seatNumber) {
        let seat = seatMapData.find(s => s.seat_number === seatNumber);
        if (!seat) {
            seat = {
                id: parseInt(seatNumber.replace(/\D/g, '')) || 1,
                seat_number: seatNumber,
                is_available: true,
                is_driver_seat: false
            };
            seatMapData.push(seat);
        }
        if (seat.is_available === false) return;

        const idx = selectedSeatNumbers.indexOf(seatNumber);
        if (idx > -1) {
            selectedSeatNumbers.splice(idx, 1);
        } else {
            if (selectedSeatNumbers.length >= 6) {
                showSeatPickerError('Maximum 6 passenger seats can be selected per reservation.');
                return;
            }
            selectedSeatNumbers.push(seatNumber);
            clearSeatPickerError();
        }

        renderSeatTiles();
        updateSelectedSeatsUI();

        // If coupon code already entered, recalculate
        const couponInput = document.getElementById('coupon-code-input');
        if (couponInput && couponInput.value.trim() && selectedSeatNumbers.length > 0) {
            applyCouponCode();
        }
    }

    function updateSelectedSeatsUI() {
        const count = selectedSeatNumbers.length;
        const sortedSeats = [...selectedSeatNumbers].sort();

        // Step 2 Live indicators
        const step2SeatsSummary = document.getElementById('step2-live-seats-summary');
        const step2GrossSummary = document.getElementById('step2-live-gross-summary');
        const step2ConfirmBtn = document.getElementById('step2-confirm-seats-btn');

        if (count === 0) {
            if (step2SeatsSummary) step2SeatsSummary.textContent = 'None selected';
            if (step2GrossSummary) step2GrossSummary.textContent = '$0.00 CAD';
            if (step2ConfirmBtn) {
                step2ConfirmBtn.disabled = true;
                const span = step2ConfirmBtn.querySelector('span');
                if (span) span.textContent = 'Confirm Seats';
            }
        } else {
            if (step2SeatsSummary) {
                step2SeatsSummary.textContent = `${sortedSeats.join(', ')} (${count} ${count === 1 ? 'seat' : 'seats'})`;
            }
            const gross = count * baseUnitFare;
            if (step2GrossSummary) {
                step2GrossSummary.textContent = `$${gross.toFixed(2)} CAD`;
            }
            if (step2ConfirmBtn) {
                step2ConfirmBtn.disabled = false;
                const span = step2ConfirmBtn.querySelector('span');
                if (span) span.textContent = `Confirm ${count} ${count === 1 ? 'Seat' : 'Seats'} ($${gross.toFixed(0)} CAD)`;
            }
        }

        // Step 1 rate indicator
        const step1Rate = document.getElementById('step1-rate-indicator') || document.getElementById('modal-current-rate-indicator');
        if (step1Rate) step1Rate.textContent = `$${baseUnitFare.toFixed(2)} CAD Base`;

        // If currently viewing Step 3, refresh summary
        if (currentWizardStep === 3) {
            populateStep3Review();
        }
    }

    function populateStep3Review() {
        const routeTitle = document.getElementById('step3-route-title');
        const pickupText = document.getElementById('step3-pickup-text');
        const pickupTime = document.getElementById('step3-pickup-time-text');
        const dropoffText = document.getElementById('step3-dropoff-text');
        const dropoffTime = document.getElementById('step3-dropoff-time-text');
        const dateText = document.getElementById('step3-date-text');
        const badgesContainer = document.getElementById('step3-seats-badges');
        const fareCalcLabel = document.getElementById('step3-fare-calc-label');
        const grossText = document.getElementById('modal-gross-fare-text');
        const discountRow = document.getElementById('modal-discount-row');
        const discountText = document.getElementById('modal-discount-text');
        const subtotalText = document.getElementById('step3-subtotal-text');
        const totalFareText = document.getElementById('final-total-fare-text');

        const pickupStation = CORRIDOR_STATIONS[currentModalPickup] || CORRIDOR_STATIONS.namur;
        const validDropoffs = getValidDropoffs(currentModalPickup);
        const dropoffStation = validDropoffs.find(d => d.code === currentModalDropoff) || validDropoffs[0];
        const direction = getRouteDirection(currentModalPickup, currentModalDropoff);

        if (routeTitle) {
            routeTitle.textContent = (direction === 'MTL_TO_TOR') ? 'Montreal → Toronto' : 'Toronto → Montreal';
        }
        if (pickupText) {
            pickupText.textContent = `${pickupStation.name} (${pickupStation.city})`;
        }
        if (pickupTime) {
            pickupTime.textContent = `Departure: ${pickupStation.departTime}`;
        }
        if (dropoffText) {
            dropoffText.textContent = dropoffStation ? `${dropoffStation.name} (${currentModalDropoff === 'namur' ? 'Montreal' : 'Toronto'})` : 'Yorkdale Mall (Toronto)';
        }
        if (dropoffTime) {
            dropoffTime.textContent = `Estimated Arrival: ${dropoffStation ? dropoffStation.time : '~12:15 PM'}`;
        }

        const dateVal = document.getElementById('modal-date-picker')?.value;
        if (dateText && dateVal) {
            try {
                const parts = dateVal.split('-');
                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                dateText.textContent = d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            } catch (e) {
                dateText.textContent = dateVal;
            }
        }

        const count = selectedSeatNumbers.length;
        const sortedSeats = [...selectedSeatNumbers].sort();

        if (badgesContainer) {
            badgesContainer.innerHTML = sortedSeats.map(s => `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-[#22C55E]/15 text-[#22C55E] border border-[#22C55E]/30">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Seat ${s}
                </span>
            `).join('');
        }

        const gross = count * baseUnitFare;
        if (fareCalcLabel) {
            fareCalcLabel.textContent = `${count} Seat${count > 1 ? 's' : ''} × $${baseUnitFare.toFixed(2)} CAD:`;
        }
        if (grossText) {
            grossText.textContent = `$${gross.toFixed(2)} CAD`;
        }
        if (subtotalText) {
            subtotalText.textContent = `$${gross.toFixed(2)} CAD`;
        }

        let discount = 0.00;
        if (appliedCoupon) {
            discount = parseFloat(appliedCoupon.discount_amount !== undefined ? appliedCoupon.discount_amount : (appliedCoupon.discount_value || 0));
            discount = Math.min(gross, discount);

            if (discountRow && discountText) {
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                discountText.textContent = `-$${discount.toFixed(2)} CAD (${appliedCoupon.code})`;
            }
        } else {
            if (discountRow) {
                discountRow.classList.remove('flex');
                discountRow.classList.add('hidden');
            }
        }

        const finalTotal = Math.max(0, gross - discount);
        if (totalFareText) {
            totalFareText.textContent = `$${finalTotal.toFixed(2)} CAD`;
        }
    }

    function quickApplyLaunchCoupon() {
        const input = document.getElementById('coupon-code-input');
        if (input) {
            input.value = 'LAUNCH10';
        }
        applyCouponCode();
    }

    function applyCouponCode() {
        const input = document.getElementById('coupon-code-input');
        const code = input ? input.value.trim() : '';

        if (!code) return;
        if (selectedSeatNumbers.length === 0) {
            showSeatPickerError('Please select at least one seat before applying promo code.');
            return;
        }

        const dateVal = document.getElementById('modal-date-picker')?.value || new Date().toISOString().split('T')[0];
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/api/coupons/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                code: code,
                trip_id: currentTrip ? currentTrip.id : null,
                direction: currentModalDirection,
                date: dateVal,
                seat_count: selectedSeatNumbers.length,
            })
        })
        .then(async res => {
            const data = await res.json();
            const feedback = document.getElementById('coupon-feedback');
            if (res.ok && data.is_valid) {
                appliedCoupon = data;
                if (data.trip_id && (!currentTrip || !currentTrip.id)) {
                    currentTrip = { id: data.trip_id };
                }
                if (feedback) {
                    feedback.className = 'text-xs rounded-xl p-2.5 font-semibold bg-[#22C55E]/15 text-[#22C55E] border border-[#22C55E]/30 block';
                    feedback.textContent = `✓ Promo "${data.code}" applied! You save $${parseFloat(data.discount_amount).toFixed(2)} CAD.`;
                }
                clearSeatPickerError();
                updateSelectedSeatsUI();
                populateStep3Review();
            } else {
                appliedCoupon = null;
                if (feedback) {
                    feedback.className = 'text-xs rounded-xl p-2.5 font-semibold bg-red-50 text-red-600 border border-red-200 block';
                    feedback.textContent = data.message || 'Invalid promo code.';
                }
                updateSelectedSeatsUI();
                populateStep3Review();
            }
        })
        .catch(() => {
            showSeatPickerError('Unable to validate promo code.');
        });
    }

    // Deferred Authentication: Guest saves state and triggers login
    function handleGuestDeferredAuth() {
        const seatIds = selectedSeatNumbers.map(num => {
            const s = seatMapData.find(item => item.seat_number === num);
            return s ? s.id : null;
        }).filter(id => id !== null);

        const pending = {
            trip_id: currentTrip ? currentTrip.id : null,
            direction: currentModalDirection,
            pickup: currentModalPickup,
            dropoff: currentModalDropoff,
            date: document.getElementById('modal-date-picker')?.value,
            seats: selectedSeatNumbers,
            seat_ids: seatIds,
            coupon_code: appliedCoupon ? appliedCoupon.code : null,
            step: 3
        };

        try {
            sessionStorage.setItem('pickme_pending_booking', JSON.stringify(pending));
            sessionStorage.setItem('oliver_pending_booking', JSON.stringify(pending));
        } catch (e) {
            console.error('sessionStorage error', e);
        }

        closeSeatPickerModal();
        openAuthModal();
    }

    function submitBookingReservation() {
        if (!currentTrip || selectedSeatNumbers.length === 0) {
            showSeatPickerError('Please select at least one seat to proceed.');
            return;
        }

        const seatIds = selectedSeatNumbers.map(num => {
            const s = seatMapData.find(item => item.seat_number === num);
            return s ? s.id : null;
        }).filter(id => id !== null);

        if (seatIds.length === 0) {
            showSeatPickerError('Please select valid seats.');
            return;
        }

        const confirmBtn = document.getElementById('confirm-booking-btn');
        const confirmText = document.getElementById('confirm-btn-text');
        if (confirmBtn) confirmBtn.disabled = true;
        if (confirmText) confirmText.textContent = 'Confirming Reservation...';

        const idempotencyKey = (typeof crypto !== 'undefined' && crypto.randomUUID)
            ? crypto.randomUUID()
            : 'ot-' + Date.now() + '-' + Math.random().toString(36).substring(2, 9);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/passenger/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                trip_id: currentTrip.id,
                vehicle_seat_ids: seatIds,
                boarding_stop_id: currentBoardingStopId,
                dropoff_stop_id: currentDropoffStopId,
                coupon_code: appliedCoupon ? appliedCoupon.code : null,
                idempotency_key: idempotencyKey,
            })
        })
        .then(async res => {
            const data = await res.json();
            if (res.status === 201 && data.redirect_url) {
                // Clear pending session storage on successful booking
                sessionStorage.removeItem('pickme_pending_booking');
                sessionStorage.removeItem('oliver_pending_booking');
                stopSeatHoldTimer();
                window.location.href = data.redirect_url;
            } else if (res.status === 409) {
                // Seat conflict concurrency error
                showSeatPickerError(data.message || 'The selected seat was just reserved by another traveler. Please pick another seat.');
                loadSeatAvailability(currentTrip.id, currentBoardingStopId, currentDropoffStopId);
                selectedSeatNumbers = [];
                updateSelectedSeatsUI();
                goToWizardStep(2);
                if (confirmBtn) confirmBtn.disabled = true;
                if (confirmText) confirmText.textContent = 'Confirm My Reservation ✓';
            } else {
                showSeatPickerError(data.message || 'Unable to confirm reservation. Please check your selections.');
                if (confirmBtn) confirmBtn.disabled = false;
                if (confirmText) confirmText.textContent = 'Confirm My Reservation ✓';
            }
        })
        .catch(() => {
            showSeatPickerError('A network error occurred while submitting your booking.');
            if (confirmBtn) confirmBtn.disabled = false;
            if (confirmText) confirmText.textContent = 'Confirm My Reservation ✓';
        });
    }

    function showSeatPickerError(msg) {
        const box = document.getElementById('wizard-error-box') || document.getElementById('seat-picker-error');
        const text = document.getElementById('wizard-error-text');
        if (box) {
            if (text) text.textContent = msg;
            else box.textContent = msg;
            box.classList.remove('hidden');
        }
    }

    function clearSeatPickerError() {
        const box = document.getElementById('wizard-error-box') || document.getElementById('seat-picker-error');
        if (box) {
            box.classList.add('hidden');
        }
    }

    function clearCouponFeedback() {
        const box = document.getElementById('coupon-feedback');
        if (box) {
            box.textContent = '';
            box.classList.add('hidden');
        }
    }
</script>

@stack('scripts')
