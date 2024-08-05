<x-app-layout>
    <div class="container px-5 py-6 mx-auto">

        @if (session('notice'))
            <div class="w-full max-w-lg mx-auto mt-10">
                <x-notice :notice="session('notice')" />
            </div>
        @endif

        <div class="w-full max-w-lg mx-auto">
            @if ($report->cancel == 1)
                <p class="text-center text-red-500 text-2xl font-semibold">取消確認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 0)
                <p class="text-center text-amber-500 text-2xl font-semibold">承認中</p>
            @endif
            @if ($report->cancel == 0 && $report->approved == 1)
                <p class="text-center text-sky-500 text-2xl font-semibold">承認済み</p>
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
                    <li class="flex items-center">
                        <p class="w-16 text-center border rounded border-gray-700 m-2 text-md text-gray-800">
                            申請日
                        </p>
                        <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                            {{ $report->report_date }}&emsp;
                        </span>
                    </li>
                    <li></li>
                </ul>
            </div>

            <ul role="list" class="divide-y divide-gray-500">
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center pb-1">
                                <p class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                    申請者
                                </p>
                                <p class="ZenKurenaido font-semibold text-gray-700 ml-4 text-lg">
                                    {{ $report->user->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
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
                                <th class="w-20 border border-gray-500 text-gray-800 text-center">部長</th>
                                <th class="w-20 border border-gray-500 text-gray-800 text-center">課長</th>
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
            <div class="flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </div>

    <!-- ボタン -->
    <div class="w-full max-w-3xl px-5 mx-auto grid grid-cols-1 gap-2">
        <button class="fixed right-16 bottom-16 bg-sky-400/80 text-white px-2 py-2 rounded-full shadow"
                onclick="window.history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        {{-- <button class="fixed right-16 bottom-28 bg-sky-400/80 text-white px-2 py-2 rounded-full shadow"
            onclick="location.href='{{ route('menu') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </button> --}}
    </div>
</x-app-layout>
