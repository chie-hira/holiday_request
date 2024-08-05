<x-app-layout>
    <div class="border-b-2 border-gray-200 overflow-x-auto">
        <nav class="px-4 py-1 space-x-6">
            <form action="{{ route('export_search') }}" method="GET">
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
                        <!-- 休暇種類選択 - start -->
                        <x-select name="select_report" id="select_report" class="block text-xs w-40 mr-2 my-1">
                            <option value=''>{{ __('Report Category') }}</option>
                            <option value=''>全て</option>
                            @foreach ($reportCategories as $report_category)
                                <option value="{{ $report_category->id }}"
                                    @if ($report_category->id == request('select_report')) selected @endif>
                                    {{ $report_category->report_name }}
                                </option>
                            @endforeach
                        </x-select>
                        <!-- 休暇種類選択 - end -->
                    </div>
                    <div class="flex">
                        <!-- 理由選択 - start -->
                        <x-select name="select_reason" id="select_reason" class="block text-xs w-40 mr-2 my-1">
                            <option value=''>{{ __('Reason') }}</option>
                            <option value=''>全て</option>
                            @foreach ($reasonCategories as $reason)
                                <option value="{{ $reason->id }}" @if ($reason->id == request('select_reason')) selected @endif>
                                    {{ $reason->reason }}
                                </option>
                            @endforeach
                        </x-select>
                        <!-- 理由選択 - end -->
                        <!-- 取得日選択 - start -->
                        <x-input type="month" id="select_month" name="select_month"
                            class="block text-xs w-40 mr-2 my-1" :value="request('select_month')" />
                        <!-- 取得日選択 - end -->
                    </div>
                    <x-show-button type="submit" class="my-1">検 索</x-show-button>
                </div>
            </form>
        </nav>
    </div>

    <section class="text-gray-600 body-font">
        <div class="container max-w-7xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">{{ __('出力内容') }}</h1>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container max-w-7xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <!-- 所属 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Affiliation') }}
                                            </th>
                                            <!-- 社員番号 -->
                                            <th scope="col"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee') }}
                                            </th>
                                            <!-- 氏名 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Name') }}
                                            </th>
                                            <!-- 申請日 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Date') }}
                                            </th>
                                            <!-- 申請種類 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Category') }}
                                            </th>
                                            <!-- 休暇期間 -->
                                            <th scope="col" colspan="2"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Span') }}
                                            </th>
                                            <!-- 休暇日数 -->
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Days') }}
                                            </th>
                                            {{-- <th scope="col" colspan="2"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Shift') }}
                                            </th> --}}
                                            <!-- 理由 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Reason') }}
                                            </th>
                                            <!-- 理由詳細 -->
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($paginator as $report)
                                            <tr id="report_{{ $report->id }}" style="display:"
                                                class="hover:bg-gray-100 ">
                                                <!-- 所属 -->
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->affiliation_name }}
                                                </td>
                                                <!-- 社員番号 -->
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if (Str::length($report->user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($report->user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $report->user->employee }}
                                                </td>
                                                <!-- 氏名 -->
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <!-- 申請日 -->
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <!-- 申請種類 -->
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <!-- 休暇期間 -->
                                                <td class="pl-4 pr-2 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td class="pr-4 py-3 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->end_date != null)
                                                        ~&emsp;{{ $report->end_date }}
                                                    @endif
                                                    @if ($report->end_time != null)
                                                        ~&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                    @endif
                                                    @if ($report->am_pm != null)
                                                        {{ $report->am_pm == 1 ? '前半' : '後半' }}
                                                    @endif
                                                </td>
                                                <!-- 休暇日数 -->
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    @if ($report->acquisition_days != 0)
                                                        {{ $report->acquisition_days }} 日&emsp;
                                                    @endif
                                                    @if ($report->acquisition_hours != 0)
                                                        {{ $report->acquisition_hours }} 時間
                                                    @endif
                                                    @if ($report->acquisition_minutes != 0)
                                                        {{ $report->acquisition_minutes }} 分
                                                    @endif
                                                </td>
                                                {{-- <td
                                                    class="pl-4 pr-2 py-3 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    {{ __('Shift') }} {{ $report->shift_category->shift_code }}
                                                </td>
                                                <td
                                                    class="pr-4 py-3 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    {{ $report->shift_category->start_time_hm }} ~
                                                    {{ $report->shift_category->end_time_hm }}
                                                </td> --}}
                                                <!-- 理由 -->
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->reason_category->reason }}
                                                </td>
                                                <!-- 理由詳細 -->
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->reason_detail }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                {{ $paginator->appends(request()->except('page'))->links() }}
            </div>

            <div class="w-full mx-auto mt-4 grid grid-cols-1 gap-2">
                <div class="flex justify-end mb-4">
                    <form id="myForm" action="{{ route('reports.export') }}" method="GET">
                        <div class="flex flex-row-reverse">
                            <x-button id="submitButton" class="w-full flex">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 mr-2 leading-6">
                                    <path fill-rule="evenodd"
                                        d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                                </svg>
                                {{ __('エクスポート') }}
                            </x-button>
                        </div>
                    </form>
                </div>
                <div class="flex justify-end">
                    <x-back-home-button class="w-30" href="{{ route('menu') }}">
                        {{ __('Back') }}
                    </x-back-home-button>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
