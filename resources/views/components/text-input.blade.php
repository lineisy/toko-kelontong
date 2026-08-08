@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-control rounded-lg px-3 py-2 shadow-sm']) }}>
