<select {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-200 focus:border-sky-400 focus:ring focus:ring-sky-300 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>
