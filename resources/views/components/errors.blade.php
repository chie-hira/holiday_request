@props(['errors'])

@if ($errors->any())

    <div id="alert-border-1" class="px-4 py-2 mb-4 text-xs sm:text-base text-indigo-400 border-t-4 border-indigo-300 bg-purple-100/40" role="alert">
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
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                            clip-rule="evenodd" fill="" />
                    </svg>
                    <div class="text-xs sm:text-base font-medium">
                        {{ $error }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
