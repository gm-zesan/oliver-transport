@extends('frontend.layout.app')

@section('title', 'Driver Panel — Passenger Boarding Roster — Oliver Transport')

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

        <!-- Ambient Warm Gold / Amber Glow in Background for Driver Portal -->
        <div class="absolute top-4 right-1/4 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 pb-6">
                <!-- Driver Identity & Operational Info -->
                <div class="flex items-start sm:items-center gap-5 sm:gap-6">
                    <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-3xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center font-black text-2xl sm:text-3xl shadow-xl shadow-amber-500/30 flex-shrink-0 ring-4 ring-amber-400/30">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500/25 text-amber-300 border border-amber-400/30 backdrop-blur-md">
                                <span class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                                <span>Driver Operational Panel</span>
                            </span>
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline">•</span>
                            <span class="text-xs font-semibold text-slate-200 hidden sm:inline drop-shadow-xs">Silver Honda Odyssey (Plate: <strong class="font-mono text-amber-300">RAJIA</strong>)</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black font-heading text-white tracking-tight leading-tight drop-shadow-sm">
                            Welcome, {{ $user->name }}
                        </h1>
                        
                        <div class="pt-1 flex flex-wrap items-center gap-2.5 text-xs sm:text-sm text-slate-200">
                            <span class="inline-flex items-center gap-2 bg-white/15 text-slate-100 border border-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-xl font-medium shadow-xs">
                                <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Eastern Time: {{ $today->format('l, F j, Y') }}</span>
                            </span>
                            @if($user->phone)
                                <span class="inline-flex items-center gap-2 bg-white/15 text-slate-100 border border-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-xl font-medium shadow-xs">
                                    <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $user->phone }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Driver Quick Action -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white/15 hover:bg-white/25 border border-white/20 backdrop-blur-md text-white px-6 py-2.5 text-xs sm:text-sm font-bold shadow-xs transition">
                        <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Driver Settings</span>
                    </a>
                </div>
            </div>

            <!-- Portal Navigation Strip -->
            <div class="flex items-center gap-2 pt-3 border-t border-slate-800/80 overflow-x-auto select-none">
                <a href="{{ route('rider.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition bg-white text-slate-900 shadow-xs">
                    <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Passenger Roster &amp; Runs</span>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile Settings</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-8 sm:py-10 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alerts -->
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
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isSameDay($today->copy()->subDay()) ? 'bg-slate-900 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Yesterday
                    </a>

                    <!-- Today Pill -->
                    <a href="{{ route('rider.dashboard', ['date' => $today->toDateString()]) }}" 
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isToday() ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        Today
                    </a>

                    <!-- Tomorrow Pill -->
                    <a href="{{ route('rider.dashboard', ['date' => $today->copy()->addDay()->toDateString()]) }}" 
                       class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $selectedDate->isSameDay($today->copy()->addDay()) ? 'bg-slate-900 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
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

            <!-- Fleet & Corridor Baseline Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Daily Service Corridor</span>
                        <span class="text-base font-black text-slate-900">Montreal ↔ Toronto</span>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Assigned Minivan</span>
                        <span class="text-base font-black text-slate-900">RAJIA (Honda Odyssey)</span>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <span class="text-lg font-black font-mono text-[#22C55E]">$</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Payment Model</span>
                        <span class="text-base font-black text-slate-900">Cash On Boarding</span>
                    </div>
                </div>
            </div>

            <!-- Assigned Runs Section Header -->
            <div class="flex items-center justify-between pt-2">
                <div>
                    <h2 class="text-xl font-black font-heading text-slate-900">
                        Scheduled Runs ({{ $selectedDate->format('M j, Y') }})
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Open the Passenger Boarding Roster for each run to verify seats, contact travelers, check in passengers, and record cash payments.
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
                        @endphp

                        <div class="rounded-3xl border border-slate-200/90 bg-white p-6 shadow-xs flex flex-col justify-between hover:border-slate-300 transition">
                            <div class="space-y-4">
                                <!-- Card Header: Direction & Status Badge -->
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 mb-1">
                                            Run #{{ $trip->id }} • {{ $trip->route->service_label ?? $trip->route->name }}
                                        </span>
                                        <h3 class="text-lg font-black text-slate-900 font-heading">
                                            {{ $trip->route->name }}
                                        </h3>
                                    </div>

                                    @if ($trip->status === 'in_progress')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                            <span>IN PROGRESS</span>
                                        </span>
                                    @elseif ($trip->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            <span>COMPLETED</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200">
                                            <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                                            <span>SCHEDULED</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Schedule & Route Details -->
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                                    <div class="flex items-center justify-between text-xs sm:text-sm">
                                        <span class="text-slate-500 font-medium">Departure Time</span>
                                        <span class="text-slate-900 font-black">{{ $depTime }} EST</span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs sm:text-sm">
                                        <span class="text-slate-500 font-medium">Passenger Occupancy</span>
                                        <span class="font-bold {{ $isFull ? 'text-amber-600' : 'text-slate-900' }}">
                                            {{ $bookedSeatCount }} of 6 Seats Booked {{ $isFull ? '(FULL)' : '' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs sm:text-sm pt-1 border-t border-slate-200/60">
                                        <span class="text-slate-500 font-medium">Cash Settlement Summary</span>
                                        <span class="font-bold text-slate-900">
                                            CAD ${{ number_format($collectedFare, 2) }} / ${{ number_format($expectedFare, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Route Stop Sequence Chips -->
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">Route Stations</span>
                                    <div class="flex flex-wrap items-center gap-1.5 text-xs text-slate-600 font-medium">
                                        @foreach ($trip->route->stops->sortBy('stop_sequence') as $stop)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700">
                                                {{ $stop->location->name }}
                                            </span>
                                            @if (! $loop->last)
                                                <span class="text-slate-300">→</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Passenger Roster Action Button -->
                            <div class="mt-6 pt-4 border-t border-slate-100">
                                <a href="{{ route('rider.trips.manifest', $trip) }}" 
                                   class="inline-flex w-full min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-slate-900 hover:bg-[#22C55E] text-white px-5 py-3 text-sm font-bold shadow-xs transition focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                                    <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
