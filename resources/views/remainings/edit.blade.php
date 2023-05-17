<x-app-layout>
    <!-- Page Heading -->
    <header class="text-xs sm:text-sm bg-sky-50 shadow-md shadow-sky-500/50">
        <div class="flex max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('remainings.index') }}" class="text-sky-600 inline-flex mr-2 hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                        clip-rule="evenodd" />
                </svg>
                <div class="px-2">
                    取得可能日数一覧
                </div>
            </a>
        </div>
    </header>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">残日数の修正</h1>
                <div class="mx-auto">
                    <p class="flex text-left leading-relaxed text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="font-semibold">
                            有給休暇
                        </span>
                        の取得可能日数を変更できます。
                    </p>
                </div>
            </div>

            <div class="container bg-white lg:w-2/3 w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                氏 名</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                名 称</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                取得可能日数</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ $remaining->user->name }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ $remaining->report_category->report_name }}
                                            </td>
                                            <form action="{{ route('remainings.update', $remaining) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-input name="remaining_days" type="number" max="40" min="0"
                                                        class="inline h-8 mt-1 w-20" :value="old('remaining_days', $remaining->remaining_days)" />日
                                                    <x-input name="remaining_hours" type="number" max="7" min="0"
                                                        class="inline h-8 mt-1 w-20" :value="old('remaining_hours', $remaining->remaining_hours)" />時間
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    <x-edit-button >
                                                        {{ __('Update') }}
                                                    </x-edit-button>
                                                </td>
                                            </form>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
