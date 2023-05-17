@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-red-500 border-2 border-gray-400 rounded-full bg-red-100/60 hover:text-white hover:font-semibold hover:bg-red-500']) !!}>

