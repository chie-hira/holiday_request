<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-green-800 border-2 border-gray-400 rounded-full bg-green-100/60 hover:text-white hover:font-semibold hover:bg-green-800']) }}>
    {{ $slot }}
</button>
