<div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 bg-gray-50">
    <div class="text-sky-800 hover:text-sky-800">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md my-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg border-2 rounded-lg">
        {{-- <div class="container bg-white lg:w-1/2 w-full mx-auto border-2 rounded-lg"> --}}
        {{ $slot }}
    </div>
</div>
