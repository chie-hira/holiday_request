<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-lg px-5 pt-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">取得可能日数</h1>
                <div class="mx-auto">
                    <div class="flex text-left leading-relaxed text-sm mb-1">
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 mr-3 text-sky-600">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                    clip-rule="evenodd" fill="" />
                            </svg>
                        </p>
                        <p class="text-sm">
                            <span class="font-semibold">{{ Auth::user()->name }}さん</span>は以下の休暇を取得できます。
                        </p>
                    </div>
                </div>
            </div>

            <div class="container max-w-lg bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-2 sm:p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                名 称</th>
                                            <th scope="col"
                                                class="px-6 pt-3 pb-1 text-right text-xs font-medium text-gray-500 uppercase">
                                                <p class="font-semibold">{{ __('日数') }}</p>
                                                <p class="text-blue-400 text-xs">{{ __('予定') }}</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($my_remainings as $my_remaining)
                                            <tr class="hover:bg-gray-100">
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $my_remaining->report_category->report_name }}
                                                </td>
                                                <td
                                                    class="px-6 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        {{ $my_remaining->remaining_days }} 日
                                                        @if (!empty($my_remaining->remaining_hours))
                                                            &ensp;{{ $my_remaining->remaining_hours }} 時間
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        @if ($my_remaining->get_days != 0)
                                                            @if ($my_remaining->remaining - $my_remaining->get_days == 0)
                                                                {{ 0 }} 日
                                                            @endif
                                                            @if ($my_remaining->expectation_days != 0)
                                                                {{ $my_remaining->expectation_days }}
                                                                日
                                                            @endif
                                                            @if ($my_remaining->expectation_hours != 0)
                                                                {{ $my_remaining->expectation_hours }}

                                                                時間
                                                            @endif
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="hover:bg-gray-100 ">
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                特別休暇(短期育休)</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 ">
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                育児休業</td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                ※
                                            </td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 ">
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
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
        </div>

        <div class="container max-w-xl px-5 pb-24 mx-auto">
            <div class="mx-auto mt-10">
                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        看護休暇は<span class="font-bold">小学校就学前の子</span>を養育する者が取得できます。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        介護休暇、介護休業は<span class="font-bold">要介護状態の家族</span>を介護する者が取得できます。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        特別休暇(慶事)は<span class="font-bold">本人が結婚する</span>ときに取得できます。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        特別休暇(弔事)は近親者が喪に服すときに取得でき、<span class="font-bold">近親者によって</span>取得上限が異なります。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        特別休暇(短期育休)、育児休業、パパ育休は<span class="font-bold">1歳に満たない子</span>と同居し扶養する者が取得できます。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        取得可能日数は<span class="font-bold">届け出承認後の日数</span>です。
                    </p>
                </div>

                <div class="flex text-left leading-relaxed text-sm mb-1">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                    </p>
                    <p class="text-sm">
                        ※は<span class="font-bold">対象者によって異なります</span>。詳細は総務課にお問い合わせください。
                    </p>
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
