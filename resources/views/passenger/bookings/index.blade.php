@extends('frontend.layout.app')

@section('title', 'My Reservations — Oliver Transport')

@section('content')
    <!-- Header Section -->
    <section class="relative bg-[#111827] pt-28 pb-12 sm:pt-32 sm:pb-16 border-b border-slate-800 text-white overflow-hidden">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-xs font-black tracking-widest text-[#22C55E] uppercase block mb-1">
                        PASSENGER PORTAL
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black font-heading text-white tracking-tight">
                        My Reservations
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1">
                        View upcoming intercity shuttle reservations, view digital boarding passes, and check trip details.
                    </p>
                </div>

                <div>
                    <a href="{{ route('home') }}#booking-panel" 
                       class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition cursor-pointer">
                        <span>Book New Journey</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Reservations List Section -->
    <section class="py-10 sm:py-14 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if($bookings->isEmpty())
                <div class="rounded-3xl border border-slate-200/80 bg-white p-12 text-center shadow-xs max-w-2xl mx-auto">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F0FDF4] text-[#22C55E] mb-4 border border-[#22C55E]/20">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-[#111827] tracking-tight font-heading">
                        No Reservations Found
                    </h2>
                    <p class="mt-2 text-sm text-[#64748B] leading-relaxed">
                        You have not placed any seat reservations yet. Select your travel date and choose your preferred seats on our Honda Odyssey minivan.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}#booking-panel" 
                           class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-2.5 text-xs sm:text-sm font-bold shadow-xs transition">
                            Book a Journey
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $b)
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs hover:shadow-md transition">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                
                                <div class="space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-mono text-base font-black text-slate-900">
                                            {{ $b->booking_reference }}
                                        </span>
                                        <span class="text-xs font-bold text-[#16A34A] uppercase tracking-wider">
                                            {{ ucfirst($b->status) }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-500">
                                            • Cash Due: ${{ number_format((float) $b->final_fare, 2) }} CAD
                                        </span>
                                    </div>

                                    <h3 class="text-lg sm:text-xl font-bold text-[#111827]">
                                        {{ $b->boardingStop->location->name }} → {{ $b->dropoffStop->location->name }}
                                    </h3>

                                    <div class="flex flex-wrap items-center gap-4 text-xs text-[#64748B]">
                                        <div>
                                            Date: <strong class="text-slate-900">{{ \Carbon\Carbon::parse($b->trip->trip_date)->format('D, M j, Y') }}</strong>
                                        </div>
                                        <div>
                                            Departure: <strong class="text-slate-900">{{ substr($b->boardingStop->scheduled_time ?? $b->trip->scheduled_departure_time, 0, 5) }}</strong>
                                        </div>
                                        <div>
                                            Seats: 
                                            @foreach($b->bookingSeats as $bs)
                                                <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-800 font-bold font-mono">
                                                    {{ $bs->vehicleSeat->seat_number }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-shrink-0">
                                    <a href="{{ route('passenger.bookings.show', $b->booking_reference) }}" 
                                       class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-5 py-2.5 text-xs sm:text-sm font-bold transition">
                                        <span>View Boarding Pass</span>
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            @endif

        </div>
    </section>
@endsection

