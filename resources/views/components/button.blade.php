@props([
    'color' => 'primary', 
    'type' => 'button'   
])

@php
$baseClasses = 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-medium text-sm shadow-sm focus:outline-none transition ease-in-out duration-150';

$colorClasses = match ($color) {
    'primary'   => 'btn-primary',
    'success'   => 'btn-success',
    'danger'    => 'btn-danger',
    'warning'   => 'btn-warning',
    'info'      => 'btn-info',
    'secondary' => 'btn-secondary',
    default     => 'btn-primary',
};

$classes = $baseClasses . ' ' . $colorClasses;
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
