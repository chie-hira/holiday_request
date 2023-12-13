<x-app-layout>
    <!-- Page nav -->
    <div class="border-b-2 border-gray-200">
        <nav class="px-4 -mb-0.5 flex space-x-2 overflow-x-auto">
            <x-nav-button onclick="reportChange1()">
                {{ $report_categories->where('id', 1)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange2()">
                {{ $report_categories->where('id', 2)->first()->report_name }}
            </x-nav-button>
            {{-- <x-nav-button onclick="reportChange3()">
                {{ $report_categories->where('id', 3)->first()->report_name }}
            </x-nav-button> --}}
            <x-nav-button onclick="reportChange4()">
                {{ $report_categories->where('id', 4)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange5()">
                {{ $report_categories->where('id', 5)->first()->report_name }}
            </x-nav-button>
            {{-- <x-nav-button onclick="reportChange6()">
                {{ $report_categories->where('id', 6)->first()->report_name }}
            </x-nav-button> --}}
            <x-nav-button onclick="reportChange7()">
                {{ $report_categories->where('id', 7)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange8()">
                {{ $report_categories->where('id', 8)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange9()">
                {{ $report_categories->where('id', 9)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange10()">
                {{ $report_categories->where('id', 10)->first()->report_name }}
            </x-nav-button>
            {{-- <x-nav-button onclick="reportChange11()">
                {{ $report_categories->where('id', 11)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange16()">
                {{ $report_categories->where('id', 16)->first()->report_name }}
            </x-nav-button> --}}
        </nav>
    </div>
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center ZenMaruGothic w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-800">{{ __('Rest Days') }}一覧</h1>
                <p id="report_name-1" style="display: " class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 1)->first()->report_name }}
                </p>
                <p id="report_name-2" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 2)->first()->report_name }}
                </p>
                {{-- <p id="report_name-3" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 3)->first()->report_name }}
                </p> --}}
                <p id="report_name-4" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 4)->first()->report_name }}
                </p>
                <p id="report_name-5" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 5)->first()->report_name }}
                </p>
                {{-- <p id="report_name-6" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 6)->first()->report_name }}
                </p> --}}
                <p id="report_name-7" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 7)->first()->report_name }}
                </p>
                <p id="report_name-8" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 8)->first()->report_name }}
                </p>
                <p id="report_name-9" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 9)->first()->report_name }}
                </p>
                <p id="report_name-10" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 10)->first()->report_name }}
                </p>
                {{-- <p id="report_name-11" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 11)->first()->report_name }}
                </p>
                <p id="report_name-16" style="display: none" class="lg:w-2/3 mx-auto text-lg leading-relaxed">
                    {{ $report_categories->where('id', 16)->first()->report_name }}
                </p> --}}
            </div>
            @can('general_admin')
                <h2 id="paid_holiday_update" style="display: " class="text-right mb-4">
                    <x-show-a-button href="{{ route('acquisition_days.update_form') }}"
                        class="px-2 py-1">日数更新</x-show-button>
                </h2>
            @endcan

            <div class="max-w-3xl w-full mx-auto">
                <x-notice :notice="session('notice')" />
            </div>

            <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-40 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Remaining Days') }}
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Acquisition Days') }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="hidden md:block text-xs text-sky-500 pl-4 pr-2 py-3 whitespace-nowrap font-medium ">
                                                    <x-affiliation-name :affiliation="$user->affiliation" />
                                                    <div class="text-sm text-gray-800">
                                                        @if (Str::length($user->employee) == 1)
                                                            &ensp;&ensp;
                                                        @endif
                                                        @if (Str::length($user->employee) == 2)
                                                            &ensp;
                                                        @endif
                                                        {{ $user->employee }}&ensp;
                                                        {{ $user->name }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="block md:hidden text-xxs text-sky-500 pl-4 pr-2 py-3 whitespace-nowrap font-medium ">
                                                    <x-affiliation-name-limit :affiliation="$user->affiliation" />
                                                    <div class="text-xs text-gray-800">
                                                        @if (Str::length($user->employee) == 1)
                                                            &ensp;&ensp;
                                                        @endif
                                                        @if (Str::length($user->employee) == 2)
                                                            &ensp;
                                                        @endif
                                                        {{ $user->employee }}&ensp;
                                                        {{ $user->name }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800">
                                                    <div id="remaining-1_{{ $user->id }}" style="display: ">
                                                        <!-- 有給休暇 -->
                                                        <x-remaining-days :user="$user" key=1 />
                                                    </div>
                                                    <div id="remaining-2_{{ $user->id }}" style="display: none">
                                                        <!-- バースデイ休暇 -->
                                                        <x-remaining-days :user="$user" key=2 />
                                                    </div>
                                                    {{-- <div id="remaining-3_{{ $user->id }}" style="display: none">
                                                        <!--  -->
                                                        <x-remaining-days :user="$user" key=3 />
                                                    </div> --}}
                                                    <div id="remaining-4_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-remaining-days :user="$user" key=4 />
                                                    </div>
                                                    <div id="remaining-5_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-remaining-days :user="$user" key=5 />
                                                    </div>
                                                    {{-- <div id="remaining-6_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-remaining-days :user="$user" key=6 />
                                                    </div> --}}
                                                    <div id="remaining-7_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-remaining-days :user="$user" key=7 />
                                                    </div>
                                                    <div id="remaining-8_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-remaining-days :user="$user" key=8 />
                                                    </div>
                                                    <div id="remaining-9_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-remaining-days :user="$user" key=9 />
                                                    </div>
                                                    <div id="remaining-10_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-remaining-days :user="$user" key=10 />
                                                    </div>
                                                    {{-- <div id="remaining-11_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-remaining-days :user="$user" key=11 />
                                                    </div>
                                                    <div id="remaining-16_{{ $user->id }}" style="display: none">
                                                        <!-- 介護休業 -->
                                                        <x-remaining-days :user="$user" key=16 />
                                                    </div> --}}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    <div id="get-1_{{ $user->id }}" style="display: ">
                                                        <!-- 有給 -->
                                                        <x-acquisition-days :user="$user" key=1 />
                                                    </div>
                                                    <div id="get-2_{{ $user->id }}" style="display: none">
                                                        <!-- バースデイ休暇 -->
                                                        <x-acquisition-days :user="$user" key=2 />
                                                    </div>
                                                    {{-- <div id="get-3_{{ $user->id }}" style="display: none">
                                                        <!--  -->
                                                        <x-acquisition-days :user="$user" key=3 />
                                                    </div> --}}
                                                    <div id="get-4_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-acquisition-days :user="$user" key=4 />
                                                    </div>
                                                    <div id="get-5_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-acquisition-days :user="$user" key=5 />
                                                    </div>
                                                    {{-- <div id="get-6_{{ $user->id }}" style="display: none">
                                                        <!-- 弔事-->
                                                        <x-acquisition-days :user="$user" key=6 />
                                                    </div> --}}
                                                    <div id="get-7_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-acquisition-days :user="$user" key=7 />
                                                    </div>
                                                    <div id="get-8_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-acquisition-days :user="$user" key=8 />
                                                    </div>
                                                    <div id="get-9_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-acquisition-days :user="$user" key=9 />
                                                    </div>
                                                    <div id="get-10_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-acquisition-days :user="$user" key=10 />
                                                    </div>
                                                    {{-- <div id="get-11_{{ $user->id }}" style="display: none">
                                                        <!-- -->
                                                        <x-acquisition-days :user="$user" key=11 />
                                                    </div>
                                                    <div id="get-16_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=16 />
                                                    </div> --}}
                                                </td>
                                                @can('general_admin')
                                                    <td id="edit"
                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        <div id="edit-1_{{ $user->id }}" style="display: ">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(1)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-2_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(2)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        {{-- <div id="edit-3_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(3)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div> --}}
                                                        <div id="edit-4_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(4)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-5_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(5)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        {{-- <div id="edit-6_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(6)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div> --}}
                                                        <div id="edit-7_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(7)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-8_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(8)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-9_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(9)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-10_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(10)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        {{-- <div id="edit-11_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(11)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div>
                                                        <div id="edit-16_{{ $user->id }}" style="display: none">
                                                            <x-show-a-button
                                                                href="{{ route('acquisition_days.edit', $user->acquisition(16)->id) }}"
                                                                class="px-3 py-1">
                                                                {{ __('Edit') }}
                                                            </x-show-a-button>
                                                        </div> --}}
                                                    </td>
                                                @else
                                                    <td id="edit"
                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        <div id="edit-1_{{ $user->id }}" style="display: ">
                                                        </div>
                                                        <div id="edit-2_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        {{-- <div id="edit-3_{{ $user->id }}" style="display: none">
                                                        </div> --}}
                                                        <div id="edit-4_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        <div id="edit-5_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        {{-- <div id="edit-6_{{ $user->id }}" style="display: none">
                                                        </div> --}}
                                                        <div id="edit-7_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        <div id="edit-8_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        <div id="edit-9_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        <div id="edit-10_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        {{-- <div id="edit-11_{{ $user->id }}" style="display: none">
                                                        </div>
                                                        <div id="edit-16_{{ $user->id }}" style="display: none">
                                                        </div> --}}
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
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
    </section>

    <script>
        let paidHolidayUpdate = document.getElementById('paid_holiday_update');
        let reportName1 = document.getElementById('report_name-1');
        let reportName2 = document.getElementById('report_name-2');
        // let reportName3 = document.getElementById('report_name-3');
        let reportName4 = document.getElementById('report_name-4');
        let reportName5 = document.getElementById('report_name-5');
        // let reportName6 = document.getElementById('report_name-6');
        let reportName7 = document.getElementById('report_name-7');
        let reportName8 = document.getElementById('report_name-8');
        let reportName9 = document.getElementById('report_name-9');
        let reportName10 = document.getElementById('report_name-10');
        // let reportName11 = document.getElementById('report_name-11');
        // let reportName16 = document.getElementById('report_name-16');
        const users = @json($users);

        function reportChange1() {
            reportNameRemainingOn(reportName1);
            reportChange(1);
            paidHolidayUpdate.style.display = '';
        }

        function reportChange2() {
            reportNameRemainingOn(reportName2);
            reportChange(2);
            paidHolidayUpdate.style.display = 'none';
        }

        // function reportChange3() {
        //     reportNameRemainingOn(reportName3);
        //     reportChange(3);
        //     paidHolidayUpdate.style.display = 'none';
        // }

        function reportChange4() {
            reportNameRemainingOn(reportName4);
            reportChange(4);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange5() {
            reportNameRemainingOn(reportName5);
            reportChange(5)
            paidHolidayUpdate.style.display = 'none';
        }

        // function reportChange6() {
        //     reportNameRemainingOn(reportName6);
        //     reportChange(6);
        //     paidHolidayUpdate.style.display = 'none';
        // }

        function reportChange7() {
            reportNameRemainingOn(reportName7);
            reportChange(7);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange8() {
            reportNameRemainingOn(reportName8);
            reportChange(8);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange9() {
            reportNameRemainingOn(reportName9);
            reportChange(9);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange10() {
            reportNameRemainingOn(reportName10);
            reportChange(10);
            paidHolidayUpdate.style.display = 'none';
        }

        // function reportChange11() {
        //     reportNameRemainingOn(reportName11);
        //     reportChange(11);
        //     paidHolidayUpdate.style.display = 'none';
        // }

        // function reportChange16() {
        //     reportNameRemainingOn(reportName16);
        //     reportChange(16);
        //     paidHolidayUpdate.style.display = 'none';
        // }

        function reportChange(reportCategoryId) {
            console.log(reportCategoryId);
            let remainingId = 'remaining-' + reportCategoryId;
            let getId = 'get-' + reportCategoryId;

            Object.keys(users).forEach((el) => {
                let remainingId1 = document.getElementById('remaining-1_' + users[el].id);
                let remainingId2 = document.getElementById('remaining-2_' + users[el].id);
                // let remainingId3 = document.getElementById('remaining-3_' + users[el].id);
                let remainingId4 = document.getElementById('remaining-4_' + users[el].id);
                let remainingId5 = document.getElementById('remaining-5_' + users[el].id);
                // let remainingId6 = document.getElementById('remaining-6_' + users[el].id);
                let remainingId7 = document.getElementById('remaining-7_' + users[el].id);
                let remainingId8 = document.getElementById('remaining-8_' + users[el].id);
                let remainingId9 = document.getElementById('remaining-9_' + users[el].id);
                let remainingId10 = document.getElementById('remaining-10_' + users[el].id);
                // let remainingId11 = document.getElementById('remaining-11_' + users[el].id);
                // let remainingId16 = document.getElementById('remaining-16_' + users[el].id);
                let getId1 = document.getElementById('get-1_' + users[el].id);
                let getId2 = document.getElementById('get-2_' + users[el].id);
                // let getId3 = document.getElementById('get-3_' + users[el].id);
                let getId4 = document.getElementById('get-4_' + users[el].id);
                let getId5 = document.getElementById('get-5_' + users[el].id);
                // let getId6 = document.getElementById('get-6_' + users[el].id);
                let getId7 = document.getElementById('get-7_' + users[el].id);
                let getId8 = document.getElementById('get-8_' + users[el].id);
                let getId9 = document.getElementById('get-9_' + users[el].id);
                let getId10 = document.getElementById('get-10_' + users[el].id);
                // let getId11 = document.getElementById('get-11_' + users[el].id);
                // let getId16 = document.getElementById('get-16_' + users[el].id);
                const remainingIds = [remainingId1, remainingId2, remainingId4, remainingId5,
                    remainingId7, remainingId8, remainingId9, remainingId10
                ];
                const getIds = [getId1, getId2, getId4, getId5,
                    getId7, getId8, getId9, getId10
                ];

                remainingIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (remainingId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
                getIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (getId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
            });

            let editId = 'edit-' + reportCategoryId;

            Object.keys(users).forEach((el) => {
                let editId1 = document.getElementById('edit-1_' + users[el].id);
                let editId2 = document.getElementById('edit-2_' + users[el].id);
                // let editId3 = document.getElementById('edit-3_' + users[el].id);
                let editId4 = document.getElementById('edit-4_' + users[el].id);
                let editId5 = document.getElementById('edit-5_' + users[el].id);
                // let editId6 = document.getElementById('edit-6_' + users[el].id);
                let editId7 = document.getElementById('edit-7_' + users[el].id);
                let editId8 = document.getElementById('edit-8_' + users[el].id);
                let editId9 = document.getElementById('edit-9_' + users[el].id);
                let editId10 = document.getElementById('edit-10_' + users[el].id);
                // let editId11 = document.getElementById('edit-11_' + users[el].id);
                // let editId16 = document.getElementById('edit-16_' + users[el].id);
                const editIds = [editId1, editId2, editId4, editId5, editId7, editId8, editId9,
                    editId10
                ];

                editIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (editId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
            });
        }

        function reportNameRemainingOn(reportName) {
            const reportNames = [reportName1, reportName2, reportName4, reportName5, reportName7,
                reportName8, reportName9, reportName10
            ];
            reportNames.forEach(name => {
                if (reportName == name) {
                    reportName.style.display = '';
                } else {
                    name.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
