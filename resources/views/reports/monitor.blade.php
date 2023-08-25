<x-app-layout>

    <section class="body-font">
        <div class="container max-w-5xl px-5 py-6 mx-auto">
            <div class="relative border border-gray-400 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-8 py-3 rounded-tl-lg">
                                {{ __('Affiliation') }}
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                {{ __('承認待ち件数') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($pending_reports) > 0)
                            @foreach ($pending_reports as $report)
                                <tr class="bg-white">
                                    <th scope="row"
                                        class="px-6 py-2 font-medium text-gray-800 text-2xl whitespace-nowrap">
                                        {{ $report['affiliation'] }}
                                    </th>
                                    <td class="px-8 py-2 font-semibold text-5xl">
                                        {{ $report['count'] }}
                                    </td>
                                </tr>
                            @endforeach
                            <th scope="row" class="px-6 py-2 font-medium text-gray-800 text-2xl whitespace-nowrap rounded-l-lg">
                            </th>
                            <td class="px-8 py-2 font-semibold text-5xl rounded-r-lg">
                            </td>
                        @else
                            <tr class="bg-white">
                                <th scope="row" colspan="2"
                                    class="px-6 py-6 text-center font-semibold text-gray-800 text-4xl whitespace-nowrap rounded-b-lg">
                                    {{ __('承認待ちの申請はありません') }}
                                </th>
                            </tr>

                        @endif
                </table>
            </div>
        </div>
    </section>


    {{-- <section class="text-gray-600 body-font">
        <div class="container max-w-7xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">{{ __('届出一覧') }}</h1>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container max-w-7xl bg-white border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Date') }}
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-2 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('状 態') }}
                                                <div class="text-xxs text-blue-500">
                                                    {{ __('Factory Manager') }}
                                                    ・{{ __('Group Leader') }}
                                                </div>
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-2 whitespace-nowrap text-right text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Affiliation') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Shift') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Category') }}
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Span') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-2 text-center whitespace-nowrap text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Days') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-100 ">
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td
                                                    class="px-2 py-3 text-center whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->approved == 0 && $report->cancel == 0)
                                                        <span class="text-amber-500">承認待ち</span>
                                                    @endif
                                                    @if ($report->approved == 1 && $report->cancel == 0)
                                                        <span class="text-sky-500">承認済み</span>
                                                    @endif
                                                    @if ($report->cancel == 1)
                                                        <span class="text-red-500">取消確認中</span>
                                                    @endif
                                                    @if ($report->cancel == 0)
                                                        <div class="flex">
                                                            <div class="flex-1">
                                                                @if ($report->approval1 == 1)
                                                                    <span class="text-blue-500">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-3 h-3 mx-auto">
                                                                            <path fill-rule="evenodd"
                                                                                d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1">
                                                                @if ($report->approval2 == 1)
                                                                    <span class="text-blue-500">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-3 h-3 mx-auto">
                                                                            <path fill-rule="evenodd"
                                                                                d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="flex px-2 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-show-a-button href="{{ route('reports.show', $report) }}"
                                                        class="px-3 py-1">
                                                        {{ __('Show') }}
                                                    </x-show-a-button>
                                                    @if ((Auth::user()->approvals->where('approval_id', 2)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', 1)->first() &&
        (($report->cancel == 0 && $report->approval1 == 0) || ($report->cancel == 1 && $report->approval1 == 1))) ||
    (Auth::user()->approvals->where('approval_id', 2)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', $report->user->affiliation->department_id)->first() &&
        (($report->cancel == 0 && $report->approval1 == 0) || ($report->cancel == 1 && $report->approval1 == 1))) ||
    (Auth::user()->approvals->where('approval_id', 3)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', $report->user->affiliation->department_id)->first() &&
        (($report->cancel == 0 && $report->approval2 == 0) || ($report->cancel == 1 && $report->approval2 == 1))))
                                                        <div class="mt-2 -ml-2 text-red-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="w-5 h-5">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td
                                                    class="pl-4 py-3 whitespace-nowrap text-xxs text-center text-gray-800">
                                                    @if (Str::length($report->user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($report->user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $report->user->employee }}
                                                </td>
                                                <td class="pl-2 pr-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    <div class="text-xxs text-blue-500">
                                                        {{ $report->user->affiliation->factory->factory_name }}
                                                    </div>
                                                    {{ $report->user->department_group_name }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    {{ $report->shift_category->shift_code }}
                                                    <div class="text-xxs text-blue-500">
                                                        {{ $report->shift_category->start_time_hm }} ~
                                                        {{ $report->shift_category->end_time_hm }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td class="pr-6 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->end_date != null)
                                                        ~&emsp;{{ $report->end_date }}
                                                    @endif
                                                    @if ($report->end_time != null)
                                                        ~&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                    @endif
                                                    @if ($report->am_pm != null)
                                                        {{ $report->am_pm == 1 ? '前 半' : '後 半' }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm text-left text-gray-800 ">
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
    </section> --}}
</x-app-layout>
