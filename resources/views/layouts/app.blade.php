<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
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
<body class="flex min-h-screen min-h-[100dvh] flex-col bg-surface-subtle text-content-primary font-sans selection:bg-brand-green selection:text-white pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)]">
    <!-- Top Navigation -->
    <x-navigation />

    <!-- Toast Notifications -->
    @include('frontend.partials.toaster')

    <!-- Main Content Area -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Global Footer -->
    <x-footer />
</body>
</html>
