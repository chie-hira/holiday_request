<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">有給休暇残日数の修正</h1>
                <p class="lg:w-2/3 mx-auto mb-2 leading-relaxed text-base">
                    <span class="font-semibold">
                        {{ Auth::user()->name }}さん
                    </span>
                    は以下の休暇を取得できます。
                </p>
            </div>

            <div class="container bg-white lg:w-2/3 w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                {{ $remaining->user->name }}
                                            </td>
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                {{ $remaining->report_category->report_name }}
                                            </td>
                                            <form action="{{ route('remainings.update', $remaining) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <input name="remaining_days" type="number" max="40" min="0"
                                                    {{-- class="w-24" --}}
                                                    class="w-24 h-8 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                                        value="{{ old('remaining_days', $remaining->remaining_days) }}">日
                                                    <input name="remaining_hours" type="number" max="7" min="0"
                                                    class="w-24 h-8 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                                        value="{{ old('remaining_hours', $remaining->remaining_hours) }}">時間
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="submit"
                                                        class="px-3 py-1 text-sm text-blue-500 rounded-full bg-blue-100/60 hover:text-white hover:bg-blue-500">
                                                        更 新
                                                    </button>
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

            <div class="flex mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('menu') }}"
                    class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="px-2 mt-1">
                        戻る
                    </div>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
