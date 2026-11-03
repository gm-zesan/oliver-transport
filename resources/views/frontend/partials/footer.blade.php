<!-- Footer (2 Sections Matching Reference Design) -->

<!-- SECTION 1: Vehicle Feature Promo Card -->
<section class="py-20 lg:py-28 bg-[#F8FAFC]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight font-heading">
                Only $65 CAD / Trip
            </h2>
            <p class="mt-4 text-sm sm:text-base text-slate-600 font-medium max-w-xl mx-auto leading-relaxed">
                Take advantage of our daily scheduled intercity passenger shuttle, securing a comfortable reserved seat between Montreal and Toronto.
            </p>
        </div>

        <!-- Vehicle Card (Matching Reference Layout) -->
        <div class="rounded-[2.5rem] bg-[#F1F3F7] p-8 sm:p-12 lg:p-14 relative overflow-hidden border border-slate-200/60 shadow-xs">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                
                <!-- Left Details (7 cols) -->
                <div class="lg:col-span-7 flex flex-col justify-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight font-heading">
                        Honda Odyssey
                    </h3>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-[#16A34A]">
                        Ontario Commercial Fleet • Plate: RAJIA
                    </p>

                    <!-- 2-Column Checkmark Specifications (Exact Reference Layout) -->
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-y-3.5 gap-x-6 text-sm font-semibold text-slate-700">
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>For Up to 6 Passengers</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tinted Privacy Windows</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>6 Passenger Seats</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Climate-Controlled Air Care</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Front Window &amp; Rear Rows</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Daily Morning &amp; Return</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Metro &amp; Subway Connections</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-slate-900 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Cash Payment Upon Boarding</span>
                        </div>
                    </div>

                    <!-- Reserve Now Button -->
                    <div class="mt-9 flex items-center gap-4">
                        @auth
                            @php
                                $dashboardRoute = auth()->user()->isRider() 
                                    ? route('rider.dashboard') 
                                    : (auth()->user()->isOperator() ? route('operator.dashboard') : route('passenger.dashboard'));
                            @endphp
                            <a href="{{ $dashboardRoute }}" 
                               class="inline-flex min-h-[48px] items-center justify-center rounded-2xl bg-slate-900 hover:bg-black text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-md hover:shadow-xl transition duration-200">
                                <span>Go to Dashboard</span>
                            </a>
                        @else
                            <button type="button" 
                                    onclick="openAuthModal()" 
                                    class="inline-flex min-h-[48px] items-center justify-center rounded-2xl bg-slate-900 hover:bg-black text-white px-8 py-3.5 text-sm sm:text-base font-bold shadow-md hover:shadow-xl transition duration-200 cursor-pointer">
                                <span>Reserve Now</span>
                            </button>
                            <a href="{{ route('login') }}" 
                               class="inline-flex min-h-[44px] items-center text-xs font-bold text-slate-700 hover:text-[#22C55E] transition px-2 py-1">
                                Book Your Seat
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Vehicle Image (5 cols) -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end">
                    <img src="{{ asset('images/hero-video-poster.jpg') }}" 
                         alt="Oliver Transport Silver Honda Odyssey Chauffeur Minivan" 
                         class="w-full max-w-md lg:max-w-none rounded-3xl object-cover shadow-xl border border-white/60 aspect-[16/10]" />
                </div>

            </div>
        </div>
    </div>
</section>

<!-- SECTION 2: Dark Curved Global Footer -->
<footer id="contact" class="rounded-t-[3rem] bg-[#1E232A] text-slate-300 pt-16 sm:pt-20 pb-10 border-t border-slate-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 pb-14 border-b border-slate-800">
            
            <!-- Column 1: Brand & Newsletter Pill (4 cols) -->
            <div class="lg:col-span-4 space-y-5">
                <div>
                    <a href="{{ route('home') }}" class="inline-block">
                        <x-brand-logo size="md" :inverted="true" />
                    </a>
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#22C55E] mt-2">
                        Montreal • Toronto • Montreal
                    </p>
                </div>

                <div class="pt-2">
                    <p class="text-sm font-semibold text-white">Subscribe to the newsletter</p>
                    <p class="text-xs text-slate-400 mt-1">Receive departure alerts, schedule updates, and corridor notices.</p>
                    
                    <!-- Newsletter Pill Input matching Reference -->
                    <form action="#" method="POST" onsubmit="event.preventDefault();" class="mt-4 flex items-center rounded-2xl bg-[#2A313C] border border-slate-700/80 p-1.5 max-w-xs focus-within:ring-2 focus-within:ring-[#22C55E]">
                        <input type="email" 
                               placeholder="Email ..." 
                               class="w-full bg-transparent px-3 text-xs sm:text-sm text-white placeholder-slate-400 focus:outline-none" />
                        <button type="submit" 
                                class="flex-shrink-0 h-9 w-9 rounded-xl bg-white text-slate-900 flex items-center justify-center hover:bg-slate-200 transition" 
                                aria-label="Subscribe">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Column 2: Top stations (matching 'Top cities' in reference) (3 cols) -->
            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-sm font-bold text-white tracking-wide">Top stations</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                    <li><a href="#schedule" class="hover:text-white transition">Station Métro Namur (Montreal)</a></li>
                    <li><a href="#schedule" class="hover:text-white transition">Yorkdale Mall (Toronto)</a></li>
                    <li><a href="#schedule" class="hover:text-white transition">Yonge Station (Toronto)</a></li>
                    <li><a href="#schedule" class="hover:text-white transition">Orange Subway Line Connection</a></li>
                    <li><a href="#schedule" class="hover:text-white transition">TTC Subway 1 &amp; 2 Interchange</a></li>
                </ul>
            </div>

            <!-- Column 3: Explore (2 cols) -->
            <div class="lg:col-span-2 space-y-4">
                <h4 class="text-sm font-bold text-white tracking-wide">Explore</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                    <li><a href="#schedule" class="hover:text-white transition">Intercity routes</a></li>
                    <li><a href="#fares" class="hover:text-white transition">Fixed standard fare</a></li>
                    <li><a href="#fleet" class="hover:text-white transition">Honda Odyssey fleet</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Book Your Seat</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Passenger Sign In</a></li>
                </ul>
            </div>

            <!-- Column 4: Intercity rides (3 cols) -->
            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-sm font-bold text-white tracking-wide">Intercity rides</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                    <li><span class="text-slate-300 font-medium">Route A: Montreal → Toronto (6:30 AM)</span></li>
                    <li><span class="text-slate-300 font-medium">Route B: Toronto → Montreal (12:15 PM &amp; 1:15 PM)</span></li>
                    <li>
                        <a href="tel:6476551884" class="text-white font-bold hover:text-[#22C55E] transition inline-flex items-center gap-1.5 pt-1">
                            <span>Phone/SMS:</span>
                            <span class="text-[#22C55E]">647-655-1884</span>
                        </a>
                    </li>
                    <li>
                        <span class="text-slate-300">Facebook: <strong class="text-white">Oliver Transport</strong></span>
                    </li>
                    <li>
                        <span class="text-xs text-slate-500">Settlement: Cash collected physically at boarding ($65 CAD)</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Row: Copyright, Legal Links, and Social Icons -->
        <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-slate-500">
            <!-- Copyright Left -->
            <div>
                © {{ date('Y') }} Oliver Transport. All rights reserved.
            </div>

            <!-- Legal Middle -->
            <div class="flex flex-wrap items-center gap-6 text-slate-400">
                <a href="#fares" class="hover:text-white transition">Terms</a>
                <a href="#contact" class="hover:text-white transition">Privacy policy</a>
                <a href="#features" class="hover:text-white transition">Legal notice</a>
                <a href="#schedule" class="hover:text-white transition">Accessibility</a>
            </div>

            <!-- Social Icons Right (Reference Style: YouTube, Facebook, Twitter, Instagram, LinkedIn) -->
            <div class="flex items-center gap-4 text-slate-400">
                <!-- YouTube -->
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="YouTube">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                <!-- Facebook -->
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Facebook">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <!-- Twitter / X -->
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Twitter">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="Instagram">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <!-- LinkedIn -->
                <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition" aria-label="LinkedIn">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
            </div>
        </div>

    </div>
</footer>
