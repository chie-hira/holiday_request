<x-app-layout>
    {{-- //TODO:月、部所指定して表示 --}}
    <!-- Page nav -->
    <div class="border-b-2 border-gray-200">
        <nav class="px-4 -mb-0.5 flex space-x-2 overflow-x-auto">
            <x-nav-button onclick="reportChange1()">
                {{ $report_categories->where('id', 1)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange2()">
                {{ $report_categories->where('id', 2)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange12()">
                {{ $report_categories->where('id', 12)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange13()">
                {{ $report_categories->where('id', 13)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange14()">
                {{ $report_categories->where('id', 14)->first()->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange15()">
                {{ $report_categories->where('id', 15)->first()->report_name }}
            </x-nav-button>
        </nav>
    </div>
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">{{ __('休暇取得状況') }}</h1>
                <p id="report_name-1" style="display: " class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 1)->first()->report_name }}
                </p>
                <p id="report_name-2" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 2)->first()->report_name }}
                </p>
                <p id="report_name-12" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 12)->first()->report_name }}
                </p>
                <p id="report_name-13" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 13)->first()->report_name }}
                </p>
                <p id="report_name-14" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 14)->first()->report_name }}
                </p>
                <p id="report_name-15" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories->where('id', 15)->first()->report_name }}
                </p>
            </div>

            <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-40 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{-- {{ __('Affiliation') }} --}}
                                                {{ __('Employee Name') }}
                                            </th>
                                            {{-- <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th> --}}
                                            <th id="remaining_title" style="display: "
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Remaining Days') }}
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Acquisition Days') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($users as $user)
                                            <tr>
                                                {{-- <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    <x-affiliation-name :affiliation="$user->affiliation" />
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $user->employee }}&ensp;
                                                    {{ $user->name }}</td> --}}
                                                <td
                                                    class="hidden md:block text-xs text-blue-500 pl-4 pr-2 py-3 whitespace-nowrap font-medium ">
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
                                                    class="block md:hidden text-xxs text-blue-500 pl-4 pr-2 py-3 whitespace-nowrap font-medium ">
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
                                                <td id="remaining-data_{{ $user->id }}" style="display: "
                                                    class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    <div id="remaining-1_{{ $user->id }}" style="display: ">
                                                        <x-remaining-days :user="$user" key=1 />
                                                        {{-- 有給 --}}
                                                    </div>
                                                    <div id="remaining-2_{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=2 />
                                                        {{-- バースデイ --}}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    <div id="get-1_{{ $user->id }}" style="display: ">
                                                        <x-acquisition-days :user="$user" key=1 />
                                                        {{-- 有給 --}}
                                                    </div>
                                                    <div id="get-2_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=2 />
                                                        {{-- バースデイ --}}
                                                    </div>
                                                    <div id="get-12_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=12 />
                                                        {{-- 欠勤 --}}
                                                    </div>
                                                    <div id="get-13_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=13 />
                                                        {{-- 遅刻 --}}
                                                    </div>
                                                    <div id="get-14_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=14 />
                                                        {{-- 早退 --}}
                                                    </div>
                                                    <div id="get-15_{{ $user->id }}" style="display: none">
                                                        <x-acquisition-days :user="$user" key=15 />
                                                        {{-- 外出 --}}
                                                    </div>
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

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>

    <script>
        let reportName1 = document.getElementById('report_name-1');
        let reportName2 = document.getElementById('report_name-2');
        let reportName12 = document.getElementById('report_name-12');
        let reportName13 = document.getElementById('report_name-13');
        let reportName14 = document.getElementById('report_name-14');
        let reportName15 = document.getElementById('report_name-15');
        let remainingTitle = document.getElementById('remaining_title');
        const users = @json($users);

        function reportChange1() {
            reportNameRemainingOn(reportName1);
            reportDataRemainingOn(1);
        }

        function reportChange2() {
            reportNameRemainingOn(reportName2);
            reportDataRemainingOn(2);
        }

        function reportChange12() {
            reportNameRemainingOff(reportName12);
            reportDataRemainingOff(12);
        }

        function reportChange13() {
            reportNameRemainingOff(reportName13);
            reportDataRemainingOff(13);
        }

        function reportChange14() {
            reportNameRemainingOff(reportName14);
            reportDataRemainingOff(14);
        }

        function reportChange15() {
            reportNameRemainingOff(reportName15);
            reportDataRemainingOff(15);
        }

        function reportDataRemainingOn(repoortCategoryId) {
            let getId = 'get-' + repoortCategoryId;
            let remainingId = 'remaining-' + repoortCategoryId;

            Object.keys(users).forEach((el) => {
                let getId1 = document.getElementById('get-1_' + users[el].id);
                let getId2 = document.getElementById('get-2_' + users[el].id);
                let getId12 = document.getElementById('get-12_' + users[el].id);
                let getId13 = document.getElementById('get-13_' + users[el].id);
                let getId14 = document.getElementById('get-14_' + users[el].id);
                let getId15 = document.getElementById('get-15_' + users[el].id);
                let remainingId1 = document.getElementById('remaining-1_' + users[el].id);
                let remainingId2 = document.getElementById('remaining-2_' + users[el].id);
                const getIds = [getId1, getId2, getId12, getId13, getId14, getId15];
                const remainingIds = [remainingId1, remainingId2];

                getIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (getId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
                remainingIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (remainingId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
            });
        }

        function reportDataRemainingOff(repoortCategoryId) {
            let getId = 'get-' + repoortCategoryId;

            Object.keys(users).forEach((el) => {
                let getId1 = document.getElementById('get-1_' + users[el].id);
                let getId2 = document.getElementById('get-2_' + users[el].id);
                let getId12 = document.getElementById('get-12_' + users[el].id);
                let getId13 = document.getElementById('get-13_' + users[el].id);
                let getId14 = document.getElementById('get-14_' + users[el].id);
                let getId15 = document.getElementById('get-15_' + users[el].id);
                let remainingId1 = document.getElementById('remaining-1_' + users[el].id);
                let remainingId2 = document.getElementById('remaining-2_' + users[el].id);
                // let barId = document.getElementById('bar_' + users[el].id);
                const getIds = [getId1, getId2, getId12, getId13, getId14, getId15];

                getIds.forEach(id => {
                    idSplit = id.id.split('_');
                    if (getId == idSplit[0]) {
                        id.style.display = '';
                    } else {
                        id.style.display = 'none';
                    }
                });
                remainingId1.style.display = 'none';
                remainingId2.style.display = 'none';
            });
        }

        function reportNameRemainingOn(reportName) {
            const reportNames = [reportName1, reportName2, reportName12, reportName13, reportName14, reportName15];
            reportNames.forEach(name => {
                if (reportName == name) {
                    reportName.style.display = '';
                } else {
                    name.style.display = 'none';
                }
            });
            remainingTitle.style.display = '';
            Object.keys(users).forEach((el) => {
                let remainingData = document.getElementById('remaining-data_' + users[el].id);
                remainingData.style.display = '';
            });
        }

        function reportNameRemainingOff(reportName) {
            const reportNames = [reportName1, reportName2, reportName12, reportName13, reportName14, reportName15];
            reportNames.forEach(name => {
                if (reportName == name) {
                    reportName.style.display = '';
                } else {
                    name.style.display = 'none';
                }
            });
            remainingTitle.style.display = 'none';
            Object.keys(users).forEach((el) => {
                let remainingData = document.getElementById('remaining-data_' + users[el].id);
                remainingData.style.display = 'none';
            });
        }
    </script>
</x-app-layout>
