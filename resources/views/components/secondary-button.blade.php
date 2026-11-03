@props(['type' => 'button'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-provisional-border bg-provisional-surface px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-provisional-card hover:text-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent focus:ring-offset-2 focus:ring-offset-provisional-surface transition']) }}>
    {{ $slot }}
</button>

