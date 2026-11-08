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

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('frontend.partials.footer')
    @include('frontend.partials.auth-modal')
    @include('frontend.partials.seat-picker-modal')
    @include('frontend.partials.role-restriction-modal')
    @include('frontend.partials.toaster')
    @include('frontend.partials.script')
</body>
</html>

