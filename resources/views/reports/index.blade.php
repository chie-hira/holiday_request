<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">出退勤届け一覧</h1>
            </div>

            {{-- <x-notice :message="session('notice')" /> --}}

            <div class="w-full mx-auto overflow-x-auto">
                <table class="table-auto w-full text-left whitespace-nowrap">
                    <thead class="">
                        <tr class="border-b-2">
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                届出日
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                届出者
                            </th>
                            <th
                                class="w-40 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                届出内容
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                始期
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                終期
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                届出日数
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                残日数
                            </th>
                            <th
                                class="w-32 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                残回数
                            </th>
                            <th colspan="3"
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td class="px-4 py-3">{{ $report->report_date }}</td>
                                <td class="px-4 py-3">{{ $report->user->name }}</td>
                                <td class="px-4 py-3">{{ $report->report_category->report_name }}</td>
                                <td class="px-4 py-3">{{ $report->start_date }}</td>
                                <td class="px-4 py-3">{{ $report->end_date }}</td>
                                <td class="px-4 py-3 text-center">{{ $report->get_days }} 日</td>
                                <td class="px-4 py-3 text-center">{{ $report->remaining_days }} 日</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($report->remaining_times != null)
                                        {{ $report->remaining_times }} 回
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('reports.show', $report) }}"
                                        class="px-3 py-1 text-sm text-indigo-500 rounded-full bg-indigo-100/60 hover:text-white hover:bg-indigo-500">
                                        出退勤届け表示
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('reports.edit', $report) }}"
                                        class="px-3 py-1 text-sm text-blue-500 rounded-full bg-blue-100/60 hover:text-white hover:bg-blue-500">
                                        変更
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-lg text-gray-900">
                                    <form
                                        action="{{ route('reports.destroy', $report) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="取消"
                                            onclick="if(!confirm('申請を取消しますか？')){return false};" {{-- class="text-sm bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20"> --}}
                                            class="px-3 py-1 text-sm text-pink-500 rounded-full bg-pink-100/60 hover:text-white hover:bg-pink-500">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <a href="" class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
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
