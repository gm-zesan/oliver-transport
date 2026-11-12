<!-- ========================================================================= -->
<!-- PickMeRoute 3-Step Unified Booking Wizard Modal (Mobile-First)       -->
<!-- Premium Clean White Theme with Frosted Translucent Blurred Backdrop       -->
<!-- Step 1: Choose Your Journey                                               -->
<!-- Step 2: Choose Your Seats                                                 -->
<!-- Step 3: Review & Confirm                                                  -->
<!-- ========================================================================= -->
<div id="seat-picker-modal"
    class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 bg-slate-950/45 backdrop-blur-md hidden transition-opacity duration-200 overflow-y-auto"
    role="dialog" aria-modal="true" aria-labelledby="wizard-modal-title">

    <!-- Frosted Backdrop Click Area -->
    <div class="fixed inset-0" onclick="closeSeatPickerModal()" aria-hidden="true"></div>

    <!-- Modal Card Container (Clean White Executive Monolith) -->
    <div
        class="relative w-full max-w-2xl max-h-[94dvh] sm:max-h-[90dvh] flex flex-col rounded-3xl bg-white border border-slate-200/90 shadow-2xl shadow-slate-900/30 z-10 my-auto text-slate-900 overflow-hidden">

        <!-- Top Header: Title, Subtitle & Close Button -->
        <div
            class="flex items-center justify-between gap-4 p-4 sm:p-5 border-b border-slate-100 bg-white/95 backdrop-blur-md sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <div
                    class="h-10 w-10 rounded-2xl bg-[#F0FDF4] border border-[#22C55E]/30 text-[#22C55E] flex items-center justify-center flex-shrink-0 shadow-xs">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h3 id="wizard-modal-title"
                        class="text-base sm:text-lg font-black tracking-tight font-heading text-slate-900 leading-tight">
                        {{ __('Step 1 of 3 — Choose Your Journey') }}
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ __('Daily Montreal ↔ Toronto Shuttle') }} • {{ $vehicle?->model ?? 'Honda Odyssey' }} (<strong
                            class="text-slate-800 font-mono">{{ $vehicle?->plate_number ?? 'RAJIA' }}</strong>)
                    </p>
                </div>
            </div>

            <button type="button" onclick="closeSeatPickerModal()"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer"
                aria-label="Close booking modal">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- 3-Step Interactive Visual Progress Indicator Bar -->
        <div class="px-4 py-3 bg-slate-50/90 border-b border-slate-200/80 select-none">
            <div class="flex items-center justify-between max-w-lg mx-auto">
                <!-- Step 1 Tab -->
                <button type="button" onclick="goToWizardStep(1)" id="step-tab-1"
                    class="flex items-center gap-2 cursor-pointer focus:outline-none group">
                    <span id="step-badge-1"
                        class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-[#22C55E] text-white shadow-xs">
                        1
                    </span>
                    <span id="step-label-1" class="text-xs font-bold text-[#16A34A] group-hover:underline">
                        {{ __('Journey') }}
                    </span>
                </button>

                <!-- Divider 1 -->
                <div id="step-divider-1" class="flex-1 h-0.5 mx-2 sm:mx-3 bg-slate-200 transition-colors"></div>

                <!-- Step 2 Tab -->
                <button type="button" onclick="goToWizardStep(2)" id="step-tab-2"
                    class="flex items-center gap-2 cursor-pointer focus:outline-none group">
                    <span id="step-badge-2"
                        class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-white text-slate-400 border border-slate-200 shadow-xs">
                        2
                    </span>
                    <span id="step-label-2" class="text-xs font-bold text-slate-400 group-hover:text-slate-600">
                        {{ __('Seats') }}
                    </span>
                </button>

                <!-- Divider 2 -->
                <div id="step-divider-2" class="flex-1 h-0.5 mx-2 sm:mx-3 bg-slate-200 transition-colors"></div>

                <!-- Step 3 Tab -->
                <button type="button" onclick="goToWizardStep(3)" id="step-tab-3"
                    class="flex items-center gap-2 cursor-pointer focus:outline-none group">
                    <span id="step-badge-3"
                        class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black transition-all bg-white text-slate-400 border border-slate-200 shadow-xs">
                        3
                    </span>
                    <span id="step-label-3" class="text-xs font-bold text-slate-400 group-hover:text-slate-600">
                        {{ __('Review & Confirm') }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Global Error Alert Box (Visible when error occurs) -->
        <div id="wizard-error-box"
            class="hidden m-4 mb-0 rounded-2xl bg-red-50 border border-red-200 p-3 text-xs text-red-700 font-semibold flex items-center justify-between gap-3"
            role="alert">
            <span id="wizard-error-text">{{ __('An error occurred. Please try again.') }}</span>
            <button type="button" onclick="clearSeatPickerError()"
                class="text-red-500 hover:text-red-800 font-bold text-xs cursor-pointer">{{ __('Dismiss') }}</button>
        </div>

        <!-- ================================================================= -->
        <!-- STEP 1 CONTAINER: Choose Your Journey                             -->
        <!-- ================================================================= -->
        <div id="wizard-step-1" class="wizard-step flex-1 overflow-y-auto p-4 sm:p-6 space-y-5">

            <div class="rounded-2xl bg-slate-50/80 border border-slate-200/90 p-4 space-y-4">
              
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Pickup Address -->
                    <div>
                        <label for="modal-pickup-select" class="block text-xs font-bold text-slate-700 mb-1.5">
                            {{ __('Pickup Address (Boarding Station)') }}
                        </label>
                        <select id="modal-pickup-select" onchange="onModalPickupChange()"
                            class="w-full rounded-xl bg-white border border-slate-200 shadow-xs px-3.5 py-2.5 text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                            <option value="" disabled selected>{{ __('Choose Pickup Station...') }}</option>
                            <option value="namur">Station Métro Namur ({{ __('Montreal') }})</option>
                            <option value="yorkdale">{{ __('Yorkdale Mall') }} ({{ __('Toronto') }})</option>
                            <option value="yonge">{{ __('Yonge Station') }} ({{ __('Toronto') }})</option>
                        </select>
                    </div>

                    <!-- Drop-off Address (Dynamically Filtered) -->
                    <div>
                        <label for="modal-dropoff-select" class="block text-xs font-bold text-slate-700 mb-1.5">
                            {{ __('Drop-off Address (Destination)') }}
                        </label>
                        <select id="modal-dropoff-select" onchange="onModalDropoffChange()"
                            class="w-full rounded-xl bg-white border border-slate-200 shadow-xs px-3.5 py-2.5 text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                            <option value="" disabled selected>{{ __('Choose Drop-off Station...') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Travel Date -->
                <div>
                    <label for="modal-date-picker" class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ __('Travel Date (Past dates locked)') }}
                    </label>
                    <input type="date" id="modal-date-picker" onchange="onModalDateChange()" value="{{ date('Y-m-d') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full rounded-xl bg-white border border-slate-200 shadow-xs px-3.5 py-2.5 text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer" />
                </div>
            </div>

            <!-- Route Timetable Status Banner -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-xs p-4 space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">{{ __('Corridor Route:') }}</span>
                    <span class="font-bold text-slate-900" id="step1-route-display">
                        {{ __('Montreal → Toronto') }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-500 block text-[11px] font-medium">{{ __('Scheduled Boarding Time:') }}</span>
                        <strong class="text-[#16A34A] text-sm font-mono block mt-0.5"
                            id="step1-pickup-time-display">6:30 AM</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-[11px] font-medium">{{ __('Estimated Arrival Time:') }}</span>
                        <strong class="text-slate-800 text-sm font-mono block mt-0.5" id="step1-dropoff-time-display">~12:15
                            PM</strong>
                    </div>
                </div>
            </div>

            <!-- Step 1 Bottom Sticky Button -->
            <div class="pt-2">
                <button type="button" onclick="goToWizardStep(2)"
                    class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-base font-bold shadow-lg shadow-[#22C55E]/20 transition cursor-pointer">
                    <span>{{ __('Continue to Seat Selection') }}</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

        </div>

        <!-- ================================================================= -->
        <!-- STEP 2 CONTAINER: Choose Your Seats                               -->
        <!-- ================================================================= -->
        <div id="wizard-step-2" class="wizard-step hidden flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">


            <!-- Interactive Minivan Cabin Shell -->
            <div class="max-w-sm mx-auto rounded-3xl border-2 border-slate-200 bg-slate-50/90 p-4 shadow-sm">

                <!-- Vehicle Front / Windshield Indicator -->
                <div class="text-center pb-3 mb-3 border-b border-dashed border-slate-200">
                    <div class="mx-auto w-24 h-1.5 rounded-t-full bg-slate-300 mb-1"></div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">
                        ▲ {{ __('FRONT / WINDSHIELD') }} ▲
                    </span>
                </div>

                <!-- Seats Grid -->
                <div class="space-y-3.5">
                    <!-- Row 1: Driver + Seat S1 -->
                    <div class="grid grid-cols-2 gap-3 items-center">
                        <!-- Driver Seat (Permanently Excluded) -->
                        <div
                            class="rounded-2xl border border-slate-200 bg-slate-100 p-2.5 text-center opacity-60 cursor-not-allowed select-none min-h-[56px] flex flex-col items-center justify-center">
                            <div
                                class="h-6 w-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mb-0.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-width="2" d="M12 3v18M3 12h18" />
                                </svg>
                            </div>
                            <span class="text-[11px] font-bold text-slate-600 block leading-tight">{{ __('Driver') }}</span>
                            <span class="text-[9px] text-slate-400 block">{{ __('Excluded') }}</span>
                        </div>

                        <!-- Seat S1 -->
                        <button type="button" id="seat-btn-S1" onclick="toggleSeatSelection('S1')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2.5 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-xs font-bold text-slate-800 block">{{ __('Seat') }} S1</span>
                            <span class="seat-sub text-[9px] text-slate-500 block">{{ __('Front Passenger') }}</span>
                        </button>
                    </div>

                    <!-- Center Aisle Indicator -->
                    <div class="py-0.5 text-center">
                        <span class="text-[8px] uppercase tracking-widest text-slate-400 font-bold">
                            — {{ __('AISLE') }} —
                        </span>
                    </div>

                    <!-- Row 2: S2 & S3 -->
                    <div class="grid grid-cols-2 gap-5 items-center">
                        <!-- Seat S2 -->
                        <button type="button" id="seat-btn-S2" onclick="toggleSeatSelection('S2')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2.5 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-xs font-bold text-slate-800 block">{{ __('Seat') }} S2</span>
                            <span class="seat-sub text-[9px] text-slate-500 block">{{ __('Row 2 Left') }}</span>
                        </button>

                        <!-- Seat S3 -->
                        <button type="button" id="seat-btn-S3" onclick="toggleSeatSelection('S3')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2.5 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-xs font-bold text-slate-800 block">{{ __('Seat') }} S3</span>
                            <span class="seat-sub text-[9px] text-slate-500 block">{{ __('Row 2 Right') }}</span>
                        </button>
                    </div>

                    <!-- Row 3: S4, S5, S6 -->
                    <div class="grid grid-cols-3 gap-2 items-center">
                        <!-- Seat S4 -->
                        <button type="button" id="seat-btn-S4" onclick="toggleSeatSelection('S4')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-[11px] font-bold text-slate-800 block">{{ __('Seat') }} S4</span>
                            <span class="seat-sub text-[8px] text-slate-500 block">{{ __('Row 3 L') }}</span>
                        </button>

                        <!-- Seat S5 -->
                        <button type="button" id="seat-btn-S5" onclick="toggleSeatSelection('S5')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-[11px] font-bold text-slate-800 block">{{ __('Seat') }} S5</span>
                            <span class="seat-sub text-[8px] text-slate-500 block">{{ __('Row 3 Mid') }}</span>
                        </button>

                        <!-- Seat S6 -->
                        <button type="button" id="seat-btn-S6" onclick="toggleSeatSelection('S6')"
                            class="seat-select-btn rounded-2xl border-2 border-slate-200 bg-white hover:border-[#22C55E] hover:bg-emerald-50/40 p-2 text-center transition cursor-pointer select-none min-h-[56px] flex flex-col items-center justify-center shadow-xs">
                            <span class="seat-label text-[11px] font-bold text-slate-800 block">{{ __('Seat') }} S6</span>
                            <span class="seat-sub text-[8px] text-slate-500 block">{{ __('Row 3 R') }}</span>
                        </button>
                    </div>
                </div>

                <!-- Rear Luggage Indicator -->
                <div class="mt-3 pt-2.5 border-t border-dashed border-slate-200 text-center">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">
                        ▼ {{ __('REAR LUGGAGE BAY') }} ▼
                    </span>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-slate-600 pt-1">
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-md bg-[#22C55E] border border-[#22C55E]"></span>
                    <span class="font-medium">{{ __('Selected') }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-md bg-white border-2 border-slate-300"></span>
                    <span class="font-medium">{{ __('Available') }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-md bg-slate-200 border border-slate-300 opacity-60"></span>
                    <span class="font-medium">{{ __('Occupied') }}</span>
                </div>
            </div>

            <!-- Step 2 Navigation Buttons -->
            <div class="flex items-center justify-between gap-3 pt-2">
                <button type="button" onclick="goToWizardStep(1)"
                    class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 text-xs sm:text-sm font-bold border border-slate-200 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Back to Journey') }}</span>
                </button>

                <button type="button" id="step2-confirm-seats-btn" onclick="goToWizardStep(3)" disabled
                    class="inline-flex min-h-[48px] flex-1 items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 disabled:cursor-not-allowed text-white px-6 py-3 text-sm sm:text-base font-bold shadow-lg shadow-[#22C55E]/20 transition cursor-pointer">
                    <span>{{ __('Confirm Seats') }}</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

        </div>

        <!-- ================================================================= -->
        <!-- STEP 3 CONTAINER: Review & Confirm                                -->
        <!-- ================================================================= -->
        <div id="wizard-step-3" class="wizard-step hidden flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">

            <!-- 1. Journey Summary Card -->
            <div class="rounded-2xl bg-slate-50/80 border border-slate-200/90 p-4 space-y-2.5">
                <div class="flex items-center justify-between border-b border-slate-200/70 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-[#22C55E]"></span>
                        <span class="text-sm font-bold text-slate-900 font-heading" id="step3-route-title">{{ __('Montreal → Toronto') }}</span>
                    </div>
                    <button type="button" onclick="goToWizardStep(1)"
                        class="text-xs font-bold text-[#16A34A] hover:underline cursor-pointer">
                        {{ __('Edit Journey') }}
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-700">
                    <div>
                        <span class="text-slate-500 block text-[11px] font-medium">{{ __('Pickup Location:') }}</span>
                        <strong class="text-slate-900 block mt-0.5" id="step3-pickup-text">Station Métro Namur</strong>
                        <span class="text-[#16A34A] font-bold text-[11px]" id="step3-pickup-time-text">{{ __('Departure:') }} 6:30 AM</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-[11px] font-medium">{{ __('Drop-off Location:') }}</span>
                        <strong class="text-slate-900 block mt-0.5" id="step3-dropoff-text">Yorkdale Mall</strong>
                        <span class="text-slate-700 text-[11px]" id="step3-dropoff-time-text">{{ __('Arrival:') }} ~12:15 PM</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-200/70 flex items-center justify-between text-xs text-slate-500">
                    <span>{{ __('Travel Date:') }} <strong class="text-slate-900 font-mono" id="step3-date-text">November 10,
                            2026</strong></span>
                    <span>{{ __('Fleet:') }} <strong class="text-slate-900 font-mono">{{ $vehicle?->model ?? 'Honda Odyssey' }} ({{ $vehicle?->plate_number ?? 'RAJIA' }})</strong></span>
                </div>
            </div>

            <!-- 2. Selected Seats Card -->
            <div
                class="rounded-2xl bg-slate-50/80 border border-slate-200/90 p-4 flex items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1.5">{{ __('Selected Seats') }}</span>
                    <div id="step3-seats-badges" class="flex flex-wrap gap-1.5">
                        <!-- Populated dynamically: [Seat S1] [Seat S2] -->
                    </div>
                </div>
                <button type="button" onclick="goToWizardStep(2)"
                    class="text-xs font-bold text-[#16A34A] hover:underline cursor-pointer flex-shrink-0">
                    {{ __('Change Seats') }}
                </button>
            </div>

            <!-- 3. Promo Code Section -->
            <div class="rounded-2xl bg-white border border-slate-200 p-3.5 space-y-2.5 shadow-xs">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-700 font-semibold">
                        {{ __('Apply Promo Code:') }}
                    </span>
                    <button type="button" onclick="quickApplyLaunchCoupon()"
                        class="inline-flex items-center gap-1 text-[11px] font-bold text-[#16A34A] hover:text-[#22C55E] underline cursor-pointer">
                        <span>{{ __('LAUNCH10 - Save $10/seat ($55 CAD)') }}</span>
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <input type="text" id="coupon-code-input" placeholder="{{ __('Promo code (e.g. LAUNCH10)') }}" maxlength="30"
                        class="flex-1 rounded-xl bg-slate-50 border border-slate-200 px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white uppercase font-mono" />
                    <button type="button" onclick="applyCouponCode()"
                        class="rounded-xl bg-slate-800 hover:bg-[#16A34A] px-4 py-2 text-xs font-bold text-white transition cursor-pointer">
                        {{ __('Apply') }}
                    </button>
                </div>

                <div id="coupon-feedback" class="hidden text-xs rounded-xl p-2.5 font-semibold"></div>
            </div>

            <!-- 4. Price Breakdown Table -->
            <div class="rounded-2xl bg-slate-50/80 border border-slate-200/90 p-4 space-y-2">
                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">{{ __('Price Breakdown') }}</div>

                <div class="flex items-center justify-between text-xs text-slate-600">
                    <span id="step3-fare-calc-label">2 Seats × ${{ number_format($regularFare ?? 65, 2) }} CAD:</span>
                    <span id="modal-gross-fare-text" class="font-mono text-slate-900 font-bold">$130.00 CAD</span>
                </div>

                <div id="modal-discount-row" class="hidden items-center justify-between text-xs text-[#16A34A]">
                    <span id="step3-discount-label">LAUNCH10 Promo Discount:</span>
                    <span id="modal-discount-text" class="font-mono font-bold">-$20.00 CAD</span>
                </div>

                <div class="pt-2 border-t border-slate-200/70 flex items-center justify-between text-xs text-slate-600">
                    <span class="font-semibold">{{ __('Subtotal:') }}</span>
                    <span id="step3-subtotal-text" class="font-mono text-slate-900 font-bold">$130.00 CAD</span>
                </div>
            </div>

            <!-- 5. CRITICAL BOARDING CASH NOTICE (Highlight Card) -->
            <div
                class="rounded-2xl border-2 border-[#22C55E]/40 bg-[#F0FDF4] p-4 sm:p-5 text-center sm:text-left flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#16A34A] block">
                        {{ __('TOTAL TO PAY ON BOARDING') }}
                    </span>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-slate-900 mt-0.5" id="final-total-fare-text">
                        $110.00 CAD
                    </div>
                    <p class="text-xs text-slate-700 mt-1">
                        💵 <strong>{{ __('Cash payment directly to your driver') }}</strong> {{ __('upon boarding the vehicle.') }}
                    </p>
                </div>
                <div
                    class="inline-flex items-center justify-center px-3.5 py-2 rounded-xl bg-white text-[#16A34A] text-xs font-bold border border-emerald-200 shadow-xs flex-shrink-0">
                    {{ __('No Prepayment Needed') }}
                </div>
            </div>

            <!-- Terms & Conditions / Cancellation Policy Summary -->
            <div
                class="rounded-xl bg-slate-50 border border-slate-200/90 p-3 text-[11px] text-slate-600 leading-relaxed space-y-1">
                <div class="font-bold text-slate-800">{{ __('Reservation Terms & Policy:') }}</div>
                <p>• {{ __('Please arrive at the station 10–15 minutes prior to scheduled departure.') }}</p>
                <p>• {{ __('If your plans change, please notify dispatch in advance via phone, SMS, or WhatsApp at') }} <strong
                        class="text-slate-900 font-mono">647-655-1884</strong>.</p>
            </div>

            <!-- Step 3 Navigation Buttons -->
            <div class="flex items-center justify-between gap-3 pt-2">
                <button type="button" onclick="goToWizardStep(2)"
                    class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 text-xs sm:text-sm font-bold border border-slate-200 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Back to Seats') }}</span>
                </button>

                <!-- Final Confirmation Button: Dynamic for Logged-In Passenger vs Guest -->
                @auth
                    @if(auth()->user()->isPassenger())
                        <button type="button" id="confirm-booking-btn" onclick="submitBookingReservation()"
                            class="inline-flex min-h-[48px] flex-1 items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-sm sm:text-base font-bold shadow-lg shadow-[#22C55E]/20 transition cursor-pointer">
                            <span id="confirm-btn-text">{{ __('Confirm My Reservation') }}</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    @else
                        @php
                            $dashRoute = auth()->user()->isRider() ? route('rider.dashboard') : route('operator.dashboard');
                        @endphp
                        <a href="{{ $dashRoute }}"
                            class="inline-flex min-h-[48px] flex-1 items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-sm sm:text-base font-bold shadow-lg shadow-[#22C55E]/20 transition text-center">
                            <span>{{ __('Go to Dashboard') }}</span>
                        </a>
                    @endif
                @else
                    <!-- Guest: Deferred Auth Trigger (Saves State then Prompts Auth) -->
                    <button type="button" id="confirm-booking-btn" onclick="handleGuestDeferredAuth()"
                        class="inline-flex min-h-[48px] flex-1 items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-sm sm:text-base font-bold shadow-lg shadow-[#22C55E]/20 transition cursor-pointer">
                        <span id="confirm-btn-text">{{ __('Sign In & Confirm Reservation →') }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                @endauth
            </div>

        </div>

    </div>
</div>
