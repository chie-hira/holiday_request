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
                            申請内容
                        </label>
                        <select name="report_id" id="report_id"
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
                        <select name="reason_id" id="reason_id" onchange="change();"
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
                            申請者名
                        </label>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="text" id="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">
                            始期
                        </label>
                        <input type="date" id="start_date" name="start_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('start_date') }}" required>
                    </div>
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900">
                            終期
                        </label>
                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('end_date') }}" required>
                    </div>
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label for="get_days" class="block mb-2 text-sm font-medium text-gray-900">
                            取得日数
                        </label>
                        <input type="number" id="get_days"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_days') }}" readonly required>
                    </div>
                    <div>
                        <label for="remaining_days" class="block mb-2 text-sm font-medium text-gray-900">
                            残日数
                        </label>
                        <input type="number" id="remaining_days" name="remaining_days"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('remaining_days') }}" readonly required>
                    </div>
                    <button type="button" id="button"
                        class="sm:w-auto mt-6 flex items-center text-indigo-400 hover:-translate-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-1">
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
        let reportCategory = document.getElementById('report_id');
        let reasonCategory = document.getElementById('reason_id');
        let reasonDetail = document.getElementById('reason_detail');

        let button = document.getElementById('button');
        let start = document.getElementById('start_date');
        let end = document.getElementById('end_date');


        function change() {
            // reportValue = reportCategory.value;
            // console.log(reportValue);
            if (reasonCategory.value == "7") {
                reasonDetail.style.display = "";
            }
        }


        button.addEventListener("click", function() {
            let ownLimits = @json($own_limits);
            const arr = Object.keys(ownLimits);

            // 取得日数
            let startDate = new Date(start.value);
            let endDate = new Date(end.value);
            let diffDays = (endDate - startDate) / 86400000 + 1; // 単純な差
            let limitDays = 0;
            let reportId = reportCategory.value;
            let getDays = 0; // diffDaysから土日を引く
            let dayOffs = 0;

            //余りの日がある場合、開始日付から余りの日数だけ曜日が定休日かの判定を行う
            //開始日付の曜日数値の取得
            var remainderDays = diffDays % 7
            dayOffs = (diffDays - remainderDays) / 7 * 2;
            var startDay = startDate.getDay(); //0~6の曜日数値
            for (var i = 0; i < remainderDays; i++) {
                //曜日数値に余りの日数を加算していき、7で割った余りの曜日数値が定休日の配列に含まれるか
                if (startDay + i == 0 || startDay + i == 6) {
                    //定休日の配列に含まれる場合、休日数に加算する
                    dayOffs++;
                }
            }

            getDays = diffDays - dayOffs;
            console.log(dayOffs);

            // console.log(getDays);

            document.getElementById('get_days').setAttribute('value', getDays);
            // console.log(arr);
            arr.forEach((el) => {
                if (ownLimits[el].report_id == reportId) {
                    limitDays = ownLimits[el].limit_days;
                }
            });

            // 残日数
            // var remainingDay = maxDay - getDay;
            // console.log(remainingDay);
            // document.getElementById('remaining_day').setAttribute('value', remainingDay);
            // console.log(myApp);
            // if (myApp == null) {
            let remainingDays = limitDays - getDays;
            document.getElementById('remaining_days').setAttribute('value', remainingDays);
        });
    </script>
</x-app-layout>
