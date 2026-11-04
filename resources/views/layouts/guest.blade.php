<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sign In — Oliver Transport' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen min-h-[100dvh] flex-col justify-center bg-[#EEF2F6] text-slate-900 font-sans selection:bg-[#22C55E] selection:text-white px-4 py-8 sm:px-6 lg:px-8 pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)] relative overflow-x-hidden">

    <!-- High-Quality Daylight Scenic Background (Clearly Visible & Realistic) -->
    <div class="fixed inset-0 z-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
        <img src="{{ asset('images/service-intercity.jpg') }}" 
             alt="Oliver Transport Corridor" 
             class="w-full h-full object-cover object-center filter brightness-[1.02] contrast-[1.02] scale-105" />
        <!-- Subtle Translucent Day Veil for Contrast -->
        <div class="absolute inset-0 bg-slate-900/10"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/35 via-transparent to-white/45"></div>
    </div>

    <!-- Soft Luminous Daylight Aura in Background -->
    <div class="fixed top-6 left-1/2 -translate-x-1/2 w-[650px] h-[350px] bg-gradient-to-r from-emerald-300/25 to-teal-100/25 rounded-full blur-3xl pointer-events-none z-0" aria-hidden="true"></div>

    <!-- Centered Brand Logo (Clean Floating Logo — No Box Background) -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center mb-6">
        <a href="{{ route('home') }}" class="inline-block transition hover:opacity-90 drop-shadow-sm focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-xl" aria-label="Oliver Transport Home">
            <x-brand-logo size="md" :show-subtitle="true" />
        </a>
    </div>

    <!-- Frosted Glassmorphism Form Card (Authentic Glass Pane with Low Opacity Fill like Reference Image) -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="rounded-[32px] border border-white/70 bg-white/45 backdrop-blur-2xl px-6 py-8 sm:px-10 sm:py-10 shadow-2xl shadow-slate-900/15 text-slate-900 ring-1 ring-white/50">
            <!-- Flash Status Messages -->
            @if (session('status'))
                <div class="mb-5 rounded-2xl border border-emerald-300/80 bg-white/80 backdrop-blur-md p-3.5 text-xs font-semibold text-[#16A34A] flex items-center gap-2 shadow-xs" role="alert">
                    <svg class="h-4 w-4 flex-shrink-0 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-2xl border border-red-300/80 bg-white/80 backdrop-blur-md p-3.5 text-xs font-semibold text-red-600 flex items-center gap-2 shadow-xs" role="alert">
                    <svg class="h-4 w-4 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </div>

        <!-- Help & Contact Footnote in Light Theme -->
        <div class="mt-6 text-center text-xs text-slate-700 space-y-1">
            <p class="drop-shadow-xs font-medium">
                Need booking assistance? Call or SMS 
                <a href="tel:6476551884" class="font-bold text-slate-900 hover:text-[#16A34A] underline inline-flex items-center gap-1 transition">
                    647-655-1884
                </a>
            </p>
            <p class="text-[11px] text-slate-600 font-medium">
                Oliver Transport • Montreal ↔ Toronto Daily Express
            </p>
        </div>
    </div>
</body>
</html>
