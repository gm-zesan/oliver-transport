    <!-- Guest Authentication Required Modal -->
    <div id="auth-booking-modal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/45 backdrop-blur-md hidden transition-opacity duration-200"
        role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">

        <!-- Backdrop clickable area -->
        <div class="fixed inset-0" onclick="closeAuthModal()" aria-hidden="true">
        </div>

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
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F0FDF4] text-[#22C55E] mb-5 border border-[#22C55E]/20">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>

            <!-- Heading & Copy -->
            <div class="text-center">
                <h3 id="auth-modal-title" class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-heading">
                    Sign In to Book Your Seat
                </h3>
                <p class="mt-2.5 text-sm text-slate-600 leading-relaxed" id="auth-modal-subtitle">
                    Please sign in to your passenger account to finalize your reserved seats. Your journey and seat selections will be preserved.
                </p>
            </div>

            <!-- Action CTAs -->
            <div class="mt-6 space-y-3">
                <!-- 1-Click Fast Passenger Test Login (Dev / Fast Testing) -->
                <form method="POST" action="{{ route('login.store') }}" class="w-full">
                    @csrf
                    <input type="hidden" name="email" value="passenger@pickmeroute.com">
                    <input type="hidden" name="password" value="password">
                    <button type="submit"
                        class="inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E]/15 hover:bg-[#22C55E]/25 text-[#16A34A] border-2 border-[#22C55E]/40 px-4 py-2.5 text-xs sm:text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>1-Click Test Passenger Sign In</span>
                    </button>
                </form>

                <a href="{{ route('auth.google.redirect') }}"
                    class="inline-flex min-h-[48px] w-full items-center justify-center gap-2.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 border border-slate-300/90 px-6 py-2.5 text-sm sm:text-base font-bold shadow-xs hover:shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <a href="{{ route('login') }}"
                    class="inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-2.5 text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#22C55E] text-center">
                    <span>Sign In With Email</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                <a href="{{ route('register') }}"
                    class="inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 px-6 py-2.5 text-xs sm:text-sm font-bold border border-slate-200/80 transition duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 text-center">
                    <span>Create New Account</span>
                </a>
            </div>

            <!-- Notice in Modal -->
            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Pay directly in cash to the driver upon boarding (${{ number_format($regularFare ?? 65, 0) }} CAD flat fare).
                </p>
            </div>

        </div>
    </div>

