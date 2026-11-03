<x-layouts.guest>
    <x-slot:title>Forgot Password — Oliver Transport</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-white">
            Reset Your Password
        </h2>
        <p class="mt-2 text-xs text-provisional-muted">
            Enter your account email address and we will send you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="passenger@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 border-t border-provisional-border pt-4 text-center">
        <a href="{{ route('login') }}" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-provisional-muted hover:text-white transition">
            ← Back to Sign In
        </a>
    </div>
</x-layouts.guest>

