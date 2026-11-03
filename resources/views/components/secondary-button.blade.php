@props(['type' => 'button'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-surface-border bg-white px-4 py-2.5 text-sm font-semibold text-content-primary shadow-xs hover:bg-surface-subtle hover:text-brand-green focus:outline-none focus:ring-2 focus:ring-brand-green focus:ring-offset-2 transition active:scale-[0.99]']) }}>
    {{ $slot }}
</button>
