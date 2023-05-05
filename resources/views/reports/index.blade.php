<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">出退勤届け一覧</h1>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                届出日
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                内 容
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                期 間
                                            </th>
                                            <th scope="col"
                                                class="w-32 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                日数・時間
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                承 諾
                                            </th>
                                            <th scope="col" colspan="3"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">

                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-100 ">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->end_date != null)
                                                        ~&emsp;&emsp;{{ $report->end_date }}
                                                    @endif
                                                    @if ($report->end_time != null)
                                                        ~&emsp;&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                    @endif
                                                    @if ($report->am_pm != null)
                                                        {{ $report->am_pm == 1 ? '午 前' : '午 後' }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    @if ($report->get_days_only != 0)
                                                        {{ $report->get_days_only }} 日&emsp;
                                                    @endif
                                                    @if ($report->get_hours != 0)
                                                        {{ $report->get_hours }} 時間
                                                    @endif
                                                    @if ($report->get_minutes != 0)
                                                        {{ $report->get_minutes }} 分
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    @if ($report->cancel == 1)
                                                        <span class="text-indigo-500">取消確認中</span>
                                                    @else
                                                        @if ($report->approval1 == 0 || $report->approval2 == 0 || $report->approval3 == 0)
                                                            <span class="text-pink-500">未承諾</span>
                                                        @else
                                                            <span class="text-blue-500">承諾済み</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <a href="{{ route('reports.show', $report) }}"
                                                        class="px-3 py-1 text-sm text-indigo-500 rounded-full bg-indigo-100/60 hover:text-white hover:bg-indigo-500">
                                                        届表示
                                                    </a>
                                                </td>
                                                <td
                                                    class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->cancel == 0 && $report->approved == 0)
                                                        @can('update', $report)
                                                            <a href="{{ route('reports.edit', $report) }}"
                                                                class="px-3 py-1 text-sm text-blue-500 rounded-full bg-blue-100/60 hover:text-white hover:bg-blue-500">
                                                                変 更
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if ($report->cancel == 0 && $report->approved == 0)
                                                        @can('delete', $report)
                                                            <form action="{{ route('reports.destroy', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="submit" value="取 消"
                                                                    onclick="if(!confirm('届けを取消しますか？')){return false};"
                                                                    class="px-3 py-1 text-sm text-pink-500 rounded-full bg-pink-100/60 hover:text-white hover:bg-pink-500">
                                                            </form>
                                                        @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
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
