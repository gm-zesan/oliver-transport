@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex min-h-[44px] items-center px-1 pt-1 border-b-2 border-provisional-accent text-sm font-bold leading-5 text-white focus:outline-none focus:border-provisional-accent transition duration-150 ease-in-out'
            : 'inline-flex min-h-[44px] items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-provisional-muted hover:text-white hover:border-provisional-border focus:outline-none focus:text-white focus:border-provisional-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

