<x-layouts.app>
    <x-slot:title>Profile Settings — Oliver Transport</x-slot:title>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Banner -->
        <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8">
            <span class="inline-flex items-center rounded-full bg-provisional-accent/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-provisional-accent border border-provisional-accent/20">
                Account Settings
            </span>
            <h1 class="mt-2 text-2xl sm:text-3xl font-black tracking-tight text-white">
                Profile Management
            </h1>
            <p class="mt-1 text-sm text-provisional-muted">
                Manage your Oliver Transport credentials, contact information, and security preferences.
            </p>
        </div>

        <div class="mt-8 space-y-6 max-w-4xl">
            <!-- Profile Info Card -->
            <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 shadow-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 shadow-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="rounded-2xl border border-provisional-border bg-provisional-surface p-6 sm:p-8 shadow-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

