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
                            届け出内容
                        </label>
                        <select name="report_id" id="report_id" onchange="reportChange();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @foreach ($report_categories as $report_category)
                                <option value="{{ old('report_id', $report_category->id) }}">
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
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
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
                            届け出日
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
                    <div style="display: " id="start_date_form">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">
                            何日から
                        </label>
                        <input type="date" id="start_date" name="start_date"
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
                    <div style="display: none" id="half_date_form">
                        <label for="half_day" class="block mb-2 text-sm font-medium text-gray-900">
                            日付
                        </label>
                        <input type="date" id="half_date" name="half_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('half_date') }}">
                    </div>
                    <div style="display: none" id="am_pm_form">
                        <label for="am_pm" class="block mb-2 text-sm font-medium text-gray-900">
                            午前・午後
                        </label>
                        <select name="am_pm" id="am_pm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="0">午前</option>
                            <option value="1">午後</option>
                        </select>
                    </div>
                    <!-- 半日有給 - end -->

                    <!-- 時間休 - start -->
                    <div style="display: none" id="time_empty_form">
                    </div>
                    <div style="display: none" id="start_time_form">
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時から
                        </label>
                        <input type="time" id="start_time" name="start_time" step="300"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('start_time') }}">
                    </div>
                    <div style="display: none" id="end_time_form">
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">
                            何時まで
                        </label>
                        <input type="time" id="end_time" name="end_time" step="300"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('end_time') }}">
                    </div>
                    <div style="display: none" id="time_form">
                        <p class="block mb-2 text-sm font-semibold">
                            <div class="flex h-8 leading-8 items-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 mr-2">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" fill="#9999ff"/>
                                </svg>
                                <div class="items-center text-center">
                                    時間休は1時間単位で取得できます
                                </div>
                            </div>
                        </p>
                    </div>
                    <!-- 時間休 - end -->
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="get_days" class="block mb-2 text-sm font-medium text-gray-900">
                            取得日数
                        </label>
                        <input type="number" id="get_days" name="get_days"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_days') }}" readonly required>
                    </div>
                    <div>
                        <label for="remaining_days" class="block mb-2 text-sm font-medium text-gray-900">
                            残日数
                        </label>
                        <input type="number" id="remaining_days" name="remaining"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('remaining_days') }}" readonly required>
                    </div>
                    <button type="button" id="button"
                        class="sm:w-auto mt-6 flex items-center text-indigo-400 hover:-translate-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 mr-1">
                            <path
                                d="M9.195 18.44c1.25.713 2.805-.19 2.805-1.629v-2.34l6.945 3.968c1.25.714 2.805-.188 2.805-1.628V8.688c0-1.44-1.555-2.342-2.805-1.628L12 11.03v-2.34c0-1.44-1.555-2.343-2.805-1.629l-7.108 4.062c-1.26.72-1.26 2.536 0 3.256l7.108 4.061z" />
                        </svg>
                        <div class="pt-1">
                            日数算出
                        </div>
                    </button>
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
        let startDateForm = document.getElementById('start_date_form');
        let endDateForm = document.getElementById('end_date_form');
        let timeEmptyForm = document.getElementById('time_empty_form');
        let timeForm = document.getElementById('time_form');
        let startTimeForm = document.getElementById('start_time_form');
        let endTimeForm = document.getElementById('end_time_form');
        let halfDateForm = document.getElementById('half_date_form');
        let amPmForm = document.getElementById('am_pm_form');



        function reportChange() {
            if (reportCategory.value == "1") {
                halfDateForm.style.display = "none";
                amPmForm.style.display = "none";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateForm.style.display = "";
                endDateForm.style.display = "";
            }
            if (reportCategory.value == "2") {
                halfDateForm.style.display = "";
                amPmForm.style.display = "";
                timeEmptyForm.style.display = "none";
                timeForm.style.display = "none";
                startTimeForm.style.display = "none";
                endTimeForm.style.display = "none";
                startDateForm.style.display = "none";
                endDateForm.style.display = "none";
            }
            if (reportCategory.value == "3") {
                halfDateForm.style.display = "";
                timeEmptyForm.style.display = "";
                timeForm.style.display = "";
                startTimeForm.style.display = "";
                endTimeForm.style.display = "";
                startDateForm.style.display = "none";
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
        let halfDate = document.getElementById('half_date');

        button.addEventListener("click", function() {
            // console.log(startTime.value);

            // 取得日数
            let startVal = new Date(startDate.value);
            let endVal = new Date(endDate.value);
            let startTimeVal = new Date(halfDate.value + ' ' + startTime.value);
            let endTimeVal = new Date(halfDate.value + ' ' + endTime.value);
            let halfVal = new Date(halfDate.value);
            var reportId = reportCategory.value;
            let diffDays = (endVal - startVal) / 86400000 + 1; // 単純な差
            let getDays = 0;
            let dayOffs = 0;

            console.log(((endTimeVal - startTimeVal) / 60000) / 60 * 0.125); // 分
            // 時間休:1時間単位 8時間で1日 1時間=1/8日 0.125

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
            if (reportCategory.value == 3) {
                getDays = ((endTimeVal - startTimeVal) / 60000) / 60 * 0.125;
                // 時間休:1時間単位 8時間で1日 1時間=1/8日 0.125
            }

            // console.log(dayOffs);
            // console.log(getDays);

            // get_days書き出し
            document.getElementById('get_days').setAttribute('value', getDays);

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
