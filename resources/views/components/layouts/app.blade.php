<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-provisional-bg text-provisional-text antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Oliver Transport') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen min-h-[100dvh] flex-col bg-provisional-bg text-provisional-text font-sans selection:bg-provisional-accent selection:text-provisional-bg pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)]">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 border-b border-provisional-border bg-provisional-surface/95 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
            <!-- Brand Mark (Provisional Text-Based Styling: Official Logo Asset Pending) -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px] min-w-[44px] py-1 focus:outline-none focus:ring-2 focus:ring-provisional-accent rounded-lg" aria-label="Oliver Transport Home">
                <span class="text-2xl font-black tracking-tight text-white">
                    Ol<span class="text-provisional-accent">iver</span>
                </span>
                <span class="rounded bg-provisional-accent/10 px-2 py-0.5 text-xs font-bold uppercase tracking-wider text-provisional-accent border border-provisional-accent/20">
                    Transport
                </span>
            </a>

            <!-- User Status & Actions -->
            <div class="flex items-center gap-3">
                @auth
                    <!-- Role Indicator Badge -->
                    <span class="hidden sm:inline-flex items-center rounded-full bg-provisional-card px-2.5 py-1 text-xs font-semibold uppercase tracking-wider text-provisional-muted border border-provisional-border">
                        Role: <span class="ml-1 text-white font-bold">{{ auth()->user()->role }}</span>
                    </span>

                    <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-provisional-muted hover:text-white transition px-2 py-1 min-h-[44px] inline-flex items-center" aria-label="Account Profile">
                        {{ auth()->user()->name }}
                    </a>

                    <!-- Logout Button (Min 44x44px Touch Target) -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2 text-sm font-semibold text-provisional-text shadow-sm hover:bg-provisional-border hover:text-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent transition">
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg bg-provisional-accent px-4 py-2 text-sm font-bold text-provisional-bg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Status Messages -->
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-provisional-accent/30 bg-provisional-accent/10 p-4 text-sm text-provisional-accent" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-lg border border-provisional-alert/30 bg-provisional-alert/10 p-4 text-sm text-provisional-alert" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Global Footer -->
    <footer class="border-t border-provisional-border bg-provisional-surface py-6 text-sm text-provisional-muted">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} Oliver Transport. Scheduled Montreal ↔ Toronto Shuttle Service.</p>
            <div class="flex items-center gap-6">
                <span>Text / Call: <strong class="text-white">647-655-1884</strong></span>
                <span>Facebook: <strong class="text-white">Oliver Transport</strong></span>
            </div>
        </div>
    </footer>
</body>
</html>
