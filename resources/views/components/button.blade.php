{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}> --}}
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-sky-600 border border-gray-500 rounded-md font-semibold text-white uppercase tracking-widest hover:bg-white hover:text-gray-600 active:bg-sky-900 focus:outline-none focus:border-sky-700 focus:ring ring-sky-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
