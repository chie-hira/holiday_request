<a
    {{ $attributes->merge(['class' => 'flex items-center justify-center text-center px-3 py-1 text-sm text-sky-600 border-2 border-sky-600 rounded-full bg-sky-100/60 hover:text-white hover:font-semibold hover:bg-sky-600']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
        class="w-5 h-5 mr-2">
        <path fill-rule="evenodd"
            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
            clip-rule="evenodd" />
    </svg>
    {{ $slot }}
</a>
