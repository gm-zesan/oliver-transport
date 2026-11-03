@extends('frontend.layout.app')

@section('title', 'Passenger Portal — Oliver Transport')

@section('content')
    <!-- Dashboard Header Hero with Consistent Brand Palette -->
    <section class="relative bg-[#111827] pt-32 pb-16 sm:pt-36 sm:pb-20 border-b border-slate-800 text-white overflow-hidden">
        <!-- Ambient Green Aura Glow -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <span class="inline-block text-xs font-black tracking-widest text-[#22C55E] uppercase mb-2">
                        PASSENGER PORTAL
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight font-heading text-white">
                        Welcome back, {{ $user->name }}
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-slate-300">
                        Email: <span class="text-white font-medium">{{ $user->email }}</span> • Phone: <span class="text-white font-medium">{{ $user->phone ?? '647-655-1884' }}</span>
                    </p>
                </div>

                <!-- Quick Action Button -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}#booking-panel" 
                       class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-3 text-sm font-bold shadow-lg shadow-[#22C55E]/20 transition cursor-pointer">
                        <span>Book New Trip</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Content Area with Site Standard Background -->
    <section class="py-12 sm:py-16 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- 3 Stat / Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                
                <!-- Card 1: Fixed Corridor Route -->
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Primary Corridor</span>
                        <span class="text-lg font-black text-[#111827]">Montreal ↔ Toronto</span>
                        <span class="text-xs text-slate-500 block">3 Fixed Stations</span>
                    </div>
                </div>

                <!-- Card 2: Dedicated Fleet -->
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Executive Fleet</span>
                        <span class="text-lg font-black text-[#111827]">Honda Odyssey</span>
                        <span class="text-xs text-slate-500 block">License Plate: RAJIA</span>
                    </div>
                </div>

                <!-- Card 3: Standard Fare Model -->
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold font-mono text-[#22C55E]">$</span>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#64748B] block">Guaranteed Rate</span>
                        <span class="text-lg font-black text-[#111827]">$65 CAD <span class="text-xs font-medium text-slate-500">/ seat</span></span>
                        <span class="text-xs text-slate-500 block">Cash On Boarding</span>
                    </div>
                </div>

            </div>

            <!-- Booking & Activity Status Container -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-8 sm:p-10 shadow-sm text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F0FDF4] text-[#22C55E] mb-5 border border-[#22C55E]/20">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-black text-[#111827] tracking-tight font-heading">
                    Ready to Book Your Next Journey?
                </h2>
                <p class="mt-2.5 max-w-xl mx-auto text-sm text-[#64748B] leading-relaxed">
                    Select your preferred travel date, pick your exact seat (S1–S6) on our interactive vehicle cabin diagram, and confirm your reservation with cash settlement upon boarding.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('home') }}#booking-panel" 
                       class="inline-flex min-h-[48px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-8 py-3.5 text-sm font-bold shadow-md hover:shadow-lg transition">
                        <span>Select Seats &amp; Reserve</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="{{ route('contact') }}" 
                       class="inline-flex min-h-[48px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 px-8 py-3.5 text-sm font-bold border border-slate-200 transition">
                        <span>Contact Dispatch (647-655-1884)</span>
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection
