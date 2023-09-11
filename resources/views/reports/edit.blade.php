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
                            <x-input type="text" id="user_id" class="block mt-1 w-full" :value="$report->user->name"
                                readonly />
                        </div>
                        <div>
                            <label for="shift_id" class="block mb-2 text-sm font-medium text-gray-900">
                                {{ __('Shift') }}
                            </label>
                            <x-select name="shift_id" id="shift_id" class="block mt-1 w-full" onchange="countDays();"
                                required autofocus>
                                <option value="{{ $report->shift_id }}">
                                    {{ __('Shift Number') }}{{ $report->shift_category->shift_code }}&emsp;{{ $report->shift_category->start_time_hm }}~{{ $report->shift_category->end_time_hm }}
                                </option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}"
                                        @if ($shift->id === (int) old('shift_id')) selected @endif>
                                        {{ __('Shift Number') }}{{ $shift->shift_code }}&emsp;{{ $shift->start_time_hm }}~{{ $shift->end_time_hm }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div></div>
                        <div>
                            <label for="report_id" class="block mb-2 text-sm font-medium text-gray-900">
                                {{ __('Report Category') }}
                            </label>
                            <x-select name="report_id" id="report_id" onchange="reportChange();"
                                class="block mt-1 w-full" required>
                                <option value="{{ $report->report_id }}">{{ $report->report_category->report_name }}
                                </option>
                                @foreach ($report_categories as $report_category)
                                    <option value="{{ $report_category->id }}"
                                        @if ($report_category->id === (int) old('report_id')) selected @endif>
                                        {{ $report_category->report_name }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
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

                        <!-- 休暇種類コメント - start -->
                        <div class="col-span-1 md:col-span-2" style="display: none" id="remarks_contener">
                            <x-info style="display: none" id="report_remarks_contener">
                                <p class="text-sm" id="report_remarks">
                                </p>
                            </x-info>
                            <x-info style="display: none" id="sub_report_remarks_contener">
                                <p class="text-sm" id="sub_report_remarks">
                                </p>
                            </x-info>
                        </div>

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
                            <x-input type="date" id="start_date" name="start_date" onchange="countDays();"
                                class="block mt-1 w-full" :value="old('start_date', $report->start_date)" required />
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
                            <x-select name="reason_id" id="reason_id" onchange="reasonChange();"
                                class="block mt-1 w-full" required>
                                <option value="{{ $report->reason_id }}">{{ $report->reason_category->reason }}
                                </option>
                                @foreach ($reasons as $reason)
                                    <option value="{{ $reason->id }}"
                                        @if ($reason->id === (int) old('reason_id')) selected @endif>
                                        {{ $reason->reason }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <label for="reason_detail" class="block mb-2 text-sm font-medium text-gray-900">
                                理由の詳細・備考
                            </label>
                            <x-input type="text" id="reason_detail" name="reason_detail"
                                placeholder="詳細・備考があれば記載してください" :value="old('reason_detail', $report->reason_detail)" />
                        </div>
                        <!-- 理由 - end -->

                        <!-- 休日アラート - start -->
                        <div class="col-span-1 md:col-span-2">
                            <x-info id="holiday_alert" style="display: none">
                                <p class="text-sm">
                                    選択中の休暇予定日は
                                    <span class="font-semibold text-red-500">休日</span>
                                    です
                                </p>
                            </x-info>
                            <!-- 休日アラート - end -->

                            <!-- 重複アラート - start -->
                            <x-info id="duplication_alert" style="display: none">
                                <p class="text-sm">
                                    選択中の休暇予定に
                                    <span class="font-semibold text-red-500">申請済みの日時</span>
                                    が含まれています
                                </p>
                            </x-info>
                            <!-- 重複アラート - end -->

                            <!-- 勤務時間アラート - start -->
                            <x-info id="working_alert" style="display: none">
                                <p class="text-sm">
                                    選択中の休暇予定時刻は
                                    <span class="font-semibold text-red-500">勤務時間外</span>
                                    です
                                </p>
                            </x-info>
                            <!-- 勤務時間アラート - end -->

                            <!-- 遅刻アラート - start -->
                            <x-info id="late_alert" style="display: none">
                                <p class="text-sm">
                                    選択中の休暇予定時刻は
                                    <span class="font-semibold text-red-500">遅刻</span>
                                    です。休暇種類は遅刻で提出してください。
                                </p>
                            </x-info>
                            <x-info id="late_start_alert" style="display: none">
                                <p class="text-sm">
                                    遅刻の開始時刻は
                                    <span class="font-semibold text-red-500">就業開始時刻</span>
                                    にしてください。
                                </p>
                            </x-info>
                            <!-- 遅刻アラート - end -->

                            <!-- 外出アラート - start -->
                            <x-info id="go_out_alert" style="display: none">
                                <p class="text-sm">
                                    選択中の休暇予定時刻は
                                    <span class="font-semibold text-red-500">外出</span>
                                    です。休暇種類は外出で提出してください。
                                </p>
                            </x-info>
                            <!-- 外出アラート - end -->

                            <!-- 早退アラート - start -->
                            <x-info id="leaving_early_alert" style="display: none">
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
                            <div class="flex items-center mb-1">
                                <x-input type="number" id="acquisition_days" name="acquisition_days"
                                    class="block mt-1 w-20" :value="old('get_days_only')" readonly />
                                <p class="ml-2">日</p>
                            </div>
                            <div class="flex items-center mb-1">
                                <x-input type="number" id="acquisition_hours" name="acquisition_hours"
                                    class="block mt-1 w-20" :value="old('acquisition_hours')" readonly />
                                <p class="ml-2">時間</p>
                            </div>
                            <div class="flex items-center">
                                <x-input type="number" id="acquisition_minutes" name="acquisition_minutes"
                                    class="block mt-1 w-20" :value="old('acquisition_minutes')" readonly />
                                <p class="ml-2">分</p>
                            </div>
                        </div>

                        <div>
                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                {{ __('Remaining Days') }}
                            </p>
                            <div class="flex items-center mb-1">
                                <x-input type="number" id="remaining_days" name="remaining_days"
                                    class="block mt-1 w-20" :value="old('remaining_days')" readonly />
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

            <div class="w-full max-w-2xl mt-10 grid grid-cols-1 gap-2">
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
        </div>
    </section>

    <!-- script - start -->
    <script>
        /* 表示切替start */
        let reportCategory = document.getElementById('report_id');
        let reasonCategory = document.getElementById('reason_id');
        let reasonDetail = document.getElementById('reason_detail');
        let emptyReasonForm = document.getElementById('empty_reason_form');
        let startDateLabel = document.getElementById('start_date_label');
        let endDateForm = document.getElementById('end_date_form');
        let timeEmptyForm = document.getElementById('time_empty_form');
        let startTimeForm = document.getElementById('start_time_form');
        let endTimeForm = document.getElementById('end_time_form');
        let halfDateLabel = document.getElementById('half_date_label');
        let amPmForm = document.getElementById('am_pm_form');
        let amPm = document.getElementById('am_pm');
        let remarksContener = document.getElementById('remarks_contener');
        let reportRemarksContener = document.getElementById('report_remarks_contener');
        let reportRemarks = document.getElementById('report_remarks');
        let subReportRemarksContener = document.getElementById('sub_report_remarks_contener');
        let subReportRemarks = document.getElementById('sub_report_remarks');
        const reasons = @json($reasons);
        const reportCategories = @json($report_categories);
        const reportCategoryArray = Object.values(reportCategories); // オブジェクト変換
        const subReportCategories = @json($sub_report_categories);
        const subReportCategoryArray = Object.values(subReportCategories); // オブジェクト変換

        // リダイレクト時の表示切替
        window.addEventListener('load', function() {
            displayReset();
            radioChange();
            subReportDisplaySwitch(); // sub_reportでform表示切替
            reportReasonSwitch(); // reportでreason種類切替
            countDays();
        });

        // 届出内容変更時の表示切替
        function reportChange() {
            displayReset();
            timeReset(); // end_date,start_time,end_timeリセット
            daysReset(); // get_daysリセット
            alertReset(); // アラートリセット
            reportReasonSwitch(); // reportでreason種類切替
            radioChange();
            subReportDisplaySwitch();
            subReportRemarksSwitch();
            reoprtRemarksSwitch(); // 届出種類ごとの説明コメント切り替え
            let selectSubReportId = document.querySelector('input[name=sub_report_id]:checked').value;
            if (selectSubReportId == 1) {
                countDays();
            }
        }

        // 届出種類ごとの説明コメント切り替え関数
        function reoprtRemarksSwitch() {
            reportRemarksContener.style.display = "none";
            let selectReportId = reportCategory.value;
            reportCategoryArray.forEach(el => {
                if (el.id == selectReportId && el.remarks != null) {
                    remarksContener.style.display = ""; // remarksコンテナ表示
                    reportRemarksContener.style.display = ""; // 表示
                    reportRemarks.textContent = el.remarks; // コメント表示
                }
            })
        }

        // 取得形態ごとの説明コメント切り替え関数
        function subReportRemarksSwitch() {
            let selectSubReportId = document.querySelector('input[name=sub_report_id]:checked').value;
            subReportCategoryArray.forEach(el => {
                if (el.id == selectSubReportId && el.remarks != null) {
                    remarksContener.style.display = ""; // remarksコンテナ表示
                    subReportRemarksContener.style.display = ""; // 表示
                    subReportRemarks.textContent = el.remarks; // コメント表示
                }
            })
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
        function daysReset() {
            document.getElementById('acquisition_days').setAttribute('value', 0);
            document.getElementById('acquisition_hours').setAttribute('value', 0);
            document.getElementById('acquisition_minutes').setAttribute('value', 0);
            document.getElementById('remaining_days').setAttribute('value', 0);
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
            daysReset();
            subReportDisplaySwitch();
            timeReset();
            alertReset();
            let selectSubReportId = document.querySelector('input[name=sub_report_id]:checked').value;
            if (selectSubReportId == 1) {
                countDays();
            }

            subReportRemarksSwitch(); // 取得形態ごとの説明コメント切り替え
        }

        // 表示初期化関数
        function displayReset() {
            halfDateLabel.style.display = "none";
            amPmForm.style.display = "none";
            timeEmptyForm.style.display = "none";
            subReportRemarksContener.style.display = "none";
            startTimeForm.style.display = "none";
            endTimeForm.style.display = "none";
            startDateLabel.style.display = "";
            endDateForm.style.display = "";
            emptyReasonForm.style.display = "none";
        }

        function radioChange() {
            let selectedReportId = reportCategory.value; // 選択中のreportCategory
            const radioOptions = document.querySelectorAll('[name="sub_report_id"]'); // すべてのラジオボタン要素
            let findReport = reportCategoryArray.find((re) => re.id == selectedReportId);
            let oldSubReportCategory = document.querySelector('input[name=sub_report_id]:checked');
            let firstSubReportCategory = document.querySelector('input[name=sub_report_id][value="1"]');
            let secondSubReportCategory = document.querySelector('input[name=sub_report_id][value="2"]');
            let thirdSubReportCategory = document.querySelector('input[name=sub_report_id][value="3"]');
            let fourthSubReportCategory = document.querySelector('input[name=sub_report_id][value="4"]');
            let oldSubReportId = '';
            if (oldSubReportCategory) {
                oldSubReportId = oldSubReportCategory.value;
            }

            switch (findReport.acquisition_id) {
                case 1:
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value == 4) {
                            radio.style.display = 'none'; // 非表示
                            radioLabel.style.display = 'none'; // 非表示
                            // 非表示が選択されていた場合、チェックを解除
                            if (oldSubReportId == 4) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    if (secondSubReportCategory.checked == false && thirdSubReportCategory.checked == false) {
                        firstSubReportCategory.checked = true;
                    }
                    break;

                case 2:
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value == 2 || radio.value == 4) {
                            radio.style.display = 'none'; // 非表示
                            radioLabel.style.display = 'none'; // 非表示
                            // 非表示が選択されていた場合、チェックを解除
                            if (oldSubReportId == 2 || oldSubReportId == 4) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    if (thirdSubReportCategory.checked == false && fourthSubReportCategory.checked == false) {
                        firstSubReportCategory.checked = true;
                    }
                    break;

                case 3:
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value == 2 || radio.value == 4) {
                            radio.style.display = 'none';
                            radioLabel.style.display = 'none';
                            if (oldSubReportId == 2 || oldSubReportId == 4) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    if (secondSubReportCategory.checked == false) {
                        firstSubReportCategory.checked = true;
                    }
                    break;

                case 4:
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value == 3 || radio.value == 4) {
                            radio.style.display = 'none';
                            radioLabel.style.display = 'none';
                            if (oldSubReportId == 3 || oldSubReportId == 4) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    if (secondSubReportCategory.checked == false) {
                        firstSubReportCategory.checked = true;
                    }
                    break;

                case 5:
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value > 1) {
                            radio.style.display = 'none';
                            radioLabel.style.display = 'none';
                            if (oldSubReportId > 1) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    firstSubReportCategory.checked = true;
                    break;

                case 6: // 連休
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value != 2) {
                            radio.style.display = 'none';
                            radioLabel.style.display = 'none';
                            if (oldSubReportId != '' && oldSubReportId != 2) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    secondSubReportCategory.checked = true;
                    break;

                case 7: // 時間
                    radioOptions.forEach(function(radio) {
                        let radioLabel = document.querySelector('label[for="' + radio.id + '"]'); // ラジオボタンのラベル要素を取得
                        if (radio.value != 4) {
                            radio.style.display = 'none';
                            radioLabel.style.display = 'none';
                            if (oldSubReportId != '' && oldSubReportId != 4) {
                                oldSubReportCategory.checked = false;
                            }
                        } else {
                            radio.style.display = '';
                            radioLabel.style.display = '';
                        }
                    });
                    fourthSubReportCategory.checked = true;
                    break;

                default:
                    break;
            }
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
                    startDateLabel.style.display = "none";
                    endDateForm.style.display = "none";
                }
                if (subReportCategoryValue == 4) { // 時間休
                    halfDateLabel.style.display = "";
                    timeEmptyForm.style.display = "";
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
            const reportReasonsArray = Object.values(reportReasons);
            let selectReportId = reportCategory.value;

            reportReasonsArray.forEach((el) => {
                if (el.report_id == selectReportId) {
                    let createId = el.reason_id;
                    let createReason = el.reason_category.reason;
                    createOption(createId, createReason);
                }
            })

            // 選択項目を保持
            for (let i = 0; i < reasonCategory.childNodes.length; i++) {
                if (oldReasonId == reasonCategory.childNodes[i].value) {
                    reasonCategory.childNodes[i].selected = true;
                }

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
            daysReset();

            const startVal = new Date(startDate.value);
            const endVal = new Date(endDate.value);
            const startTimeVal = new Date(startDate.value + ' ' + startTime.value);
            const endTimeVal = new Date(startDate.value + ' ' + endTime.value);
            const amPmVal = amPm.value;
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
            let endY_M_D = endVal.getFullYear() +
                '-' + ('0' + (endVal.getMonth() + 1)).slice(-2) +
                '-' + ('0' + endVal.getDate()).slice(-2);
            let getDays = 0;
            let halfDays = 0;
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
            let workTime1 = '';
            let workHours1 = 0;
            let workMinutes1 = 0;
            let workTime2 = '';
            let workHours2 = 0;
            let workMinutes2 = 0;
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
                    workTime1 = shift.work_time1;
                    workTime2 = shift.work_time2;
                    if (Number.isInteger(workTime1)) {
                        workHours1 = workTime1;
                    } else {
                        workHours1 = Math.floor(workTime1);
                        workMinutes1 = 30;
                    }
                    if (Number.isInteger(workTime2)) {
                        workHours2 = workTime2;
                    } else {
                        workHours2 = Math.floor(workTime2);
                        workMinutes2 = 30;
                    }
                    workTimeStart = new Date(startDate.value + ' ' + shift.start_time);
                    workTimeEnd = new Date(startDate.value + ' ' + shift.end_time);
                    amPmSwitch = new Date(startDate.value + ' ' + shift.am_pm_switch);
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
                    if (shift.start_time > shift.am_pm_switch) {
                        amPmSwitch.setDate(amPmSwitch.getDate() + 1);
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

            // ここから計算式
            let acquisitionDays = 0;
            let acquisitionHours = 0;
            let acquisitionMinutes = 0;
            let validateMinutes = 0;
            let selectSubReportId = document.querySelector('input[name=sub_report_id]:checked').value;
            if (selectSubReportId == 1) { // 終日休
                if (holidayCheck() == true) {
                    acquisitionDays = 0;
                } else if (duplicationCheck() == true) {
                    acquisitionDays = 0;
                } else {
                    acquisitionDays = 1;
                }
            } else if (selectSubReportId == 2) { // 連休
                if (duplicationCheck() == true) {
                    acquisitionDays = 0;
                } else {
                    // この順番を変えてはいけない
                    acquisitionDays = diffDays - dayOffs;
                    holidayCheck();
                }
            } else if (selectSubReportId == 3) { // 半日休
                if (holidayCheck() == true) {
                    acquisitionDays = 0;
                } else if (duplicationCheck() == true) {
                    acquisitionDays = 0;
                } else {
                    acquisitionDays = 0;
                    if (amPmVal == 1) {
                        acquisitionHours = workHours1;
                        acquisitionMinutes = workMinutes1;
                    } else if (amPmVal == 2) {
                        acquisitionHours = workHours2;
                        acquisitionMinutes = workMinutes2;
                    }
                }
            } else if (
                // WORNING:時間休にを有効にする場合、シフトによって1時間の重みが違うので注意
                // 4時間労働の2時間休み=8時間労働の4時間休み
                selectSubReportId == 4) { // 時間休

                if (holidayCheck() == true) {
                    acquisitionDays = 0;
                } else if (duplicationCheck() == true) {
                    acquisitionDays = 0;
                } else if (workingTimeCheck() == true && selectSubReportId == 4) {
                    acquisitionDays = 0;
                } else if (timeCheck() == true) { // 申請時間を確認
                    acquisitionDays = 0;
                } else {
                    let restTime = 0;
                    // ランチタイムを挟む場合
                    if (startTimeVal < lunchTimeStart && endTimeVal >= lunchTimeStart && endTimeVal < lunchTimeEnd) {
                        restTime += endTimeVal - lunchTimeStart;
                    }
                    if (startTimeVal < lunchTimeStart && endTimeVal >= lunchTimeEnd) {
                        restTime += lunchTimeEnd - lunchTimeStart;
                    }
                    if (startTimeVal >= lunchTimeStart && startTimeVal < lunchTimeEnd && endTimeVal > lunchTimeEnd) {
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
                    validateMinutes = (endTimeVal - startTimeVal - restTime) / 60000;

                    if (validateMinutes < 60) {
                        acquisitionMinutes = validateMinutes;
                    } else {
                        acquisitionMinutes = validateMinutes % 60;
                        acquisitionHours = (validateMinutes - acquisitionMinutes) / 60;
                    }
                }
            }

            // get_days書き出し
            document.getElementById('acquisition_days').setAttribute('value', acquisitionDays);
            document.getElementById('acquisition_hours').setAttribute('value', acquisitionHours);
            document.getElementById('acquisition_minutes').setAttribute('value', acquisitionMinutes);

            const myAcquisitionDays = @json($my_acquisition_days);
            const myAcquisitionDaysArray = Object.values(myAcquisitionDays);
            let selectReportId = reportCategory.value;
            let remainingDays = 0;
            let remainingHours = 0;
            let remainingMinutes = 0;
            myAcquisitionDaysArray.forEach(el => {
                if (el.report_id == selectReportId) {
                    if (el.remaining_days != null) {
                        // 申請中の日数を考慮した残日数を算出
                        remainingDays = el.expectation_remaining_days - acquisitionDays;
                        remainingHours = el.expectation_remaining_hours - acquisitionHours;
                        remainingMinutes = el.expectation_remaining_minutes - acquisitionMinutes;
                        // シフトによって半日の時間が異なるため、半日休は0.5日で管理
                        if (selectSubReportId == 3) {
                            remainingDays = el.expectation_remaining_days - 0.5;
                            remainingHours = el.expectation_remaining_hours;
                            remainingMinutes = el.expectation_remaining_minutes;
                        } else {
                            if (remainingMinutes < 0) {
                                remainingMinutes += 60;
                                remainingHours -= 1;
                            }
                            if (remainingHours < 0) {
                                remainingHours += (workHours1 + workHours2);
                                remainingMinutes += (workMinutes1 + workMinutes2);
                                remainingDays -= 1;
                            }
                        }
                    } else {
                        remainderDays = 0;
                        remainingHours = 0;
                        remainingMinutes = 0;
                    }
                }
            })

            // 残日数書き出し
            document.getElementById('remaining_days').setAttribute('value', remainingDays);
            document.getElementById('remaining_hours').setAttribute('value', remainingHours);
            document.getElementById('remaining_minutes').setAttribute('value', remainingMinutes);

            /* --functions-- */
            // 休日確認関数
            function holidayCheck() {
                console.log('holidayCheck'); // 起動確認
                let holiday = false;
                // これは必要:土曜営業日はfalse
                if (saturdays.includes(startYMD)) {
                    holiday = false;
                } else if (holidays.includes(startYMD)) {
                    holiday = true;
                } else if (startWeek == 0 || startWeek == 6 || startWeek == 7) {
                    holiday = true;
                } else if (endDate.value) {
                    for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                        const Y_M_D = d.getFullYear() +
                            ('0' + (d.getMonth() + 1)).slice(-2) +
                            ('0' + d.getDate()).slice(-2);
                        if (holidays.includes(Y_M_D) && getDays == 0) {
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
                const myReportsArray = Object.values(myReports);
                let duplication = false;
                myReportsArray.forEach(el => {
                    let elStartTime = '';
                    let elEndTime = '';
                    let selectStartTime = '';
                    let selectEndTime = '';

                    // 届出済み・終日休
                    if (el.sub_report_id == 1) {
                        // 同日NG
                        if (el.start_date == startY_M_D) {
                            duplication = true;
                        }
                    }

                    // 届出済み・連休
                    if (el.sub_report_id == 2) {
                        for (let d = new Date(el.start_date); d <= new Date(el.end_date); d.setDate(d.getDate() +
                                1)) {
                            const Y_M_D = d.getFullYear() +
                                '-' + ('0' + (d.getMonth() + 1)).slice(-2) +
                                '-' + ('0' + d.getDate()).slice(-2);
                            // = el.start_date
                            // = el.end_date
                            // - 連休 Y_M_D
                            // * startY_M_D
                            // * endY_M_D
                            // =-----=
                            //   *
                            //   *~~*
                            //   *~~~~~*
                            if (startY_M_D == Y_M_D) {
                                duplication = true;
                            }
                            //   =-----=
                            //      *
                            // *~~*
                            // *~~~~~*
                            if (endY_M_D == Y_M_D) {
                                duplication = true;
                            }
                            //   =-----=
                            // *~~~~~~~~~*
                            if (startY_M_D <= Y_M_D && endY_M_D >= Y_M_D) {
                                duplication = true;
                            }
                        }
                    }

                    // 届出済み・半日休
                    if (el.sub_report_id == 3) {
                        if (selectSubReportId == 1 && el.start_date == startY_M_D) {
                            duplication = true;
                        }
                        if (selectSubReportId == 2) {
                            for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                                const Y_M_D = d.getFullYear() +
                                    '-' + ('0' + (d.getMonth() + 1)).slice(-2) +
                                    '-' + ('0' + d.getDate()).slice(-2);
                                // = 連休予定開始
                                // = 連休予定終了
                                // - 連休 Y_M_D
                                // * el.start_date
                                // =-----=
                                //   *
                                if (el.start_date == Y_M_D) {
                                    duplication = true;
                                }
                            }
                        }

                        // 届出済みの半日の開始時刻、終了時刻
                        if (el.am_pm == 1) {
                            elStartTime = new Date(el.start_date + ' ' + el.shift_category.start_time);
                            elEndTime = new Date(el.start_date + ' ' + el.shift_category.am_pm_switch);
                            // 後半の開始時刻との一致を防ぐために5分前の時刻とする
                            elEndTime.setTime(elEndTime.getTime() - 5 * 60 * 1000);
                            if (elStartTime > elEndTime) {
                                elEndTime.setDate(elEndTime.getDate() + 1);
                            }
                        }
                        if (el.am_pm == 2) {
                            elStartTime = new Date(el.start_date + ' ' + el.shift_category.am_pm_switch);
                            elEndTime = new Date(el.start_date + ' ' + el.shift_category.end_time);
                            if (elStartTime > elEndTime) {
                                elEndTime.setDate(elEndTime.getDate() + 1);
                            }
                        }


                        if (selectSubReportId == 3 && el.start_date == startY_M_D) {
                            // 取得予定の半日の開始時刻、終了時刻
                            if (amPmVal == 1) {
                                selectStartTime = workTimeStart;
                                selectEndTime = amPmSwitch;
                            }
                            if (amPmVal == 2) {
                                selectStartTime = amPmSwitch;
                                selectEndTime = workTimeEnd;
                            }
                            // // 時間確認
                            // console.log(elStartTime);
                            // console.log(elEndTime);
                            // console.log(selectStartTime);
                            // console.log(selectEndTime);
                            for (let t = new Date(selectStartTime); t < selectEndTime; t
                                .setTime(t
                                    .getTime() + 5 * 60 * 1000)) {
                                // = 開始時間
                                // = 終了時間
                                // - 5分刻み時間 t
                                // * elStartTime
                                // * elEndTime
                                // =-----=
                                //   *~~*
                                //   *~~~~~*
                                if (elStartTime == t) {
                                    duplication = true;
                                }
                                //   =-----=
                                // *~~*
                                // *~~~~~*
                                if (elEndTime == t) {
                                    duplication = true;
                                }
                                //   =-----=
                                // *~~~~~~~~~*
                                if (elStartTime <= t && elEndTime >= t) {
                                    duplication = true;
                                }
                            }
                            // // これはシフトが違うときはNG
                            // // シフトが無いときは使用可能
                            // if (el.am_pm == amPmVal) {
                            //     duplication = true;
                            // }
                        }
                        if (selectSubReportId == 4 && el.start_date == startY_M_D) {
                            selectStartTime = startTimeVal;
                            selectEndTime = endTimeVal;
                            for (let t = new Date(selectStartTime); t < selectEndTime; t
                                .setTime(t
                                    .getTime() + 5 * 60 * 1000)) {
                                // = 開始時間
                                // = 終了時間
                                // - 5分刻み時間 t
                                // * elStartTime
                                // * elEndTime
                                // =-----=
                                //   *~~*
                                //   *~~~~~*
                                if (elStartTime == t) {
                                    duplication = true;
                                }
                                //   =-----=
                                // *~~*
                                // *~~~~~*
                                if (elEndTime == t) {
                                    duplication = true;
                                }
                                //   =-----=
                                // *~~~~~~~~~*
                                if (elStartTime <= t && elEndTime >= t) {
                                    duplication = true;
                                }
                            }
                        }
                    }

                    // 届出済み・時間休
                    if (el.sub_report_id == 4) {
                        if (selectSubReportId == 1 && el.start_date == startY_M_D) {
                            duplication = true;
                        }
                        if (selectSubReportId == 2) {
                            for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                                const Y_M_D = d.getFullYear() +
                                    '-' + ('0' + (d.getMonth() + 1)).slice(-2) +
                                    '-' + ('0' + d.getDate()).slice(-2);
                                if (el.start_date == Y_M_D) {
                                    duplication = true;
                                }
                            }
                        }

                        elStartTime = new Date(el.start_date + ' ' + el.start_time);
                        elEndTime = new Date(el.start_date + ' ' + el.end_time);
                        // console.log(elStartTime);
                        // console.log(elEndTime);

                        if (selectSubReportId == 3 && el.start_date == startY_M_D) {
                            // 取得予定の半日の開始時刻、終了時刻
                            if (amPmVal == 1) {
                                selectStartTime = workTimeStart;
                                selectEndTime = amPmSwitch;
                            }
                            if (amPmVal == 2) {
                                selectStartTime = amPmSwitch;
                                selectEndTime = workTimeEnd;
                            }

                            for (let t = new Date(selectStartTime); t < selectEndTime; t
                                .setTime(t
                                    .getTime() + 5 * 60 * 1000)) {
                                if (elStartTime == t) {
                                    duplication = true;
                                }
                                if (elEndTime == t) {
                                    duplication = true;
                                }
                                if (elStartTime <= t && elEndTime >= t) {
                                    duplication = true;
                                }
                            }
                            // // これはシフトが違うときはNG
                            // // シフトが無いときは使用可能
                            // if (el.am_pm == amPmVal) {
                            //     duplication = true;
                            // }
                        }

                        if (selectSubReportId == 4 && el.start_date == startY_M_D) {
                            selectStartTime = startTimeVal;
                            selectEndTime = endTimeVal;
                            for (let t = new Date(selectStartTime); t < selectEndTime; t
                                .setTime(t
                                    .getTime() + 5 * 60 * 1000)) {
                                if (elStartTime == t) {
                                    duplication = true;
                                }
                                if (elEndTime == t) {
                                    duplication = true;
                                }
                                if (elStartTime <= t && elEndTime >= t) {
                                    duplication = true;
                                }
                            }
                        }
                    }
                })

                if (duplication == true) {
                    duplicationAlert.style.display = '';
                    return true;
                } else {
                    for (let d = new Date(startDate.value); d <= endVal; d.setDate(d.getDate() + 1)) {
                        const Y_M_D = d.getFullYear() +
                            '-' + ('0' + (d.getMonth() + 1)).slice(-2) +
                            '-' + ('0' + d.getDate()).slice(-2);
                        myReportsArray.forEach(report => {
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
