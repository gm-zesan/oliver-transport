<x-layouts.app>
    <x-slot:title>Passenger Portal — Oliver Transport</x-slot:title>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Banner -->
        <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="inline-flex items-center rounded-full bg-provisional-accent/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-provisional-accent border border-provisional-accent/20">
                        Passenger Portal
                    </span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Welcome back, {{ $user->name }}
                    </h1>
                    <p class="mt-1 text-sm text-provisional-muted">
                        Email: <span class="text-white">{{ $user->email }}</span> • Phone: <span class="text-white">{{ $user->phone }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Foundation Notice -->
        <div class="mt-8 rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-provisional-accent/10 text-provisional-accent mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-white">Passenger Foundation Successfully Established</h2>
            <p class="mt-2 max-w-lg mx-auto text-sm text-provisional-muted">
                Your passenger account is active and verified. In upcoming phases, this dashboard will feature your upcoming Montreal ↔ Toronto reservations, seat allocations, and digital boarding passes.
            </p>
        </div>
    </div>
</x-layouts.app>
