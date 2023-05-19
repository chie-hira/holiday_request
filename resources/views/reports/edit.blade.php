<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container w-full md:w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">出退勤届け編集</h1>
                <div class="mx-auto">
                    <p class="flex text-left leading-relaxed text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="text-sm">
                            項目を入力して、<span class="font-bold">更新</span>を押してください。
                        </span>
                    </p>
                    <p class="flex text-left leading-relaxed text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="text-sm">
                            更新すると<span class="font-bold">承認がリセット</span>されます。
                        </span>
                    </p>
                </div>
            </div>

            <x-errors :errors="$errors" />

            <form action="{{ route('reports.update', $report) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="report_id" class="block mb-2 text-sm font-medium text-gray-900">
                            届出内容
                        </label>
                        <x-select name="report_id" id="report_id" onchange="reportChange();" class="block mt-1 w-full"
                            required autofocus>
                            <option value="{{ $report->report_id }}">{{ $report->report_category->report_name }}
                            </option>
                            @foreach ($report_categories as $report_category)
                                <option value="{{ $report_category->id }}"
                                    @if ($report_category->id === (int) old('report_id')) selected @endif>
                                    {{ $report_category->report_name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div style="display: " id="empty_field_form"></div>
                    <div style="display: none" id="sub_category_form">
                        <label for="sub_report_category" class="block mb-2 text-sm font-medium text-gray-900">
                            取得形態
                        </label>
                        <div class="flex gap-x-6">
                            <div class="flex mt-2" id="sub_report_id" onchange="subReportChange();">
                                @foreach ($sub_report_categories as $sub_category)
                                    <input type="radio" name="sub_report_id" value="{{ $sub_category->id }}"
                                        @if ($sub_category->id === (int) old('sub_report_id', $report->sub_report_id)) checked @endif
                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-sky-600 focus:ring-sky-300 ">
                                    <label for="sub_report_id" name="sub_report_name"
                                        class="mr-2 text-sm text-gray-500 ml-2">
                                        {{ old('sub_report_name', $sub_category->sub_report_name) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="reason_id" class="block mb-2 text-sm font-medium text-gray-900">
                            理由
                        </label>
                        <x-select name="reason_id" id="reason_id" onchange="reasonChange();" class="block mt-1 w-full"
                            required>
                            <option value="{{ $report->reason_id }}">{{ $report->reason_category->reason }}</option>
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}" @if ($reason->id === (int) old('reason_id')) selected @endif>
                                    {{ $reason->reason }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div></div>
                    <div style="display: none" class="col-span-2" id="reason_detail">
                        <label for="reason_detail" class="block mb-2 text-sm font-medium text-gray-900">
                            理由を記入してください
                        </label>
                        <x-input type="text" id="" name="reason_detail" class="block mt-1 w-full"
                            :value="old('reason_detail', $report->reason_detail)" />
                    </div>
                    <div>
                        <label for="report_date" class="block mb-2 text-sm font-medium text-gray-900">
                            届出日
                        </label>
                        <x-input type="date" id="report_date" name="report_date" class="block mt-1 w-full"
                            :value="old('report_date', $report->report_date)" required />
                    </div>
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">
                            氏名
                        </label>
                        <input type="hidden" name="user_id" value="{{ $report->user_id }}">
                        <x-input type="text" id="user_id" class="block mt-1 w-full" :value="$report->user->name" readonly />
                    </div>

                    <!-- 有給休暇 - start -->
                    <div>
                        <label style="display: " id="start_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            期間：何日から
                        </label>
                        <label style="display: none" id="half_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            日付
                        </label>
                        <x-input style="display: " type="date" id="start_date" name="start_date"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('start_date', $report->start_date)" required />
                        {{-- onchange="dateChange();" class="block mt-1 w-full" :value="old('start_date', $report->start_date)" required/> --}}
                    </div>
                    <div style="display: " id="end_date_form">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900">
                            期間：何日まで
                        </label>
                        <x-input type="date" id="end_date" name="end_date" onchange="countDays();"
                            class="block mt-1 w-full" :value="old('end_date', $report->end_date)" />
                        {{-- <x-input type="date" id="end_date" name="end_date" onchange="dateChange();" class="block mt-1 w-full" :value="old('end_date', $report->end_date)"/> --}}
                    </div>
                    <!-- 有給休暇 - end -->

                    <!-- 半日有給 - start -->
                    <div style="display: none" id="am_pm_form">
                        <label for="am_pm" class="block mb-2 text-sm font-medium text-gray-900">
                            午前・午後
                        </label>
                        <x-select name="am_pm" id="am_pm" class="block mt-1 w-full" onchange="countDays();">
                            <option value="">選択してください</option>
                            <option value="1" @if (1 === (int) old('am_pm', $report->am_pm)) selected @endif>午前</option>
                            <option value="2" @if (2 === (int) old('am_pm', $report->am_pm)) selected @endif>午後</option>
                        </x-select>
                    </div>
                    <!-- 半日有給 - end -->

                    <!-- 時間休 - start -->
                    <div style="display: none" id="time_empty_form">
                    </div>
                    <div style="display: none" id="start_time_form">
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">
                            期間：何時から<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <x-input type="time" id="start_time" name="start_time" step="300"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('start_time', substr($report->start_time, 0, 5))" />
                    </div>
                    <div style="display: none" id="end_time_form">
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">
                            期間：何時まで<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <x-input type="time" id="end_time" name="end_time" step="300"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('end_time', substr($report->end_time, 0, 5))" />
                    </div>
                </div>
                <div style="display: none" id="time_form">
                    <div class="flex h-8 leading-8 items-center text-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-2">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        <div class="items-center text-center">
                            時間休は
                            <span class="font-semibold">1時間単位</span>
                            で取得できます
                        </div>
                    </div>
                </div>
                <!-- 時間休 - end -->

                <!-- 遅刻・早退 - start -->
                <div style="display: none" id="time_form_10m">
                    <div class="flex h-8 leading-8 items-center text-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-2">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        <div class="items-center text-center">
                            遅刻・早退は
                            <span class="font-semibold">10分単位</span>
                            で取得できます
                        </div>
                    </div>
                </div>
                <!-- 遅刻・早退 - end -->

                <!-- 外出 - start -->
                <div style="display: none" id="time_form_30m">
                    <div class="flex h-8 leading-8 items-center text-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-2">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="#9999ff" />
                        </svg>
                        <div class="items-center text-center">
                            外出は
                            <span class="font-semibold">30分単位</span>
                            で取得できます
                        </div>
                    </div>
                </div>
                <!-- 外出 - end -->

                {{-- <div class="mb-6">
                    <button type="button" id="button"
                        class="w-32 h-10 flex justify-center items-center rounded-3xl text-center text-indigo-500 bg-indigo-100/60 hover:text-white hover:bg-indigo-500">
                        <span class="pt-1">
                            日数算出
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M6.32 1.827a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V19.5a3 3 0 01-3 3H6.75a3 3 0 01-3-3V4.757c0-1.47 1.073-2.756 2.57-2.93zM7.5 11.25a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H8.25a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H8.25zm-.75 3a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H8.25a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V18a.75.75 0 00-.75-.75H8.25zm1.748-6a.75.75 0 01.75-.75h.007a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.007a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.335.75.75.75h.007a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75h-.007zm-.75 3a.75.75 0 01.75-.75h.007a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.007a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.335.75.75.75h.007a.75.75 0 00.75-.75V18a.75.75 0 00-.75-.75h-.007zm1.754-6a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75h-.008zm-.75 3a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V18a.75.75 0 00-.75-.75h-.008zm1.748-6a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008zm.75 1.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75h-.008zm-8.25-6A.75.75 0 018.25 6h7.5a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75v-.75zm9 9a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-2.25z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div> --}}
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="get_days" class="block mb-2 text-sm font-medium text-gray-900">
                            取得日数
                        </label>
                        <input type="hidden" id="get_days" name="get_days"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_days') }}" readonly required>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="get_days_only" name="get_days_only" class="block mt-1 w-20"
                                :value="old('get_days_only')" readonly />
                            {{-- <input type="number" id="get_days_only" name="get_days_only"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_days_only') }}" readonly> --}}
                            <p class="ml-2">日</p>
                        </div>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="get_hours" name="get_hours" class="block mt-1 w-20"
                                :value="old('get_hours')" readonly />
                            {{-- <input type="number" id="get_hours" name="get_hours"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_hours') }}" readonly> --}}
                            <p class="ml-2">時間</p>
                        </div>
                        <div class="flex items-center">
                            <x-input type="number" id="get_minutes" name="get_minutes" class="block mt-1 w-20"
                                :value="old('get_minutes')" readonly />
                            {{-- <input type="number" id="get_minutes" name="get_minutes"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_minutes') }}" readonly> --}}
                            <p class="ml-2">分</p>
                        </div>
                    </div>

                    <div>
                        <label for="remaining_days" class="block mb-2 text-sm font-medium text-gray-900">
                            残日数
                        </label>
                        <input type="hidden" id="remaining_days" name="remaining"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('remaining_days') }}" readonly required>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="remaining_days_only" name="remaining_days_only"
                                class="block mt-1 w-20" :value="old('remaining_days_only')" readonly />
                            <p class="ml-2">日</p>
                        </div>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="remaining_hours" name="remaining_hours"
                                class="block mt-1 w-20" :value="old('remaining_hours')" readonly />
                            <p class="ml-2">時間</p>
                        </div>
                        <div class="flex items-center">
                            <x-input type="number" id="remaining_minutes" name="remaining_minutes"
                                class="block mt-1 w-20" :value="old('remaining_minutes')" readonly />
                            <p class="ml-2">分</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row-reverse">
                    <x-edit-rectangle-button class="w-full">
                        {{ __('Update') }}
                    </x-edit-rectangle-button>
                </div>
            </form>

            <div class="mt-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('reports.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>

    <!-- script - start -->
    <script>
        /* 表示切替start */
        var reportCategory = document.getElementById('report_id');
        let subReportCategories = document.getElementsByName('sub_report_id');
        let subReport = document.getElementById('sub_report_id');
        let reasonCategory = document.getElementById('reason_id');
        let subCategoryForm = document.getElementById('sub_category_form');
        let emptyFieldForm = document.getElementById('empty_field_form');
        let reasonDetail = document.getElementById('reason_detail');
        let startDateLabel = document.getElementById('start_date_label');
        let startDateForm = document.getElementById('start_date');
        let endDateForm = document.getElementById('end_date_form');
        let timeEmptyForm = document.getElementById('time_empty_form');
        let timeForm = document.getElementById('time_form');
        let timeForm30 = document.getElementById('time_form_30m');
        let timeForm10 = document.getElementById('time_form_10m');
        let startTimeForm = document.getElementById('start_time_form');
        let endTimeForm = document.getElementById('end_time_form');
        let halfDateLabel = document.getElementById('half_date_label');
        let amPmForm = document.getElementById('am_pm_form');
        let amPm = document.getElementById('am_pm');
        const reasons = @json($reasons);
        const report = @json($report);
        console.log(report);

        // リダイレクト時の表示切替
        window.addEventListener('load', function() {
            reportDisplaySwitch(); // reportでform表示切替
            subReportDisplaySwitch(); // sub_reportでform表示切替
            reportReasonSwitch(); // reportでreason種類切替
            reasonDisplaySwitch(); // reasonで理由:その他表示切替
            countDays();
        });

        // 届出内容変更時の表示切替
        function reportChange() {
            reportDisplaySwitch(); // reportでform表示切替
            reportReasonSwitch(); // reportでreason種類切替
            reasonDisplaySwitch(); // reasonで理由:その他表示切替
            subReportCategories[0].checked = false;
            subReportCategories[1].checked = false;
            subReportCategories[2].checked = false;
            timeReset(); // end_date,start_time,end_timeリセット
            dateChange(); // get_daysリセット

            if (reportCategory.value == "2" ||
                reportCategory.value == "12") {
                countDays();
            }
        }

        // get_daysリセット関数
        function dateChange() {
            document.getElementById('get_days').setAttribute('value', 0);
            document.getElementById('get_days_only').setAttribute('value', 0);
            document.getElementById('get_hours').setAttribute('value', 0);
            document.getElementById('get_minutes').setAttribute('value', 0);
            document.getElementById('remaining_days_only').setAttribute('value', 0);
            document.getElementById('remaining_hours').setAttribute('value', 0);
            document.getElementById('remaining_minutes').setAttribute('value', 0);
        }

        // その他理由選択時の表示切替
        function reasonChange() {
            reasonDisplaySwitch(); // reasonで理由:その他表示切替
        }

        // subカテゴリーによるフォーム切替関数
        function subReportChange() {
            dateChange();
            subReportDisplaySwitch();
            timeReset();
        }

        function subReportDisplaySwitch() {
            if (subReportCategories[0].checked) { // 終日休
                halfDateLabel.style.display = "none";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "";
                startDateForm.style.display = "";
                endDateForm.style.display = "";
            }
            if (subReportCategories[1].checked) { // 半日休
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                startDateForm.style.display = "";
                amPmForm.style.display = "";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
            if (subReportCategories[2].checked) { // 時間休
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "";
                endTimeForm.style.display = "";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
        }

        // end_date,start_time,end_timeリセット関数
        function timeReset() {
            endDate.value = '';
            startTime.value = '';
            endTime.value = '';
            amPm.value = '';
        }

        // optionタグ生成関数
        function createOption(createId, createReason) {
            let reasonOption = document.createElement('option');
            let text = document.createTextNode(createReason);
            reasonOption.appendChild(text); // optionタグにtexセット
            reasonOption.setAttribute('value', createId); // optionタグにvalueセット
            reasonCategory.appendChild(reasonOption); // htmlにoptionを追加
        }

        // reason_option作成関数
        function reportReasonSwitch() {
            let oldReasonId = reasonCategory.value;
            // reasonCategoryのリセット=option要素を削除
            while (0 < reasonCategory.childNodes.length) {
                reasonCategory.removeChild(reasonCategory.childNodes[0]);
            }

            // 選択したreport_categoryでreasonのoptionを作成&追加
            if (reportCategory.value == "1" || // 有給
                reportCategory.value == "12" || // 欠勤
                reportCategory.value == "13" || // 遅刻
                reportCategory.value == "14" || // 早退
                reportCategory.value == "15") { // 外出
                let reasonId = [1, 2, 3, 4, 5, 6, 7, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "2") { // バースデイ
                let reasonId = [9];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "3") { // 特別休暇(慶事)
                let reasonId = [10, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "4") { // 特別休暇(弔事・配偶者等)
                let reasonId = [11, 12, 13, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "5") { // 特別休暇(弔事・同居の義父母)
                let reasonId = [15, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "6") { // 特別休暇(弔事・別居父母等)
                let reasonId = [14, 16, 17, 18, 19, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "7" || // 特別休暇(看護・対象1名)
                reportCategory.value == "8") { // 特別休暇(看護・対象2名以上)
                let reasonId = [20, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "9" || // 特別休暇(介護・対象1名)
                reportCategory.value == "10" || // 特別休暇(介護・対象2名)
                reportCategory.value == "16") { // 介護休業
                let reasonId = [21, 22, 23, 24, 25, 26, 27, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }
            if (reportCategory.value == "11" || // 特別休暇(短期育休)
                reportCategory.value == "17" || // 育児休業
                reportCategory.value == "18") { // パパ育休
                let reasonId = [28, 8];
                reasonId.forEach(e => {
                    let createId = reasons[e - 1].id;
                    let createReason = reasons[e - 1].reason;
                    createOption(createId, createReason)
                });
            }

            for (let i = 0; i < reasonCategory.childNodes.length; i++) {
                if (oldReasonId == reasonCategory.childNodes[i].value) {
                    reasonCategory.childNodes[i].selected = true;
                }

            }
        }

        // form表示関数
        function reportDisplaySwitch() {
            if (reportCategory.value == "1" || // 有給
                reportCategory.value == "7" || // 特別休暇(看護・対象1名)
                reportCategory.value == "8" || // 特別休暇(看護・対象2名)
                reportCategory.value == "9" || // 特別休暇(介護・対象1名)
                reportCategory.value == "10") { // 特別休暇(介護・対象2名)
                emptyFieldForm.style.display = "none";
                subCategoryForm.style.display = "";
                halfDateLabel.style.display = "none";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "";
                startDateForm.style.display = "";
                endDateForm.style.display = "";
            }
            if (reportCategory.value == "3" || // 特別休暇(慶事)
                reportCategory.value == "4" || // 特別休暇(弔事)
                reportCategory.value == "5" || // 特別休暇(弔事)
                reportCategory.value == "6" || // 特別休暇(弔事)
                reportCategory.value == "11" || // 特別休暇(短期育休)
                reportCategory.value == "16" || // 介護休業
                reportCategory.value == "17" || // 育児休業
                reportCategory.value == "18") { // パパ育休
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                halfDateLabel.style.display = "none";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "";
                startDateForm.style.display = "";
                endDateForm.style.display = "";
            }
            if (reportCategory.value == "13" || // 遅刻
                reportCategory.value == "14") { // 早退
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "";
                startTimeForm.style.display = "";
                endTimeForm.style.display = "";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
            if (reportCategory.value == "15") { // 外出
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "none";
                timeForm30.style.display = "";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "";
                endTimeForm.style.display = "";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
            if (reportCategory.value == "2" || // バースデイ
                reportCategory.value == "12") { // 欠勤
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                timeEmptyForm.style.display = "";
                amPmForm.style.display = "none";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
        }

        // 理由form関数
        function reasonDisplaySwitch() {
            if (reasonCategory.value == "8") { // 理由その他表示
                reasonDetail.style.display = "";
            }
            if (reasonCategory.value != "8") { // 理由その他非表示
                reasonDetail.style.display = "none";
            }
        }
        /* 表示切替end */

        /* 日数算出start */
        // let button = document.getElementById('button');
        let startDate = document.getElementById('start_date');
        let endDate = document.getElementById('end_date');
        let startTime = document.getElementById('start_time');
        let endTime = document.getElementById('end_time');

        // button.addEventListener("click", function() {
        //     // 取得日数
        //     const startVal = new Date(startDate.value);
        //     const endVal = new Date(endDate.value);
        //     const startTimeVal = new Date(startDate.value + ' ' + startTime.value);
        //     const endTimeVal = new Date(startDate.value + ' ' + endTime.value);
        //     let reportId = reportCategory.value;
        //     let diffDays = (endVal - startVal) / 86400000 + 1; // 単純な差
        //     let getDays = 0;
        //     let dayOffs = 0;

        //     //土曜日、日曜日は基本休業日でdayOffsに加算
        //     let remainderDays = diffDays % 7
        //     let startWeek = startVal.getDay(); //0~6の曜日数値
        //     dayOffs = (diffDays - remainderDays) / 7 * 2;
        //     for (var i = 0; i < remainderDays; i++) {
        //         if (startWeek + i == 0 || startWeek + i == 6 || startWeek + i == 7) {
        //             dayOffs++; // 土曜日6,日曜日0,7は休日数に加算
        //         }
        //     }

        //     // 土曜日の営業日をdayOffsから減算
        //     const saturday = [ //土曜日の営業日を配列
        //         '20230819',
        //         '20240309',
        //     ];
        //     for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
        //         let startYMD = d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d
        //             .getDate()).slice(-2);
        //         if (saturday.indexOf(startYMD) != -1) {
        //             dayOffs--; // 土曜日の営業日は休日数から減算
        //             // console.log(startYMD);
        //         }
        //     }

        //     // 祝祭日等の休業日をdayOffsに加算
        //     const holiday = [ // 土日以外の休業日を配列で記載
        //         '20230503',
        //         '20230504',
        //         '20230505',
        //         '20230814',
        //         '20230815',
        //         '20230816',
        //         '20240101',
        //         '20240102',
        //         '20240103',
        //     ];
        //     for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
        //         let startYMD = d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d
        //             .getDate()).slice(-2);
        //         if (holiday.indexOf(startYMD) != -1) {
        //             dayOffs++; // 土曜日の営業日は休日数から減算
        //             // console.log(startYMD);
        //         }
        //     }

        //     if (reportCategory.value == 1 || // 有給
        //         reportCategory.value == 3 || // 特別休暇(慶事)
        //         reportCategory.value == 4 || // 特別休暇(弔事)
        //         reportCategory.value == 5 || // 特別休暇(弔事)
        //         reportCategory.value == 6 || // 特別休暇(弔事)
        //         reportCategory.value == 7 || // 特別休暇(看護・対象1人)
        //         reportCategory.value == 8 || // 特別休暇(看護・対象2人以上)
        //         reportCategory.value == 9 || // 特別休暇(介護・対象1人)
        //         reportCategory.value == 10 || // 特別休暇(介護・対象2人以上)
        //         reportCategory.value == 11 || // 特別休暇(短期育休)
        //         reportCategory.value == 16 || // 介護休業
        //         reportCategory.value == 17 || // 育児休業
        //         reportCategory.value == 18) { // パパ育休
        //         getDays = diffDays - dayOffs;
        //     }
        //     if (subReportCategories[1].checked) { // 半日休
        //         getDays = 0.5;
        //     }
        //     if (subReportCategories[2].checked ||
        //         reportCategory.value == 13 || // 遅刻
        //         reportCategory.value == 14 || // 早退
        //         reportCategory.value == 15) { // 外出
        //         getDays = ((endTimeVal - startTimeVal) / 60000) / 60 * 1 / 8;
        //         // 時間換算:8時間で1日 1時間=1/8日 0.125日
        //         getDays = orgRound(getDays, 100000); // 小数点以下切り捨て
        //     }
        //     if (reportCategory.value == 2 || reportCategory.value == 12) {
        //         getDays = 1.0;
        //     }

        //     // get_days書き出し
        //     document.getElementById('get_days').setAttribute('value', getDays);

        //     // get時間&get日数作成&書き出し
        //     function orgRound(value, base) { // 小数点以下を丸める関数
        //         return Math.round(value * base) / base;
        //     }

        //     function decimalPart(num, decDigits) { // 指定した桁数の小数点以下を取り出す関数
        //         var decPart = num - ((num >= 0) ? Math.floor(num) : Math.ceil(num));
        //         return decPart.toFixed(decDigits);
        //     }

        //     // console.log(orgRound(getDays, 100000)); // 小数5桁
        //     let getDaysOnly = getDays - decimalPart(getDays, 5);
        //     let getHours = decimalPart(getDays, 5) * 8;
        //     let getMinutes = 0;
        //     if (decimalPart(getHours, 5) != 0 && decimalPart(getHours, 5) < 1) {
        //         getHoursOnly = getHours - decimalPart(getHours, 5);
        //         getHoursOnly = orgRound(getHoursOnly, 1);
        //         getMinutes = decimalPart(getHours, 5) * 60;
        //         getMinutes = orgRound(getMinutes, 1);
        //     } else {
        //         getHoursOnly = getHours;
        //     }
        //     document.getElementById('get_days_only').setAttribute('value', getDaysOnly);
        //     document.getElementById('get_hours').setAttribute('value', getHoursOnly);
        //     document.getElementById('get_minutes').setAttribute('value', getMinutes);

        //     let ownRemainings = @json($my_remainings);
        //     const arr = Object.keys(ownRemainings);
        //     let ownRemainingDays = 0;
        //     // console.log(arr);
        //     arr.forEach((el) => {
        //         if (ownRemainings[el].report_id == reportId) {
        //             ownRemainingDays = ownRemainings[el].remaining;
        //         }
        //     });

        //     let remainingDays = ownRemainingDays - getDays;
        //     // 残日数書き出し
        //     document.getElementById('remaining_days').setAttribute('value', remainingDays);

        //     // console.log(orgRound(remainingDays, 100000)); // 小数5桁
        //     let remainingDaysOnly = remainingDays - decimalPart(remainingDays, 5);
        //     let remainingHours = decimalPart(remainingDays, 5) * 8;
        //     let remainingMinutes = 0;
        //     if (decimalPart(remainingHours, 5) != 0 && decimalPart(remainingHours, 5) < 1) {
        //         remainingHoursOnly = remainingHours - decimalPart(remainingHours, 5);
        //         remainingHoursOnly = orgRound(remainingHoursOnly, 1);
        //         remainingMinutes = decimalPart(remainingHours, 5) * 60;
        //         remainingMinutes = orgRound(remainingMinutes, 1);
        //     } else {
        //         remainingHoursOnly = getHours;
        //     }
        //     document.getElementById('remaining_days_only').setAttribute('value', remainingDaysOnly);
        //     document.getElementById('remaining_hours').setAttribute('value', remainingHoursOnly);
        //     document.getElementById('remaining_minutes').setAttribute('value', remainingMinutes);
        // });

        function countDays() {
            // get_daysリセット
            document.getElementById('get_days').setAttribute('value', 0);
            document.getElementById('get_days_only').setAttribute('value', 0);
            document.getElementById('get_hours').setAttribute('value', 0);
            document.getElementById('get_minutes').setAttribute('value', 0);
            document.getElementById('remaining_days_only').setAttribute('value', 0);
            document.getElementById('remaining_hours').setAttribute('value', 0);
            document.getElementById('remaining_minutes').setAttribute('value', 0);

            // 取得日数
            const startVal = new Date(startDate.value);
            const endVal = new Date(endDate.value);
            const startTimeVal = new Date(startDate.value + ' ' + startTime.value);
            const endTimeVal = new Date(startDate.value + ' ' + endTime.value);
            let reportId = reportCategory.value;
            let diffDays = (endVal - startVal) / 86400000 + 1; // 単純な差
            let getDays = 0;
            let dayOffs = 0;

            //土曜日、日曜日は基本休業日でdayOffsに加算
            let remainderDays = diffDays % 7
            let startWeek = startVal.getDay(); //0~6の曜日数値
            dayOffs = (diffDays - remainderDays) / 7 * 2;
            for (var i = 0; i < remainderDays; i++) {
                if (startWeek + i == 0 || startWeek + i == 6 || startWeek + i == 7) {
                    dayOffs++; // 土曜日6,日曜日0,7は休日数に加算
                }
            }

            // 土曜日の営業日をdayOffsから減算
            const saturday = [ //土曜日の営業日を配列
                '20230819',
                '20240309',
            ];
            for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                let startYMD = d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d
                    .getDate()).slice(-2);
                if (saturday.indexOf(startYMD) != -1) {
                    dayOffs--; // 土曜日の営業日は休日数から減算
                    // console.log(startYMD);
                }
            }

            // 祝祭日等の休業日をdayOffsに加算
            const holiday = [ // 土日以外の休業日を配列で記載
                '20230503',
                '20230504',
                '20230505',
                '20230814',
                '20230815',
                '20230816',
                '20240101',
                '20240102',
                '20240103',
            ];
            for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                let startYMD = d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d
                    .getDate()).slice(-2);
                if (holiday.indexOf(startYMD) != -1) {
                    dayOffs++; // 土曜日の営業日は休日数から減算
                    // console.log(startYMD);
                }
            }

            if (reportCategory.value == 1 || // 有給
                reportCategory.value == 3 || // 特別休暇(慶事)
                reportCategory.value == 4 || // 特別休暇(弔事)
                reportCategory.value == 5 || // 特別休暇(弔事)
                reportCategory.value == 6 || // 特別休暇(弔事)
                reportCategory.value == 7 || // 特別休暇(看護・対象1人)
                reportCategory.value == 8 || // 特別休暇(看護・対象2人以上)
                reportCategory.value == 9 || // 特別休暇(介護・対象1人)
                reportCategory.value == 10 || // 特別休暇(介護・対象2人以上)
                reportCategory.value == 11 || // 特別休暇(短期育休)
                reportCategory.value == 16 || // 介護休業
                reportCategory.value == 17 || // 育児休業
                reportCategory.value == 18) { // パパ育休
                getDays = diffDays - dayOffs;
            }
            if (subReportCategories[1].checked) { // 半日休
                getDays = 0.5;
            }
            if (subReportCategories[2].checked ||
                reportCategory.value == 13 || // 遅刻
                reportCategory.value == 14 || // 早退
                reportCategory.value == 15) { // 外出
                getDays = ((endTimeVal - startTimeVal) / 60000) / 60 * 1 / 8;
                // 時間換算:8時間で1日 1時間=1/8日 0.125日
                getDays = orgRound(getDays, 100000); // 小数点以下切り捨て
            }
            if (reportCategory.value == 2 || reportCategory.value == 12) {
                getDays = 1.0;
            }

            // get_days書き出し
            document.getElementById('get_days').setAttribute('value', getDays);

            // get時間&get日数作成&書き出し
            function orgRound(value, base) { // 小数点以下を丸める関数
                return Math.round(value * base) / base;
            }

            function decimalPart(num, decDigits) { // 指定した桁数の小数点以下を取り出す関数
                var decPart = num - ((num >= 0) ? Math.floor(num) : Math.ceil(num));
                return decPart.toFixed(decDigits);
            }

            // console.log(orgRound(getDays, 100000)); // 小数5桁
            let getDaysOnly = getDays - decimalPart(getDays, 5);
            let getHours = decimalPart(getDays, 5) * 8;
            let getMinutes = 0;
            if (decimalPart(getHours, 5) != 0 && decimalPart(getHours, 5) < 1) {
                getHoursOnly = getHours - decimalPart(getHours, 5);
                getHoursOnly = orgRound(getHoursOnly, 1);
                getMinutes = decimalPart(getHours, 5) * 60;
                getMinutes = orgRound(getMinutes, 1);
            } else {
                getHoursOnly = getHours;
            }
            document.getElementById('get_days_only').setAttribute('value', getDaysOnly);
            document.getElementById('get_hours').setAttribute('value', getHoursOnly);
            document.getElementById('get_minutes').setAttribute('value', getMinutes);

            let ownRemainings = @json($my_remainings);
            const arr = Object.keys(ownRemainings);
            let ownRemainingDays = 0;
            // console.log(arr);
            arr.forEach((el) => {
                if (ownRemainings[el].report_id == reportId) {
                    ownRemainingDays = ownRemainings[el].remaining;
                }
            });

            let remainingDays = ownRemainingDays - getDays;
            // 残日数書き出し
            document.getElementById('remaining_days').setAttribute('value', remainingDays);

            // console.log(orgRound(remainingDays, 100000)); // 小数5桁
            let remainingDaysOnly = remainingDays - decimalPart(remainingDays, 5);
            let remainingHours = decimalPart(remainingDays, 5) * 8;
            let remainingMinutes = 0;
            if (decimalPart(remainingHours, 5) != 0 && decimalPart(remainingHours, 5) < 1) {
                remainingHoursOnly = remainingHours - decimalPart(remainingHours, 5);
                remainingHoursOnly = orgRound(remainingHoursOnly, 1);
                remainingMinutes = decimalPart(remainingHours, 5) * 60;
                remainingMinutes = orgRound(remainingMinutes, 1);
            } else {
                remainingHoursOnly = getHours;
            }
            document.getElementById('remaining_days_only').setAttribute('value', remainingDaysOnly);
            document.getElementById('remaining_hours').setAttribute('value', remainingHoursOnly);
            document.getElementById('remaining_minutes').setAttribute('value', remainingMinutes);
        };
        /* 日数算出end */
    </script>
</x-app-layout>
