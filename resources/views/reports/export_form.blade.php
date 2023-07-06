<x-app-layout>
    <div class="border-b-2 border-gray-200 dark:border-gray-700">
        <nav class="-mb-0.5 px-4 py-1 flex space-x-6">
            <!-- 工場選択 - start -->
            <x-select name="select_factory" id="select_factory" class="block text-xs" onchange="search();">
                <option value=''>全て</option>
                @foreach ($factories as $factory)
                    <option value="{{ $factory->id }}" @if ($factory->id === (int) old('select_factory')) selected @endif>
                        {{ $factory->factory_name }}
                    </option>
                @endforeach
            </x-select>
            <!-- 工場選択 - end -->
            <!-- 理由選択 - start -->
            <x-select name="select_user" id="select_user" class="block text-xs" onchange="search();">
                <option value=''>全て</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if ($user->id === (int) old('select_user')) selected @endif>
                        {{ $user->employee }}
                    </option>
                @endforeach
            </x-select>
            <!-- 理由選択 - end -->
            <!-- 休暇種類選択 - start -->
            <x-select name="select_report" id="select_report" class="block text-xs" onchange="search();">
                <option value=''>全て</option>
                @foreach ($report_categories as $report_category)
                    <option value="{{ $report_category->id }}" @if ($report_category->id === (int) old('select_report')) selected @endif>
                        {{ $report_category->report_name }}
                    </option>
                @endforeach
            </x-select>
            <!-- 休暇種類選択 - end -->
            <!-- 取得日選択 - start -->
            <x-input type="month" id="select_month" name="select_month" onchange="search();" class="block text-xs"
                :value="old('month')" required />
            <!-- 取得日選択 - end -->
        </nav>
    </div>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">{{ __('出力内容') }}</h1>
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
                                                class="pl-4 pr-1 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Team') }}
                                            </th>
                                            <th scope="col"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee') }}
                                            </th>
                                            <th scope="col"
                                                class="pl-1 pr-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Name') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                休暇種類
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                取得期間
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                日数・時間
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                シフト
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                届出日
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                理 由
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($reports as $report)
                                            <tr id="report_{{ $report->id }}" style="display:"
                                                class="hover:bg-gray-100 ">
                                                <td class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->team_all }}
                                                </td>
                                                <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if (Str::length($report->user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($report->user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $report->user->employee }}
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
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
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    ナンバー{{ $report->shift_category->shift_code }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->reason_category->reason }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->reason_detail }}
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

            <div class="w-full mx-auto mt-4 grid grid-cols-1 gap-2">
                <div class="flex justify-end mb-4">
                    <form action="{{ route('reports.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="factory_id" id="factory_id" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="hidden" name="report_category_id" id="report_category_id" value="">
                        <input type="hidden" name="get_month" id="get_month" value="">
                        <div class="flex flex-row-reverse">
                            <x-button class="w-full flex">
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

    <script>
        let selectFactory = document.getElementById('select_factory');
        let selectUser = document.getElementById('select_user');
        let selectReport = document.getElementById('select_report');
        let selectMonth = document.getElementById('select_month');
        const reports = @json($reports);

        function search() {
            let selectFactoryId = selectFactory.value;
            let selectUserId = selectUser.value;
            let selectReportId = selectReport.value;
            let selectGetMonth = selectMonth.value;
            console.log('search'); // 起動確認
            // 条件書き出し
            document.getElementById('factory_id').setAttribute('value', selectFactoryId);
            document.getElementById('user_id').setAttribute('value', selectUserId);
            document.getElementById('report_category_id').setAttribute('value', selectReportId);
            document.getElementById('get_month').setAttribute('value', selectGetMonth);
            reportDataChange(selectFactoryId, selectUserId, selectReportId, selectGetMonth);
        }

        function reportDataChange(selectFactoryId, selectUserId, selectReportId, selectGetMonth) {
            Object.keys(reports).forEach(key => {
                const value = reports[key];
                let reportFactoryId = value.user.factory_id;
                let reportCartegoryId = value.report_id;
                let reportUserId = value.user_id;
                let reportGetMonth = value.start_date.substr(0, 7);
                let reportId = document.getElementById('report_' + value.id);
                console.log(key, value);

                // 選択された値と一致する場合は表示、そうでなければ非表示
                if (selectFactoryId == reportFactoryId &&
                    selectReportId == reportCartegoryId &&
                    selectUserId == reportUserId &&
                    selectGetMonth == reportGetMonth || // 全て選択

                    !selectFactoryId &&
                    selectReportId == reportCartegoryId &&
                    selectUserId == reportUserId &&
                    selectGetMonth == reportGetMonth || // 休暇種類,ユーザー,月 選択

                    selectFactoryId == reportFactoryId &&
                    !selectReportId &&
                    selectUserId == reportUserId &&
                    selectGetMonth == reportGetMonth || // 工場,ユーザー,月 選択

                    selectFactoryId == reportFactoryId &&
                    selectReportId == reportCartegoryId &&
                    !selectUserId &&
                    selectGetMonth == reportGetMonth || // 工場,休暇種類,月 選択

                    selectFactoryId == reportFactoryId &&
                    selectReportId == reportCartegoryId &&
                    selectUserId == reportUserId &&
                    !selectGetMonth || // 工場,休暇種類,ユーザー 選択

                    !selectFactoryId &&
                    !selectReportId &&
                    selectUserId == reportUserId &&
                    selectGetMonth == reportGetMonth || // ユーザー,月 選択

                    !selectFactoryId &&
                    selectReportId == reportCartegoryId &&
                    !selectUserId &&
                    selectGetMonth == reportGetMonth || // 休暇種類,月 選択

                    !selectFactoryId &&
                    selectReportId == reportCartegoryId &&
                    selectUserId == reportUserId &&
                    !selectGetMonth || // 休暇種類,ユーザー 選択

                    selectFactoryId == reportFactoryId &&
                    !selectReportId &&
                    !selectUserId &&
                    selectGetMonth == reportGetMonth || // 工場,月 選択

                    selectFactoryId == reportFactoryId &&
                    !selectReportId &&
                    selectUserId == reportUserId &&
                    !selectGetMonth || // 工場,ユーザー 選択

                    selectFactoryId == reportFactoryId &&
                    selectReportId == reportCartegoryId &&
                    !selectUserId &&
                    !selectGetMonth || // 工場,休暇種類 選択

                    !selectFactoryId &&
                    !selectReportId &&
                    !selectUserId &&
                    selectGetMonth == reportGetMonth || // 月 選択

                    !selectFactoryId &&
                    selectReportId == reportCartegoryId &&
                    !selectUserId &&
                    !selectGetMonth || // 休暇種類 選択

                    !selectFactoryId &&
                    !selectReportId &&
                    selectUserId == reportUserId &&
                    !selectGetMonth || // ユーザー 選択

                    selectFactoryId == reportFactoryId &&
                    !selectReportId &&
                    !selectUserId &&
                    !selectGetMonth || // 工場 選択

                    !selectFactoryId &&
                    !selectReportId &&
                    !selectUserId &&
                    !selectGetMonth // 全て未選択
                ) {
                    reportId.style.display = '';
                } else {
                    reportId.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
