<select {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-200 focus:border-green-500 focus:ring focus:ring-green-300 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>
