@props([
    'inverted' => false,
    'showSubtitle' => false,
    'size' => 'md',
])

@php
    $sizeConfig = match($size) {
        'sm' => [
            'icon' => 'h-7 w-auto',
            'title' => 'text-lg sm:text-xl',
            'badge' => 'text-[8px] tracking-[0.28em]',
            'gap' => 'gap-2.5',
        ],
        'lg' => [
            'icon' => 'h-10 w-auto',
            'title' => 'text-3xl sm:text-4xl',
            'badge' => 'text-xs tracking-[0.32em]',
            'gap' => 'gap-3.5',
        ],
        default => [
            'icon' => 'h-8 sm:h-9 w-auto',
            'title' => 'text-2xl sm:text-[26px]',
            'badge' => 'text-[9px] tracking-[0.30em]',
            'gap' => 'gap-3',
        ],
    };

    $nameColor = $inverted ? 'text-white' : 'text-[#111827]';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center ' . $sizeConfig['gap'] . ' select-none leading-none']) }}>
    <!-- Automotive Motion Symbol (Green Aerodynamic Speed Swoosh) -->
    <svg class="{{ $sizeConfig['icon'] }} flex-shrink-0" viewBox="0 0 46 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M2 24C8 24 13 22 17 15C21 8 26 4 36 4C41 4 44 5.5 45 6.5C41 8.5 35 9.5 30 11C23 13 19 20 14 26C10 30 5 31 0 31L2 24Z" fill="#22C55E"/>
        <path d="M12 26.5C18 26.5 24 24 33 19C37 16.5 41 13 44 10C40 14 34 17 27 20C20 23 15 24 10 24.5L12 26.5Z" fill="#16A34A"/>
        <circle cx="11" cy="25" r="2.5" fill="#22C55E"/>
        <circle cx="33" cy="25" r="2.5" fill="#22C55E"/>
        <path d="M11 25H33" stroke="#22C55E" stroke-width="1.5" stroke-linecap="round"/>
    </svg>

    <!-- Company Name & Subtext -->
    <div class="flex flex-col items-start leading-none">
        <span class="{{ $sizeConfig['title'] }} font-black tracking-wider uppercase font-heading {{ $nameColor }} leading-none">
            Ol<span class="text-inherit">iver</span>
        </span>
        <span class="font-extrabold uppercase {{ $sizeConfig['badge'] }} text-[#22C55E] tracking-[0.30em] mt-1 leading-none">
            Transport
        </span>
        @if($showSubtitle)
            <span class="text-[8.5px] font-bold uppercase tracking-[0.2em] text-[#22C55E] mt-1.5 leading-none">
                Montreal • Toronto • Montreal
            </span>
        @endif
    </div>
</div>
