<div class="min-h-screen flex flex-col sm:justify-center items-center pb-16 sm:pt-0 bg-gray-100">
    <div class="text-indigo-500">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg border-2 rounded-lg">
        {{-- <div class="container bg-white lg:w-1/2 w-full mx-auto border-2 rounded-lg"> --}}
        {{ $slot }}
    </div>
</div>
