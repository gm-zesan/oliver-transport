@extends('frontend.layout.app')

@section('title', 'Driver Panel — Passenger Boarding Roster — Oliver Transport')

@section('content')
    <!-- Executive Driver Hero Header Section with Clean, Spacious Layout & Reduced Height -->
    <section class="relative overflow-hidden bg-slate-950 pt-28 sm:pt-36 lg:pt-40 pb-10 sm:pb-14 lg:pb-16 border-b border-slate-800 text-white select-none">
        
        <!-- Fleet Background Image with High Contrast Gradients -->
        <div class="absolute inset-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ asset('images/honda-odyssey-fleet-raw.jpg') }}" 
                 alt="Oliver Transport Fleet" 
                 class="w-full h-full object-cover object-center scale-105 filter brightness-[0.70] contrast-[1.10] saturate-110" />
            <!-- Balanced Luminous Cinematic Gradients for Crisp Text Contrast -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/92 via-slate-950/70 to-slate-950/45"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-transparent to-black/30"></div>
        </div>

        <!-- Ambient Warm Gold / Amber Glow in Background for Driver Portal -->
        <div class="absolute top-4 right-1/4 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <!-- Driver Identity & Operational Info -->
                <div class="flex items-center gap-4 sm:gap-5">
                    <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center font-black text-xl sm:text-2xl shadow-lg shadow-amber-500/30 flex-shrink-0 ring-4 ring-amber-400/25">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading text-white tracking-tight leading-tight drop-shadow-sm">
                            Welcome, {{ $user->name }}
                        </h1>
                        
                        <div class="pt-1.5 text-xs text-slate-300 flex flex-wrap items-center gap-2">
                            <span>Eastern Time: <strong>{{ $today->format('l, F j, Y') }}</strong></span>
                            <span class="text-slate-500">•</span>
                            <span>Honda Odyssey (<strong class="font-mono text-amber-300">RAJIA</strong>)</span>
                            <span class="hidden sm:inline text-slate-500">•</span>
                            <span class="hidden sm:inline text-slate-300">Montreal ↔ Toronto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-8 sm:py-10 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Interactive Date Switcher & Schedule Inspector -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Schedule Date</span>
                        @if ($selectedDate->isToday())
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Today's Active Runs</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-100 text-amber-800">
                                <span>Previewing: {{ $selectedDate->format('M j, Y') }}</span>
                            </span>
                        @endif
                    </div>
                    <h3 class="text-lg sm:text-xl font-black font-heading text-slate-900 mt-1">
                        {{ $selectedDate->format('l, F j, Y') }}
                    </h3>
                </div>

                <!-- Quick Date Filter Buttons & Calendar Selector -->
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Yesterday Pill -->
                    <a href="{{ route('rider.dashboard', ['date' => $today->copy()->subDay()->toDateString()]) }}" 
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isSameDay($today->copy()->subDay()) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Yesterday
                    </a>

                    <!-- Today Pill -->
                    <a href="{{ route('rider.dashboard', ['date' => $today->toDateString()]) }}" 
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isToday() ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Today
                    </a>

                    <!-- Tomorrow Pill -->
                    <a href="{{ route('rider.dashboard', ['date' => $today->copy()->addDay()->toDateString()]) }}" 
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isSameDay($today->copy()->addDay()) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Tomorrow
                    </a>

                    <!-- Custom HTML5 Date Input -->
                    <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <input type="date" 
                               value="{{ $selectedDate->toDateString() }}" 
                               onchange="window.location.href='{{ route('rider.dashboard') }}?date=' + this.value" 
                               class="bg-transparent border-0 p-0 text-xs font-bold text-slate-800 focus:ring-0 cursor-pointer" 
                               aria-label="Pick custom date">
                    </div>

                    @if (! $selectedDate->isToday())
                        <a href="{{ route('rider.dashboard') }}" 
                           class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 underline px-2 py-1">
                            Reset to Today
                        </a>
                    @endif
                </div>
            </div>

            <!-- Shift Overview HUD: Financial & Occupancy Gauges -->
            @php
                $totalBookedSeats = $trips->sum(fn ($t) => $t->bookings->sum('seat_count'));
                $totalCapacity = $trips->count() * 6;
                $occupancyPercent = $totalCapacity > 0 ? min(100, round(($totalBookedSeats / $totalCapacity) * 100)) : 0;
                $totalExpected = (float) $trips->sum(fn ($t) => $t->bookings->sum('final_fare'));
                $totalCollected = (float) $trips->sum(fn ($t) => $t->bookings->filter(fn ($b) => $b->payment?->status === 'paid')->sum(fn ($b) => $b->payment?->amount ?? $b->final_fare));
                $totalPending = max(0.0, round($totalExpected - $totalCollected, 2));
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Occupancy Card -->
                <div class="p-4 sm:p-5 rounded-3xl bg-white border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider">Van Occupancy</span>
                        <span class="h-2 w-2 rounded-full {{ $totalBookedSeats >= $totalCapacity ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </div>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 font-mono">{{ $totalBookedSeats }}</span>
                        <span class="text-xs font-semibold text-slate-400">/ {{ $totalCapacity ?: 12 }} Seats</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full mt-3 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $occupancyPercent }}%;"></div>
                    </div>
                </div>

                <!-- Expected Cash Card -->
                <div class="p-4 sm:p-5 rounded-3xl bg-white border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider">Expected Cash</span>
                        <span class="text-xs font-mono text-slate-400 font-bold">CAD</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono mt-1">
                        ${{ number_format($totalExpected, 2) }}
                    </div>
                    <span class="text-xs text-slate-400 mt-2 block font-medium">Gross Shift Target</span>
                </div>

                <!-- Collected Cash Card -->
                <div class="p-4 sm:p-5 rounded-3xl bg-white border border-emerald-200 shadow-xs relative overflow-hidden">
                    <div class="flex items-center justify-between text-emerald-700 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider">Collected Cash</span>
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 font-mono mt-1">
                        ${{ number_format($totalCollected, 2) }}
                    </div>
                    <span class="text-xs text-emerald-700 mt-2 block font-medium">Physically Collected</span>
                </div>

                <!-- Pending Cash Card -->
                <div class="p-4 sm:p-5 rounded-3xl bg-white border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-slate-500 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider">Pending Cash</span>
                        <span class="h-2 w-2 rounded-full {{ $totalPending > 0 ? 'bg-rose-500' : 'bg-slate-300' }}"></span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black {{ $totalPending > 0 ? 'text-rose-600' : 'text-slate-900' }} font-mono mt-1">
                        ${{ number_format($totalPending, 2) }}
                    </div>
                    <span class="text-xs text-slate-400 mt-2 block font-medium">Due Upon Boarding</span>
                </div>
            </div>

            <!-- Assigned Runs Section Header -->
            <div class="flex items-center justify-between pt-2">
                <div>
                    <h2 class="text-xl font-black font-heading text-slate-900">
                        Operational Daily Runs ({{ $selectedDate->format('M j, Y') }})
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Select a run below to open the Passenger Boarding Roster, view assigned cabin seats, and collect cash.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>{{ $trips->count() }} Runs</span>
                </span>
            </div>

            <!-- Trip Run Cards -->
            @if ($trips->isEmpty())
                <div class="rounded-3xl border border-slate-200/90 bg-white p-8 text-center shadow-xs">
                    <p class="text-slate-600 font-medium">No trip runs are scheduled for {{ $selectedDate->format('l, F j, Y') }}.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($trips as $trip)
                        @php
                            $bookedSeatCount = $trip->bookings->sum('seat_count');
                            $isFull = $bookedSeatCount >= 6;
                            $depTime = \Carbon\Carbon::parse($trip->scheduled_departure_time)->format('g:i A');
                            $expectedFare = $trip->bookings->sum('final_fare');
                            $collectedFare = $trip->bookings->filter(fn ($b) => $b->payment?->status === 'paid')->sum(fn ($b) => $b->payment?->amount ?? $b->final_fare);
                            $orderedStops = $trip->route->stops->sortBy('stop_sequence');
                            $originStop = $orderedStops->first();
                            $destStop = $orderedStops->last();
                        @endphp

                        <div class="rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-slate-300 transition">
                            <div class="space-y-3.5">
                                <!-- Top Row: Direction/Run Tag on Left, Status Badge on Right (Clean mobile spacing) -->
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                        <span class="font-black text-slate-900">Run #{{ $trip->id }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span>{{ $trip->route->service_label ?? ($trip->route->direction === 'MTL_TO_TOR' ? 'Route A • Daily Service' : 'Route B • Daily Service') }}</span>
                                    </span>

                                    @if ($trip->status === 'in_progress')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 animate-pulse flex-shrink-0">
                                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                            <span>IN PROGRESS</span>
                                        </span>
                                    @elseif ($trip->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            <span>COMPLETED</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200 flex-shrink-0">
                                            <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                                            <span>SCHEDULED</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Route Name & Departure Time Tag -->
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 font-heading tracking-tight leading-snug">
                                        {{ $trip->route->name }}
                                    </h3>
                                    <div class="mt-1.5 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/60">
                                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Departs {{ $depTime }} EST</span>
                                    </div>
                                </div>

                                <!-- Route Timeline Strip -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                                    <div class="flex items-center justify-between text-xs font-bold text-slate-600">
                                        <span class="flex items-center gap-1.5 text-slate-900 truncate max-w-[45%]">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                            <span class="truncate">{{ $originStop?->location?->name ?? 'Origin' }}</span>
                                        </span>
                                        <div class="flex-1 mx-2 flex items-center justify-center">
                                            <div class="w-full border-t border-dashed border-slate-300"></div>
                                            <svg class="h-3.5 w-3.5 text-slate-400 -ml-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="flex items-center gap-1.5 text-slate-900 truncate max-w-[45%]">
                                            <span class="truncate">{{ $destStop?->location?->name ?? 'Destination' }}</span>
                                            <span class="h-2 w-2 rounded-full bg-slate-800 flex-shrink-0"></span>
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-200/60">
                                        <span class="text-slate-500 font-medium">Occupancy:</span>
                                        <strong class="font-bold {{ $isFull ? 'text-amber-600' : 'text-slate-900' }}">
                                            {{ $bookedSeatCount }} of 6 Seats Booked {{ $isFull ? '(FULL)' : '' }}
                                        </strong>
                                    </div>

                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-medium">Cash Collected:</span>
                                        <strong class="font-bold text-slate-900 font-mono">
                                            CAD ${{ number_format($collectedFare, 2) }} / ${{ number_format($expectedFare, 2) }}
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Passenger Roster Action Button: Brand Green Theme (#22C55E) -->
                            <div class="mt-5 pt-4 border-t border-slate-100">
                                <a href="{{ route('rider.trips.manifest', $trip) }}" 
                                   class="inline-flex w-full min-h-[50px] items-center justify-center gap-2 rounded-2xl bg-[#22C55E] hover:bg-[#16A34A] text-white px-5 py-3 text-sm font-bold shadow-md shadow-emerald-500/20 transition hover:scale-[1.01] focus:outline-hidden focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Open Passenger Boarding Roster</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Dispatch Emergency Contact Footer Card -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Dispatch Operations Helpdesk</span>
                        <span class="text-sm font-black text-slate-900">Phone &amp; SMS: 647-655-1884</span>
                    </div>
                </div>

                <a href="tel:16476551884" 
                   class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 px-4 py-2 text-xs font-bold transition">
                    <span>Call Dispatch</span>
                </a>
            </div>

        </div>
    </section>
@endsection
