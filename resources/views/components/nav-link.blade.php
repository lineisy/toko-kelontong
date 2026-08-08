@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium ease-in-out'
            : 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:text-gray-900 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
