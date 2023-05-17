@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-300 focus:ring-opacity-50']) !!}>
