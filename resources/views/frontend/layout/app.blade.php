<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title ?? config('app.name', 'Oliver Transport'))</title>

    @include('frontend.partials.favicon')
    @include('frontend.partials.styles')
</head>
<body class="flex min-h-screen min-h-[100dvh] flex-col bg-surface-subtle text-content-primary font-sans selection:bg-brand-green selection:text-white pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] pl-[env(safe-area-inset-left)] pr-[env(safe-area-inset-right)]">
    @include('frontend.partials.header')

    <!-- Flash Status Messages -->
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('status'))
            <div class="mb-4 rounded-xl border border-brand-green/30 bg-brand-green-subtle p-4 text-sm font-semibold text-brand-green" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-brand-red/30 bg-brand-red-light p-4 text-sm font-semibold text-brand-red" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('frontend.partials.footer')
    @include('frontend.partials.script')
</body>
</html>

