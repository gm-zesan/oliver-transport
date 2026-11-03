<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-xl bg-brand-green px-5 py-3 text-base font-bold text-white shadow-xs hover:bg-brand-green-hover focus:outline-none focus:ring-2 focus:ring-brand-green focus:ring-offset-2 transition active:scale-[0.99]']) }}>
    {{ $slot }}
</button>
