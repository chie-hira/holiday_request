{{-- @props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}> --}}

<select {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-200 focus:border-sky-500 focus:ring focus:ring-sky-300 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>
