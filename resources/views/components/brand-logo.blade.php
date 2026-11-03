@props([
    'inverted' => false,
    'showSubtitle' => false,
    'size' => 'md',
])

@php
    $sizeClasses = match($size) {
        'sm' => ['title' => 'text-xl', 'badge' => 'text-[10px] tracking-widest', 'sub' => 'text-[9px]'],
        'lg' => ['title' => 'text-3xl sm:text-4xl', 'badge' => 'text-xs tracking-widest', 'sub' => 'text-[11px]'],
        default => ['title' => 'text-2xl', 'badge' => 'text-[11px] tracking-widest', 'sub' => 'text-[10px]'],
    };

    $olColor = $inverted ? 'text-white' : 'text-brand-charcoal';
    $transportColor = $inverted ? 'text-slate-300' : 'text-brand-charcoal';
    $subtitleColor = $inverted ? 'text-slate-400' : 'text-content-muted';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex flex-col leading-none select-none']) }}>
    <div class="flex items-baseline gap-1.5">
        <span class="{{ $sizeClasses['title'] }} font-black tracking-tight {{ $olColor }}">
            Ol<span class="text-brand-green">iver</span>
        </span>
        <span class="font-extrabold uppercase {{ $sizeClasses['badge'] }} {{ $transportColor }}">
            Transport
        </span>
    </div>
    @if ($showSubtitle)
        <span class="mt-1 font-bold uppercase tracking-wider {{ $sizeClasses['sub'] }} {{ $subtitleColor }}">
            Montreal • Toronto • Montreal
        </span>
    @endif
</div>

