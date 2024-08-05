@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-gray-500 border-2 border-gray-400 rounded-full bg-red-200/60 hover:text-white hover:font-semibold hover:bg-red-500 hover:border-red-500']) !!}>

