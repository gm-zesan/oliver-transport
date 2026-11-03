@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex min-h-[44px] items-center w-full ps-3 pe-4 py-2 border-s-4 border-provisional-accent text-start text-base font-bold text-white bg-provisional-accent/10 focus:outline-none focus:text-white focus:bg-provisional-accent/20 focus:border-provisional-accent transition duration-150 ease-in-out'
            : 'flex min-h-[44px] items-center w-full ps-3 pe-4 py-2 border-s-4 border-transparent text-start text-base font-medium text-provisional-muted hover:text-white hover:bg-provisional-card hover:border-provisional-border focus:outline-none focus:text-white focus:bg-provisional-card focus:border-provisional-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

