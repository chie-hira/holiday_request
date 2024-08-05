<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 text-sm text-gray-500 border-2 border-gray-400 rounded-full bg-amber-200/60 hover:text-white hover:font-semibold hover:bg-amber-400 hover:border-amber-400']) }}>
    {{ $slot }}
</button>
