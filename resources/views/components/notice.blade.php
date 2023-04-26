@props(['notice'])

@if ($notice)

    <div id="alert-border-1" class="p-4 mb-4 text-xs sm:text-base text-indigo-400 border-t-4 border-indigo-300 bg-purple-100/40" role="alert">
        <p class="flex">
            <span class="font-medium mr-2">
                <i class="fa-solid fa-bell"></i>
            </span>
            <b class="text-xs sm:text-base font-medium">
                {{ $notice }}
            </b>
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
    </div>
@endif
