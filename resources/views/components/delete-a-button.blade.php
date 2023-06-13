<a {{ $attributes->merge(['class' => 'text-sm text-red-500 border-2 border-gray-400 rounded-full bg-red-100/60 hover:text-white hover:font-semibold hover:bg-red-500 hover:border-red-500']) }}>
    {{ $slot }}
</a>
