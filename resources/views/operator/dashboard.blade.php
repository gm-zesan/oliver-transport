<x-layouts.app>
    <x-slot:title>Operator Portal — Oliver Transport</x-slot:title>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Banner -->
        <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="inline-flex items-center rounded-full bg-provisional-alert/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-provisional-alert border border-provisional-alert/20">
                        System Operator Portal
                    </span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Welcome, {{ $user->name }}
                    </h1>
                    <p class="mt-1 text-sm text-provisional-muted">
                        Email: <span class="text-white">{{ $user->email }}</span> • Role: <strong class="text-white">{{ $user->role }}</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Foundation Notice -->
        <div class="mt-8 rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-provisional-alert/10 text-provisional-alert mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-white">System Operator Foundation Established</h2>
            <p class="mt-2 max-w-lg mx-auto text-sm text-provisional-muted">
                Your operator credentials provide system-wide administrative oversight. In upcoming phases, operational analytics, driver assignments, and booking overrides will be available here.
            </p>
        </div>
    </div>
</x-layouts.app>

