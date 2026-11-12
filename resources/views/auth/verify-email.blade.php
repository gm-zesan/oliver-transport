<x-layouts.guest>
    <x-slot:title>{{ __('Verify Email') }} — PickMeRoute</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 font-heading">
            {{ __('Verify Email Address') }}
        </h2>
        <p class="mt-2 text-xs text-slate-500">
            {{ __('Thanks for signing up with PickMeRoute! Please click the verification link we sent to your email to activate all passenger features.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl border border-emerald-200 bg-[#F0FDF4] p-3.5 text-xs text-[#16A34A] font-medium">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button class="w-full">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-slate-500 hover:text-slate-900 transition cursor-pointer">
                {{ __('Sign Out') }}
            </button>
        </form>
    </div>
</x-layouts.guest>

