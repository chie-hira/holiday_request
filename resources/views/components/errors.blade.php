@props(['errors'])

@if ($errors->any())
    <div class="my-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-2">
        <div class="flex m-1">
            <span class="font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                    <path
                        d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                    <path fill-rule="evenodd"
                        d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <span class="font-bold">{{ count($errors) }}件</span>の<span class="font-bold">エラー</span>があります
        </div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="flex ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 mr-2">
                        <path fill-rule="evenodd"
                            d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                            clip-rule="evenodd" fill="" />
                    </svg>
                    <div class="font-medium">
                        {{ __($error) }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- <div id="alert-border-1"
        class="px-4 py-2 mb-4 text-xs sm:text-sm text-red-700 border-l-4 border-b border-red-600 bg-red-50"
        role="alert">
        <p class="flex">
            <span class="font-medium mr-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </span>
            <b>{{ count($errors) }}件のエラーがあります。</b>
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 mr-2">
                        <path fill-rule="evenodd"
                            d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                            clip-rule="evenodd" fill="" />
                    </svg>
                    <div class="font-medium">
                        {{ $error }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div> --}}
@endif
