@extends('layouts.passenger')

@section('title', 'Passenger Portal — Oliver Transport')

@section('passenger_content')
    <div class="space-y-8">
        <!-- 4 Quick Highlight Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: My Reservations Link -->
            <a href="{{ route('passenger.bookings.index') }}" 
               class="group rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs hover:shadow-md hover:border-[#22C55E]/40 transition flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Bookings</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block font-mono">
                        {{ $totalBookingsCount ?? 0 }}
                    </span>
                    <span class="text-xs font-semibold text-[#16A34A] group-hover:underline inline-flex items-center gap-1 mt-1">
                        View passes →
                    </span>
                </div>
                <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
            </a>

            <!-- Card 2: Fixed Corridor -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Fixed Corridor</span>
                    <span class="text-base font-black text-slate-900 mt-1 block">Montreal ↔ Toronto</span>
                    <span class="text-xs text-slate-500 block mt-0.5">3 Fixed Stations</span>
                </div>
                <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
            </div>

            <!-- Card 3: Cash Settlement Notice -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Settlement Model</span>
                    <span class="text-base font-black text-slate-900 mt-1 block">Cash on Boarding</span>
                    <span class="text-xs text-slate-500 block mt-0.5">Pay Rider in Van</span>
                </div>
                <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 4: Operating Fleet -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Fleet &amp; Capacity</span>
                    <span class="text-base font-black text-slate-900 mt-1 block">Honda Odyssey</span>
                    <span class="text-xs text-slate-500 block mt-0.5 font-mono">Plate: RAJIA (6 Seats)</span>
                </div>
                <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- Recent Reservations Section -->
        <div class="rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 font-heading">
                        Recent Reservations
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Your latest reserved seats for Montreal ↔ Toronto daily shuttles
                    </p>
                </div>
                
                <a href="{{ route('passenger.bookings.index') }}" 
                   class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#16A34A] hover:underline">
                    <span>View all bookings ({{ $totalBookingsCount ?? 0 }})</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Bookings List or Empty State -->
            @if(isset($recentBookings) && $recentBookings->isNotEmpty())
                <div class="mt-6 divide-y divide-slate-100">
                    @foreach($recentBookings as $booking)
                        <div class="py-4.5 sm:py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 hover:bg-slate-50/50 rounded-2xl px-3 -mx-3 transition">
                            
                            <!-- Left: Route & Date -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs font-black text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md">
                                        {{ $booking->booking_reference }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                        {{ $booking->status }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Cash on Boarding
                                    </span>
                                </div>

                                <div class="text-sm font-black text-slate-900 flex items-center gap-2 pt-0.5">
                                    <span>{{ $booking->boardingStop?->location?->name ?? 'Namur Station' }}</span>
                                    <span class="text-slate-400">→</span>
                                    <span>{{ $booking->dropoffStop?->location?->name ?? 'Yorkdale Mall' }}</span>
                                </div>

                                <div class="text-xs text-slate-500 flex items-center gap-3">
                                    <span>Travel Date: {{ \Carbon\Carbon::parse($booking->trip?->trip_date)->format('M d, Y') }}</span>
                                    <span>•</span>
                                    <span>Seats: {{ $booking->seat_count }} ({{ $booking->bookingSeats?->pluck('vehicleSeat.seat_number')->filter()->implode(', ') ?: 'Assigned' }})</span>
                                </div>
                            </div>

                            <!-- Right: Price & Voucher Button -->
                            <div class="flex items-center justify-between sm:justify-end gap-4">
                                <div class="text-left sm:text-right">
                                    <div class="text-base font-black text-slate-900 font-mono">
                                        ${{ number_format($booking->final_fare, 2) }} CAD
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium">
                                        Settlement on van
                                    </span>
                                </div>

                                <a href="{{ route('passenger.bookings.show', $booking->booking_reference) }}" 
                                   class="inline-flex min-h-[44px] items-center justify-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 text-xs font-bold transition shadow-xs">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Boarding Pass</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="mt-8 text-center py-10 px-4">
                    <div class="mx-auto h-16 w-16 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                        <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-heading">No Reservations Found</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto mt-1">
                        You don't have any shuttle bookings yet. Ready to travel between Montreal and Toronto?
                    </p>
                    <div class="mt-5">
                        <button type="button" onclick="handleGlobalBookNow()" 
                                class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold shadow-md shadow-[#22C55E]/20 transition cursor-pointer">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Book Montreal ↔ Toronto Shuttle</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Need Help Card -->
        <div class="rounded-3xl border border-emerald-200/80 bg-[#F0FDF4] p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
            <div>
                <h3 class="text-base font-black text-slate-900 font-heading">
                    Need Dispatch Assistance or Have Luggage Questions?
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Our direct dispatch line is available daily 7 days a week for scheduling support.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="tel:6476551884" 
                   class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-white border border-emerald-300 text-[#16A34A] px-5 py-2.5 text-xs sm:text-sm font-bold shadow-xs hover:bg-emerald-50 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>Call 647-655-1884</span>
                </a>
            </div>
        </div>
    </div>
@endsection
