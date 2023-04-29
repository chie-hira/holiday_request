<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">取得可能日数</h1>
                <p class="lg:w-2/3 mx-auto mb-2 leading-relaxed text-base">
                    <span class="font-semibold">
                        {{ Auth::user()->name }}さん
                    </span>
                    は以下の休暇を取得できます。
                </p>
            </div>

            <div class="container bg-white lg:w-1/2 w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                名 称</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                                取得可能日数</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($my_remainings as $my_remaining)
                                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $my_remaining->report_category->report_name }}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    {{ $my_remaining->remaining_days }} 日
                                                    @if (!empty($my_remaining->remaining_hours))
                                                        &ensp;{{ $my_remaining->remaining_hours }} 時間
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                特別休暇(弔事)</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                特別休暇(短期育休)</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                育児休業</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                パパ育休</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col text-center mt-10">
                <ul class="w-84 mx-auto leading-relaxed text-sm overflow-x-auto">
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        看護休暇は<span class="font-bold">小学校就学前の子</span>を養育する者が取得できます。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        介護休暇、介護休業は<span class="font-bold">要介護状態の家族</span>を介護する者が取得できます。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        特別休暇(慶事)は<span class="font-bold">本人が結婚する</span>ときに取得できます。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        特別休暇(弔事)は近親者が喪に服すときに取得でき、<span class="font-bold">近親者によって</span>取得上限が異なります。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        特別休暇(短期育休)、育児休業、パパ育休は<span class="font-bold">1歳に満たない子</span>と同居し扶養する者が取得できます。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        取得可能日数は<span class="font-bold">届け出承認後の日数</span>です。
                    </li>
                    <li class="flex items-left text-left whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-3">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        ※は<span class="font-bold">対象者、家族構成等</span>によって異なります。詳細は総務課にお問い合わせください。
                    </li>
                </ul>
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
