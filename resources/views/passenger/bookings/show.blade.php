@extends('layouts.passenger')

@section('title', __('Booking Voucher') . ' ' . $booking->booking_reference . ' — PickMeRoute')

@push('styles')
<style>
    /* Print-Only Isolation Styles: Print strictly the digital ticket card on a single clean page */
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }

        /* Suppress global navigation, hero headers, footers and interactive action buttons */
        html, body {
            background: #FFFFFF !important;
            color: #0F172A !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 12px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #site-header,
        header,
        footer,
        #passenger-hero-section,
        .print\:hidden,
        .print-hidden {
            display: none !important;
        }

        main {
            margin: 0 !important;
            padding: 0 !important;
            flex: none !important;
        }

        #ticket-content-section {
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
        }

        #ticket-content-section > div {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Digital Ticket Card Print Styling */
        #digital-ticket-card {
            box-shadow: none !important;
            border: 2px solid #0F172A !important;
            border-radius: 16px !important;
            max-width: 100% !important;
            margin: 0 auto !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            background: #FFFFFF !important;
        }

        /* High-contrast header for print */
        #ticket-banner {
            background: #0F172A !important;
            color: #FFFFFF !important;
            padding: 16px 20px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .ticket-detail-card {
            border: 1px solid #CBD5E1 !important;
            background: #F8FAFC !important;
            padding: 10px !important;
            border-radius: 12px !important;
        }

        #ticket-settlement-card {
            border: 1.5px solid #16A34A !important;
            background: #F0FDF4 !important;
            padding: 12px !important;
            border-radius: 12px !important;
        }

        /* Show the driver signature box only when printing */
        .print-only-signature {
            display: block !important;
        }
    }
</style>
@endpush

@section('hero_title', __('Booking Voucher') . ' ' . $booking->booking_reference)

@section('hero_meta')
    <span class="inline-flex items-center gap-1.5 bg-white/10 text-slate-200 border border-white/15 backdrop-blur-md px-2.5 py-1 rounded-xl">
        <svg class="h-3.5 w-3.5 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>{{ __('Travel Date:') }} {{ \Carbon\Carbon::parse($booking->trip->trip_date)->format('D, M j, Y') }}</span>
    </span>
@endsection

@section('hero_action')
    <div class="flex items-center gap-3">
        <button type="button" 
                onclick="window.print()" 
                class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2 text-xs sm:text-sm font-bold backdrop-blur-md transition cursor-pointer shadow-xs">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>{{ __('Print Pass') }}</span>
        </button>
        <a href="{{ route('passenger.bookings.index') }}" 
           class="inline-flex min-h-[44px] items-center justify-center gap-1.5 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-4 py-2 text-xs sm:text-sm font-bold shadow-md shadow-[#22C55E]/20 transition">
            <span>{{ __('← All Bookings') }}</span>
        </a>
    </div>
@endsection

@section('passenger_content')
    <div id="ticket-content-section">
        <div class="max-w-4xl mx-auto">
            <!-- Digital Airline-Style Boarding Pass Voucher Card -->
            <div id="digital-ticket-card" class="rounded-3xl border border-slate-200/90 bg-white shadow-xl overflow-hidden transition">
                
                <!-- Ticket Top Header Banner -->
                <div id="ticket-banner" class="bg-slate-900 text-white p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#22C55E]/15 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-black uppercase tracking-widest text-[#22C55E]">
                                    PickMeRoute {{ __('Express') }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black tracking-tight font-heading mt-1">
                                {{ __('Passenger Boarding Voucher') }}
                            </h2>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="text-[11px] font-bold text-slate-400 block uppercase tracking-wider">
                                {{ __('Booking Reference') }}
                            </span>
                            <span class="font-mono text-2xl font-black text-white tracking-widest">
                                {{ $booking->booking_reference }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Main Ticket Body: Origin ↔ Destination & Trip Logistics -->
                <div class="p-6 sm:p-8 space-y-6">
                    
                    <!-- Route Flow Display -->
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        
                        <!-- Departure (Boarding) -->
                        <div class="flex-1 space-y-1">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-[#16A34A]">
                                <span class="h-2 w-2 rounded-full bg-[#22C55E]"></span>
                                <span>{{ __('Boarding Station') }}</span>
                            </span>
                            <div class="text-xl font-black text-slate-900 font-heading">
                                {{ $booking->boardingStop->location->localized_name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $booking->boardingStop->location->localized_city }}
                            </div>
                            <div class="text-xs font-bold text-slate-700 font-mono mt-1 pt-1 border-t border-slate-200/60">
                                {{ __('Scheduled Boarding:') }} <span class="text-[#16A34A]">{{ substr($booking->boardingStop->scheduled_time ?? $booking->trip->scheduled_departure_time, 0, 5) }} EST</span>
                            </div>
                        </div>

                        <!-- Route Graphic -->
                        <div class="flex md:flex-col items-center justify-center gap-2 text-slate-400 px-4">
                            <span class="text-xs font-mono font-bold text-slate-500 hidden md:inline">{{ __('Express') }}</span>
                            <svg class="h-6 w-6 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            <span class="text-[11px] text-slate-400 font-medium">{{ __('Daily Direct') }}</span>
                        </div>

                        <!-- Arrival (Dropoff) -->
                        <div class="flex-1 space-y-1 text-left md:text-right">
                            <span class="inline-flex md:justify-end items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-slate-500">
                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                <span>{{ __('Dropoff Station') }}</span>
                            </span>
                            <div class="text-xl font-black text-slate-900 font-heading">
                                {{ $booking->dropoffStop->location->localized_name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $booking->dropoffStop->location->localized_city }}
                            </div>
                            <div class="text-xs font-bold text-slate-700 font-mono mt-1 pt-1 border-t border-slate-200/60">
                                {{ __('Scheduled Arrival:') }} <span class="text-slate-900">{{ substr($booking->dropoffStop->scheduled_time ?? 'TBD', 0, 5) }} EST</span>
                            </div>
                        </div>

                    </div>

                    <!-- 3-Column Ticket Details: Passenger, Vehicle & Seats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        
                        <!-- Passenger Details -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-2xs">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                {{ __('Passenger Name') }}
                            </span>
                            <div class="text-base font-black text-slate-900 font-heading">
                                {{ $booking->user->name }}
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $booking->user->email }}
                            </div>
                            @if($booking->user->phone)
                                <div class="text-xs text-slate-600 font-mono mt-1">
                                    {{ $booking->user->phone }}
                                </div>
                            @endif
                        </div>

                        <!-- Fleet & Vehicle Details -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-2xs">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                {{ __('Vehicle & Plate') }}
                            </span>
                            <div class="text-base font-black text-slate-900 font-heading">
                                Honda Odyssey
                            </div>
                            <div class="text-xs font-mono font-bold text-[#16A34A] mt-0.5">
                                License Plate: RAJIA
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                Silver Minivan • 6 Seats
                            </div>
                        </div>

                        <!-- Assigned Seats -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-2xs">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                {{ __('Assigned Seats (:count)', ['count' => $booking->seat_count]) }}
                            </span>
                            <div class="flex flex-wrap gap-1.5 mt-1">
                                @foreach($booking->bookingSeats as $bs)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#F0FDF4] border border-emerald-200 text-[#16A34A] font-black font-mono text-sm">
                                        {{ $bs->vehicleSeat->seat_number }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="text-[11px] text-slate-500 mt-1.5">
                                {{ __('Visual cabin selection') }}
                            </div>
                        </div>

                    </div>

                    <!-- Mandatory Cash Settlement Box -->
                    <div id="ticket-settlement-card" class="rounded-2xl border-2 border-emerald-500/80 bg-[#F0FDF4] p-5 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <span class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-[#16A34A] mb-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ __('Cash Payment Settlement Upon Boarding') }}</span>
                                </span>
                                <h3 class="text-base font-black text-slate-900 font-heading">
                                    {{ __('Exact Cash Settlement Required') }}
                                </h3>
                                <p class="text-xs text-slate-600 mt-0.5">
                                    {{ __('Please present this voucher and hand the exact cash fare to the Rider (driver) upon boarding the vehicle.') }}
                                </p>
                            </div>

                            <div class="text-left sm:text-right flex-shrink-0">
                                <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">
                                    {{ __('Total Cash Due') }}
                                </span>
                                <span class="text-2xl sm:text-3xl font-black font-mono text-slate-900">
                                    ${{ number_format((float) $booking->final_fare, 2) }} CAD
                                </span>
                                <span class="text-xs font-semibold text-[#16A34A] block mt-0.5">
                                    Status: {{ ucfirst($booking->payment?->status ?? 'unpaid') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Physical Receipt / Signature Box (Active for Print) -->
                    <div class="print-only-signature hidden pt-4 border-t border-slate-300">
                        <div class="grid grid-cols-2 gap-8 text-xs">
                            <div>
                                <span class="block text-slate-500 font-bold mb-8">{{ __('Rider / Driver Signature:') }}</span>
                                <div class="border-b border-slate-400"></div>
                            </div>
                            <div>
                                <span class="block text-slate-500 font-bold mb-8">{{ __('Cash Received Timestamp:') }}</span>
                                <div class="border-b border-slate-400"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Boarding Instructions Footnote -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                        <div>
                            <span>{{ __('Questions or running late? Contact Dispatch: ') }}</span>
                            <a href="tel:6476551884" class="font-bold text-[#16A34A] hover:underline">
                                647-655-1884
                            </a>
                        </div>
                        <div class="text-slate-400 text-[11px]">
                            {{ __('Please arrive 10 minutes prior to scheduled departure.') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
