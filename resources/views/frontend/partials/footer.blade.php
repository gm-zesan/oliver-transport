<!-- Footer: Premium Dark Charcoal (#111827) 4-Column Layout with Green CTA Panel -->
<footer class="bg-[#111827] text-slate-300 pt-16 sm:pt-20 pb-10 border-t border-slate-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-14 border-b border-slate-800">
            
            <!-- Column 1: Brand & Description (4 cols) -->
            <div class="lg:col-span-4 space-y-4">
                <a href="{{ route('home') }}" class="inline-block">
                    <x-brand-logo size="md" :inverted="true" :showSubtitle="true" />
                </a>

                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Scheduled intercity passenger shuttle connecting Montreal and Toronto with guaranteed reserved seating, well-maintained vehicles, and cash settlement upon boarding.
                </p>

                <!-- Social Links -->
                <div class="pt-2 flex items-center gap-3">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="h-10 w-10 rounded-full bg-slate-800 hover:bg-[#22C55E] hover:text-white text-slate-300 flex items-center justify-center transition" 
                       aria-label="Facebook: PickMeRoute">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <span class="text-xs sm:text-sm text-slate-400 font-medium">Facebook: <strong class="text-white">PickMeRoute</strong></span>
                </div>
            </div>

            <!-- Combined Columns 2 & 3: Quick Links & Contact Us (Side by Side on mobile, separate on desktop) -->
            <div class="lg:col-span-5 grid grid-cols-12 gap-5 sm:gap-8">
                <!-- Column 2: Quick Links -->
                <div class="col-span-5 lg:col-span-5 space-y-4">
                    <h4 class="text-sm font-bold text-white tracking-wider uppercase font-heading">Quick Links</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-[#22C55E] transition">Home</a></li>
                        <li><a href="{{ route('home') }}#services" class="hover:text-[#22C55E] transition">Services</a></li>
                        <li><a href="{{ route('home') }}#promotions" class="hover:text-[#22C55E] transition">Promotions</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#22C55E] transition">Contact</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#22C55E] transition">Sign In</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact Us -->
                <div class="col-span-7 lg:col-span-7 space-y-4">
                    <h4 class="text-sm font-bold text-white tracking-wider uppercase font-heading">Contact Us</h4>
                    <ul class="space-y-3.5 text-xs sm:text-sm text-slate-400">
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div class="min-w-0">
                                <span class="block text-slate-500 text-[10px] sm:text-xs uppercase tracking-wider font-semibold">Phone / SMS / WhatsApp</span>
                                <a href="tel:6476551884" class="text-white font-bold hover:text-[#22C55E] transition text-xs sm:text-sm">647-655-1884</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div class="min-w-0">
                                <span class="block text-slate-500 text-[10px] sm:text-xs uppercase tracking-wider font-semibold">Email</span>
                                <a href="mailto:info@pickmeroute.com" class="text-white hover:text-[#22C55E] transition truncate block text-xs sm:text-sm">info@pickmeroute.com</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 text-[#22C55E] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="min-w-0">
                                <span class="block text-slate-500 text-[10px] sm:text-xs uppercase tracking-wider font-semibold">Predefined Station Hubs</span>
                                <span class="text-white block text-xs sm:text-sm">Station Métro Namur (Montreal)</span>
                                <span class="text-slate-400 block text-[11px] sm:text-xs">Yorkdale Mall &amp; Yonge Station (Toronto)</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Column 4: Green CTA Panel (3 cols) -->
            <div class="lg:col-span-3">
                <div class="rounded-2xl bg-gradient-to-br from-[#22C55E]/15 to-[#22C55E]/5 border border-[#22C55E]/30 p-6 sm:p-7 flex flex-col justify-between h-full shadow-lg">
                    <div>
                        <span class="inline-block text-[11px] font-black uppercase tracking-widest text-[#22C55E] mb-1">
                            PickMeRoute
                        </span>
                        <h4 class="text-lg sm:text-xl font-black text-white leading-snug font-heading">
                            Ready for Your Next Journey?
                        </h4>
                        <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                            Book your seat today and travel in comfort between Montreal and Toronto.
                        </p>
                    </div>

                    <div class="mt-6 pt-2">
                        @auth
                            @if(auth()->user()->isPassenger())
                                <button type="button" onclick="handleGlobalBookNow()"
                                   class="inline-flex min-h-[48px] w-full items-center justify-center rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-3 text-sm font-bold shadow-md hover:shadow-xl transition duration-200 text-center cursor-pointer">
                                    Book Now
                                </button>
                            @else
                                @php
                                    $dashboardRoute = auth()->user()->isRider() 
                                        ? route('rider.dashboard') 
                                        : route('operator.dashboard');
                                @endphp
                                <a href="{{ $dashboardRoute }}" 
                                   class="inline-flex min-h-[48px] w-full items-center justify-center rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-3 text-sm font-bold shadow-md hover:shadow-xl transition duration-200 text-center">
                                    Go to Dashboard
                                </a>
                            @endif
                        @else
                            <button type="button" onclick="handleGlobalBookNow()" 
                               class="inline-flex min-h-[48px] w-full items-center justify-center rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-3 text-sm font-bold shadow-md hover:shadow-xl transition duration-200 text-center cursor-pointer">
                                Book Now
                            </button>
                            <div class="mt-2 text-center">
                                <button type="button" onclick="handleGlobalBookNow()" class="text-xs text-slate-400 hover:text-[#22C55E] underline cursor-pointer">
                                    Select Seats &amp; Reserve
                                </button>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Row: Copyright & Legal Links -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                © {{ date('Y') }} PickMeRoute. All rights reserved.
            </div>

            <div class="flex items-center gap-6 text-slate-400">
                <a href="#about" class="hover:text-white transition">Privacy Policy</a>
                <a href="#services" class="hover:text-white transition">Terms &amp; Conditions</a>
            </div>
        </div>

    </div>
</footer>
