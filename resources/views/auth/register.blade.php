<x-layouts.guest>
    <x-slot:title>Register — Oliver Transport</x-slot:title>

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-white">
            Create Passenger Account
        </h2>
        <p class="mt-1 text-xs text-provisional-muted">
            Book and manage your Montreal ↔ Toronto shuttle seats
        </p>
    </div>

    <!-- Passenger Registration Form -->
    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-white">
                Full Name
            </label>
            <div class="mt-1">
                <input id="name" 
                       name="name" 
                       type="text" 
                       autocomplete="name" 
                       required 
                       value="{{ old('name') }}"
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent @error('name') border-provisional-alert @enderror"
                       placeholder="Jane Doe">
            </div>
            @error('name')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

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
                       placeholder="jane@example.com">
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-sm font-medium text-white">
                Phone Number
            </label>
            <div class="mt-1">
                <input id="phone" 
                       name="phone" 
                       type="tel" 
                       autocomplete="tel" 
                       required 
                       value="{{ old('phone') }}"
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent @error('phone') border-provisional-alert @enderror"
                       placeholder="647-555-0199">
            </div>
            @error('phone')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-white">
                Password
            </label>
            <div class="mt-1">
                <input id="password" 
                       name="password" 
                       type="password" 
                       autocomplete="new-password" 
                       required 
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent @error('password') border-provisional-alert @enderror">
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-provisional-alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-white">
                Confirm Password
            </label>
            <div class="mt-1">
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       autocomplete="new-password" 
                       required 
                       class="block w-full min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent">
            </div>
        </div>

        <!-- Submit Button (48px Height for Primary Mobile Action) -->
        <div class="pt-2">
            <button type="submit" 
                    class="flex w-full min-h-[48px] items-center justify-center rounded-lg bg-provisional-accent px-4 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent focus:ring-offset-2 focus:ring-offset-provisional-surface transition">
                Create Account
            </button>
        </div>
    </form>

    <!-- Sign In Link -->
    <div class="mt-6 border-t border-provisional-border pt-4 text-center">
        <p class="text-sm text-provisional-muted">
            Already have an account? 
            <a href="{{ route('login') }}" class="inline-flex items-center min-h-[44px] font-bold text-provisional-accent hover:underline focus:outline-none focus:ring-2 focus:ring-provisional-accent rounded px-1">
                Sign In
            </a>
        </p>
    </div>
</x-layouts.guest>
