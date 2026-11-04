@extends('frontend.layout.app')

@section('title', 'Boarding Pass ' . $booking->booking_reference . ' — Oliver Transport')

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
        #ticket-hero-section,
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

@section('content')
    <!-- Interactive Header Section (Hidden on Print) -->
    <section id="ticket-hero-section" class="print:hidden relative bg-[#111827] pt-28 pb-12 sm:pt-32 sm:pb-16 border-b border-slate-800 text-white overflow-hidden">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#22C55E]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4 mb-4">
                <a href="{{ route('passenger.bookings.index') }}" 
                   class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-300 hover:text-[#22C55E] transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>My Reservations</span>
                </a>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Digital Boarding Pass</span>
                    <h1 class="text-3xl sm:text-4xl font-black font-mono text-white tracking-tight mt-0.5">
                        {{ $booking->booking_reference }}
                    </h1>
                </div>

                <div class="flex items-center gap-2.5">
                    <button type="button" onclick="window.print()" 
                            class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-2.5 text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Print Ticket Only</span>
                    </button>

                    <a href="{{ route('passenger.bookings.index') }}" 
                       class="inline-flex min-h-[44px] items-center justify-center rounded-xl bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 text-xs sm:text-sm font-bold border border-slate-700 transition">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Boarding Pass Card Section -->
    <section id="ticket-content-section" class="py-8 sm:py-12 bg-[#F8FAFC]">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <!-- THE DIGITAL TICKET CARD (Isolated for Printing) -->
            <div id="digital-ticket-card" class="rounded-3xl border border-slate-200/90 bg-white shadow-xl overflow-hidden">
                
                <!-- Ticket Route Banner -->
                <div id="ticket-banner" class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 p-6 sm:p-7 text-white border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2.5">
                            <x-brand-logo size="sm" :inverted="true" />
                            <span class="text-[11px] font-black uppercase tracking-widest text-[#22C55E] font-mono">
                                DIGITAL BOARDING PASS
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight font-heading mt-2">
                            {{ $booking->boardingStop->location->name }} → {{ $booking->dropoffStop->location->name }}
                        </h2>
                        <span class="text-xs text-slate-400 block font-medium">
                            {{ $booking->trip->route->name }} • Montreal ↔ Toronto Shuttle Service
                        </span>
                    </div>

                    <div class="sm:text-right space-y-1">
                        <span class="text-[11px] uppercase tracking-wider text-slate-400 block font-semibold">Travel Date</span>
                        <span class="text-base sm:text-lg font-bold text-white block font-mono">
                            {{ \Carbon\Carbon::parse($booking->trip->trip_date)->format('D, M j, Y') }}
                        </span>
                        <span class="inline-block mt-1 font-mono text-xs font-black text-[#22C55E] px-2.5 py-0.5 rounded-md bg-white/10 border border-white/10">
                            REF: {{ $booking->booking_reference }}
                        </span>
                    </div>
                </div>

                <!-- Ticket Core Details -->
                <div class="p-6 sm:p-8 space-y-5">

                    <!-- Grid: Departure, Arrival, Seats, Vehicle -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        
                        <!-- Station 1: Departure -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Boarding Station</span>
                            <span class="text-sm font-bold text-slate-900 block mt-1">
                                {{ $booking->boardingStop->location->name }}
                            </span>
                            <span class="text-xs text-[#16A34A] font-bold block mt-0.5">
                                Departure: {{ substr($booking->boardingStop->scheduled_time ?? $booking->trip->scheduled_departure_time, 0, 5) }}
                            </span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">
                                {{ $booking->boardingStop->location->city }}
                            </span>
                        </div>

                        <!-- Station 2: Drop-off -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Drop-off Station</span>
                            <span class="text-sm font-bold text-slate-900 block mt-1">
                                {{ $booking->dropoffStop->location->name }}
                            </span>
                            <span class="text-xs text-slate-700 font-semibold block mt-0.5">
                                Approx Arrival: {{ substr($booking->dropoffStop->scheduled_time ?? '~12:15 PM', 0, 8) }}
                            </span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">
                                {{ $booking->dropoffStop->location->city }}
                            </span>
                        </div>

                        <!-- Seats Reserved -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Reserved Seats ({{ $booking->seat_count }})</span>
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($booking->bookingSeats as $bs)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#22C55E]/15 text-[#16A34A] text-xs font-black border border-[#22C55E]/30 font-mono">
                                        ✓ {{ $bs->vehicleSeat->seat_number }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Vehicle Fleet -->
                        <div class="ticket-detail-card rounded-2xl border border-slate-200/80 bg-[#F8FAFC] p-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Shuttle Vehicle</span>
                            <span class="text-sm font-bold text-slate-900 block mt-1">
                                Silver Honda Odyssey
                            </span>
                            <span class="text-xs font-mono font-black text-[#16A34A] block mt-0.5">
                                Plate: {{ $booking->trip->vehicle->plate_number ?? 'RAJIA' }}
                            </span>
                        </div>

                    </div>

                    <!-- Passenger & Cash Settlement Notice -->
                    <div id="ticket-settlement-card" class="rounded-2xl border-2 border-[#22C55E]/30 bg-[#F0FDF4] p-5 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-[#16A34A] block">
                                    Cash Payment Settlement Upon Boarding
                                </span>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono mt-1">
                                    ${{ number_format((float) $booking->final_fare, 2) }} <span class="text-sm font-bold text-slate-600 font-sans">CAD</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-700 mt-1">
                                    Payment Status: <strong class="text-amber-800">UNPAID (Cash Only)</strong> • Please pay the driver directly in cash upon boarding.
                                </p>
                            </div>

                            <div class="sm:text-right space-y-1 text-xs text-slate-600 border-t sm:border-t-0 sm:border-l border-emerald-200 pt-3 sm:pt-0 sm:pl-6">
                                <div>Passenger: <strong class="text-slate-900">{{ $booking->user->name }}</strong></div>
                                <div>Phone: <strong class="text-slate-900 font-mono">{{ $booking->user->phone ?? '647-655-1884' }}</strong></div>
                                <div>Email: <strong class="text-slate-900">{{ $booking->user->email }}</strong></div>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Sign-Off Stamp Box (Only appears on Printed Paper Ticket) -->
                    <div class="hidden print-only-signature border-2 border-dashed border-slate-300 rounded-xl p-3 bg-slate-50 text-xs">
                        <div class="flex items-center justify-between text-slate-700">
                            <div>
                                <span class="font-bold uppercase tracking-wider block">Driver Physical Cash Settlement Verification:</span>
                                <span class="text-[11px] text-slate-500">Collected: ${{ number_format((float) $booking->final_fare, 2) }} CAD by Driver (RAJIA)</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-[11px] text-slate-500">Driver Signature: _______________________</span>
                            </div>
                        </div>
                    </div>

                    <!-- Journey Guidelines & Support -->
                    <div class="border-t border-slate-200/80 pt-4 space-y-1.5 text-xs text-slate-600 leading-relaxed">
                        <div class="font-bold text-slate-900 uppercase tracking-wider text-[11px]">Important Passenger Guidelines:</div>
                        <ul class="list-disc list-inside space-y-0.5 text-slate-600">
                            <li>Please arrive at the station 10 to 15 minutes before the scheduled departure time.</li>
                            <li>Look for the Silver Honda Odyssey bearing Ontario commercial license plate <strong class="text-slate-900 font-mono">RAJIA</strong>.</li>
                            <li>Have exact cash ready for settlement upon boarding.</li>
                            <li>Customer Support / Dispatch Direct: <strong class="text-slate-900 font-mono">647-655-1884</strong> (Phone, SMS, WhatsApp).</li>
                        </ul>
                    </div>

                </div>

                <!-- Footer Action Bar (Screen Only - Hidden on Print) -->
                <div class="bg-slate-50 border-t border-slate-200/80 p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <span class="text-xs text-slate-500">
                        Official Reservation Reference: <strong class="font-mono text-slate-800">{{ $booking->booking_reference }}</strong>
                    </span>

                    <div class="flex items-center gap-3 print:hidden">
                        <button type="button" onclick="window.print()" 
                                class="inline-flex min-h-[40px] items-center justify-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 text-xs font-bold transition cursor-pointer">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span>Print Pass</span>
                        </button>
                        <a href="{{ route('passenger.bookings.index') }}" 
                           class="inline-flex min-h-[40px] items-center justify-center rounded-xl bg-white border border-slate-200 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 transition">
                            My Reservations
                        </a>
                        <a href="{{ route('home') }}#booking-panel" 
                           class="inline-flex min-h-[40px] items-center justify-center rounded-xl bg-[#22C55E] hover:bg-[#16A34A] px-4 py-2 text-xs font-bold text-white shadow-xs transition">
                            Book Another Journey
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
