<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">有給取得状況一覧</h1>
            </div>

            <div class="w-full mx-auto overflow-x-auto">
                <table class="table-auto mx-auto text-left whitespace-nowrap">
                    <thead class="">
                        <tr class="border-b-2">
                            <th
                                class="w-40 px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl">
                                所 属
                            </th>
                            <th
                                class="w-24 px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                社員番号
                            </th>
                            <th
                                class="w-24 px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                氏 名
                            </th>
                            <th 
                                class="w-24 px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                取得日数
                            </th>
                            <th 
                                class="w-24 px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr">
                                残日数
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-3 text-left">{{ $user->factory->factory_name }}工場&ensp;/&ensp;{{ $user->department->department_name }}</td>
                                <td class="px-4 py-3 text-center">{{ $user->employee }}</td>
                                <td class="px-4 py-3 text-center">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($user->sum_get_days->first())
                                        @if ($user->sumGetDaysOnly(1) != 0)
                                            {{ $user->sumGetDaysOnly(1) }} 日
                                        @endif
                                        @if ($user->sumGetHours(1) != 0)
                                            {{ $user->sumGetHours(1) }} 時間
                                        @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($user->remainings->first())
                                        {{-- {{ $user->remainings[0]->remaining }} --}}
                                        @if ($user->remainingDaysOnly(0) != 0)
                                            {{ $user->remainingDaysOnly(0) }} 日
                                        @endif
                                        @if ($user->remainingHours(0) != 0)
                                            {{ $user->remainingHours(0) }} 時間
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('menu') }}" class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="px-2 mt-1">
                    一覧へ戻る
                    </div>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
