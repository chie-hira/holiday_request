<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-amber-400 border border-gray-500 rounded-md font-semibold text-white uppercase tracking-widest hover:bg-white hover:text-gray-600 active:bg-amber-500 focus:outline-none focus:border-amber-600 focus:ring ring-amber-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
