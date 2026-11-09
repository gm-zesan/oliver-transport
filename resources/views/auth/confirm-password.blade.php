<x-layouts.guest>
    <x-slot:title>Confirm Password — PickMeRoute</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 font-heading">
            Security Confirmation
        </h2>
        <p class="mt-2 text-xs text-slate-500">
            This is a secure action. Please confirm your account password before proceeding.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full">
                {{ __('Confirm Password') }}
            </x-primary-button>
        </div>
    </form>
</x-layouts.guest>

