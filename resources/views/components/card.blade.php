@props([
    'padding' => 'p-6 sm:p-8',
    'hover' => false,
    'bordered' => true,
])

<div {{ $attributes->merge([
    'class' => 'bg-surface-card rounded-2xl ' . 
        ($bordered ? 'border border-surface-border ' : '') . 
        ($hover ? 'transition-all duration-200 hover:shadow-md hover:border-slate-300 ' : 'shadow-xs ') . 
        $padding
]) }}>
    {{ $slot }}
</div>

