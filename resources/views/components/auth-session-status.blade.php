@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-provisional-accent border border-provisional-accent/30 bg-provisional-accent/10 p-3.5 rounded-lg']) }}>
        {{ $status }}
    </div>
@endif

