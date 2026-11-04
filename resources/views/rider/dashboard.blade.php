@extends('frontend.layout.app')

@section('title', 'Rider Portal — Oliver Transport')

@section('content')
    <!-- Executive Light Hero Header Section -->
    <section class="relative bg-gradient-to-b from-white via-slate-50/90 to-[#F8FAFC] pt-28 sm:pt-32 pb-6 sm:pb-8 border-b border-slate-200/90 overflow-hidden">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 pb-6">
                <!-- Driver Identity & Title -->
                <div class="flex items-start sm:items-center gap-4">
                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-amber-500/25 flex-shrink-0 ring-4 ring-amber-100">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                <span>Driver Operational Panel</span>
                            </span>
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline">•</span>
                            <span class="text-xs font-semibold text-slate-500 hidden sm:inline">Assigned: Honda Odyssey (RAJIA)</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading text-slate-900 tracking-tight leading-tight">
                            Welcome, {{ $user->name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Silver Honda Odyssey minivan • Plate: <strong class="text-slate-900 font-mono">RAJIA</strong> (6 Passenger Seats)
                        </p>
                    </div>
                </div>

                <!-- Driver Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-6 py-2.5 text-xs sm:text-sm font-bold shadow-xs transition">
                        <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Driver Profile</span>
                    </a>
                </div>
            </div>

            <!-- Portal Navigation Tabs Strip -->
            <div class="flex items-center gap-2 pt-2 border-t border-slate-200/70 overflow-x-auto select-none">
                <a href="{{ route('rider.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition bg-slate-900 text-white shadow-xs">
                    <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span>Manifest &amp; Runs</span>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile Settings</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Content Area -->
    <section class="py-8 sm:py-12 bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Assigned Run Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Daily Service</span>
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
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Operating Van</span>
                        <span class="text-base font-black text-slate-900">RAJIA (Honda Odyssey)</span>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/90 bg-white p-5 shadow-xs flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-[#F0FDF4] text-[#22C55E] flex items-center justify-center flex-shrink-0">
                        <span class="text-lg font-black font-mono text-[#22C55E]">$</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Settlement Model</span>
                        <span class="text-base font-black text-slate-900">Cash On Boarding</span>
                    </div>
                </div>
            </div>

            <!-- Foundation Status Card -->
            <div class="rounded-3xl border border-slate-200/90 bg-white p-8 sm:p-10 shadow-xs text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 mb-4 border border-amber-200">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25H4.125c-.621 0-1.125.504-1.125 1.125v6.75" />
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-900 font-heading">
                    Driver Identity Authenticated
                </h2>
                <p class="mt-2 max-w-lg mx-auto text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Your rider credentials are active. In Phase 4, this panel will display your real-time daily passenger boarding manifest, station stop sequencing, tap-to-call passenger communication, and one-tap cash settlement collection logging.
                </p>
                <div class="mt-6">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-6 py-2.5 text-xs sm:text-sm font-bold transition">
                        <span>Manage Driver Profile</span>
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection
