<x-layouts.guest>
    <x-slot:title>{{ __('Forgot Password') }} — PickMeRoute</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black tracking-tight text-slate-900 font-heading">
            {{ __('Reset Password') }}
        </h2>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            {{ __('Enter your account email address and we will send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="passenger@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 border-t border-slate-200/80 pt-4 text-center">
        <a href="{{ route('login') }}" class="font-bold text-xs sm:text-sm text-[#16A34A] hover:underline">
            {{ __('← Back to Sign In') }}
        </a>
    </div>
</x-layouts.guest>
