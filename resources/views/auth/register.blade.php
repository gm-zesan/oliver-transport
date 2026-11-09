<x-layouts.guest :hide-floating-logo="true">
    <x-slot:title>Register — PickMeRoute</x-slot:title>

    <!-- Brand Logo & Welcome Text inside Card (Matching Login Page) -->
    <div class="mb-6 text-center">
        <a href="{{ route('home') }}"
            class="inline-block transition hover:opacity-90 drop-shadow-sm focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-xl"
            aria-label="PickMeRoute Home">
            <x-brand-logo size="lg" :show-subtitle="true" />
        </a>
        <p class="mt-3 text-xs sm:text-sm text-slate-600 font-medium">
            Create your account to book your seats.
        </p>
    </div>

    <!-- Passenger Registration Form -->
    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                Full Name
            </label>
            <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                placeholder="e.g. John Doe">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                Email Address
            </label>
            <input id="email" name="email" type="email" autocomplete="email" autocapitalize="none" autocorrect="off"
                spellcheck="false" required value="{{ old('email') }}"
                class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                placeholder="e.g. passenger@example.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                Password
            </label>
            <input id="password" name="password" type="password" autocomplete="new-password" required
                class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                placeholder="Create a secure password (min. 8 characters)">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                Confirm Password
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                required
                class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E]"
                placeholder="Re-type your password">
        </div>

        <!-- Submit Button (48px Height for Primary Mobile Action) -->
        <div class="pt-2">
            <button type="submit"
                class="flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] px-5 py-3 text-sm sm:text-base font-bold text-white shadow-lg shadow-[#22C55E]/20 transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:ring-offset-2 cursor-pointer touch-manipulation">
                <span>Create Passenger Account</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Sign In Link -->
    <div class="mt-6 border-t border-slate-200/80 pt-4 text-center">
        <p class="text-xs sm:text-sm text-slate-600">
            Already registered?
            <a href="{{ route('login') }}"
                class="font-bold text-[#16A34A] hover:underline focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded px-1">
                Sign In here →
            </a>
        </p>
    </div>
</x-layouts.guest>