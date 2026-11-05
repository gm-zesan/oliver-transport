@extends('frontend.layout.app')

@section('title', 'Passenger Boarding Roster — Run #' . $trip->id . ' — Oliver Transport')

@section('content')
    <!-- Executive Driver Hero Header Section with Fleet Background & Balanced Amber Glow Overlay -->
    <section class="relative overflow-hidden bg-slate-950 pt-32 sm:pt-36 lg:pt-40 pb-8 sm:pb-10 lg:pb-12 border-b border-slate-800 text-white select-none">
        
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
            <!-- Back Navigation & Breadcrumb -->
            <div class="flex items-center gap-2 mb-4 text-xs font-semibold text-slate-300">
                <a href="{{ route('rider.dashboard') }}" class="hover:text-amber-300 inline-flex items-center gap-1.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Driver Dashboard</span>
                </a>
                <span class="text-slate-600">/</span>
                <span class="text-white">Run #{{ $trip->id }} Passenger Roster</span>
            </div>

            <!-- Run Title & Operational Status Strip -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 pb-2">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500/25 text-amber-300 border border-amber-400/30 backdrop-blur-md">
                            Run #{{ $trip->id }} • {{ $trip->route->service_label ?? $trip->route->name }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium hidden sm:inline">•</span>
                        <span class="text-xs font-semibold text-slate-200 hidden sm:inline">
                            {{ \Carbon\Carbon::parse($trip->trip_date)->format('l, F j, Y') }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium hidden sm:inline">•</span>
                        <span class="text-xs font-semibold text-slate-200 hidden sm:inline">
                            Operating Van: Honda Odyssey (Plate: <strong class="font-mono text-amber-300">RAJIA</strong>)
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black font-heading text-white tracking-tight leading-tight drop-shadow-sm">
                        {{ $trip->route->name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1.5">
                        Scheduled Departure: <strong class="text-amber-300 font-bold">{{ \Carbon\Carbon::parse($trip->scheduled_departure_time)->format('g:i A') }} EST</strong> • Assigned Driver: <strong class="text-white">{{ $trip->rider?->name ?? $user->name }}</strong>
                    </p>
                </div>

                <!-- Trip Operational Lifecycle Actions -->
                <div class="flex flex-wrap items-center gap-3">
                    @if ($trip->status === 'scheduled')
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-sky-500/25 text-sky-300 border border-sky-400/30 backdrop-blur-md">
                            <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                            <span>SCHEDULED</span>
                        </span>

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

    <!-- Main Content Area -->
    <section class="py-8 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Status Messages -->
            @if (session('status'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center gap-3">
                    <svg class="h-5 w-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Live Financial & Passenger KPIs Strip -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Booked Seats</span>
                        <span class="h-2 w-2 rounded-full {{ $kpis['booked_seats'] >= $kpis['total_seats'] ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </div>
                    <div class="text-2xl font-black text-slate-900 font-heading">
                        {{ $kpis['booked_seats'] }} <span class="text-sm font-semibold text-slate-400">/ {{ $kpis['total_seats'] }}</span>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-0.5 block">
                        {{ $kpis['total_bookings'] }} Total Reservation{{ $kpis['total_bookings'] === 1 ? '' : 's' }}
                    </span>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Expected Cash</span>
                        <span class="text-slate-400 font-mono text-xs">CAD</span>
                    </div>
                    <div class="text-2xl font-black text-slate-900 font-heading">
                        ${{ number_format($kpis['expected_cash'], 2) }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-0.5 block">
                        Gross Trip Value
                    </span>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Collected Cash</span>
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="text-2xl font-black text-emerald-600 font-heading">
                        ${{ number_format($kpis['collected_cash'], 2) }}
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-700 mt-0.5 block">
                        Physically Settled
                    </span>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Pending Cash</span>
                        <span class="h-2 w-2 rounded-full {{ $kpis['pending_cash'] > 0 ? 'bg-rose-500' : 'bg-slate-300' }}"></span>
                    </div>
                    <div class="text-2xl font-black {{ $kpis['pending_cash'] > 0 ? 'text-rose-600' : 'text-slate-900' }} font-heading">
                        ${{ number_format($kpis['pending_cash'], 2) }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-0.5 block">
                        Awaiting Boarding Cash
                    </span>
                </div>
            </div>

            <!-- Stop-by-Stop Passenger Boarding Roster Sequence -->
            <div class="space-y-6 pt-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black font-heading text-slate-900">
                            Stop-by-Stop Passenger Boarding Roster
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Sequential passenger list, physical seats, click-to-call, passenger check-in, and cash settlement controls.
                        </p>
                    </div>
                </div>

                @foreach ($stops as $stopData)
                    @php
                        $stop = $stopData['stop'];
                        $location = $stopData['location'];
                        $boardingPassengers = $stopData['boarding_passengers'];
                        $dropoffPassengers = $stopData['dropoff_passengers'];
                        $formattedTime = \Carbon\Carbon::parse($stopData['scheduled_time'])->format('g:i A');
                    @endphp

                    <div class="rounded-3xl border border-slate-200/90 bg-white overflow-hidden shadow-xs">
                        <!-- Stop Header Banner -->
                        <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-5 sm:p-6 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-start sm:items-center gap-3">
                                <div class="h-10 w-10 rounded-2xl bg-white/10 flex items-center justify-center font-black text-sm text-amber-400 border border-white/15 flex-shrink-0">
                                    {{ $stopData['stop_sequence'] }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-400">
                                            STOP {{ $stopData['stop_sequence'] }} • {{ strtoupper($stopData['stop_type']->value ?? 'STOP') }}
                                        </span>
                                        <span class="text-slate-500">•</span>
                                        <span class="text-xs text-slate-300 font-semibold">{{ $formattedTime }} EST</span>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-black tracking-tight">
                                        {{ $location->name }}
                                    </h3>
                                    <p class="text-xs text-slate-400">
                                        {{ $location->address_line1 }}, {{ $location->city }}, {{ $location->province_code }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl bg-white/10 text-xs font-bold text-white border border-white/15">
                                    {{ $boardingPassengers->count() }} Boarding • {{ $dropoffPassengers->count() }} Disembarking
                                </span>
                            </div>
                        </div>

                        <!-- Boarding Passengers Roster -->
                        <div class="p-5 sm:p-6 space-y-4">
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
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $booking->user->phone ?? '');
                                            $isPaid = $booking->payment?->status === 'paid';
                                            $isCheckedIn = $booking->isCheckedIn();
                                            $escapedName = addslashes($booking->user->name);
                                            $fareFormatted = number_format($booking->final_fare, 2);
                                        @endphp

                                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 hover:bg-slate-50 transition flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                            <!-- Passenger Identity & Route Details -->
                                            <div class="flex items-start sm:items-center gap-3.5">
                                                <!-- Cabin Physical Seat Badge -->
                                                <div class="flex-shrink-0 flex flex-col items-center justify-center min-w-[56px] h-14 rounded-2xl bg-slate-900 text-white p-2 text-center shadow-xs">
                                                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">SEAT</span>
                                                    <span class="text-base font-black text-emerald-400 font-mono leading-none">
                                                        {{ $seatNumbers ?: 'S' . $booking->seat_count }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h5 class="text-base font-black text-slate-900">
                                                            {{ $booking->user->name }}
                                                        </h5>
                                                        <span class="text-[11px] font-mono text-slate-500 bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                                            {{ $booking->booking_reference }}
                                                        </span>
                                                        <span class="text-xs font-semibold text-slate-600">
                                                            ({{ $booking->seat_count }} seat{{ $booking->seat_count === 1 ? '' : 's' }})
                                                        </span>
                                                    </div>

                                                    <div class="flex flex-wrap items-center gap-2 mt-1 text-xs text-slate-500">
                                                        <span>Drop-off: <strong class="text-slate-800 font-semibold">{{ $booking->dropoffStop->location->name }}</strong></span>
                                                        <span>•</span>
                                                        <span>Fare: <strong class="text-slate-800 font-bold font-mono">CAD ${{ $fareFormatted }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Touch Controls: Call, WhatsApp, Check-in, Cash Collection -->
                                            <div class="flex flex-wrap items-center gap-2 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-200/60">
                                                <!-- Contact Actions: Min 44x44px touch target -->
                                                @if ($booking->user->phone)
                                                    <a href="tel:{{ $booking->user->phone }}" 
                                                       title="Call Passenger"
                                                       class="min-h-[44px] min-w-[44px] px-3 inline-flex items-center justify-center gap-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition shadow-2xs">
                                                        <svg class="h-4 w-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <span class="hidden sm:inline">{{ $booking->user->phone }}</span>
                                                    </a>

                                                    @if ($cleanPhone)
                                                        <a href="https://wa.me/{{ $cleanPhone }}" 
                                                           target="_blank" 
                                                           rel="noopener noreferrer"
                                                           title="WhatsApp Message"
                                                           class="min-h-[44px] min-w-[44px] px-3 inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition shadow-2xs">
                                                            <svg class="h-4 w-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.772.82 2.792.82 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.587-5.766-5.768-5.766zm3.385 8.163c-.144.405-.837.774-1.17.822-.312.043-.679.066-2.12-.533-1.841-.765-3.033-2.639-3.125-2.761-.091-.122-.739-.984-.739-1.876 0-.893.468-1.332.635-1.512.167-.18.365-.225.487-.225.122 0 .243.001.35.006.112.005.263-.042.412.316.153.366.522 1.272.568 1.363.045.092.076.198.015.319-.061.121-.091.198-.182.304-.091.106-.192.237-.274.318-.092.091-.188.19-.081.373.106.183.473.78 1.015 1.263.698.621 1.287.814 1.47.905.182.091.289.076.395-.045.106-.122.456-.532.578-.714.121-.183.243-.152.41-.091.167.061 1.063.501 1.246.592.182.091.304.137.35.213.045.076.045.441-.099.846z"/>
                                                            </svg>
                                                            <span class="hidden sm:inline">WhatsApp</span>
                                                        </a>
                                                    @endif
                                                @endif

                                                <!-- Check-In Action with Confirmation Modal -->
                                                @if ($isCheckedIn)
                                                    <span class="inline-flex min-h-[44px] items-center gap-1.5 px-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                                                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>Checked In ({{ $booking->checked_in_at->format('g:i A') }})</span>
                                                    </span>
                                                @else
                                                    <form id="form-checkin-{{ $booking->id }}" method="POST" action="{{ route('rider.trips.bookings.check-in', [$trip, $booking]) }}">
                                                        @csrf
                                                        <button type="button" 
                                                                onclick="triggerCheckInModal('form-checkin-{{ $booking->id }}', '{{ $escapedName }}', '{{ $seatNumbers }}')"
                                                                class="min-h-[44px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                                            <svg class="h-3.5 w-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span>Check In</span>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Cash Collection Action with Dedicated Confirmation Modal -->
                                                @if ($isPaid)
                                                    <span class="inline-flex min-h-[44px] items-center gap-1.5 px-3 rounded-xl bg-emerald-600 text-white text-xs font-black uppercase tracking-wider shadow-xs">
                                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>PAID (${{ number_format($booking->payment->amount, 2) }})</span>
                                                    </span>
                                                @else
                                                    @if ($booking->payment)
                                                        <form id="form-collect-{{ $booking->payment->id }}" method="POST" action="{{ route('rider.trips.payments.collect', [$trip, $booking->payment]) }}">
                                                            @csrf
                                                            <button type="button" 
                                                                    onclick="triggerCashCollectionModal('form-collect-{{ $booking->payment->id }}', '{{ $escapedName }}', '{{ $fareFormatted }}', '{{ $seatNumbers }}')"
                                                                    class="min-h-[44px] px-4 inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#22C55E] hover:bg-emerald-600 text-white text-xs font-black uppercase tracking-wider shadow-sm transition hover:scale-[1.02] cursor-pointer">
                                                                <span class="font-mono font-bold">$</span>
                                                                <span>Collect CAD ${{ $fareFormatted }}</span>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="inline-flex min-h-[44px] items-center px-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                                                            UNPAID (${{ $fareFormatted }})
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
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" title="Boarded"></span>
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

            <!-- Footer Dispatch Card -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Dispatch Assistance</span>
                        <span class="text-sm font-black text-slate-900">Phone &amp; SMS: 647-655-1884</span>
                    </div>
                </div>

                <a href="tel:16476551884" 
                   class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 px-4 py-2 text-xs font-bold transition">
                    <span>Call Dispatch Support</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Modern Operational Action Confirmation Modal -->
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
                        class="absolute top-5 right-5 h-8 w-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Icon -->
                <div id="confirm-modal-icon-container" class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4">
                    <!-- Icon injected by JS -->
                </div>

                <!-- Modal Content -->
                <div class="text-center space-y-2">
                    <span id="confirm-modal-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">
                    </span>

                    <h3 id="confirm-modal-title" class="text-xl font-black font-heading text-slate-900 tracking-tight">
                    </h3>

                    <p id="confirm-modal-message" class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm mx-auto">
                    </p>

                    <!-- Extra Details Box -->
                    <div id="confirm-modal-details" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-700 space-y-1 text-left hidden">
                    </div>
                </div>

                <!-- Actions Grid -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-center gap-3">
                    <button type="button" 
                            onclick="closeDriverConfirmModal()" 
                            class="w-1/2 inline-flex min-h-[46px] items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 text-xs sm:text-sm font-bold transition">
                        Cancel
                    </button>

                    <button type="button" 
                            id="confirm-modal-submit-btn" 
                            onclick="executeDriverConfirmAction()" 
                            class="w-1/2 inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl text-white px-4 py-2 text-xs sm:text-sm font-bold shadow-xs transition">
                        <span>Confirm</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Dynamic Confirmation Modal Controls -->
    <script>
        let pendingFormId = null;

        function openDriverConfirmModal(config) {
            pendingFormId = config.formId;

            const modal = document.getElementById('driver-confirm-modal');
            const iconContainer = document.getElementById('confirm-modal-icon-container');
            const badge = document.getElementById('confirm-modal-badge');
            const title = document.getElementById('confirm-modal-title');
            const message = document.getElementById('confirm-modal-message');
            const details = document.getElementById('confirm-modal-details');
            const submitBtn = document.getElementById('confirm-modal-submit-btn');

            // Setup Badge
            badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider ' + (config.badgeClass || 'bg-slate-100 text-slate-800');
            badge.textContent = config.badgeText;

            // Setup Title & Message
            title.textContent = config.title;
            message.textContent = config.message;

            // Setup Details Box if provided
            if (config.detailsHtml) {
                details.innerHTML = config.detailsHtml;
                details.classList.remove('hidden');
            } else {
                details.classList.add('hidden');
                details.innerHTML = '';
            }

            // Setup Icon
            iconContainer.className = 'mx-auto flex h-14 w-14 items-center justify-center rounded-2xl mb-4 ' + (config.iconBgClass || 'bg-emerald-50 text-emerald-600 border border-emerald-200');
            iconContainer.innerHTML = config.iconSvg;

            // Setup Submit Button
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

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDriverConfirmModal();
            }
        });

        // Trigger helpers
        function triggerCashCollectionModal(formId, passengerName, amountFormatted, seatNumbers) {
            openDriverConfirmModal({
                formId: formId,
                badgeText: 'Cash Settlement',
                badgeClass: 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                title: 'Confirm Cash Collection',
                message: 'Confirm physical receipt of cash from ' + passengerName + ' upon boarding?',
                detailsHtml: '<div class="flex justify-between"><span>Passenger:</span><strong class="text-slate-900">' + passengerName + '</strong></div>' +
                             '<div class="flex justify-between"><span>Assigned Seat(s):</span><strong class="font-mono text-slate-900">' + seatNumbers + '</strong></div>' +
                             '<div class="flex justify-between pt-1 border-t border-slate-200 text-emerald-700 font-bold"><span>Amount Due:</span><span class="font-mono">CAD $' + amountFormatted + '</span></div>',
                iconBgClass: 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                iconSvg: '<svg class="h-7 w-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                btnClass: 'bg-[#22C55E] hover:bg-emerald-600',
                btnText: '<span>Confirm Collection</span>'
            });
        }

        function triggerStartTripModal() {
            openDriverConfirmModal({
                formId: 'form-start-trip',
                badgeText: 'Departure Confirmation',
                badgeClass: 'bg-sky-100 text-sky-800 border border-sky-200',
                title: 'Start Trip Run #{{ $trip->id }}',
                message: 'Ready to depart origin station? This will update the operational status to IN PROGRESS for all passengers.',
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
                btnClass: 'bg-slate-900 hover:bg-black',
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
                btnClass: 'bg-slate-800 hover:bg-slate-900',
                btnText: '<span>Confirm Boarded</span>'
            });
        }
    </script>
@endsection
