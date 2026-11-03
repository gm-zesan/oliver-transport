@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'min-h-[44px] rounded-lg border border-provisional-border bg-provisional-card px-3.5 py-2.5 text-base text-white placeholder-provisional-muted shadow-sm focus:border-provisional-accent focus:outline-none focus:ring-2 focus:ring-provisional-accent']) }}>

