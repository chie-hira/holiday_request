<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-sky-300 border border-gray-500 rounded-md font-semibold text-white uppercase tracking-widest hover:bg-white hover:text-gray-600 active:bg-sky-400 focus:outline-none focus:border-sky-600 focus:ring ring-sky-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
