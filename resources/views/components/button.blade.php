<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-green-800 border border-gray-500 rounded-md font-semibold text-white uppercase tracking-widest hover:bg-white hover:text-gray-600 active:bg-green-900 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
