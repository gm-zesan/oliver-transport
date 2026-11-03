<footer id="contact" class="border-t border-slate-800 bg-brand-charcoal text-slate-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
            <!-- Brand & Corridor Intro -->
            <div class="space-y-4">
                <x-brand-logo size="md" :inverted="true" />
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#22C55E]">
                    Montreal • Toronto • Montreal
                </p>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Daily scheduled intercity passenger shuttle connecting Montreal and Toronto with guaranteed reserved cabin seating.
                </p>
                <div class="inline-flex items-center gap-2 rounded-lg bg-slate-800/80 px-3 py-1.5 text-xs text-slate-300 border border-slate-700">
                    <span class="h-2 w-2 rounded-full bg-brand-green"></span>
                    <span>Fleet: Silver Honda Odyssey (Plate: <strong>RAJIA</strong>)</span>
                </div>
            </div>

            <!-- Route Summary -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Daily Corridors</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>
                        <strong class="text-slate-200 block">Montreal → Toronto</strong>
                        <span>Departs Station Métro Namur at 6:30 AM ET</span>
                    </li>
                    <li class="pt-2 border-t border-slate-800">
                        <strong class="text-slate-200 block">Toronto → Montreal</strong>
                        <span>Yorkdale Mall (12:15 PM) & Yonge Station (1:15 PM)</span>
                    </li>
                </ul>
            </div>

            <!-- Confirmed Customer Support -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Confirmed Contacts</h3>
                <p class="text-xs text-slate-400">
                    Direct phone, SMS, and WhatsApp communications:
                </p>
                <div class="space-y-2">
                    <a href="tel:6476551884" class="flex items-center gap-2 text-sm font-bold text-white hover:text-brand-green transition min-h-[44px]">
                        <svg class="h-4 w-4 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>647-655-1884</span>
                    </a>
                    <div class="flex items-center gap-2 text-sm text-slate-300">
                        <svg class="h-4 w-4 text-brand-green" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                        <span>Facebook: <strong>Oliver Transport</strong></span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 pt-1">
                    Cash settlement physically collected upon boarding.
                </p>
            </div>

            <!-- Quick Navigation -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Passenger Links</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#routes" class="hover:text-brand-green transition py-1 inline-block">Routes & Schedule</a></li>
                    <li><a href="#fares" class="hover:text-brand-green transition py-1 inline-block">Transparent Pricing</a></li>
                    <li><a href="#why-us" class="hover:text-brand-green transition py-1 inline-block">Why Choose Us</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-brand-green transition py-1 inline-block">Passenger Sign In</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>© {{ date('Y') }} Oliver Transport. Daily Montreal ↔ Toronto Shuttle Service. All rights reserved.</p>
            <p>English-first MVP release. Official CAD Currency.</p>
        </div>
    </div>
</footer>

