@extends('frontend.layout.app')

@section('title', 'Contact Us — Oliver Transport Montreal ↔ Toronto Passenger Shuttle')

@section('content')
    <!-- Contact Page Header -->
    <section class="relative bg-[#111827] pt-32 pb-16 sm:pt-36 sm:pb-20 border-b border-slate-800 text-white overflow-hidden">
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block text-xs font-black tracking-widest text-[#22C55E] uppercase mb-3">
                GET IN TOUCH
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading text-white">
                Contact Oliver Transport
            </h1>
            <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Have questions regarding our daily Montreal ↔ Toronto shuttle, booking assistance, or group charters? We are here to help.
            </p>
        </div>
    </section>

    <!-- Contact Details & Inquiry Form Section -->
    <section class="py-16 sm:py-24 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                <!-- Left Column: Verified Contact Cards (5 cols) -->
                <div class="lg:col-span-5 space-y-5">

                    <!-- Phone Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-start gap-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Direct Telephone / SMS / WhatsApp</span>
                            <a href="tel:6476551884" class="text-xl sm:text-2xl font-black text-[#111827] hover:text-[#22C55E] transition font-mono mt-0.5 block">
                                647-655-1884
                            </a>
                            <span class="text-xs text-slate-500 mt-1 block">Live 7 days a week: 6:00 AM – 9:00 PM EST</span>
                        </div>
                    </div>

                    <!-- Email Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-start gap-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Official Email</span>
                            <a href="mailto:info@olivertransport.ca" class="text-base sm:text-lg font-bold text-[#111827] hover:text-[#22C55E] transition mt-0.5 block">
                                info@olivertransport.ca
                            </a>
                            <span class="text-xs text-slate-500 mt-1 block">Inquiries, charters, and booking support</span>
                        </div>
                    </div>

                    <!-- Station Hubs Summary Card -->
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Fixed Corridor Hubs</span>
                        
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <span class="h-6 w-6 rounded-full bg-[#22C55E]/15 text-[#16A34A] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</span>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Station Métro Namur (Montreal)</h4>
                                    <p class="text-xs text-slate-500">Route A pickup (6:30 AM EST) &amp; Route B final drop-off (~7:15 PM EST)</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="h-6 w-6 rounded-full bg-[#22C55E]/15 text-[#16A34A] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</span>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Yorkdale Mall (Toronto)</h4>
                                    <p class="text-xs text-slate-500">Route A 1st drop-off &amp; Route B 1st pickup (12:15 PM EST)</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="h-6 w-6 rounded-full bg-[#22C55E]/15 text-[#16A34A] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</span>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Yonge Station (Toronto)</h4>
                                    <p class="text-xs text-slate-500">Route A 2nd drop-off &amp; Route B 2nd pickup (1:15 PM EST)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Contact Inquiry Form (7 cols) -->
                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-8 sm:p-10 shadow-sm">
                        <h3 class="text-2xl font-black text-[#111827] tracking-tight font-heading mb-2">
                            Send Us an Inquiry
                        </h3>
                        <p class="text-xs sm:text-sm text-[#64748B] mb-8">
                            Fill out the form below and our dispatch coordinator will respond promptly.
                        </p>

                        <form action="javascript:void(0);" onsubmit="alert('Thank you for contacting Oliver Transport! Our dispatch team will reach out to you shortly.')" class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Your Name</label>
                                    <input type="text" required placeholder="John Doe" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Phone Number</label>
                                    <input type="tel" required placeholder="647-xxx-xxxx" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Email Address</label>
                                <input type="email" required placeholder="john@example.com" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition" />
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Preferred Route / Service</label>
                                <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition">
                                    <option value="route-a">Route A: Montreal → Toronto (6:30 AM)</option>
                                    <option value="route-b">Route B: Toronto → Montreal (12:15 PM &amp; 1:15 PM)</option>
                                    <option value="private-charter">Private Full Van Charter (All 6 Seats)</option>
                                    <option value="general">General Inquiry</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Your Message</label>
                                <textarea rows="4" required placeholder="Let us know your travel date, passenger count, or questions..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:bg-white transition"></textarea>
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white py-4 text-sm font-bold shadow-md hover:shadow-lg transition cursor-pointer">
                                Submit Inquiry
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

