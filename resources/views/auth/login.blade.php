<x-layouts.guest>
    <x-slot:title>Sign In — Oliver Transport</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black tracking-tight text-slate-900 font-heading">
            Sign in to Oliver Transport
        </h2>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            One portal for Passengers, Riders, and Operators
        </p>
    </div>

    <!-- 1-Click Fast Fill Test Accounts (Easy Quick Testing) -->
    <div class="mb-6 rounded-2xl border border-white/80 bg-white/60 backdrop-blur-md p-3.5 shadow-xs">
        <div class="flex items-center justify-between text-[11px] font-black uppercase tracking-wider text-[#16A34A] mb-2.5">
            <span>Quick Test Login</span>
            <span class="text-slate-400 font-mono text-[10px] lowercase">pass: password</span>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <!-- Passenger Button -->
            <button type="button" 
                    onclick="fillCredentials('passenger@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-xl border border-slate-200/80 bg-white/80 backdrop-blur-xs px-2 py-2 text-center transition hover:border-[#22C55E] hover:bg-[#F0FDF4] focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer shadow-2xs">
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#16A34A]">Passenger</span>
                <span class="text-[10px] text-slate-500">Bookings</span>
            </button>

            <!-- Rider Button -->
            <button type="button" 
                    onclick="fillCredentials('rider@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-xl border border-slate-200/80 bg-white/80 backdrop-blur-xs px-2 py-2 text-center transition hover:border-[#22C55E] hover:bg-[#F0FDF4] focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer shadow-2xs">
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#16A34A]">Rider</span>
                <span class="text-[10px] text-slate-500">Driver</span>
            </button>

            <!-- Operator Button -->
            <button type="button" 
                    onclick="fillCredentials('operator@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-xl border border-slate-200/80 bg-white/80 backdrop-blur-xs px-2 py-2 text-center transition hover:border-[#22C55E] hover:bg-[#F0FDF4] focus:outline-none focus:ring-2 focus:ring-[#22C55E] cursor-pointer shadow-2xs">
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#16A34A]">Operator</span>
                <span class="text-[10px] text-slate-500">Dispatch</span>
            </button>
        </div>
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
                   required 
                   value="{{ old('email') }}"
                   class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/70 backdrop-blur-md px-3.5 py-2.5 text-base text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                   placeholder="e.g. passenger@olivertransport.ca">
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
                   class="block w-full min-h-[48px] rounded-xl border border-white/80 bg-white/70 backdrop-blur-md px-3.5 py-2.5 text-base text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#22C55E] @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
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

        <!-- Submit Button (48px Height for Primary Mobile Action) -->
        <div class="pt-1">
            <button type="submit" 
                    class="flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#22C55E] hover:bg-[#16A34A] px-5 py-3 text-sm sm:text-base font-bold text-white shadow-lg shadow-[#22C55E]/20 transition focus:outline-none focus:ring-2 focus:ring-[#22C55E] focus:ring-offset-2 cursor-pointer">
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

    <!-- Fast Autofill Script -->
    <script>
        function fillCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;
                emailInput.focus();
            }
        }
    </script>
</x-layouts.guest>
