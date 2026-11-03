@props([
    'disabled' => false,
    'id' => null,
    'name' => null,
    'type' => 'text',
    'label' => null,
    'error' => null,
    'hint' => null,
])

<div class="w-full">
    @if ($label)
        <label for="{{ $id ?? $name }}" class="block text-sm font-semibold text-content-primary mb-1.5">
            {{ $label }}
        </label>
    @endif

    <input 
        type="{{ $type }}" 
        id="{{ $id ?? $name }}" 
        name="{{ $name }}" 
        @disabled($disabled) 
        {{ $attributes->merge([
            'class' => 'w-full min-h-[48px] rounded-xl border border-surface-border bg-white px-4 py-3 text-base text-content-primary placeholder-content-muted shadow-xs transition focus:border-brand-green focus:outline-none focus:ring-2 focus:ring-brand-green disabled:bg-surface-muted disabled:cursor-not-allowed ' . ($error ? 'border-brand-red focus:border-brand-red focus:ring-brand-red' : '')
        ]) }}
    />

    @if ($hint && ! $error)
        <p class="mt-1 text-xs text-content-muted">{{ $hint }}</p>
    @endif

    @if ($error)
        <p class="mt-1 text-xs font-semibold text-brand-red">{{ $error }}</p>
    @endif
</div>

