<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-amber-600 border-2 border-gray-400 rounded-full bg-amber-100/60 hover:text-white hover:font-semibold hover:bg-amber-400']) }}>
    {{ $slot }}
</button>
