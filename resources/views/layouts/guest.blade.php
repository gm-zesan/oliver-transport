<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-provisional-bg text-provisional-text antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sign In — Oliver Transport' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen min-h-[100dvh] flex-col justify-center bg-provisional-bg text-provisional-text font-sans selection:bg-provisional-accent selection:text-provisional-bg px-4 py-8 sm:px-6 lg:px-8 pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)]">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Brand Mark (Provisional Text-Based Styling: Official Logo Asset Pending) -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-provisional-accent rounded-lg p-1 min-h-[44px] min-w-[44px]" aria-label="Oliver Transport Home">
                <span class="text-4xl font-black tracking-tight text-white">
                    Ol<span class="text-provisional-accent">iver</span>
                </span>
                <span class="rounded bg-provisional-accent/10 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-provisional-accent border border-provisional-accent/20">
                    Transport
                </span>
            </a>
            <p class="mt-2 text-xs font-semibold uppercase tracking-widest text-provisional-muted">
                Montreal • Toronto • Montreal
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="rounded-2xl border border-provisional-border bg-provisional-surface px-6 py-8 shadow-2xl sm:px-10">
            <!-- Flash Status Messages -->
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-provisional-accent/30 bg-provisional-accent/10 p-4 text-sm text-provisional-accent" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-provisional-alert/30 bg-provisional-alert/10 p-4 text-sm text-provisional-alert" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </div>

        <!-- Help & Contact Footnote -->
        <div class="mt-6 text-center text-xs text-provisional-muted">
            <p>Need booking assistance? Text or call <a href="tel:6476551884" class="font-bold text-white hover:text-provisional-accent min-h-[44px] inline-flex items-center">647-655-1884</a></p>
        </div>
    </div>
</body>
</html>
