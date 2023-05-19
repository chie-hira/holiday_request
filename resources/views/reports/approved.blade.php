<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">承認済 一覧</h1>
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
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                届出日
                                            </th>
                                            <th scope="col"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th scope="col"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                内 容
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                期 間
                                            </th>
                                            <th scope="col"
                                                class="w-32 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                日数・時間
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                部 長
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                工場長
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                G L
                                            </th>
                                            <th scope="col"
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
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td class="pl-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->end_date != null)
                                                        ~&emsp;&emsp;{{ $report->end_date }}
                                                    @endif
                                                    @if ($report->end_time != null)
                                                        ~&emsp;&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                    @endif
                                                    @if ($report->am_pm != null)
                                                        {{ $report->am_pm == 0 ? '午 前' : '午 後' }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->get_days_only != 0)
                                                        {{ $report->get_days_only }} 日
                                                    @endif
                                                    @if ($report->get_hours != 0)
                                                        {{ $report->get_hours }} 時間
                                                    @endif
                                                    @if ($report->get_minutes != 0)
                                                        {{ $report->get_minutes }} 分
                                                    @endif
                                                </td>
                                                @if ($report->cancel == 0)
                                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        @if ($report->approval1 == 1)
                                                            <x-checked-mark />
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        @if ($report->approval2 == 1)
                                                            <x-checked-mark />
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        @if ($report->approval3 == 1)
                                                            <x-checked-mark />
                                                        @endif
                                                    </td>
                                                @else
                                                    <td colspan="3"
                                                        class="px-2 py-4 text-center text-red-600 whitespace-nowrap text-sm">
                                                        取消確認中
                                                    </td>
                                                @endif
                                                <td
                                                    class="flex pl-2 pr-1 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <x-show-a-button href="{{ route('reports.show', $report) }}"
                                                        class="px-3 py-1">
                                                        {{ __('Show') }}
                                                    </x-show-a-button>
                                                    @if (Auth::user()->approvals->where('approval_id', 1)->first())
                                                        @if ($report->approval1 == 1 && $report->cancel == 1)
                                                            <div class="mt-2 -ml-2 text-pink-400">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (Auth::user()->approvals->where('approval_id', 2)->first())
                                                        @foreach (Auth::user()->approvals->where('approval_id', 2) as $approval)
                                                            @if ($report->user->factory_id == $approval->factory_id && $report->approval2 == 1 && $report->cancel == 1)
                                                                {{-- <div class="mt-2 -ml-2 text-pink-400">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        class="w-5 h-5">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                                                            clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div> --}}
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if (Auth::user()->approvals->where('approval_id', 3)->first())
                                                        @foreach (Auth::user()->approvals->where('approval_id', 3) as $approval)
                                                            @if (
                                                                $report->user->factory_id == $approval->factory_id &&
                                                                    $report->user->department_id == $approval->department_id &&
                                                                    $report->user->group_id == $approval->group_id &&
                                                                    $report->approval3 == 1 &&
                                                                    $report->cancel == 1)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                {{-- <td class="pl-1 pr-2 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if ($report->cancel == 0)
                                                        @can('general_only')
                                                            <form action="{{ route('reports.approved_cancel', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="submit" value="取消"
                                                                    onclick="if(!confirm('承認済みの届けを取消しますか？工場長とGLの確認後に届けが削除されます。')){return false};"
                                                                    class="px-3 py-1 text-sm text-red-500 border-2 border-gray-400 rounded-full bg-red-100/60 hover:text-white hover:font-semibold hover:bg-red-500">
                                                            </form>
                                                        @endcan
                                                    @endif
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
