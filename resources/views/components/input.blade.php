@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-brand/50 focus:ring-brand/30 rounded-md shadow-sm']) !!}>
