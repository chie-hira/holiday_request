@props(['errors'])

@if ($errors->any())

    <div id="alert-border-1" class="p-4 mb-4 text-xs sm:text-base text-indigo-400 border-t-4 border-indigo-300 bg-purple-100" role="alert">
        <p class="flex">
            <span class="font-medium mr-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </span>
            <b>{{ count($errors) }}件のエラーがあります。</b>
            <button type="button" onclick="#"
                class="ml-auto -mx-1.5 -my-1.5 text-indigo-400 p-1.5 hover:text-indigo-500 inline-flex h-8 w-8"
                data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
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
