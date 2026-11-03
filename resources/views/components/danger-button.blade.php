<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg bg-provisional-alert px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-provisional-alert/90 focus:outline-none focus:ring-2 focus:ring-provisional-alert focus:ring-offset-2 focus:ring-offset-provisional-surface transition']) }}>
    {{ $slot }}
</button>

