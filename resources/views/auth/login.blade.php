<x-layouts.guest>
    <x-slot:title>Sign In — Oliver Transport</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-white">
            Sign in to Oliver Transport
        </h2>
        <p class="mt-1 text-xs text-provisional-muted">
            One portal for Passengers, Riders, and Operators
        </p>
    </div>

    <!-- 1-Click Fast Fill Test Accounts (Non-Production / Easy Testing) -->
    <div class="mb-6 rounded-xl border border-white/10 bg-provisional-surface/80 p-3.5 shadow-sm">
        <div class="text-[11px] font-black uppercase tracking-wider text-[#22C55E] mb-2.5">
            1-Click Quick Fill Credentials
        </div>
        <div class="grid grid-cols-3 gap-2">
            <!-- Passenger Button -->
            <button type="button" 
                    onclick="fillCredentials('passenger@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-lg border border-white/10 bg-provisional-card/90 px-2 py-2 text-center transition hover:border-[#22C55E]/60 hover:bg-[#22C55E]/10 focus:outline-none focus:ring-1 focus:ring-[#22C55E]">
                <span class="text-xs font-bold text-white group-hover:text-[#22C55E]">Passenger</span>
                <span class="text-[10px] text-provisional-muted">Book Seats</span>
            </button>

            <!-- Rider Button -->
            <button type="button" 
                    onclick="fillCredentials('rider@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-lg border border-white/10 bg-provisional-card/90 px-2 py-2 text-center transition hover:border-[#22C55E]/60 hover:bg-[#22C55E]/10 focus:outline-none focus:ring-1 focus:ring-[#22C55E]">
                <span class="text-xs font-bold text-white group-hover:text-[#22C55E]">Rider</span>
                <span class="text-[10px] text-provisional-muted">Driver Panel</span>
            </button>

            <!-- Operator Button -->
            <button type="button" 
                    onclick="fillCredentials('operator@olivertransport.ca', 'password')"
                    class="group flex flex-col items-center justify-center rounded-lg border border-white/10 bg-provisional-card/90 px-2 py-2 text-center transition hover:border-[#22C55E]/60 hover:bg-[#22C55E]/10 focus:outline-none focus:ring-1 focus:ring-[#22C55E]">
                <span class="text-xs font-bold text-white group-hover:text-[#22C55E]">Operator</span>
                <span class="text-[10px] text-provisional-muted">Dispatch</span>
            </button>
        </div>
        <div class="mt-2 text-center text-[11px] text-provisional-muted">
            Password: <code class="text-slate-300 font-mono font-semibold">password</code> (Click any role to autofill)
        </div>
    </div>

    <!-- Unified Shared Login Form -->
    <form id="login-form" method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-white">
                Email Address
            </label>
            <div class="mt-1">
                <input id="email" 
                       name="email" 
                       type="email" 
                       autocomplete="email" 
                       required 
                       value="{{ old('email') }}"
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent @error('email') border-provisional-alert @enderror"
                       placeholder="passenger@olivertransport.ca">
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-white">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-provisional-muted hover:text-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent rounded p-1">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="mt-1">
                <input id="password" 
                       name="password" 
                       type="password" 
                       autocomplete="current-password" 
                       required 
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent @error('password') border-provisional-alert @enderror">
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me Checkbox with 44px Minimum Touch Target -->
        <div class="flex items-center">
            <label for="remember" class="flex items-center gap-3 min-h-[44px] py-1 cursor-pointer select-none">
                <input type="checkbox" 
                       name="remember" 
                       id="remember"
                       class="h-5 w-5 rounded border-provisional-border bg-provisional-card text-provisional-accent focus:ring-provisional-accent focus:ring-offset-provisional-surface">
                <span class="text-sm text-provisional-muted">Remember me</span>
            </label>
        </div>

        <!-- Submit Button (48px Height for Primary Mobile Action) -->
        <div>
            <button type="submit" 
                    class="flex w-full min-h-[48px] items-center justify-center rounded-lg bg-provisional-accent px-4 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent focus:ring-offset-2 focus:ring-offset-provisional-surface transition cursor-pointer">
                Sign In
            </button>
        </div>
    </form>

    <!-- Passenger Registration Link -->
    <div class="mt-6 border-t border-provisional-border pt-4 text-center">
        <p class="text-sm text-provisional-muted">
            New passenger? 
            <a href="{{ route('register') }}" class="inline-flex items-center min-h-[44px] font-bold text-provisional-accent hover:underline focus:outline-none focus:ring-2 focus:ring-provisional-accent rounded px-1">
                Create Passenger Account
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
