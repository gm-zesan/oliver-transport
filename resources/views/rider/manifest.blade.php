@extends('frontend.layout.app')

@section('title', 'Passenger Boarding Roster — Run #' . $trip->id . ' — Oliver Transport')

@section('content')
    @php
        $confirmedBookings = $trip->bookings->where('status', 'confirmed');
        $checkedInCount = $confirmedBookings->filter(fn ($b) => $b->isCheckedIn())->sum('seat_count');
        $totalPassengers = $kpis['total_passengers'] ?: $confirmedBookings->sum('seat_count');
        $bookedSeats = $kpis['booked_seats'];
        $totalSeats = $kpis['total_seats'] ?: 6;
        $occupancyPercent = $totalSeats > 0 ? min(100, round(($bookedSeats / $totalSeats) * 100)) : 0;
        $boardedPercent = $totalPassengers > 0 ? min(100, round(($checkedInCount / $totalPassengers) * 100)) : 0;

        // Map cabin seats to passenger bookings
        $cabinSeatMap = [];
        foreach ($trip->vehicle->seats->sortBy('seat_number') as $seat) {
            $cabinSeatMap[$seat->seat_number] = [
                'seat_number' => $seat->seat_number,
                'booking' => null,
                'passenger_name' => null,
                'is_checked_in' => false,
                'is_paid' => false,
                'fare' => 0,
            ];
        }

        foreach ($confirmedBookings as $booking) {
            $isPaid = $booking->payment?->status === 'paid';
            $isCheckedIn = $booking->isCheckedIn();
            $passengerName = $booking->user?->name ?? 'Passenger';
            $singleFare = $booking->seat_count > 0 ? round($booking->final_fare / $booking->seat_count, 2) : $booking->final_fare;

            foreach ($booking->bookingSeats as $bs) {
                $seatNum = $bs->vehicleSeat?->seat_number;
                if ($seatNum && isset($cabinSeatMap[$seatNum])) {
                    $cabinSeatMap[$seatNum]['booking'] = $booking;
                    $cabinSeatMap[$seatNum]['passenger_name'] = $passengerName;
                    $cabinSeatMap[$seatNum]['is_checked_in'] = $isCheckedIn;
                    $cabinSeatMap[$seatNum]['is_paid'] = $isPaid;
                    $cabinSeatMap[$seatNum]['fare'] = $singleFare;
                }
            }
        }
    @endphp

    <!-- Executive Driver Hero Header Section with Clean, Minimal Trip Info Layout -->
    <section class="relative overflow-hidden bg-slate-950 pt-28 sm:pt-36 lg:pt-40 pb-8 sm:pb-10 lg:pb-12 border-b border-slate-800 text-white select-none">
        
        <!-- Fleet Background Image with High Contrast Gradients -->
        <div class="absolute inset-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ asset('images/honda-odyssey-fleet-raw.jpg') }}" 
                 alt="Oliver Transport Fleet" 
                 class="w-full h-full object-cover object-center scale-105 filter brightness-[0.70] contrast-[1.10] saturate-110" />
            <!-- Balanced Luminous Cinematic Gradients for Crisp Text Contrast -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/92 via-slate-950/70 to-slate-950/45"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-transparent to-black/30"></div>
        </div>

        <!-- Ambient Warm Gold / Amber Glow in Background -->
        <div class="absolute top-4 right-1/4 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Back Navigation -->
            <div class="mb-4">
                <a href="{{ route('rider.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-300 hover:text-white transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Driver Dashboard</span>
                </a>
            </div>

            <!-- Clean Trip Info & Action Row -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading text-white tracking-tight leading-tight drop-shadow-sm">
                        {{ $trip->route->name }}
                    </h1>
                    <div class="pt-1.5 text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-2">
                        <span>Run #{{ $trip->id }}</span>
                        <span class="text-slate-500">•</span>
                        <span>{{ \Carbon\Carbon::parse($trip->trip_date)->format('l, F j, Y') }}</span>
                        <span class="text-slate-500">•</span>
                        <span>Departs: <strong class="text-white">{{ \Carbon\Carbon::parse($trip->scheduled_departure_time)->format('g:i A') }} EST</strong></span>
                    </div>
                </div>

                <!-- Trip Action: Start or Complete Trip (No Scheduled Badge) -->
                <div class="flex items-center gap-3">
                    @if ($trip->status === 'scheduled')
                        <form id="form-start-trip" method="POST" action="{{ route('rider.trips.status', $trip) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="button" 
                                    onclick="triggerStartTripModal()"
                                    class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-emerald-600 text-white px-6 py-2.5 text-xs sm:text-sm font-bold shadow-lg shadow-emerald-500/30 transition hover:scale-[1.02] cursor-pointer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Start Trip</span>
                            </button>
                        </form>
                    @elseif ($trip->status === 'in_progress')
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500/25 text-amber-300 border border-amber-400/30 backdrop-blur-md animate-pulse">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            <span>IN PROGRESS</span>
                        </span>

                        <form id="form-complete-trip" method="POST" action="{{ route('rider.trips.status', $trip) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="button" 
                                    onclick="triggerCompleteTripModal()"
                                    class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white hover:bg-slate-100 text-slate-900 px-6 py-2.5 text-xs sm:text-sm font-bold shadow-lg transition hover:scale-[1.02] cursor-pointer">
                                <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Complete Trip</span>
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider bg-emerald-500/25 text-emerald-300 border border-emerald-400/30 backdrop-blur-md">
                            <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>TRIP RUN COMPLETED</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area: Cockpit Canvas -->
    <section class="py-6 sm:py-8 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Live Shift HUD (4 Key Gauges: Occupancy, Boarded, Expected Cash, Collected Cash) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                
                <!-- Meter 1: Van Occupancy -->
                <div class="rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Reserved Seats</span>
                        <span class="h-2 w-2 rounded-full {{ $bookedSeats >= $totalSeats ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </div>
                    <div class="flex items-baseline gap-1.5 mt-1 font-mono">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900">{{ $bookedSeats }}</span>
                        <span class="text-xs font-semibold text-slate-400">/ {{ $totalSeats }} Seats</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full mt-3 overflow-hidden">
                        <div class="h-full bg-amber-400 rounded-full transition-all duration-300" style="width: {{ $occupancyPercent }}%;"></div>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 mt-2 block">
                        {{ $kpis['total_bookings'] }} Reservation{{ $kpis['total_bookings'] === 1 ? '' : 's' }}
                    </span>
                </div>

                <!-- Meter 2: Passenger Boarding Progress -->
                <div class="rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Boarded Status</span>
                        <span class="h-2 w-2 rounded-full {{ $checkedInCount >= $totalPassengers && $totalPassengers > 0 ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    </div>
                    <div class="flex items-baseline gap-1.5 mt-1 font-mono">
                        <span class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $checkedInCount }}</span>
                        <span class="text-xs font-semibold text-slate-400">/ {{ $totalPassengers }} Boarded</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full mt-3 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $boardedPercent }}%;"></div>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 mt-2 block">
                        {{ max(0, $totalPassengers - $checkedInCount) }} Awaiting Boarding
                    </span>
                </div>

                <!-- Meter 3: Expected Cash (Gross Trip Value) -->
                <div class="rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Expected Cash</span>
                        <span class="text-slate-400 font-mono text-xs">CAD</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono mt-1">
                        ${{ number_format($kpis['expected_cash'], 2) }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 mt-2 block">
                        Gross Trip Value
                    </span>
                </div>

                <!-- Meter 4: Cash Collected & Pending -->
                <div class="rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pending Cash</span>
                        <span class="h-2 w-2 rounded-full {{ $kpis['pending_cash'] > 0 ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black {{ $kpis['pending_cash'] > 0 ? 'text-rose-600' : 'text-slate-900' }} font-mono mt-1">
                        ${{ number_format($kpis['pending_cash'], 2) }}
                    </div>
                    <span class="text-[11px] font-bold text-emerald-600 mt-2 block">
                        ${{ number_format($kpis['collected_cash'], 2) }} Settled in Hand
                    </span>
                </div>
            </div>

            <!-- Interactive Minivan Cabin Map: Honda Odyssey 7-Seat Layout -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base sm:text-lg font-black font-heading text-slate-900">
                                Honda Odyssey Cabin Layout
                            </h2>
                            <span class="text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">
                                Plate: RAJIA
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Tap any seat to inspect passenger details and quickly jump to their boarding card.
                        </p>
                    </div>

                    <!-- Legend -->
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <span class="inline-flex items-center gap-1.5 text-emerald-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span>Boarded</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-amber-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                            <span>Waiting</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-slate-400">
                            <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                            <span>Open</span>
                        </span>
                    </div>
                </div>

                <!-- Van Diagram Grid Layout (Light Theme Friendly) -->
                <div class="max-w-md mx-auto bg-slate-50 p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-2xs">
                    <!-- Front Windshield -->
                    <div class="h-3 w-36 mx-auto bg-slate-200/80 border border-slate-300/60 rounded-full mb-4 flex items-center justify-center">
                        <span class="text-[9px] uppercase tracking-widest text-slate-500 font-black">FRONT WINDSHIELD</span>
                    </div>

                    <!-- Row 1: Driver Seat + S1 (Front Passenger) -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <!-- Driver Seat (Permanent) -->
                        <div class="h-14 rounded-2xl bg-white border border-slate-200/90 flex items-center justify-center gap-2 text-slate-700 shadow-2xs select-none">
                            <span class="text-base">🚗</span>
                            <div class="text-left">
                                <span class="text-xs font-black uppercase tracking-wider block text-slate-900 leading-tight">Driver</span>
                                <span class="text-[10px] text-slate-500 truncate block">{{ $trip->rider?->name ?? 'Jean-Luc' }}</span>
                            </div>
                        </div>

                        <!-- Seat S1 -->
                        @php $s1 = $cabinSeatMap['S1'] ?? null; @endphp
                        @if ($s1 && $s1['booking'])
                            <button type="button" 
                                    onclick="selectSeatCard('S1')" 
                                    id="seat-pill-S1"
                                    class="h-14 rounded-2xl border-2 transition hover:scale-[1.02] cursor-pointer flex flex-col items-center justify-center p-1.5 shadow-2xs {{ $s1['is_checked_in'] ? 'bg-emerald-50 border-emerald-500 text-emerald-900 hover:bg-emerald-100/70' : 'bg-amber-50 border-amber-400 text-amber-900 hover:bg-amber-100/70' }}">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-black font-mono {{ $s1['is_checked_in'] ? 'text-emerald-800' : 'text-amber-800' }}">S1</span>
                                    <span class="font-bold {{ $s1['is_checked_in'] ? 'text-emerald-600' : 'text-amber-600' }}">{{ $s1['is_checked_in'] ? '✓' : '⌛' }}</span>
                                </div>
                                <span class="text-[10px] font-bold truncate max-w-[120px] {{ $s1['is_checked_in'] ? 'text-emerald-950' : 'text-amber-950' }}">{{ explode(' ', $s1['passenger_name'])[0] }}</span>
                            </button>
                        @else
                            <div class="h-14 rounded-2xl bg-white border-2 border-dashed border-slate-200 text-slate-400 flex flex-col items-center justify-center select-none shadow-2xs">
                                <span class="text-xs font-black font-mono text-slate-400">S1</span>
                                <span class="text-[9px] uppercase font-bold text-slate-400">Open</span>
                            </div>
                        @endif
                    </div>

                    <!-- Row 2: Middle Captain Chairs (S2, S3) -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        @foreach (['S2', 'S3'] as $seatId)
                            @php $seatData = $cabinSeatMap[$seatId] ?? null; @endphp
                            @if ($seatData && $seatData['booking'])
                                <button type="button" 
                                        onclick="selectSeatCard('{{ $seatId }}')" 
                                        id="seat-pill-{{ $seatId }}"
                                        class="h-14 rounded-2xl border-2 transition hover:scale-[1.02] cursor-pointer flex flex-col items-center justify-center p-1.5 shadow-2xs {{ $seatData['is_checked_in'] ? 'bg-emerald-50 border-emerald-500 text-emerald-900 hover:bg-emerald-100/70' : 'bg-amber-50 border-amber-400 text-amber-900 hover:bg-amber-100/70' }}">
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-black font-mono {{ $seatData['is_checked_in'] ? 'text-emerald-800' : 'text-amber-800' }}">{{ $seatId }}</span>
                                        <span class="font-bold {{ $seatData['is_checked_in'] ? 'text-emerald-600' : 'text-amber-600' }}">{{ $seatData['is_checked_in'] ? '✓' : '⌛' }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold truncate max-w-[120px] {{ $seatData['is_checked_in'] ? 'text-emerald-950' : 'text-amber-950' }}">{{ explode(' ', $seatData['passenger_name'])[0] }}</span>
                                </button>
                            @else
                                <div class="h-14 rounded-2xl bg-white border-2 border-dashed border-slate-200 text-slate-400 flex flex-col items-center justify-center select-none shadow-2xs">
                                    <span class="text-xs font-black font-mono text-slate-400">{{ $seatId }}</span>
                                    <span class="text-[9px] uppercase font-bold text-slate-400">Open</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Row 3: Rear Bench (S4, S5, S6) -->
                    <div class="grid grid-cols-3 gap-2">
                        @foreach (['S4', 'S5', 'S6'] as $seatId)
                            @php $seatData = $cabinSeatMap[$seatId] ?? null; @endphp
                            @if ($seatData && $seatData['booking'])
                                <button type="button" 
                                        onclick="selectSeatCard('{{ $seatId }}')" 
                                        id="seat-pill-{{ $seatId }}"
                                        class="h-14 rounded-2xl border-2 transition hover:scale-[1.02] cursor-pointer flex flex-col items-center justify-center p-1 shadow-2xs {{ $seatData['is_checked_in'] ? 'bg-emerald-50 border-emerald-500 text-emerald-900 hover:bg-emerald-100/70' : 'bg-amber-50 border-amber-400 text-amber-900 hover:bg-amber-100/70' }}">
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-black font-mono {{ $seatData['is_checked_in'] ? 'text-emerald-800' : 'text-amber-800' }}">{{ $seatId }}</span>
                                        <span class="font-bold {{ $seatData['is_checked_in'] ? 'text-emerald-600' : 'text-amber-600' }}">{{ $seatData['is_checked_in'] ? '✓' : '⌛' }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold truncate max-w-[80px] {{ $seatData['is_checked_in'] ? 'text-emerald-950' : 'text-amber-950' }}">{{ explode(' ', $seatData['passenger_name'])[0] }}</span>
                                </button>
                            @else
                                <div class="h-14 rounded-2xl bg-white border-2 border-dashed border-slate-200 text-slate-400 flex flex-col items-center justify-center select-none shadow-2xs">
                                    <span class="text-xs font-black font-mono text-slate-400">{{ $seatId }}</span>
                                    <span class="text-[9px] uppercase font-bold text-slate-400">Open</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Smart Station Filter Pills (One-Touch Station Focusing) -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar select-none">
                <button type="button" 
                        onclick="filterManifestStop('all')" 
                        id="filter-pill-all"
                        class="manifest-filter-pill px-4 py-2 rounded-2xl text-xs font-bold transition whitespace-nowrap bg-[#22C55E] text-white shadow-xs cursor-pointer">
                    All Stations ({{ $totalPassengers }})
                </button>

                @foreach ($stops as $stopData)
                    @php
                        $stopLoc = $stopData['location'];
                        $bCount = $stopData['boarding_passengers']->count();
                        $dCount = $stopData['dropoff_passengers']->count();
                    @endphp
                    <button type="button" 
                            onclick="filterManifestStop('stop-{{ $stopData['stop_sequence'] }}')" 
                            id="filter-pill-stop-{{ $stopData['stop_sequence'] }}"
                            class="manifest-filter-pill px-4 py-2 rounded-2xl text-xs font-bold transition whitespace-nowrap bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 shadow-2xs cursor-pointer">
                        {{ $stopLoc->name }} ({{ $bCount }} Pick / {{ $dCount }} Drop)
                    </button>
                @endforeach
            </div>

            <!-- Stop-by-Stop Passenger Boarding Roster Sequence -->
            <div class="space-y-6 pt-1">
                @foreach ($stops as $stopData)
                    @php
                        $stop = $stopData['stop'];
                        $location = $stopData['location'];
                        $boardingPassengers = $stopData['boarding_passengers'];
                        $dropoffPassengers = $stopData['dropoff_passengers'];
                        $formattedTime = \Carbon\Carbon::parse($stopData['scheduled_time'])->format('g:i A');
                    @endphp

                    <div id="station-section-stop-{{ $stopData['stop_sequence'] }}" 
                         class="station-card rounded-3xl border border-slate-200/90 bg-white overflow-hidden shadow-xs transition">
                        
                        <!-- Stop Header Banner (Clean White Theme Style) -->
                        <div class="bg-slate-50/90 border-b border-slate-200/90 p-4 sm:p-6 text-slate-900 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-start sm:items-center gap-3.5">
                                <div class="h-11 w-11 rounded-2xl bg-emerald-100/80 text-emerald-800 flex items-center justify-center font-black text-sm border border-emerald-300/80 shadow-2xs flex-shrink-0">
                                    {{ $stopData['stop_sequence'] }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-700">
                                            STOP {{ $stopData['stop_sequence'] }} • {{ strtoupper($stopData['stop_type']->value ?? 'STOP') }}
                                        </span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-xs text-slate-600 font-bold">{{ $formattedTime }} EST</span>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                                        {{ $location->name }}
                                    </h3>
                                    <p class="text-xs text-slate-500">
                                        {{ $location->address_line1 }}, {{ $location->city }}, {{ $location->province_code }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white text-xs font-bold text-slate-700 border border-slate-200 shadow-2xs">
                                    <span class="text-emerald-700 font-black mr-1">{{ $boardingPassengers->count() }}</span> Pick-up • <span class="text-slate-900 font-black mx-1">{{ $dropoffPassengers->count() }}</span> Drop-off
                                </span>
                            </div>
                        </div>

                        <!-- Boarding Passengers Roster -->
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    <span>Boarding Passengers ({{ $boardingPassengers->count() }})</span>
                                </h4>
                            </div>

                            @if ($boardingPassengers->isEmpty())
                                <p class="text-xs sm:text-sm text-slate-400 italic py-2">
                                    No passengers scheduled to board at this station.
                                </p>
                            @else
                                <div class="space-y-3">
                                    @foreach ($boardingPassengers as $booking)
                                        @php
                                            $seatNumbers = $booking->bookingSeats->pluck('vehicleSeat.seat_number')->sort()->implode(', ');
                                            $seatClasses = $booking->bookingSeats->pluck('vehicleSeat.seat_number')->map(fn ($s) => 'seat-card-' . $s)->implode(' ');
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $booking->user->phone ?? '');
                                            $isPaid = $booking->payment?->status === 'paid';
                                            $isCheckedIn = $booking->isCheckedIn();
                                            $escapedName = addslashes($booking->user->name);
                                            $fareFormatted = number_format($booking->final_fare, 2);
                                            $fareRaw = (float) $booking->final_fare;
                                        @endphp

                                        <div id="booking-card-{{ $booking->id }}" 
                                             class="passenger-roster-card {{ $seatClasses }} p-4 sm:p-5 rounded-2xl border-2 transition flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 {{ $isCheckedIn ? 'bg-emerald-50/40 border-emerald-300' : 'bg-white border-slate-200/90 hover:border-amber-400' }}">
                                            
                                            <!-- Passenger Identity & Route Details -->
                                            <div class="flex items-start sm:items-center gap-3.5">
                                                <!-- Cabin Physical Seat Badge -->
                                                <div class="flex-shrink-0 flex flex-col items-center justify-center min-w-[56px] h-14 rounded-2xl p-2 text-center shadow-xs {{ $isCheckedIn ? 'bg-emerald-600 text-white shadow-emerald-500/20' : 'bg-emerald-50 border-2 border-emerald-500 text-emerald-950 shadow-2xs' }}">
                                                    <span class="text-[9px] font-bold uppercase tracking-wider {{ $isCheckedIn ? 'text-emerald-100' : 'text-emerald-700' }}">SEAT</span>
                                                    <span class="text-base font-black font-mono leading-none {{ $isCheckedIn ? 'text-white' : 'text-emerald-900' }}">
                                                        {{ $seatNumbers ?: 'S' . $booking->seat_count }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h5 class="text-base font-black text-slate-900">
                                                            {{ $booking->user->name }}
                                                        </h5>
                                                        <span class="text-[11px] font-mono text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                                            {{ $booking->booking_reference }}
                                                        </span>
                                                        <span class="text-xs font-semibold text-slate-600">
                                                            ({{ $booking->seat_count }} seat{{ $booking->seat_count === 1 ? '' : 's' }})
                                                        </span>
                                                        
                                                        @if ($isCheckedIn)
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                                <span>BOARDED ✓</span>
                                                                <span class="font-normal font-mono">({{ $booking->checked_in_at->format('g:i A') }})</span>
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300">
                                                                <span>WAITING TO BOARD</span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="flex flex-wrap items-center gap-2 mt-1.5 text-xs text-slate-500">
                                                        <span>Drop-off: <strong class="text-slate-800 font-semibold">{{ $booking->dropoffStop->location->name }}</strong></span>
                                                        <span>•</span>
                                                        <span>Fare: <strong class="text-slate-800 font-bold font-mono">CAD ${{ $fareFormatted }}</strong></span>
                                                        @if ($isPaid)
                                                            <span class="text-emerald-700 font-bold">• PAID (CASH)</span>
                                                        @else
                                                            <span class="text-rose-600 font-bold">• CASH DUE</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Touch Controls: Call, SMS, WhatsApp, Boarding, Cash Calculator -->
                                            <div class="flex flex-wrap items-center gap-2 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-200/60">
                                                <!-- Contact Actions: 44px+ touch target -->
                                                @if ($booking->user->phone)
                                                    <a href="tel:{{ $booking->user->phone }}" 
                                                       title="Call Passenger"
                                                       class="min-h-[44px] min-w-[44px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition shadow-2xs">
                                                        <svg class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <span>Call</span>
                                                    </a>

                                                    <a href="sms:{{ $booking->user->phone }}" 
                                                       title="SMS Passenger"
                                                       class="min-h-[44px] min-w-[44px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition shadow-2xs">
                                                        <svg class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        <span>SMS</span>
                                                    </a>

                                                    @if ($cleanPhone)
                                                        <a href="https://wa.me/{{ $cleanPhone }}" 
                                                           target="_blank" 
                                                           rel="noopener noreferrer"
                                                           title="WhatsApp Message"
                                                           class="min-h-[44px] min-w-[44px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition shadow-2xs">
                                                            <svg class="h-4 w-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.772.82 2.792.82 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.587-5.766-5.768-5.766zm3.385 8.163c-.144.405-.837.774-1.17.822-.312.043-.679.066-2.12-.533-1.841-.765-3.033-2.639-3.125-2.761-.091-.122-.739-.984-.739-1.876 0-.893.468-1.332.635-1.512.167-.18.365-.225.487-.225.122 0 .243.001.35.006.112.005.263-.042.412.316.153.366.522 1.272.568 1.363.045.092.076.198.015.319-.061.121-.091.198-.182.304-.091.106-.192.237-.274.318-.092.091-.188.19-.081.373.106.183.473.78 1.015 1.263.698.621 1.287.814 1.47.905.182.091.289.076.395-.045.106-.122.456-.532.578-.714.121-.183.243-.152.41-.091.167.061 1.063.501 1.246.592.182.091.304.137.35.213.045.076.045.441-.099.846z"/>
                                                            </svg>
                                                            <span>WhatsApp</span>
                                                        </a>
                                                    @endif
                                                @endif

                                                <!-- Cash Collection & Check-in Actions -->
                                                @if (! $isPaid && $booking->payment)
                                                    <!-- Combined 1-Tap Cash Collection & Boarding Button with Built-in Change Calculator -->
                                                    <form id="form-collect-{{ $booking->payment->id }}" method="POST" action="{{ route('rider.trips.payments.collect', [$trip, $booking->payment]) }}">
                                                        @csrf
                                                        <input type="hidden" name="check_in" value="1">
                                                        <button type="button" 
                                                                onclick="openCockpitCashModal('form-collect-{{ $booking->payment->id }}', '{{ $escapedName }}', {{ $fareRaw }}, '{{ $seatNumbers }}')"
                                                                class="min-h-[48px] px-5 inline-flex items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-emerald-600 text-white text-xs sm:text-sm font-black uppercase tracking-wider shadow-md shadow-emerald-500/20 transition hover:scale-[1.02] cursor-pointer">
                                                            <span class="font-mono font-bold text-base">$</span>
                                                            <span>Collect CAD ${{ $fareFormatted }}</span>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Check-In Action Button (if paid earlier or separate checkin needed) -->
                                                @if (! $isCheckedIn)
                                                    <form id="form-checkin-{{ $booking->id }}" method="POST" action="{{ route('rider.trips.bookings.check-in', [$trip, $booking]) }}">
                                                        @csrf
                                                        <button type="button" 
                                                                onclick="triggerCheckInModal('form-checkin-{{ $booking->id }}', '{{ $escapedName }}', '{{ $seatNumbers }}')"
                                                                class="min-h-[44px] px-4 inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 text-xs font-bold transition shadow-2xs cursor-pointer">
                                                            <svg class="h-3.5 w-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span>Check In Only</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    @if ($isPaid)
                                                        <span class="inline-flex min-h-[44px] items-center gap-1.5 px-4 rounded-xl bg-emerald-600 text-white text-xs font-black uppercase tracking-wider shadow-xs">
                                                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            <span>PAID &amp; BOARDED ✓</span>
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Disembarking Passengers Sub-section (if intermediate or terminus) -->
                            @if ($dropoffPassengers->isNotEmpty())
                                <div class="pt-4 mt-2 border-t border-slate-100">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        <span>Disembarking Passengers at {{ $location->name }} ({{ $dropoffPassengers->count() }})</span>
                                    </h4>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($dropoffPassengers as $dropBooking)
                                            @php
                                                $dropSeats = $dropBooking->bookingSeats->pluck('vehicleSeat.seat_number')->sort()->implode(', ');
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold">
                                                <span class="font-mono font-bold text-slate-900 bg-white px-1.5 py-0.5 rounded border border-slate-200">{{ $dropSeats ?: 'S' }}</span>
                                                <span>{{ $dropBooking->user->name }}</span>
                                                @if ($dropBooking->isCheckedIn())
                                                    <span class="h-2 w-2 rounded-full bg-emerald-500" title="Boarded"></span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer Dispatch & Shift Assistance Card -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center flex-shrink-0 border border-amber-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Dispatch Operations Assistance</span>
                        <span class="text-sm font-black text-slate-900">Support Hotline: 647-655-1884</span>
                    </div>
                </div>

                <a href="tel:16476551884" 
                   class="inline-flex min-h-[46px] items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 px-5 py-2.5 text-xs sm:text-sm font-bold shadow-2xs transition cursor-pointer">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>Call Dispatch (647-655-1884)</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Cash Settlement & Change Return Calculator Modal (Clean Light Theme) -->
    <div id="cockpit-cash-modal" 
         class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/70 backdrop-blur-sm transition-opacity duration-150" 
         aria-labelledby="cash-modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white border border-slate-200 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 sm:p-7 text-slate-900">
                
                <!-- Close Button -->
                <button type="button" 
                        onclick="closeCockpitCashModal()" 
                        class="absolute top-5 right-5 h-8 w-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Header -->
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div id="cash-modal-seat-badge" class="h-12 w-12 rounded-2xl bg-emerald-100 text-emerald-800 border border-emerald-300 font-black font-mono text-base flex items-center justify-center shadow-xs">
                        S1
                    </div>
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-700 block">Boarding Cash Settlement</span>
                        <h3 id="cash-modal-passenger-name" class="text-lg font-black text-slate-900 font-heading">
                            Passenger Name
                        </h3>
                    </div>
                </div>

                <!-- Calculator Body -->
                <div class="py-4 space-y-4">
                    <!-- Fare Due Display -->
                    <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-200/80 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600">Total Fare Payable:</span>
                        <span id="cash-modal-fare-due" class="text-2xl font-black text-emerald-800 font-mono">$65.00 CAD</span>
                    </div>

                    <!-- Tendered Quick Buttons -->
                    <div>
                        <span class="text-xs font-bold text-slate-600 block mb-2">Cash Given by Passenger:</span>
                        <div class="grid grid-cols-4 gap-2 mb-3" id="cash-quick-buttons-container">
                            <!-- Buttons injected by JS based on fare -->
                        </div>

                        <!-- Live Change Return Meter -->
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-600">Change to Return:</span>
                            <span id="cash-modal-change-return" class="font-mono font-black text-emerald-700 text-base sm:text-lg">
                                $0.00 CAD
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                    <button type="button" 
                            onclick="closeCockpitCashModal()" 
                            class="w-1/3 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-700 transition cursor-pointer">
                        Cancel
                    </button>
                    
                    <button type="button" 
                            id="cash-modal-confirm-btn"
                            onclick="executeCockpitCashCollection()" 
                            class="w-2/3 py-3 rounded-xl bg-[#22C55E] hover:bg-emerald-600 text-white font-black text-xs sm:text-sm shadow-md shadow-emerald-500/20 transition hover:scale-[1.02] cursor-pointer">
                        Confirm Cash &amp; Board ✓
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Lifecycle Confirmation Modal (Start / Complete / Checkin) -->
    <div id="driver-confirm-modal" 
         class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/75 backdrop-blur-sm transition-opacity duration-150" 
         aria-labelledby="confirm-modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200 p-6 sm:p-7">
                
                <!-- Close Button -->
                <button type="button" 
                        onclick="closeDriverConfirmModal()" 
                        class="absolute top-5 right-5 h-8 w-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Icon -->
                <div id="confirm-modal-icon-container" class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4">
                </div>

                <!-- Modal Content -->
                <div class="text-center space-y-2">
                    <span id="confirm-modal-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">
                    </span>

                    <h3 id="confirm-modal-title" class="text-xl font-black font-heading text-slate-900 tracking-tight">
                    </h3>

                    <p id="confirm-modal-message" class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm mx-auto">
                    </p>

                    <div id="confirm-modal-details" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-700 space-y-1 text-left hidden">
                    </div>
                </div>

                <!-- Actions Grid -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-center gap-3">
                    <button type="button" 
                            onclick="closeDriverConfirmModal()" 
                            class="w-1/2 inline-flex min-h-[46px] items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 text-xs sm:text-sm font-bold transition cursor-pointer">
                        Cancel
                    </button>

                    <button type="button" 
                            id="confirm-modal-submit-btn" 
                            onclick="executeDriverConfirmAction()" 
                            class="w-1/2 inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl text-white px-4 py-2 text-xs sm:text-sm font-bold shadow-xs transition cursor-pointer">
                        <span>Confirm</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Dynamic Cabin Seat Map, Change Calculator & Cockpit Filtering -->
    <script>
        let pendingFormId = null;
        let activeCashModalConfig = null;

        // 1. Cabin Diagram Click Interaction
        function selectSeatCard(seatNumber) {
            const cards = document.querySelectorAll('.passenger-roster-card');
            let foundCard = null;

            cards.forEach(card => {
                if (card.classList.contains('seat-card-' + seatNumber)) {
                    foundCard = card;
                }
            });

            if (foundCard) {
                // Ensure station is visible
                const parentStation = foundCard.closest('.station-card');
                if (parentStation) {
                    parentStation.style.display = 'block';
                }

                foundCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                foundCard.classList.add('ring-4', 'ring-[#22C55E]');
                setTimeout(() => {
                    foundCard.classList.remove('ring-4', 'ring-[#22C55E]');
                }, 2000);
            }
        }

        // 2. Smart Station Filter Pills
        function filterManifestStop(stopId) {
            const allPills = document.querySelectorAll('.manifest-filter-pill');
            allPills.forEach(pill => {
                pill.className = 'manifest-filter-pill px-4 py-2 rounded-2xl text-xs font-bold transition whitespace-nowrap bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 shadow-2xs cursor-pointer';
            });

            const activePill = document.getElementById('filter-pill-' + stopId);
            if (activePill) {
                activePill.className = 'manifest-filter-pill px-4 py-2 rounded-2xl text-xs font-bold transition whitespace-nowrap bg-[#22C55E] text-white shadow-xs cursor-pointer';
            }

            const stationCards = document.querySelectorAll('.station-card');
            stationCards.forEach(card => {
                if (stopId === 'all') {
                    card.style.display = 'block';
                } else if (card.id === 'station-section-' + stopId) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // 3. Cash Settlement Modal with Change Return Calculator
        function openCockpitCashModal(formId, passengerName, fareAmount, seatNumbers) {
            activeCashModalConfig = { formId, passengerName, fareAmount, seatNumbers };

            document.getElementById('cash-modal-passenger-name').textContent = passengerName;
            document.getElementById('cash-modal-seat-badge').textContent = seatNumbers || 'S';
            document.getElementById('cash-modal-fare-due').textContent = '$' + fareAmount.toFixed(2) + ' CAD';

            // Generate tendered quick buttons
            const container = document.getElementById('cash-quick-buttons-container');
            const roundFare = Math.ceil(fareAmount);
            const options = [
                { label: '$' + roundFare + ' Exact', value: roundFare },
                { label: '$' + (roundFare <= 65 ? 70 : roundFare + 10), value: roundFare <= 65 ? 70 : roundFare + 10 },
                { label: '$' + (roundFare <= 65 ? 80 : roundFare + 20), value: roundFare <= 65 ? 80 : roundFare + 20 },
                { label: '$100', value: 100 }
            ];

            container.innerHTML = options.map(opt => `
                <button type="button" 
                        onclick="calculateChangeReturn(${opt.value})" 
                        class="cash-tender-btn py-2 px-1 bg-slate-100 hover:bg-[#22C55E] hover:text-white text-slate-800 text-xs font-bold rounded-xl border border-slate-200 transition cursor-pointer text-center">
                    ${opt.label}
                </button>
            `).join('');

            calculateChangeReturn(roundFare);
            document.getElementById('cockpit-cash-modal').classList.remove('hidden');
        }

        function calculateChangeReturn(tenderedAmount) {
            if (!activeCashModalConfig) return;
            const fare = activeCashModalConfig.fareAmount;
            const change = Math.max(0, tenderedAmount - fare);
            document.getElementById('cash-modal-change-return').textContent = '$' + change.toFixed(2) + ' CAD';

            // Highlight active button
            const buttons = document.querySelectorAll('.cash-tender-btn');
            buttons.forEach(btn => {
                if (btn.textContent.includes('$' + tenderedAmount)) {
                    btn.className = 'cash-tender-btn py-2 px-1 bg-[#22C55E] text-white text-xs font-black rounded-xl border border-emerald-600 shadow-xs transition cursor-pointer text-center';
                } else {
                    btn.className = 'cash-tender-btn py-2 px-1 bg-slate-100 hover:bg-[#22C55E] hover:text-white text-slate-800 text-xs font-bold rounded-xl border border-slate-200 transition cursor-pointer text-center';
                }
            });
        }

        function closeCockpitCashModal() {
            document.getElementById('cockpit-cash-modal').classList.add('hidden');
            activeCashModalConfig = null;
        }

        function executeCockpitCashCollection() {
            if (activeCashModalConfig && activeCashModalConfig.formId) {
                const targetForm = document.getElementById(activeCashModalConfig.formId);
                if (targetForm) {
                    targetForm.submit();
                }
            }
        }

        // 4. Standard Lifecycle Action Confirmation Modal
        function openDriverConfirmModal(config) {
            pendingFormId = config.formId;

            const modal = document.getElementById('driver-confirm-modal');
            const iconContainer = document.getElementById('confirm-modal-icon-container');
            const badge = document.getElementById('confirm-modal-badge');
            const title = document.getElementById('confirm-modal-title');
            const message = document.getElementById('confirm-modal-message');
            const details = document.getElementById('confirm-modal-details');
            const submitBtn = document.getElementById('confirm-modal-submit-btn');

            badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider ' + (config.badgeClass || 'bg-slate-100 text-slate-800');
            badge.textContent = config.badgeText;

            title.textContent = config.title;
            message.textContent = config.message;

            if (config.detailsHtml) {
                details.innerHTML = config.detailsHtml;
                details.classList.remove('hidden');
            } else {
                details.classList.add('hidden');
                details.innerHTML = '';
            }

            iconContainer.className = 'mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4 ' + (config.iconBgClass || 'bg-emerald-50 text-emerald-600 border border-emerald-200');
            iconContainer.innerHTML = config.iconSvg;

            submitBtn.className = 'w-1/2 inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl text-white px-4 py-2 text-xs sm:text-sm font-bold shadow-xs transition ' + (config.btnClass || 'bg-[#22C55E] hover:bg-emerald-600');
            submitBtn.innerHTML = config.btnText;

            modal.classList.remove('hidden');
        }

        function closeDriverConfirmModal() {
            const modal = document.getElementById('driver-confirm-modal');
            if (modal) modal.classList.add('hidden');
            pendingFormId = null;
        }

        function executeDriverConfirmAction() {
            if (pendingFormId) {
                const targetForm = document.getElementById(pendingFormId);
                if (targetForm) {
                    targetForm.submit();
                }
            }
        }

        // Modal triggers
        function triggerStartTripModal() {
            openDriverConfirmModal({
                formId: 'form-start-trip',
                badgeText: 'Departure Confirmation',
                badgeClass: 'bg-sky-100 text-sky-800 border border-sky-200',
                title: 'Start Trip Run #{{ $trip->id }}',
                message: 'Ready to depart origin station? This will update the operational status to IN PROGRESS.',
                detailsHtml: '<div class="text-slate-600">Route: <strong class="text-slate-900">{{ $trip->route->name }}</strong></div><div class="text-slate-600">Vehicle: <strong class="text-slate-900">Honda Odyssey (RAJIA)</strong></div>',
                iconBgClass: 'bg-sky-50 text-sky-600 border border-sky-200',
                iconSvg: '<svg class="h-7 w-7 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                btnClass: 'bg-[#22C55E] hover:bg-emerald-600',
                btnText: '<span>Depart &amp; Start Trip</span>'
            });
        }

        function triggerCompleteTripModal() {
            openDriverConfirmModal({
                formId: 'form-complete-trip',
                badgeText: 'Trip Completion',
                badgeClass: 'bg-slate-100 text-slate-800 border border-slate-200',
                title: 'Complete Trip Run #{{ $trip->id }}',
                message: 'Confirm that this shuttle run has arrived at the final station and all passengers have safely disembarked.',
                detailsHtml: '<div class="text-slate-600">Status will update to <strong class="text-emerald-600 uppercase font-black">COMPLETED</strong></div>',
                iconBgClass: 'bg-slate-100 text-slate-800 border border-slate-200',
                iconSvg: '<svg class="h-7 w-7 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
                btnClass: 'bg-[#22C55E] hover:bg-emerald-600',
                btnText: '<span>Yes, Complete Run</span>'
            });
        }

        function triggerCheckInModal(formId, passengerName, seatNumbers) {
            openDriverConfirmModal({
                formId: formId,
                badgeText: 'Passenger Check-In',
                badgeClass: 'bg-amber-100 text-amber-800 border border-amber-200',
                title: 'Check In Passenger',
                message: 'Confirm that ' + passengerName + ' has physically boarded the vehicle for Seat(s) ' + seatNumbers + '?',
                detailsHtml: '<div class="text-slate-600">Passenger: <strong class="text-slate-900">' + passengerName + '</strong> (Seat ' + seatNumbers + ')</div>',
                iconBgClass: 'bg-amber-50 text-amber-600 border border-amber-200',
                iconSvg: '<svg class="h-7 w-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                btnClass: 'bg-[#22C55E] hover:bg-[#16A34A]',
                btnText: '<span>Confirm Boarded</span>'
            });
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCockpitCashModal();
                closeDriverConfirmModal();
            }
        });
    </script>
@endsection
