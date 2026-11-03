@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'align' => 'center',
])

@php
    $alignmentClasses = match($align) {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center mx-auto',
    };
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col max-w-3xl mb-10 sm:mb-14 {$alignmentClasses}"]) }}>
    @if ($eyebrow)
        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-green-subtle px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-brand-green border border-brand-green/20 mb-3">
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="text-2xl font-black tracking-tight text-content-primary sm:text-3xl lg:text-4xl">
        {{ $title }}
    </h2>

    @if ($subtitle)
        <p class="mt-3 text-base text-content-secondary sm:text-lg leading-relaxed">
            {{ $subtitle }}
        </p>
    @endif
</div>

