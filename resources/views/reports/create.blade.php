<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">出退勤届け作成</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    すべての項目を入力してください。
                </p>
            </div>

            <x-errors :errors="$errors" />

            <form action="{{ route('reports.store') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="report_id" class="block mb-2 text-sm font-medium text-gray-900">
                            届出内容
                        </label>
                        <select name="report_id" id="report_id" onchange="reportChange();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @foreach ($report_categories as $report_category)
                                <option value="{{ $report_category->id }}"
                                    @if ($report_category->id === (int) old('report_id')) selected @endif>
                                    {{ $report_category->report_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="reason_id" class="block mb-2 text-sm font-medium text-gray-900">
                            理由
                        </label>
                        <select name="reason_id" id="reason_id" onchange="reasonChange();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}" @if ($reason->id === (int) old('reason_id')) selected @endif>
                                    {{ $reason->reason }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: none" class="col-span-2" id="reason_detail">
                        <label for="reason_detail" class="block mb-2 text-sm font-medium text-gray-900">
                            理由を記入してください
                        </label>
                        <input type="text" id="" name="reason_detail"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('reason_detail') }}">
                    </div>
                    <div>
                        <label for="report_date" class="block mb-2 text-sm font-medium text-gray-900">
                            届出日
                        </label>
                        <input type="date" id="report_date" name="report_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('report_date') }}" required>
                    </div>
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">
                            氏名
                        </label>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="text" id="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <!-- 有給休暇 - start -->
                    <div>
                        <label style="display: " id="start_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            何日から
                        </label>
                        <label style="display: none" id="half_date_label" for="start_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            日付
                        </label>
                        <input style="display: " type="date" id="start_date" name="start_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('start_date') }}">
                    </div>
                    <div style="display: " id="end_date_form">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900">
                            何日まで
                        </label>
                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('end_date') }}">
                    </div>
                    <!-- 有給休暇 - end -->

                    <!-- 半日有給 - start -->
                    <div style="display: none" id="am_pm_form">
                        <label for="am_pm" class="block mb-2 text-sm font-medium text-gray-900">
                            午前・午後
                        </label>
                        <select name="am_pm" id="am_pm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="0" @if (0 === (int) old('am_pm')) selected @endif>午前</option>
                            <option value="1" @if (1 === (int) old('am_pm')) selected @endif>午後</option>
                        </select>
                    </div>
                    <!-- 半日有給 - end -->

                    <!-- 時間休 - start -->
                    <div style="display: none" id="time_empty_form">
                    </div>
                    <div style="display: none" id="start_time_form">
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時から<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <input type="time" id="start_time" name="start_time" step="300"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('start_time') }}">
                    </div>
                    <div style="display: none" id="end_time_form">
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時まで<span class="text-xs text-gray-600">&emsp;5分刻み</span>
                        </label>
                        <input type="time" id="end_time" name="end_time" step="300"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('end_time') }}">
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
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="get_days" class="block mb-2 text-sm font-medium text-gray-900">
                            取得日数
                        </label>
                        <input type="hidden" id="get_days" name="get_days"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_days') }}" readonly required>
                        <div class="flex items-center mb-1">
                            <input type="number" id="get_days_only" name="get_days_only"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_days_only') }}" readonly>
                            <p class="ml-2">日</p>
                        </div>
                        <div class="flex items-center mb-1">
                            <input type="number" id="get_hours" name="get_hours"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_hours') }}" readonly>
                            <p class="ml-2">時間</p>
                        </div>
                        <div class="flex items-center">
                            <input type="number" id="get_minites" name="get_minites"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5"
                                value="{{ old('get_minites') }}" readonly>
                            <p class="ml-2">分</p>
                        </div>
                    </div>
                    <div>
                        <label for="remaining_days" class="block mb-2 text-sm font-medium text-gray-900">
                            残日数
                        </label>
                        <input type="number" id="remaining_days" name="remaining"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('remaining') }}" readonly required>
                    </div>
                    <div class="flex items-center text-center">
                    <button type="button" id="button"
                        class="w-32 h-10 mx-auto flex justify-center items-center rounded-3xl text-center text-indigo-500 bg-indigo-100/60 hover:text-white hover:bg-indigo-500">
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
                    </div>
                </div>
                <div class="flex flex-row-reverse">
                    <button type="submit"
                        class="text-white bg-pink-300 hover:bg-indigo-400 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        届 出
                    </button>
                </div>
            </form>

        </div>
    </section>

    <!-- script - start -->
    <script>
        var reportCategory = document.getElementById('report_id');
        let reasonCategory = document.getElementById('reason_id');
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

        // リダイレクト時
        if (reportCategory.value == "1" ||
            reportCategory.value == "5" ||
            reportCategory.value == "6" ||
            reportCategory.value == "7" ||
            reportCategory.value == "8" ||
            reportCategory.value == "9" ||
            reportCategory.value == "10" ||
            reportCategory.value == "15" ||
            reportCategory.value == "16" ||
            reportCategory.value == "17") {
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
        if (reportCategory.value == "2") {
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
        if (reportCategory.value == "3") {
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
        if (reportCategory.value == "12" ||
            reportCategory.value == "13") {
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
        if (reportCategory.value == "14") {
            halfDateLabel.style.display = "";
            startDateForm.style.display = "";
            amPmForm.style.display = "none";
            timeEmptyForm.style.display = "";
            timeForm.style.display = "none";
            timeForm30.style.display = "";
            timeForm10.style.display = "";
            startTimeForm.style.display = "";
            endTimeForm.style.display = "";
            startDateLabel.style.display = "none";
            endDateForm.style.display = "none";
        }
        if (reportCategory.value == "4" || reportCategory.value == "11") {
            halfDateLabel.style.display = "";
            startDateForm.style.display = "";
            timeEmptyForm.style.display = "";
            timeForm.style.display = "none";
            timeForm30.style.display = "none";
            timeForm10.style.display = "none";
            startTimeForm.style.display = "none";
            endTimeForm.style.display = "none";
            startDateLabel.style.display = "none";
            endDateForm.style.display = "none";
        }

        if (reasonCategory.value == "7") {
            reasonDetail.style.display = "";
        }
        if (reasonCategory.value != "7") {
            reasonDetail.style.display = "none";
        }

        function reportChange() {
            if (reportCategory.value == "1" ||
                reportCategory.value == "5" ||
                reportCategory.value == "6" ||
                reportCategory.value == "7" ||
                reportCategory.value == "8" ||
                reportCategory.value == "9" ||
                reportCategory.value == "10" ||
                reportCategory.value == "15" ||
                reportCategory.value == "16" ||
                reportCategory.value == "17") {
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
            if (reportCategory.value == "2") {
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
            if (reportCategory.value == "3") {
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
            if (reportCategory.value == "12" ||
                reportCategory.value == "13") {
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
            if (reportCategory.value == "14") {
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "none";
                timeForm30.style.display = "";
                timeForm10.style.display = "";
                startTimeForm.style.display = "";
                endTimeForm.style.display = "";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
            if (reportCategory.value == "4" || reportCategory.value == "11") {
                halfDateLabel.style.display = "";
                startDateForm.style.display = "";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "none";
                timeForm30.style.display = "none";
                timeForm10.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateLabel.style.display = "none";
                endDateForm.style.display = "none";
            }
        }

        function reasonChange() {
            if (reasonCategory.value == "7") {
                reasonDetail.style.display = "";
            }
            if (reasonCategory.value != "7") {
                reasonDetail.style.display = "none";
            }
        }

        let button = document.getElementById('button');
        let startDate = document.getElementById('start_date');
        let endDate = document.getElementById('end_date');
        let startTime = document.getElementById('start_time');
        let endTime = document.getElementById('end_time');
        // let halfDate = document.getElementById('half_date');

        button.addEventListener("click", function() {
            // console.log(startTime.value);

            // 取得日数
            let startVal = new Date(startDate.value);
            let endVal = new Date(endDate.value);
            let startTimeVal = new Date(startDate.value + ' ' + startTime.value);
            let endTimeVal = new Date(startDate.value + ' ' + endTime.value);
            // let halfVal = new Date(halfDate.value);
            var reportId = reportCategory.value;
            let diffDays = (endVal - startVal) / 86400000 + 1; // 単純な差
            let getDays = 0;
            let dayOffs = 0;

            //開始日付の曜日数値の取得
            var remainderDays = diffDays % 7
            dayOffs = (diffDays - remainderDays) / 7 * 2;
            var startWeek = startVal.getDay(); //0~6の曜日数値
            for (var i = 0; i < remainderDays; i++) {
                if (startWeek + i == 0 || startWeek + i == 6) {
                    dayOffs++; // 土日は休日数に加算
                }
            }


            if (reportCategory.value == 1) {
                getDays = diffDays - dayOffs;
            }
            if (reportCategory.value == 2) {
                getDays = 0.5;
            }
            if (reportCategory.value == 3 ||
                reportCategory.value == 12 ||
                reportCategory.value == 13 ||
                reportCategory.value == 14) {
                getDays = ((endTimeVal - startTimeVal) / 60000) / 60 * 1 / 8;
                // 時間換算:8時間で1日 1時間=1/8日 0.125日
                getDays = orgRound(getDays, 100000); // 小数点以下5桁に丸める
                console.log(getDays);
            }
            if (reportCategory.value == 4) {
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

            console.log(orgRound(getDays, 100000)); // 小数5桁
            let getDaysOnly = getDays - decimalPart(getDays, 4);
            let getHours = decimalPart(getDays, 5) * 8;
            let getMinites = 0;
            if (decimalPart(getHours, 5) != 0 && decimalPart(getHours, 4) < 1) {
                getMinites = getHours * 60;
                getMinites = orgRound(getMinites, 1);
                getDaysOnly = 0;
                getHours = 0;
            }
            document.getElementById('get_days_only').setAttribute('value', getDaysOnly);
            document.getElementById('get_hours').setAttribute('value', getHours);
            document.getElementById('get_minites').setAttribute('value', getMinites);


            if (reportId == 2 || reportId == 3) {
                reportId = 1; // 半日有給、時間給は有給休暇のreport_id
            }

            let ownRemainings = @json($own_remainings);
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
        });
    </script>
</x-app-layout>
