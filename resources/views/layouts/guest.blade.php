@props([
    'title' => 'Sign In — PickMeRoute',
    'hideFloatingLogo' => false,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sign In — PickMeRoute' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Favicon & Meta Tags -->
    @include('frontend.partials.favicon')

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- iOS Safari Form & Touch Optimizations -->
    <style>
        input,
        button,
        select,
        textarea,
        a {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="tel"] {
            -webkit-appearance: none;
            appearance: none;
            font-size: 16px !important;
            /* Strictly prevents iOS Safari auto-zoom disorientation */
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.95) inset !important;
            -webkit-text-fill-color: #0f172a !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>

<body
    class="flex min-h-screen min-h-[100dvh] flex-col justify-center bg-[#EEF2F6] text-slate-900 font-sans selection:bg-[#22C55E] selection:text-white px-4 py-8 sm:px-6 lg:px-8 pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)] relative overflow-x-hidden">

    <!-- High-Quality Scenic Background (Generated Intercity Highway Corridor) -->
    <div class="fixed inset-0 z-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
        <img src="{{ asset('images/login-corridor-bg.jpg') }}" alt="PickMeRoute Corridor"
            class="w-full h-full object-cover object-center filter brightness-[1.02] contrast-[1.02] scale-105" />
        <!-- Subtle Translucent Day Veil for Contrast -->
        <div class="absolute inset-0 bg-slate-900/15"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/30 via-transparent to-white/40"></div>
    </div>

    <!-- Soft Luminous Daylight Aura in Background -->
    <div class="fixed top-6 left-1/2 -translate-x-1/2 w-[650px] h-[350px] bg-gradient-to-r from-emerald-300/25 to-teal-100/25 rounded-full blur-3xl pointer-events-none z-0"
        aria-hidden="true"></div>

    @include('frontend.partials.toaster')

    <!-- Language Switcher in Guest Layout (Top Right) -->
    <div class="fixed top-4 right-4 z-30 flex items-center rounded-full border border-slate-300/80 bg-white/85 backdrop-blur-md p-0.5 text-xs font-bold shadow-xs">
        <a href="{{ route('locale.switch', 'en') }}"
            class="px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-[#22C55E] text-white shadow-xs' : 'text-slate-700 hover:text-slate-900' }}"
            title="English">EN</a>
        <a href="{{ route('locale.switch', 'fr') }}"
            class="px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'fr' ? 'bg-[#22C55E] text-white shadow-xs' : 'text-slate-700 hover:text-slate-900' }}"
            title="Français">FR</a>
    </div>

    <!-- Frosted Glassmorphism Form Card (Authentic Glass Pane with Sharp Mobile Readability) -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div
            class="rounded-[32px] border border-white/80 bg-white/65 backdrop-blur-2xl px-6 py-8 sm:px-10 sm:py-10 shadow-2xl shadow-slate-900/15 text-slate-900 ring-1 ring-white/60">
            {{ $slot }}
        </div>
    </div>
</body>

</html>