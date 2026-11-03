<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-lg bg-provisional-accent px-4 py-3 text-base font-bold text-provisional-bg shadow-lg hover:bg-provisional-accent-hover focus:outline-none focus:ring-2 focus:ring-provisional-accent focus:ring-offset-2 focus:ring-offset-provisional-surface transition']) }}>
    {{ $slot }}
</button>

