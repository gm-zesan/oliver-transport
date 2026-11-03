@props([
    'inverted' => false,
    'showSubtitle' => false,
    'size' => 'md',
])

@php
    $sizeClasses = match($size) {
        'sm' => ['title' => 'text-lg sm:text-xl', 'badge' => 'text-[8px] tracking-[0.28em]'],
        'lg' => ['title' => 'text-3xl sm:text-4xl', 'badge' => 'text-xs sm:text-[12px] tracking-[0.35em]'],
        default => ['title' => 'text-2xl sm:text-[26px]', 'badge' => 'text-[9px] sm:text-[10px] tracking-[0.32em]'],
    };

    $olColor = $inverted ? 'text-white' : 'text-slate-900';
    $transportColor = $inverted ? 'text-emerald-400' : 'text-slate-500';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center select-none leading-none']) }}>
    <div class="flex flex-col items-start leading-none">
        <span class="{{ $sizeClasses['title'] }} font-black tracking-tight font-heading {{ $olColor }} leading-none">
            Ol<span class="text-[#22C55E]">iver</span>
        </span>
        <span class="font-extrabold uppercase {{ $sizeClasses['badge'] }} {{ $transportColor }} transition-colors mt-1 leading-none">
            Transport
        </span>
    </div>
</div>
