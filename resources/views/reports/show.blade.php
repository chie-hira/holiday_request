<x-app-layout>

    <div class="w-full max-w-md mx-auto mt-10 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <h5
                class="border-solid border-2 px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                出 退 勤 届 け
            </h5>
            <p
                class="border-solid border-2 px-4 py-1 border-indigo-500 rounded-md text-md font-medium text-indigo-600 hover:underline">
                {{ Auth::user()->company->company_name }}工場
            </p>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200">
                <!-- divide-y アンダーライン仕切り -->
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="px-2 text-xl font-semibold text-gray-800">
                                {{ $report->report_category->report_name }}
                            </p>
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    理 由
                                </p>
                                <p class="text-gray-700 ml-4">{{ $report->reason->reason }}</p>
                            </div>
                            @if ($report->reason_detail)
                                <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                    {{ $report->reason_detail }}
                                </p>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    期 間
                                </p>
                                <p class="text-gray-700 ml-4">
                                    @if ($report->start_date != null)
                                        {{ $report->start_date }}
                                    @else
                                        -
                                    @endif
                                    @if ($report->start_time != null)
                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                    @endif
                                    @if ($report->end_date != null)
                                        &emsp;~&emsp;{{ $report->end_date }}
                                    @endif
                                    @if ($report->end_time != null)
                                        &emsp;~&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                    @endif
                                    @if ($report->am_pm != null)
                                        &emsp;{{ $report->am_pm == 0 ? '午 前' : '午 後' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    届出日
                                </p>
                                <p class="text-gray-700 ml-4">{{ $report->report_date }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    コード
                                </p>
                                <p class="text-gray-700 ml-4">{{ $report->user->employee }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    氏 名
                                </p>
                                <p class="text-gray-700 ml-4">{{ $report->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <table>
                        <thead class="">
                            <tr>
                                <th class="w-20 border border-gray-500 text-center">総務部長</th>
                                <th class="w-20 border border-gray-500 text-center">工場長</th>
                                <th class="w-20 border border-gray-500 text-center">GL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w-20 h-12 border border-gray-500 text-center">{{ $report->approval1 }}</td>
                                <td class="w-20 h-12 border border-gray-500 text-center">{{ $report->approval2 }}</td>
                                <td class="w-20 h-12 border border-gray-500 text-center">{{ $report->approval3 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
        <a href="{{ route('reports.index') }}" class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
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
    <div>&emsp;</div>

</x-app-layout>
