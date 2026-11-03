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

    <!-- Unified Shared Login Form -->
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
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
                       placeholder="passenger@example.com / driver@olivertransport.ca">
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
                    class="flex w-full min-h-[48px] items-center justify-center rounded-lg bg-provisional-accent px-4 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent focus:ring-offset-2 focus:ring-offset-provisional-surface transition">
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
</x-layouts.guest>
