<x-layouts.app>
    <x-slot:title>Rider Portal — Oliver Transport</x-slot:title>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Banner -->
        <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="inline-flex items-center rounded-full bg-provisional-highlight/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-provisional-highlight border border-provisional-highlight/20">
                        Driver Operational Panel
                    </span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Welcome, {{ $user->name }}
                    </h1>
                    <p class="mt-1 text-sm text-provisional-muted">
                        Assigned Vehicle: <strong class="text-white">Honda Odyssey (Plate: RAJIA)</strong> • 6 Passenger Seats
                    </p>
                </div>
            </div>
        </div>

        <!-- Foundation Notice -->
        <div class="mt-8 rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-provisional-highlight/10 text-provisional-highlight mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25H4.125c-.621 0-1.125.504-1.125 1.125v6.75" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-white">Rider Operational Foundation Established</h2>
            <p class="mt-2 max-w-lg mx-auto text-sm text-provisional-muted">
                Your driver identity is authenticated. In upcoming phases, this dashboard will present your daily assigned runs, stop-ordered passenger manifests, click-to-call communication, and one-tap cash collection logging.
            </p>
        </div>
    </div>
</x-layouts.app>

