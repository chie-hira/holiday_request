<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-sky-600 border-2 border-gray-400 rounded-full bg-sky-100/60 hover:text-white hover:font-semibold hover:bg-sky-600']) }}>
    {{ $slot }}
</button>
