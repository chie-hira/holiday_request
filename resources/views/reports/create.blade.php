<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">出退勤届け作成</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    すべての項目を入力してください。
                </p>
            </div>

            {{-- <x-errors :errors="$errors" /> --}}

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
                                <option value="{{ $report_category->id }}">{{ $report_category->report_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="reason_id" class="block mb-2 text-sm font-medium text-gray-900">
                            理由
                        </label>
                        <select name="reason_id" id=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="hidden col-span-2">
                        <label for="report_date" class="block mb-2 text-sm font-medium text-gray-900">
                            理由を記入してください
                        </label>
                        <input type="text" id="" name="reason_detail"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('reason_detail') }}" required>
                    </div>
                    <div>
                        <label for="report_date" class="block mb-2 text-sm font-medium text-gray-900">
                            申請日
                        </label>
                        <input type="date" id="report_date" name="apply_date"
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
                        <label for="get_day" class="block mb-2 text-sm font-medium text-gray-900">
                            取得日数
                        </label>
                        <input type="number" id="get_day"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('get_day') }}" readonly required>
                    </div>
                    <div>
                        <label for="remaining_day" class="block mb-2 text-sm font-medium text-gray-900">
                            残日数
                        </label>
                        <input type="number" id="remaining_day" name="remaining_day"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('remaining_day') }}" readonly required>
                    </div>
                    <button type="button" id="button"
                        class="sm:w-auto py-2.5 text-center flex items-center text-indigo-600 hover:translate-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M13.28 3.97a.75.75 0 010 1.06L6.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5a.75.75 0 010-1.06l7.5-7.5a.75.75 0 011.06 0zm6 0a.75.75 0 010 1.06L12.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5a.75.75 0 010-1.06l7.5-7.5a.75.75 0 011.06 0z"
                                clip-rule="evenodd" />
                        </svg>
                        日数算出
                    </button>
                </div>
                <div class="flex flex-row-reverse">
                    <button type="submit"
                        class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        届 出
                    </button>
                </div>
            </form>

        </div>
    </section>

    <!-- script - start -->
    <script>
        // var maxDay = @json($report_category).max_days;
        var reportCategories = @json($report_categories);
        var maxDay = document.getElementById('report_id');

        let button = document.getElementById('button');
        let startDate = document.getElementById('start_date');
        let endDate = document.getElementById('end_date');

        // button.click = function () {
        //     console.log(hello);
        // }
        // console.log(reportCategories);


        button.addEventListener("click", function() {

            // 取得日数
            var startDay = new Date(startDate.value);
            var endDay = new Date(endDate.value);
            var getDay = (endDay - startDay) / 86400000;
            var reportId = maxDay.value;
            document.getElementById('get_day').setAttribute('value', getDay);
            reportCategories.forEach((el) => {
                if (el.id == reportId) {
                    console.log(el.max_days);
                }
            });

            // 残日数
            // var remainingDay = maxDay - getDay;
            // console.log(remainingDay);
            // document.getElementById('remaining_day').setAttribute('value', remainingDay);
            // console.log(myApp);
            // if (myApp == null) {
            var remainingDay = maxDay - getDay;
            // } else {
            //     var lastDay = myApp.remaining_day
            //     var remainingDay = lastDay - getDay;
            // }
            document.getElementById('remaining_day').setAttribute('value', remainingDay);
        });
    </script>
</x-app-layout>
