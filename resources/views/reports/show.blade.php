<x-app-layout>
    <div class="container px-5 py-6 mx-auto">

        @if (session('notice'))
            <div class="w-full max-w-lg mx-auto mt-10">
                <x-notice :notice="session('notice')" />
            </div>
        @endif

        <div class="w-full max-w-lg mx-auto">
            @if ($report->cancel == 1)
                <p class="text-center text-red-600 text-2xl font-semibold">取消確認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 0)
                <p class="text-center text-amber-500 text-2xl font-semibold">承認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 1)
                <p class="text-center text-sky-600 text-2xl font-semibold">承認済み</p>
            @endif
        </div>

        <div class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                <h5
                    class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                    @if ($report->report_id == 12 || $report->report_id == 13 || $report->report_id == 14 || $report->report_id == 15)
                        欠勤届
                    @else
                        有給休暇願
                    @endif
                </h5>
                <p
                    class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                    @if ($report->report_id == 1)
                        {{ $report->sub_report_category->sub_report_name }}
                    @else
                        {{ $report->report_category->report_name }}
                    @endif
                </p>
            </div>
            <div class="flex justify-end text-lg">
                <div></div>
                <ul role="list" class="divide-y divide-gray-500">
                    <!-- divide-y アンダーライン仕切り -->
                    <li class="">
                        &emsp;申請日&emsp;:&emsp;
                        <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                            {{ $report->report_date }}&emsp;
                        </span>
                    </li>
                    <li></li>
                </ul>
            </div>

            <div class="flex justify-between my-4">
                <ul class="divide-y divide-gray-500">
                    <li class="pt-2">
                        <div class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                            &emsp;富士善工業株式会社&ensp;御中&emsp;
                        </div>
                    </li>
                    <li class="pt-2">
                        <div class="flex items-center text-md sm:text-lg">
                            &emsp;氏 名 &emsp;
                            <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                {{ $report->user->name }}
                            </span>
                        </div>
                    </li>
                    <li></li>
                </ul>
            </div>
            <ul role="list" class="divide-y divide-gray-500">
                <li class="pt-2 pb-0">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    期 間
                                </p>
                                <p class="ZenKurenaido font-semibold text-gray-800 ml-4 text-lg">
                                    {{ $report->start_date }}
                                    @if ($report->end_date != null)
                                        &emsp;~&emsp;{{ $report->end_date }}
                                        <span class="ml-4">
                                            {{ $report->acquisition_days }}日間
                                        </span>
                                    @endif
                                    @if ($report->start_time != null)
                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                        &emsp;~&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                        <span class="ml-4">
                                            @if ($report->acquisition_hours != 0)
                                                {{ $report->acquisition_hours }}時間
                                            @endif
                                            @if ($report->acquisition_minutes != 0)
                                                {{ $report->acquisition_minutes }}分
                                            @endif
                                        </span>
                                    @endif
                                    @if ($report->am_pm != null)
                                        &emsp;{{ $report->am_pm == 1 ? '午 前' : '午 後' }}
                                    @endif
                                    @if ($report->end_date == null && $report->start_time == null && $report->am_pm == null)
                                        <span class="ml-4">
                                            {{ __('1') }}日間
                                        </span>
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
                                    事 由
                                </p>
                                <p class="ZenKurenaido font-semibold text-gray-700 ml-4 text-lg">
                                    {{ $report->reason_category->reason }}
                                    {{-- @if ($report->reason_detail)
                                        <span
                                            class="ZenKurenaido font-semibold text-md text-gray-700 truncate px-4 pt-2">
                                            ({{ $report->reason_detail }})
                                        </span>
                                    @endif --}}
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
                                    備 考
                                </p>
                                <p class="ZenKurenaido font-semibold text-gray-700 ml-4 text-lg">
                                    {{ $report->reason_detail }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="pt-4 pb-0 flex justify-end">
                    <table>
                        <thead class="">
                            <tr>
                                <th class="w-20 border border-gray-500 text-gray-900 text-center">上長</th>
                                <th class="w-20 border border-gray-500 text-gray-900 text-center">係長</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- 上長承認 start -->
                                <td class="w-20 h-12 border border-gray-500 text-center">
                                    @if (
                                        !empty(Auth::user()->approvals->where('approval_id', 2)->where('factory_id', $report->user->factory_id)->where('department_id', 1)->first()
                                        ))
                                        @if ($report->cancel == 0 && $report->approval1 == 0)
                                            <x-edit-a-button href="{{ route('approval', $report) }}"
                                                dusk='approval1-button' onclick="if(!confirm('承認しますか？')){return false};"
                                                class="px-3 py-1">
                                                {{ __('Approval') }}
                                            </x-edit-a-button>
                                        @endif
                                        @if ($report->cancel == 1 && $report->approval1 == 1)
                                            <x-delete-a-button href="{{ route('reports.approval_cancel', $report) }}"
                                                onclick="if(!confirm('取消を確認しました')){return false};" class="px-1 py-1">
                                                {{ __('CancelCheck') }}
                                            </x-delete-a-button>
                                        @endif
                                    @elseif (
                                        !empty(Auth::user()->approvals->where('approval_id', 2)->where('factory_id', $report->user->factory_id)->where('department_id', $report->user->department_id)->first()
                                        ))
                                        @if ($report->cancel == 0 && $report->approval1 == 0)
                                            <x-edit-a-button href="{{ route('approval', $report) }}"
                                                dusk='approval1-button' onclick="if(!confirm('承認しますか？')){return false};"
                                                class="px-3 py-1">
                                                {{ __('Approval') }}
                                            </x-edit-a-button>
                                        @endif
                                        @if ($report->cancel == 1 && $report->approval1 == 1)
                                            <x-delete-a-button href="{{ route('reports.approval_cancel', $report) }}"
                                                onclick="if(!confirm('取消を確認しました')){return false};" class="px-1 py-1">
                                                {{ __('CancelCheck') }}
                                            </x-delete-a-button>
                                        @endif
                                    @else
                                        <!-- 承認&確認済み start -->
                                        @if ($report->cancel == 1 && $report->approval1 == 1)
                                            <div class="flex justify-center">
                                                <x-approved-stamp />
                                            </div>
                                        @endif
                                    @endif
                                    @if ($report->cancel == 0 && $report->approval1 == 1)
                                        <div class="flex justify-center" dusk='approved1-stamp'>
                                            <x-approved-stamp />
                                        </div>
                                    @endif
                                    @if ($report->cancel == 1 && $report->approval1 == 0)
                                        <div class="flex justify-center">
                                            <x-cancel-stamp />
                                        </div>
                                    @endif
                                    <!-- 承認&確認済み end -->
                                </td>
                                <!-- 上長承認 end -->
                                <!-- 係長承認 start -->
                                <td class="w-20 h-12 border border-gray-500 text-center">
                                    @if (
                                        !empty(Auth::user()->approvals->where('approval_id', 3)->where('factory_id', $report->user->factory_id)->where('department_id', $report->user->department_id)->first()
                                        ))
                                        @if ($report->cancel == 0 && $report->approval2 == 0)
                                            <x-edit-a-button href="{{ route('approval', $report) }}"
                                                dusk='approval2-button' onclick="if(!confirm('承認しますか？')){return false};"
                                                class="px-3 py-1">
                                                {{ __('Approval') }}
                                            </x-edit-a-button>
                                        @endif
                                        @if ($report->cancel == 1 && $report->approval2 == 1)
                                            <x-delete-a-button href="{{ route('reports.approval_cancel', $report) }}"
                                                onclick="if(!confirm('取消を確認しました')){return false};" class="px-1 py-1">
                                                {{ __('CancelCheck') }}
                                            </x-delete-a-button>
                                        @endif
                                        <!-- 係長承認 end -->
                                        <!-- 承認&確認済み start -->
                                    @else
                                        @if ($report->cancel == 1 && $report->approval2 == 1)
                                            <div class="flex justify-center">
                                                <x-approved-stamp />
                                            </div>
                                        @endif
                                    @endif
                                    @if ($report->cancel == 0 && $report->approval2 == 1)
                                        <div class="flex justify-center" dusk='approved2-stamp'>
                                            <x-approved-stamp />
                                        </div>
                                    @endif
                                    @if ($report->cancel == 1 && $report->approval2 == 0)
                                        <div class="flex justify-center">
                                            <x-cancel-stamp />
                                        </div>
                                    @endif
                                    <!-- 承認&確認済み end -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>

        <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
            @can('approver_reader')
                <div class="flex justify-end">
                    <x-return-button class="w-30" href="{{ route('reports.index') }}">
                        {{ __('申請一覧') }}
                    </x-return-button>
                </div>
            @endcan
            <div class="flex justify-end">
                <x-return-button class="w-30 px-4" href="{{ route('reports.my_index') }}">
                    {{ __('My申請一覧') }}
                </x-return-button>
            </div>
            <div class="flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </div>
{{-- 
    <div class="container px-5 py-6 mx-auto">
        <div class="w-full max-w-md mx-auto mt-10">
            <x-notice :notice="session('notice')" />
        </div>

        <div class="w-full max-w-md mx-auto mt-10 -mb-5">
            @if ($report->cancel == 1)
                <p class="text-center text-red-600 text-2xl font-semibold">取消確認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 0)
                <p class="text-center text-amber-500 text-2xl font-semibold">承認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 1)
                <p class="text-center text-sky-600 text-2xl font-semibold">承認済み</p>
            @endif
        </div>

        <div class="w-full max-w-md mx-auto mt-10 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
            <div class="flex items-center justify-between mb-2">
                <h5
                    class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                    出 退 勤 届 け
                </h5>
                <p class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                    {{ $report->user->affiliation->factory->factory_name }}
                </p>
            </div>
            <p class="text-gray-600 text-sm text-right">{{ $report->user->department_group_name }}</p>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">
                    <!-- divide-y アンダーライン仕切り -->
                    <li class="">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                    <x-report-name :report="$report" />
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="pt-3 pb-0 sm:pt-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center pb-1">
                                    <p
                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                        {{ __('Reason') }}
                                    </p>
                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                        {{ $report->reason_category->reason }}</p>
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
                                    <p
                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                        期 間
                                    </p>
                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                        {{ $report->start_date }}
                                        @if ($report->end_date != null)
                                            &emsp;~&emsp;{{ $report->end_date }}
                                            <span class="ml-4">
                                                {{ $report->acquisition_days }}日間
                                            </span>
                                        @endif
                                        @if ($report->start_time != null)
                                            &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                            &emsp;~&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                            <span class="ml-4">
                                                @if ($report->acquisition_hours != 0)
                                                    {{ $report->acquisition_hours }}時間
                                                @endif
                                                @if ($report->acquisition_minutes != 0)
                                                    {{ $report->acquisition_minutes }}分
                                                @endif
                                            </span>
                                        @endif
                                        @if ($report->am_pm != null)
                                            &emsp;{{ $report->am_pm == 1 ? '前 半' : '後 半' }}
                                        @endif
                                        @if ($report->end_date == null && $report->start_time == null && $report->am_pm == null)
                                            <span class="ml-4">
                                                {{ __('1') }}日間
                                            </span>
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
                                    <p
                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                        {{ __('Report Date') }}
                                    </p>
                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                        {{ $report->report_date }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pt-3 pb-0 sm:pt-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center pb-1">
                                    <p
                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                        コード
                                    </p>
                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                        {{ $report->user->employee }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pt-3 pb-0 sm:pt-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center pb-1">
                                    <p
                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                        {{ __('Name') }}
                                    </p>
                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">{{ $report->user->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="pt-3 pb-0 sm:pt-4">
                        <table>
                            <thead class="">
                                <tr>
                                    <th class="w-20 border border-gray-500 text-gray-900 text-center text-sm">部長/工場長
                                    </th>
                                    <th class="w-20 border border-gray-500 text-gray-900 text-center text-sm">課長/GL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-20 h-12 border border-gray-500 text-center">
                                        <!-- 部長・工場長承認 start -->
                                        @if (Auth::user()->approvals->load('affiliation')->where('approval_id', 2)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', $report->user->affiliation->department_id)->first() ||
                                                Auth::user()->approvals->load('affiliation')->where('approval_id', 2)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('affiliation.department_id', 1)->first())
                                            @if ($report->cancel == 0 && $report->approval1 == 0 && $report->approval2 == 1)
                                                <x-edit-a-button href="{{ route('approval', $report) }}"
                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                    class="px-3 py-1">
                                                    {{ __('Approval') }}
                                                </x-edit-a-button>
                                            @endif
                                            @if ($report->cancel == 1 && $report->approval1 == 1)
                                                <x-delete-a-button
                                                    href="{{ route('reports.approval_cancel', $report) }}"
                                                    onclick="if(!confirm('取消を確認しました')){return false};"
                                                    class="px-1 py-1">
                                                    {{ __('CancelCheck') }}
                                                </x-delete-a-button>
                                            @endif
                                            <!-- 部長・工場長承認 end -->
                                        @else
                                            <!-- 承認&確認済み start -->
                                            @if ($report->cancel == 1 && $report->approval1 == 1)
                                                <div class="flex justify-center">
                                                    <x-approved-stamp />
                                                </div>
                                            @endif
                                        @endif
                                        @if ($report->cancel == 0 && $report->approval1 == 1)
                                            <div class="flex justify-center" dusk='approved1-stamp'>
                                                <x-approved-stamp />
                                            </div>
                                        @endif
                                        @if ($report->cancel == 1 && $report->approval1 == 0)
                                            <div class="flex justify-center">
                                                <x-cancel-stamp />
                                            </div>
                                        @endif
                                        <!-- 承認&確認済み end -->
                                    </td>
                                    <td class="w-20 h-12 border border-gray-500 text-center">
                                        <!-- 課長・GL承認 start -->
                                        @if (
                                            !empty(Auth::user()->approvals->load('affiliation')->where('approval_id', 3)->where('affiliation.factory_id', $report->user->affiliation->factory_id)->where('department_id', $report->user->department_id)->first()
                                            ))
                                            @if ($report->cancel == 0 && $report->approval2 == 0)
                                                <x-edit-a-button href="{{ route('approval', $report) }}"
                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                    class="px-3 py-1">
                                                    {{ __('Approval') }}
                                                </x-edit-a-button>
                                            @endif
                                            @if ($report->cancel == 1 && $report->approval2 == 1)
                                                <x-delete-a-button
                                                    href="{{ route('reports.approval_cancel', $report) }}"
                                                    onclick="if(!confirm('取消を確認しました')){return false};"
                                                    class="px-1 py-1">
                                                    {{ __('CancelCheck') }}
                                                </x-delete-a-button>
                                            @endif
                                            <!-- 課長承認 end -->
                                        @else
                                            @if ($report->cancel == 1 && $report->approval2 == 1)
                                                <div class="flex justify-center">
                                                    <x-approved-stamp />
                                                </div>
                                            @endif
                                        @endif
                                        @if ($report->cancel == 0 && $report->approval2 == 1)
                                            <div class="flex justify-center" dusk='approved2-stamp'>
                                                <x-approved-stamp />
                                            </div>
                                        @endif
                                        @if ($report->cancel == 1 && $report->approval2 == 0)
                                            <div class="flex justify-center">
                                                <x-cancel-stamp />
                                            </div>
                                        @endif
                                        <!-- 承認&確認済み end -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
                <div class="w-full max-w-md mx-auto mt-2 -mb-4">
                    <x-approval-msg :msg="session('msg')" />
                </div>
            </div>
        </div>

        <div class="w-full max-w-md mx-auto mt-10 grid grid-cols-1 gap-2">
            @can('approver_reader')
                <div class="flex justify-end">
                    <x-return-button class="w-30" href="{{ route('reports.index') }}">
                        {{ __('Report Index') }}
                    </x-return-button>
                </div>
            @endcan
            <div class="flex justify-end">
                <x-return-button class="w-30 px-4" href="{{ route('reports.my_index') }}">
                    {{ __('Report MyIndex') }}
                </x-return-button>
            </div>
            <div class="flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </div> --}}
</x-app-layout>
