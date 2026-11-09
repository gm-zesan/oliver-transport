<x-layouts.guest :hide-floating-logo="true">
    <x-slot:title>Sign In — PickMeRoute</x-slot:title>

    <!-- Brand Logo & Welcome Text inside Card -->
    <div class="mb-6 text-center">
        <a href="{{ route('home') }}" class="inline-block transition hover:opacity-90 drop-shadow-sm focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded-xl" aria-label="PickMeRoute Home">
            <x-brand-logo size="lg" :show-subtitle="true" />
        </a>
        <p class="mt-3 text-xs sm:text-sm text-slate-600 font-medium">
            Welcome back! Please enter your details to sign in.
        </p>
    </div>

    <!-- Unified Shared Login Form -->
    <form id="login-form" method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                Email Address
            </label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   autocomplete="email" 
                   autocapitalize="none"
                   autocorrect="off"
                   spellcheck="false"
                   required 
                   value="{{ old('email') }}"
                   class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                   placeholder="e.g. passenger@pickmeroute.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#16A34A] hover:underline focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" 
                   name="password" 
                   type="password" 
                   autocomplete="current-password" 
                   required 
                   class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/80 backdrop-blur-md px-3.5 py-2.5 text-base text-[16px] text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                   placeholder="Enter your password">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me Checkbox with 44px Minimum Touch Target -->
        <div class="flex items-center pt-1">
            <label for="remember" class="flex items-center gap-2.5 min-h-[44px] cursor-pointer select-none">
                <input type="checkbox" 
                       name="remember" 
                       id="remember"
                       class="h-4 w-4 rounded border-slate-300 text-[#22C55E] focus:ring-[#22C55E] cursor-pointer">
                <span class="text-xs sm:text-sm font-medium text-slate-600">Keep me signed in</span>
            </label>
        </div>

        <!-- Submit Button (48px+ Height for Primary Mobile Action) -->
        <div class="pt-1">
            <button type="submit" 
                    class="flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] px-5 py-3 text-sm sm:text-base font-bold text-white shadow-lg shadow-[#22C55E]/20 transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:ring-offset-2 cursor-pointer touch-manipulation">
                <span>Sign In to Account</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Passenger Registration Link -->
    <div class="mt-6 border-t border-slate-200/80 pt-4 text-center">
        <p class="text-xs sm:text-sm text-slate-600">
            Don't have an account yet? 
            <a href="{{ route('register') }}" class="font-bold text-[#16A34A] hover:underline focus:outline-none focus:ring-2 focus:ring-[#22C55E] rounded px-1">
                Register here →
            </a>
        </p>
    </div>
</x-layouts.guest>
