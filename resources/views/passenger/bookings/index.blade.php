@extends('layouts.passenger')

@section('title', 'My Reservations — Oliver Transport')

@section('hero_title', 'My Reservations')

@section('hero_meta')
    <span class="inline-flex items-center gap-1.5 bg-white/10 text-slate-200 border border-white/15 backdrop-blur-md px-2.5 py-1 rounded-xl">
        <svg class="h-3.5 w-3.5 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <span>Confirmed Passes &amp; Boarding Vouchers ({{ $bookings->total() }})</span>
    </span>
@endsection

@section('passenger_content')
    <div>
        @if($bookings->isEmpty())
            <div class="rounded-3xl border border-slate-200/90 bg-white p-8 sm:p-14 text-center shadow-xs max-w-2xl mx-auto">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-[#F0FDF4] text-[#22C55E] mb-4 border border-[#22C55E]/20">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-heading">
                    No Active Reservations Yet
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-md mx-auto">
                    You have not placed any seat bookings. Book your seat between Montreal and Toronto with guaranteed reserved seating and cash settlement on boarding.
                </p>
                <div class="mt-6">
                    <button type="button" onclick="handleGlobalBookNow()" 
                       class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-6 py-2.5 text-xs sm:text-sm font-bold shadow-md shadow-[#22C55E]/20 transition cursor-pointer">
                        <span>Reserve a Seat Now</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $b)
                    <div class="rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-xs hover:shadow-md hover:border-[#22C55E]/30 transition">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            
                            <div class="space-y-2.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-mono text-xs sm:text-sm font-black text-slate-900 bg-slate-100 px-2.5 py-0.5 rounded-md">
                                        {{ $b->booking_reference }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#F0FDF4] text-[#16A34A] border border-emerald-200">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-600">
                                        • Cash Due: <strong class="text-slate-900 font-mono">${{ number_format((float) $b->final_fare, 2) }} CAD</strong>
                                    </span>
                                    <span class="text-[11px] text-slate-400">
                                        (Pay to Driver on Boarding)
                                    </span>
                                </div>

                                <h3 class="text-lg sm:text-xl font-black text-slate-900 font-heading">
                                    {{ $b->boardingStop->location->name }} → {{ $b->dropoffStop->location->name }}
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-slate-600 pt-1">
                                    <div>
                                        <span class="text-slate-400 block text-[11px] font-medium">Travel Date:</span>
                                        <strong class="text-slate-900 font-semibold">{{ \Carbon\Carbon::parse($b->trip->trip_date)->format('D, M j, Y') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px] font-medium">Boarding Time:</span>
                                        <strong class="text-[#16A34A] font-mono font-bold">{{ substr($b->boardingStop->scheduled_time ?? $b->trip->scheduled_departure_time, 0, 5) }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px] font-medium">Assigned Seats:</span>
                                        <div class="flex flex-wrap gap-1 mt-0.5">
                                            @foreach($b->bookingSeats as $bs)
                                                <span class="inline-block px-2 py-0.5 rounded-md bg-[#F0FDF4] border border-emerald-200 text-[#16A34A] font-black font-mono text-[11px]">
                                                    {{ $bs->vehicleSeat->seat_number }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 flex-shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                                <a href="{{ route('passenger.bookings.show', $b->booking_reference) }}" 
                                   class="inline-flex min-h-[44px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold shadow-md shadow-[#22C55E]/15 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    <span>Digital Boarding Pass</span>
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
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
@endsection
