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

    @error('google')
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50/90 px-4 py-3 text-xs sm:text-sm font-medium text-red-700 flex items-start gap-2.5" role="alert">
            <svg class="h-4 w-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    @enderror

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

    <!-- Social Authentication Divider -->
    <div class="relative my-5 flex items-center">
        <div class="flex-grow border-t border-slate-200/90"></div>
        <span class="mx-3 flex-shrink-0 text-xs font-semibold uppercase tracking-wider text-slate-500">or continue with</span>
        <div class="flex-grow border-t border-slate-200/90"></div>
    </div>

    <!-- Continue with Google Button (48px Touch Target) -->
    <a href="{{ route('auth.google.redirect') }}"
       class="flex w-full min-h-[48px] items-center justify-center gap-2.5 rounded-xl border border-slate-300/90 bg-white/95 hover:bg-white px-5 py-3 text-sm sm:text-base font-bold text-slate-800 shadow-xs transition hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:ring-offset-2 touch-manipulation">
        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
        </svg>
        <span>Continue with Google</span>
    </a>

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
