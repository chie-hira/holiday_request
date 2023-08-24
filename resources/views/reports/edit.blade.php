<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-2xl px-6 py-12 mx-auto">
            <div class="">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">届出書編集</h1>
                <div class="mx-auto">
                    <x-info>
                        <p class="text-sm">
                            項目を入力して、<span class="font-bold">更新</span>を押してください。
                        </p>
                    </x-info>
                    <x-info>
                        <p class="text-sm">
                            更新すると<span class="font-bold">承認がリセット</span>されます。
                        </p>
                    </x-info>
                </div>
            </div>

            <x-errors :errors="$errors" />

            <form id="myForm" action="{{ route('reports.update', $report) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="report_date" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Report Date') }}
                        </label>
                        <x-input type="date" id="report_date" name="report_date" class="block mt-1 w-full"
                            :value="old('report_date', $report->report_date)" required />
                    </div>
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Name') }}
                        </label>
                        <input type="hidden" name="user_id" value="{{ $report->user_id }}">
                        <x-input type="text" id="user_id" class="block mt-1 w-full" :value="$report->user->name" readonly />
                    </div>
                    <div>
                        <label for="shift_id" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('休暇予定日のシフト') }}
                        </label>
                        <x-select name="shift_id" id="shift_id" class="block mt-1 w-full" onchange="countDays();"
                            required autofocus>
                            <option value="{{ $report->shift_id }}">
                                シフトコード{{ $report->shift_category->shift_code }}&emsp;{{ $report->shift_category->start_time_hm }}~{{ $report->shift_category->end_time_hm }}
                            </option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" @if ($shift->id === (int) old('shift_id')) selected @endif>
                                    シフトコード{{ $shift->shift_code }}&emsp;{{ $shift->start_time_hm }}~{{ $shift->end_time_hm }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div></div>
                    <div>
                        <label for="report_id" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Report Category') }}
                        </label>
                        <x-select name="report_id" id="report_id" onchange="reportChange();" class="block mt-1 w-full"
                            required>
                            <option value="{{ $report->report_id }}">{{ $report->report_category->report_name }}
                            </option>
                            @foreach ($report_categories as $report_category)
                                <option value="{{ $report_category->id }}"
                                    @if ($report_category->id === (int) old('report_id')) selected @endif>
                                    {{ $report_category->report_name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="hidden md:block" style="display: " id="empty_field_form"></div>

                        <!-- 遅刻・早退コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="time_form_10m">
                            <x-info>
                                <p class="text-sm">
                                    遅刻・早退は
                                    <span class="font-semibold text-red-500">10分単位</span>
                                    で取得できます
                                </p>
                            </x-info>
                        </div>
                        <!-- 遅刻・早退コメント - end -->

                        <!-- 外出コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="time_form_30m">
                            <x-info>
                                <p class="text-sm">
                                    外出は
                                    <span class="font-semibold text-red-500">30分単位</span>
                                    で取得できます
                                </p>
                            </x-info>
                        </div>
                        <!-- 外出コメント - end -->

                        <!-- 弔事コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="mourning_1">
                            <x-info>
                                <p class="text-sm">
                                    <span class="font-semibold text-red-500">配偶者、子、同居している父母</span>
                                    の喪に服するとき<span class="font-semibold text-red-500">3日間</span>取得できます
                                </p>
                            </x-info>
                        </div>
                        <div class="col-span-1 md:col-span-2" style="display: none" id="mourning_2">
                            <x-info>
                                <p class="text-sm">
                                    <span class="font-semibold text-red-500">同居している配偶者の父母</span>
                                    の喪に服するとき<span class="font-semibold text-red-500">2日間</span>取得できます
                                </p>
                            </x-info>
                        </div>
                        <div class="col-span-1 md:col-span-2" style="display: none" id="mourning_3">
                            <x-info class="">
                                <p class="text-sm">
                                    <span
                                        class="font-semibold text-red-500">同居していない父母、同居していない配偶者の父母、祖父母、同居している配偶者の祖父母、兄弟姉妹</span>
                                    の喪に服するとき<span class="font-semibold text-red-500">1日間</span>取得できます
                                </p>
                            </x-info>
                        </div>
                        <!-- 弔事コメント - end -->

                    <div style="display: none" id="sub_category_form">
                        <p class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Sub Report Category') }}
                        </p>
                        <div class="flex gap-x-6">
                            <div class="flex mt-2">
                                @foreach ($sub_report_categories as $sub_category)
                                    <input type="radio" name="sub_report_id"
                                        id="sub_report_id_{{ $sub_category->id }}" onclick="subReportChange()"
                                        value="{{ $sub_category->id }}"
                                        @if ($sub_category->id === (int) old('sub_report_id', $report->sub_report_id)) checked @endif
                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-sky-600 focus:ring-sky-300 ">
                                    <label for="sub_report_id_{{ $sub_category->id }}" name="sub_report_name"
                                        class="mr-2 text-sm text-gray-500 ml-2">
                                        {{ old('sub_report_name', $sub_category->sub_report_name) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 半日休コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="am_pm_comment">
                            <x-info>
                                <p class="text-sm">
                                    半日休の後半が日を跨ぐ場合でも、休暇予定日は
                                    <span class="font-semibold text-red-500">始業時間の日付</span>
                                    にしてください。
                                </p>
                            </x-info>
                        </div>
                        <!-- 半日休コメント - end -->

                        <!-- 時間休コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="time_form">
                            <x-info>
                                <p class="text-sm">
                                    時間休は
                                    <span class="font-semibold text-red-500">1時間単位</span>
                                    で取得できます。
                                </p>
                            </x-info>
                        </div>
                        <!-- 時間休コメント - end -->

                    <!-- 有給休暇 - start -->
                    <div>
                        <label style="display: " id="start_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            休暇予定日：何日から
                        </label>
                        <label style="display: none" id="half_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            休暇予定日
                        </label>
                        <x-input style="display: " type="date" id="start_date" name="start_date"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('start_date', $report->start_date)" required />
                    </div>
                    <div style="display: " id="end_date_form">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900">
                            何日まで
                        </label>
                        <x-input type="date" id="end_date" name="end_date" onchange="countDays();"
                            class="block mt-1 w-full" :value="old('end_date', $report->end_date)" />
                    </div>
                    <!-- 有給休暇 - end -->

                    <!-- 半日休 - start -->
                    <div style="display: none" id="am_pm_form">
                        <label for="am_pm" class="block mb-2 text-sm font-medium text-gray-900">
                            前半・後半
                        </label>
                        <x-select name="am_pm" id="am_pm" class="block mt-1 w-full" onchange="countDays();">
                            <option value="">選択してください</option>
                            <option value="1" @if (1 === (int) old('am_pm', $report->am_pm)) selected @endif>前半</option>
                            <option value="2" @if (2 === (int) old('am_pm', $report->am_pm)) selected @endif>後半</option>
                        </x-select>
                    </div>
                    <!-- 半日休 - end -->

                    <!-- 時間休 - start -->
                    <div style="display: none" id="time_empty_form">
                    </div>
                    <div style="display: none" id="start_time_form">
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時から<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <x-input type="time" id="start_time" name="start_time" step="300"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('start_time', substr($report->start_time, 0, 5))" />
                    </div>
                    <div style="display: none" id="end_time_form">
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時まで<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <x-input type="time" id="end_time" name="end_time" step="300"
                            onchange="countDays();" class="block mt-1 w-full" :value="old('end_time', substr($report->end_time, 0, 5))" />
                    </div>
                    <!-- 時間休 - end -->

                    <!-- 理由 - start -->
                    <div style="display: none" id="empty_reason_form"></div>
                    <div>
                        <label for="reason_id" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Reason') }}
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
                    <div style="display: " class="" id="reason_detail_form">
                        <label for="reason_detail" class="block mb-2 text-sm font-medium text-gray-900">
                            理由の詳細・備考
                        </label>
                        <x-input type="text" id="reason_detail" name="reason_detail" class="block mt-1 w-full"
                            placeholder="詳細・備考があれば記載してください" :value="old('reason_detail', $report->reason_detail)" />
                    </div>
                    <!-- 理由 - end -->

                <!-- 休日アラート - start -->
                <div class="col-span-1 md:col-span-2" id="holiday_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定日は
                            <span class="font-semibold text-red-500">休日</span>
                            です
                        </p>
                    </x-info>
                </div>
                <!-- 休日アラート - end -->

                <!-- 重複アラート - start -->
                <div class="col-span-1 md:col-span-2" id="duplication_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定に
                            <span class="font-semibold text-red-500">申請済みの日時</span>
                            が含まれています
                        </p>
                    </x-info>
                </div>
                <!-- 重複アラート - end -->

                <!-- 勤務時間アラート - start -->
                <div class="col-span-1 md:col-span-2" id="working_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定時刻は
                            <span class="font-semibold text-red-500">勤務時間外</span>
                            です
                        </p>
                    </x-info>
                </div>
                <!-- 勤務時間アラート - end -->

                <!-- 遅刻アラート - start -->
                <div class="col-span-1 md:col-span-2" id="late_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定時刻は
                            <span class="font-semibold text-red-500">遅刻</span>
                            です。休暇種類は遅刻で提出してください。
                        </p>
                    </x-info>
                </div>
                <div id="late_start_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            遅刻の開始時刻は
                            <span class="font-semibold text-red-500">就業開始時刻</span>
                            にしてください。
                        </p>
                    </x-info>
                </div>
                <!-- 遅刻アラート - end -->

                <!-- 外出アラート - start -->
                <div class="col-span-1 md:col-span-2" id="go_out_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定時刻は
                            <span class="font-semibold text-red-500">外出</span>
                            です。休暇種類は外出で提出してください。
                        </p>
                    </x-info>
                </div>
                <!-- 外出アラート - end -->

                <!-- 早退アラート - start -->
                <div class="col-span-1 md:col-span-2" id="leaving_early_alert" style="display: none">
                    <x-info>
                        <p class="text-sm">
                            選択中の休暇予定時刻は
                            <span class="font-semibold text-red-500">早退</span>
                            です。休暇種類は早退で提出してください。
                        </p>
                    </x-info>
                </div>
                <!-- 早退アラート - end -->
            </div>

                <div class="flex my-6">
                    <div class="mr-4">
                        <p class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Acquisition Days') }}
                        </p>
                        <input type="hidden" id="get_days" name="get_days"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_days') }}" readonly required>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="get_days_only" name="get_days_only" class="block mt-1 w-20"
                                :value="old('get_days_only')" readonly />
                            <p class="ml-2">日</p>
                        </div>
                        <div class="flex items-center mb-1">
                            <x-input type="number" id="get_hours" name="get_hours" class="block mt-1 w-20"
                                :value="old('get_hours')" readonly />
                            <p class="ml-2">時間</p>
                        </div>
                        <div class="flex items-center">
                            <x-input type="number" id="get_minutes" name="get_minutes" class="block mt-1 w-20"
                                :value="old('get_minutes')" readonly />
                            <p class="ml-2">分</p>
                        </div>
                    </div>

                    <div>
                        <p class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Remaining Days') }}
                        </p>
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
                    <x-edit-rectangle-button id="submitButton" class="w-full">
                        {{ __('Update') }}
                    </x-edit-rectangle-button>
                </div>
            </form>
        </div>

            <div class="mt-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('reports.my_index') }}">
                    届出一覧
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
        let emptyReasonForm = document.getElementById('empty_reason_form');
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
        let amPmComment = document.getElementById('am_pm_comment');
        let mourning1 = document.getElementById('mourning_1');
        let mourning2 = document.getElementById('mourning_2');
        let mourning3 = document.getElementById('mourning_3');
        let amPm = document.getElementById('am_pm');
        const reasons = @json($reasons);

        // リダイレクト時の表示切替
        window.addEventListener('load', function() {
            displayReset();
            reportDisplaySwitch(); // reportでform表示切替
            subReportDisplaySwitch(); // sub_reportでform表示切替
            reportReasonSwitch(); // reportでreason種類切替
            countDays();
        });

        // 届出内容変更時の表示切替
        function reportChange() {
            displayReset();
            reportDisplaySwitch(); // reportでform表示切替
            reportReasonSwitch(); // reportでreason種類切替
            let subReportCategory = document.querySelector('input[name=sub_report_id]:checked');
            if (subReportCategory) {
                console.log(subReportCategory.value);
                subReportCategory.checked = false;
            }
            timeReset(); // end_date,start_time,end_timeリセット
            dateChange(); // get_daysリセット
            alertReset(); // アラートリセット
            if (reportCategory.value == "2" ||
                reportCategory.value == "12") {
                countDays();
            }
            emptyReasonForm.style.display = "none";
        }

        // アラートリセット関数
        function alertReset() {
            duplicationAlert.style.display = 'none';
            workingAlert.style.display = 'none';
            lateAlert.style.display = 'none';
            lateStartAlert.style.display = 'none';
            goOutAlert.style.display = 'none';
            earlyAlert.style.display = 'none';
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

        // その他理由選択時のplaceholder表示切替
        function reasonChange() {
            reasonDisplaySwitch(); // reasonで理由:その他表示切替
        }

        // subカテゴリーによるフォーム切替関数
        function subReportChange() {
            displayReset();
            dateChange();
            subReportDisplaySwitch();
            timeReset();
            alertReset();
            if (subReportCategories[0].checked) {
                countDays();
            }
        }

        // 表示初期化関数
        function displayReset() {
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
            mourning1.style.display = "none";
            mourning2.style.display = "none";
            mourning3.style.display = "none";
            amPmComment.style.display = "none";
            emptyReasonForm.style.display = "none";
        }

        function subReportDisplaySwitch() {
            let subReportCategory = document.querySelector('input[name=sub_report_id]:checked');
            if (subReportCategory) {
                let subReportCategoryValue = subReportCategory.value;
                if (subReportCategoryValue == 1) { // 終日休
                    halfDateLabel.style.display = "";
                    startDateLabel.style.display = "none";
                    endDateForm.style.display = "none";
                    emptyReasonForm.style.display = "";
                }
                if (subReportCategoryValue == 2) { // 連休
                    holidayAlert.style.display = "none";
                }
                if (subReportCategoryValue == 3) { // 半日休
                    halfDateLabel.style.display = "";
                    amPmForm.style.display = "";
                    amPmComment.style.display = "";
                    startDateLabel.style.display = "none";
                    endDateForm.style.display = "none";
                }
                if (subReportCategoryValue == 4) { // 時間休
                    halfDateLabel.style.display = "";
                    timeEmptyForm.style.display = "";
                    timeForm.style.display = "";
                    startTimeForm.style.display = "";
                    endTimeForm.style.display = "";
                    startDateLabel.style.display = "none";
                    endDateForm.style.display = "none";
                }
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

        // reason切替関数
        function reportReasonSwitch() {
            let oldReasonId = reasonCategory.value;
            // reasonCategoryのリセット=option要素を削除
            while (0 < reasonCategory.childNodes.length) {
                reasonCategory.removeChild(reasonCategory.childNodes[0]);
            }

            const reportReasons = @json($report_reasons);

            // reasonCategoryをセット=option要素を追加
            Object.keys(reportReasons).forEach((el) => {
                if (reportCategory.value == reportReasons[el].report_id) {
                    let createId = reasons[reportReasons[el].reason_id - 1].id;
                    let createReason = reasons[reportReasons[el].reason_id - 1].reason;
                    createOption(createId, createReason)
                }
            })

            for (let i = 0; i < reasonCategory.childNodes.length; i++) {
                if (oldReasonId == reasonCategory.childNodes[i].value) {
                    reasonCategory.childNodes[i].selected = true;
                }

            }
        }

        // form表示切替関数
        function reportDisplaySwitch() {
            if (
                reportCategory.value == "4"
            ) { // 特別休暇(弔事1)
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                mourning1.style.display = "";
            }
            if (
                reportCategory.value == "5"
            ) { // 特別休暇(弔事2)
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                mourning2.style.display = "";
            }
            if (
                reportCategory.value == "6"
            ) { // 特別休暇(弔事3)
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                mourning3.style.display = "";
            }
            if (reportCategory.value == "3" || // 特別休暇(慶事)
                reportCategory.value == "11" || // 特別休暇(短期育休)
                reportCategory.value == "16" || // 介護休業
                reportCategory.value == "17" || // 育児休業
                reportCategory.value == "18") { // パパ育休
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
            }
            if (reportCategory.value == "13" || // 遅刻
                reportCategory.value == "14") { // 早退
                emptyFieldForm.style.display = "";
                subCategoryForm.style.display = "none";
                halfDateLabel.style.display = "";
                timeEmptyForm.style.display = "";
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
                timeEmptyForm.style.display = "";
                timeForm30.style.display = "";
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
                timeEmptyForm.style.display = "";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
        }

        // 理由詳細placeholder切替関数
        function reasonDisplaySwitch() {
            if (reasonCategory.value == "9") { // 理由その他表示
                reasonDetail.placeholder = "詳細を記入してください";
            }
            if (reasonCategory.value != "9") { // 理由その他非表示
                reasonDetail.placeholder = "詳細・備考があれば記入してください";
            }
        }
        /* 表示切替end */

        /* 二重送信防止start */
        // 送信ボタンをクリックした後に非活性化する関数
        function disableSubmitButton() {
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true; // ボタンを非活性にする
        }

        // フォームが送信される前にdisableSubmitButton関数を呼び出す
        document.getElementById('myForm').addEventListener('submit', function() {
            disableSubmitButton();
        });
        /* 二重送信防止end */

        /* 日数算出start */
        let startDate = document.getElementById('start_date');
        let endDate = document.getElementById('end_date');
        let startTime = document.getElementById('start_time');
        let endTime = document.getElementById('end_time');
        let holidayAlert = document.getElementById('holiday_alert');
        let duplicationAlert = document.getElementById('duplication_alert');
        let workingAlert = document.getElementById('working_alert');
        let lateAlert = document.getElementById('late_alert');
        let lateStartAlert = document.getElementById('late_start_alert');
        let goOutAlert = document.getElementById('go_out_alert');
        let earlyAlert = document.getElementById('leaving_early_alert');
        let shiftCategory = document.getElementById('shift_id');

        /* --日数カウント-- */
        function countDays() {
            // get_daysリセット
            document.getElementById('get_days').setAttribute('value', 0);
            document.getElementById('get_days_only').setAttribute('value', 0);
            document.getElementById('get_hours').setAttribute('value', 0);
            document.getElementById('get_minutes').setAttribute('value', 0);
            document.getElementById('remaining_days_only').setAttribute('value', 0);
            document.getElementById('remaining_hours').setAttribute('value', 0);
            document.getElementById('remaining_minutes').setAttribute('value', 0);

            const startVal = new Date(startDate.value);
            const endVal = new Date(endDate.value);
            const startTimeVal = new Date(startDate.value + ' ' + startTime.value);
            const endTimeVal = new Date(startDate.value + ' ' + endTime.value);
            const amPmVal = amPm.value;
            const reportId = reportCategory.value;
            const shiftId = shiftCategory.value;
            const shifts = @json($shifts);

            if (startTime.value > endTime.value) {
                endTimeVal.setDate(endTimeVal.getDate() + 1);
            }

            let diffDays = (endVal - startVal) / 86400000 + 1; // 単純な差
            let startYMD = startVal.getFullYear() +
                ('0' + (startVal.getMonth() + 1)).slice(-2) +
                ('0' + startVal.getDate()).slice(-2);
            let startY_M_D = startVal.getFullYear() +
                '-' + ('0' + (startVal.getMonth() + 1)).slice(-2) +
                '-' + ('0' + startVal.getDate()).slice(-2);
            let getDays = 0;
            let dayOffs = 0;

            // 土曜日の営業日
            const businessDayCalender = @json($business_day_calender);
            const saturdays = businessDayCalender.map(item => item.date);

            // 祝祭日等(休暇取得推進日含む)
            const holidayCalender = @json($holiday_calender);
            const holidays = holidayCalender.map(item => item.date);

            //土曜日、日曜日をdayOffsに集計
            let remainderDays = diffDays % 7
            let startWeek = startVal.getDay(); //0~6の曜日数値
            dayOffs = (diffDays - remainderDays) / 7 * 2;
            for (var i = 0; i < remainderDays; i++) {
                if (startWeek + i == 0 || startWeek + i == 6 || startWeek + i == 7) {
                    dayOffs++; // 土曜日6,日曜日0,7は休日数に加算
                }
            }

            //祝日等と土曜営業日をdayOffsに集計
            for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                let dYMD = d.getFullYear() + ('0' + (d.getMonth() + 1)).slice(-2) + ('0' + d
                    .getDate()).slice(-2);
                // 土曜日の営業日をdayOffsから減算
                if (saturdays.includes(dYMD)) {
                    dayOffs--;
                }
                // 祝祭日等の休業日をdayOffsに加算
                if (holidays.includes(dYMD)) {
                    dayOffs++;
                }
            }

            // シフトごとに変わる時間を定義
            let workTimeStart = '';
            let workTimeEnd = '';
            let rest1TimeStart = '';
            let rest2TimeStart = '';
            let rest3TimeStart = '';
            let rest1TimeEnd = '';
            let rest2TimeEnd = '';
            let rest3TimeEnd = '';
            let lunchTimeStart = '';
            let lunchTimeEnd = '';
            for (let i = 0; i < shifts.length; i++) {
                const shift = shifts[i];
                if (shift.id == shiftId) {
                    workTimeStart = new Date(startDate.value + ' ' + shift.start_time);
                    workTimeEnd = new Date(startDate.value + ' ' + shift.end_time);
                    rest1TimeStart = new Date(startDate.value + ' ' + shift.rest1_start_time);
                    rest1TimeEnd = new Date(startDate.value + ' ' + shift.rest1_end_time);
                    rest2TimeStart = new Date(startDate.value + ' ' + shift.rest2_start_time);
                    rest2TimeEnd = new Date(startDate.value + ' ' + shift.rest2_end_time);
                    rest3TimeStart = new Date(startDate.value + ' ' + shift.rest3_start_time);
                    rest3TimeEnd = new Date(startDate.value + ' ' + shift.rest3_end_time);
                    lunchTimeStart = new Date(startDate.value + ' ' + shift.lunch_start_time);
                    lunchTimeEnd = new Date(startDate.value + ' ' + shift.lunch_end_time);
                    if (shift.start_time > shift.end_time) {
                        workTimeEnd.setDate(workTimeEnd.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest1_start_time) {
                        rest1TimeStart.setDate(rest1TimeStart.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest1_end_time) {
                        rest1TimeEnd.setDate(rest1TimeEnd.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest2_start_time) {
                        rest2TimeStart.setDate(rest2TimeStart.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest2_end_time) {
                        rest2TimeEnd.setDate(rest2TimeEnd.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest3_start_time) {
                        rest3TimeStart.setDate(rest3TimeStart.getDate() + 1);
                    }
                    if (shift.start_time > shift.rest3_end_time) {
                        rest3TimeEnd.setDate(rest3TimeEnd.getDate() + 1);
                    }
                    if (shift.start_time > shift.lunch_start_time) {
                        lunchTimeStart.setDate(lunchTimeStart.getDate() + 1);
                    }
                    if (shift.start_time > shift.lunch_end_time) {
                        lunchTimeEnd.setDate(lunchTimeEnd.getDate() + 1);
                    }
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
                if (duplicationCheck() == true) {
                    getDays = 0;
                } else {
                    // この順番を変えてはいけない
                    getDays = diffDays - dayOffs;
                    holidayCheck();
                }
            }

            if (subReportCategories[0].checked) { // 終日休
                if (holidayCheck() == true) {
                    getDays = 0;
                } else if (duplicationCheck() == true) {
                    getDays = 0;
                } else {
                    getDays = 1.0;
                }
            }
            if (subReportCategories[2].checked) { // 半日休
                if (holidayCheck() == true) {
                    getDays = 0;
                } else if (duplicationCheck() == true) {
                    getDays = 0;
                } else {
                    getDays = 0.5;
                    // パート,アルバイトはコードで休時間が変わる
                    // フルタイムは4時間
                    // if (shiftId == 19 || // コード43
                    //     (shiftId == 15 && amPmVal == 2)) { // コード11後半
                    //     getDays = 0.25; // 2時間
                    // } else if (
                    //     (shiftId == 21 && amPmVal == 2) || // コード58後半
                    //     (shiftId == 14 && amPmVal == 2) || // コード8後半
                    //     shiftId == 22 || // コード59
                    //     (shiftId == 16 && amPmVal == 1)) { // コード14前半
                    //     getDays = 0.3125; // 2時間半
                    // } else if (
                    //     (shiftId == 17 && amPmVal == 2) || // コード19後半
                    //     shiftId == 18 || // コード42
                    //     (shiftId == 13 && amPmVal == 1) || // コード5前半
                    //     (shiftId == 16 && amPmVal == 2)) { // コード14後半
                    //     getDays = 0.375; // 3時間
                    // } else if (
                    //     (shiftId == 15 && amPmVal == 1) || // コード11前半
                    //     shiftId == 20 || // コード53
                    //     (shiftId == 14 && amPmVal == 1) || // コード8前半
                    //     (shiftId == 17 && amPmVal == 1)) { // コード19前半
                    //     getDays = 0.4375; // 3時間半
                    // } else {
                    //     getDays = 0.5;
                    // }
                }
            }

            if (
                // WORNING:時間休にを有効にする場合、シフトによって1時間の重みが違う
                // 4時間労働の2時間休み=8時間労働の4時間休み
                // これがシフトが変わったとき、どのように扱うのか
                // subReportCategories[3].checked ||
                reportCategory.value == 13 || // 遅刻
                reportCategory.value == 14 || // 早退
                reportCategory.value == 15) { // 外出

                if (holidayCheck() == true) {
                    getDays = 0;
                } else if (duplicationCheck() == true) {
                    getDays = 0;
                } else if (workingTimeCheck() == true && subReportCategories[3].checked) {
                    getDays = 0;
                } else if (timeCheck() == true) { // 申請時間を確認
                    getDays = 0;
                } else {
                    let restTime = 0;
                    // ランチタイムを挟む場合
                    if (startTimeVal < lunchTimeStart && endTimeVal >= lunchTimeStart && endTimeVal < lunchTimeEnd) {
                        restTime += endTimeVal - lunchTimeStart;
                        // getDays = ((endTimeVal - startTimeVal - (endTimeVal - lunchTimeStart)) / 60000) / 60 * 1 / 8;
                    }
                    if (startTimeVal < lunchTimeStart && endTimeVal >= lunchTimeEnd) {
                        // getDays = ((endTimeVal - startTimeVal - (lunchTimeEnd - lunchTimeStart)) / 60000) / 60 * 1 / 8;
                        restTime += lunchTimeEnd - lunchTimeStart;
                    }
                    if (startTimeVal >= lunchTimeStart && startTimeVal < lunchTimeEnd && endTimeVal > lunchTimeEnd) {
                        // getDays = ((endTimeVal - startTimeVal - (lunchTimeEnd - startTimeVal)) / 60000) / 60 * 1 / 8;
                        restTime += lunchTimeEnd - startTimeVal;
                    }
                    // 中休み1を挟む場合
                    if (startTimeVal < rest1TimeStart && endTimeVal >= rest1TimeStart && endTimeVal < rest1TimeEnd) {
                        restTime += endTimeVal - rest1TimeStart;
                    }
                    if (startTimeVal < rest1TimeStart && endTimeVal >= rest1TimeEnd) {
                        restTime += rest1TimeEnd - rest1TimeStart;
                    }
                    if (startTimeVal >= rest1TimeStart && startTimeVal < rest1TimeEnd && endTimeVal > rest1TimeEnd) {
                        restTime += rest1TimeEnd - startTimeVal;
                    }
                    // 中休み2を挟む場合
                    if (startTimeVal < rest2TimeStart && endTimeVal >= rest2TimeStart && endTimeVal < rest2TimeEnd) {
                        restTime += endTimeVal - rest2TimeStart;
                    }
                    if (startTimeVal < rest2TimeStart && endTimeVal >= rest2TimeEnd) {
                        restTime += rest2TimeEnd - rest2TimeStart;
                    }
                    if (startTimeVal >= rest2TimeStart && startTimeVal < rest2TimeEnd && endTimeVal > rest2TimeEnd) {
                        restTime += rest2TimeEnd - startTimeVal;
                    }
                    // 中休み3を挟む場合
                    if (startTimeVal < rest3TimeStart && endTimeVal >= rest3TimeStart && endTimeVal < rest3TimeEnd) {
                        restTime += endTimeVal - rest3TimeStart;
                    }
                    if (startTimeVal < rest3TimeStart && endTimeVal >= rest3TimeEnd) {
                        restTime += rest3TimeEnd - rest3TimeStart;
                    }
                    if (startTimeVal >= rest3TimeStart && startTimeVal < rest3TimeEnd && endTimeVal > rest3TimeEnd) {
                        restTime += rest3TimeEnd - startTimeVal;
                    }
                    getDays = ((endTimeVal - startTimeVal - restTime) / 60000) / 60 * 1 / 8;
                }

                // 時間換算:8時間で1日 1時間=1/8日 0.125日
                getDays = orgRound(getDays, 100000); // 小数点以下切り捨て
            }
            if (reportCategory.value == 2 || reportCategory.value == 12) { // バースデイ休暇、欠勤
                if (holidayCheck() == true) {
                    getDays = 0;
                } else if (duplicationCheck() == true) {
                    getDays = 0;
                } else {
                    getDays = 1.0;
                }
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

            let myAcquisitionDays = @json($my_acquisition_days);
            let ownRemainingDays = 0;
            Object.keys(myAcquisitionDays).forEach((el) => {
                if (myAcquisitionDays[el].report_id == reportId) {
                    // 申請中の日数を考慮した残日数を算出
                    ownRemainingDays = myAcquisitionDays[el].remaining_days;
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
            if (remainingDaysOnly < 0) {
                remainingDaysOnly = 0;
            }
            if (remainingHours < 0) {
                remainingHours = 0;
            }
            if (remainingMinutes < 0) {
                remainingMinutes = 0;
            }
            document.getElementById('remaining_days_only').setAttribute('value', remainingDaysOnly);
            document.getElementById('remaining_hours').setAttribute('value', remainingHoursOnly);
            document.getElementById('remaining_minutes').setAttribute('value', remainingMinutes);

            /* --functions-- */
            // 休日確認関数
            function holidayCheck() {
                console.log('holidayCheck'); // 起動確認
                let holiday = false;
                // これは必要:土曜営業日はfalse
                if (saturdays.includes(startYMD)) {
                    holiday = false;
                } else if (startWeek + i == 0 || startWeek + i == 6 || startWeek + i == 7) {
                    holiday = true;
                } else if (holidays.includes(startYMD)) {
                    holiday = true;
                } else if (endDate.value) {
                    for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                        const Y_M_D = d.getFullYear() +
                            ('0' + (d.getMonth() + 1)).slice(-2) +
                            ('0' + d.getDate()).slice(-2);
                        if (holidays.includes(Y_M_D) && getDays == 0) {
                            console.log(Y_M_D);
                            holiday = true;
                        }
                    }
                } else {
                    holiday = false;
                }

                if (holiday == true) {
                    holidayAlert.style.display = '';
                    return true;
                } else {
                    holidayAlert.style.display = 'none';
                    return false;
                }
            }

            // 取得時間確認
            function timeCheck() {
                console.log('timeCheck'); // 起動確認
                let lateTime = false; // 遅刻判定
                let goOutTime = false; // 外出判定
                let earlyTime = false; // 早退判定

                // 遅刻判定
                if (startTime.value != '' && workTimeStart.getTime() == startTimeVal.getTime() && (reportCategory.value ==
                        14 || reportCategory
                        .value == 15)) {
                    lateTime = true;
                    console.log('late');
                }

                // 外出判定
                if (
                    startTime.value != '' && workTimeStart < startTimeVal && endTime.value != '' && workTimeEnd >
                    endTimeVal && (reportCategory.value == 13 || reportCategory.value == 14)
                ) {
                    goOutTime = true;
                    console.log('goOut');
                }

                // 早退判定
                if (
                    endTime.value != '' && workTimeEnd.getTime() == endTimeVal.getTime() && (reportCategory.value == 13 ||
                        reportCategory
                        .value == 15)
                ) {
                    earlyTime = true;
                    console.log('early');
                }

                if (lateTime == true) {
                    lateAlert.style.display = '';
                } else {
                    lateAlert.style.display = 'none';
                }

                if (goOutTime == true) {
                    goOutAlert.style.display = '';
                } else {
                    goOutAlert.style.display = 'none';
                }

                if (earlyTime == true) {
                    earlyAlert.style.display = '';
                } else {
                    earlyAlert.style.display = 'none';
                }

                if (lateTime == true || goOutTime == true || earlyTime == true) {
                    return true;
                } else {
                    return false;
                }
            }

            // 勤務確認関数
            function workingTimeCheck() {
                console.log('workingTimeCheck'); // 起動確認
                let workingTime = false; // 勤務時間判定
                    if (startTime.value != '' && workTimeStart > startTimeVal) {
                        workingTime = true;
                    } else if (startTime.value != '' && workTimeEnd <= startTimeVal) {
                        workingTime = true;
                    } else if (endTime.value != '' && workTimeEnd < endTimeVal) {
                        workingTime = true;
                    }
                // }

                if (workingTime == true) {
                    workingAlert.style.display = '';
                    return true;
                } else {
                    workingAlert.style.display = 'none';
                    return false;
                }
            }

            // 重複確認関数
            function duplicationCheck() {
                console.log('duplicationCheck'); // 起動確認
                const myReports = @json($my_reports);
                let duplication = false;
                Object.keys(myReports).forEach((el) => {
                    // 終日選択
                    if (subReportCategories[0].checked || subReportCategories[1].checked) {
                        if (myReports[el].start_date == startY_M_D) {
                            duplication = true;
                        }
                    }
                    // 終日休み
                    if (myReports[el].am_pm == null && myReports[el].start_time == null && myReports[el]
                        .start_date == startY_M_D) {
                        duplication = true;
                    }
                    // 時間休み
                    if (myReports[el].start_time != null && myReports[el].start_date == startY_M_D) {
                        for (let t = new Date(startDate.value + ' ' + startTime.value); t <= endTimeVal; t.setTime(t
                                .getTime() + 5 * 60 * 1000)) {
                            if (myReports[el].start_time == convertTime(t.getTime())) {
                                duplication = true;
                            }
                            if (myReports[el].end_time == convertTime(t.getTime())) {
                                duplication = true;
                            }
                            if (myReports[el].start_time <= convertTime(t.getTime()) && myReports[el].end_time >=
                                convertTime(t
                                    .getTime())) {
                                duplication = true;
                            }
                        }
                    }
                    // 半日休み
                    if (myReports[el].am_pm != null && myReports[el].start_date == startY_M_D) {
                        if (myReports[el].am_pm == amPmVal) {
                            duplication = true;
                        }
                        if (myReports[el].am_pm == 1) {
                            var sTime = workTimeStart;
                            var eTime = lunchTimeStart;
                        }
                        if (myReports[el].am_pm == 2) {
                            var sTime = lunchTimeEnd;
                            var eTime = workTimeEnd;
                        }
                        for (let t = new Date(startDate.value + ' ' + startTime.value); t <= endTimeVal; t.setTime(t
                                .getTime() + 5 * 60 * 1000)) {
                            if (sTime == t) {
                                duplication = true;
                            }
                            if (eTime == t) {
                                duplication = true;
                            }
                            if (sTime <= t && eTime >= t) {
                                duplication = true;
                            }
                        }
                    }
                });
                if (duplication == true) {
                    duplicationAlert.style.display = '';
                    return true;
                } else {
                    for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                        const Y_M_D = d.getFullYear() +
                            '-' + ('0' + (d.getMonth() + 1)).slice(-2) +
                            '-' + ('0' + d.getDate()).slice(-2);
                        myReports.forEach(report => {
                            if (report.start_date == Y_M_D) {
                                duplication = true;
                            }
                            if (report.end_date == Y_M_D) {
                                duplication = true;
                            }
                            if (report.start_date <= Y_M_D && report.end_date >= Y_M_D) {
                                duplication = true;
                            }
                        });
                        if (duplication == true) {
                            duplicationAlert.style.display = '';
                            return true;
                        }
                    }
                }
                duplicationAlert.style.display = 'none';
                return false;
            }

            function convertTime(milliseconds) {
                // タイムゾーンオフセット（日本時間の場合は9時間）
                var timeZoneOffset = 9 * 60 * 60 * 1000;
                // 日本時間に補正
                var japanTimeInMilliseconds = milliseconds + timeZoneOffset;

                var totalSeconds = Math.floor(japanTimeInMilliseconds / 1000);
                var seconds = totalSeconds % 60;
                var totalMinutes = Math.floor(totalSeconds / 60);
                var minutes = totalMinutes % 60;
                var totalHours = Math.floor(totalMinutes / 60);
                var hours = totalHours % 24;

                // ゼロ埋め
                var hh = padZero(hours);
                var mm = padZero(minutes);
                var ss = padZero(seconds);

                return hh + ":" + mm + ":" + ss;
            }

            function padZero(num) {
                return num.toString().padStart(2, "0");
            }
        };
        /* 日数算出end */
    </script>
</x-app-layout>
