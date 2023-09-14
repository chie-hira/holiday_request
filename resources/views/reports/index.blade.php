<x-app-layout>
    <div class="border-b-2 border-gray-200 overflow-x-auto">
        <nav class="px-4 py-1 space-x-6">
            <form action="/search" method="GET">
                <div class="md:flex">
                    <div class="flex">
                        <!-- 所属選択 - start -->
                        <x-select name="select_affiliation" id="select_affiliation" class="block text-xs w-40 mr-2 my-1">
                            <option value='1'>{{ __('Affiliation') }}</option>
                            @foreach ($affiliations as $affiliation)
                                <option value="{{ $affiliation->id }}"
                                    @if ($affiliation->id == request('select_affiliation')) selected @endif>
                                    <x-affiliation-name :affiliation="$affiliation" />
                                </option>
                            @endforeach
                        </x-select>
                        <!-- 属性選択 - end -->
                        <!-- 社員番号選択 - start -->
                        <x-select name="select_user" id="select_user" class="block text-xs w-40 mr-2 my-1">
                            <option value=''>{{ __('User') }}</option>
                            <option value=''>全員</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" 
                                    @if ($user->id == request('select_user')) selected @endif>
                                    {{ $user->employee }}{{ $user->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <!-- 属性選択 - end -->
                    </div>
                    <div class="flex">
                        <!-- 休暇種類選択 - start -->
                        <x-select name="select_report" id="select_report" class="block text-xs w-40 mr-2 my-1">
                            <option value=''>{{ __('Report Category') }}</option>
                            <option value=''>全て</option>
                            @foreach ($report_categories as $report_category)
                                <option value="{{ $report_category->id }}"
                                    @if ($report_category->id == request('select_report')) selected @endif>
                                    {{ $report_category->report_name }}
                                </option>
                            @endforeach
                        </x-select>
                        <!-- 休暇種類選択 - end -->
                        <!-- 取得日選択 - start -->
                        <x-input type="month" id="select_month" name="select_month" class="block text-xs w-40 mr-2 my-1"
                            :value="request('select_month')" />
                        <!-- 取得日選択 - end -->
                    </div>
                    <x-show-button type="submit" class="my-1">検索</x-show-button>
                </div>
            </form>
        </nav>
    </div>

    <section class="text-gray-600 body-font">
        <div class="container max-w-7xl px-5 py-12 mx-auto">
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
                                                    {{ __('Approver1') }}
                                                    ・{{ __('Approver2') }}
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
                                        @foreach ($paginator as $report)
                                            <tr id="resultContainer" class="hover:bg-gray-100 ">
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
                                                    @if (
                                                        (Auth::user()->approvals->where('approval_id', 2)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', 1)->first() &&
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
                                                {{-- <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    {{ $report->shift_category->shift_code }}
                                                    <div class="text-xxs text-blue-500">
                                                        {{ $report->shift_category->start_time_hm }} ~
                                                        {{ $report->shift_category->end_time_hm }}
                                                    </div>
                                                </td> --}}
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
                                                        {{ $report->am_pm == 1 ? '午 前' : '午 後' }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm text-left text-gray-800 ">
                                                    @if ($report->acquisition_days != 0)
                                                        {{ $report->acquisition_days }} 日
                                                    @endif
                                                    {{-- @if ($report->sub_report_id == 3)
                                                        {{ 0.5 }} 日
                                                    @endif
                                                    @if ($report->sub_report_id != 3 && $report->acquisition_hours != 0)
                                                        {{ $report->acquisition_hours }} 時間
                                                    @endif --}}
                                                    @if ($report->acquisition_hours != 0)
                                                        {{ $report->acquisition_hours }} 時間
                                                    @endif
                                                    @if ($report->acquisition_minutes != 0)
                                                        {{ $report->acquisition_minutes }} 分
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
            {{ $paginator->appends(request()->except('page'))->links() }}
            {{-- {{ $paginator->links() }} --}}

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>

</x-app-layout>
