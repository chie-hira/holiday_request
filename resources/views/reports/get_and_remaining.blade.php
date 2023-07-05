<x-app-layout>
{{-- //TODO:月、部所指定して表示 --}}
    <!-- Page nav -->
    <div class="border-b-2 border-gray-200">
        <nav class="px-4 -mb-0.5 flex space-x-2">
            <x-nav-button onclick="reportChange1()">
                {{ __('有給休暇') }}
            </x-nav-button>
            <x-nav-button onclick="reportChange2()">
                {{ __('バースデイ休暇') }}
            </x-nav-button>
            <x-nav-button onclick="reportChange12()">
                {{ __('欠勤') }}
            </x-nav-button>
            <x-nav-button onclick="reportChange13()">
                {{ __('遅刻') }}
            </x-nav-button>
            <x-nav-button onclick="reportChange14()">
                {{ __('早退') }}
            </x-nav-button>
            <x-nav-button onclick="reportChange15()">
                {{ __('外出') }}
            </x-nav-button>
        </nav>
    </div>
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">休暇取得状況</h1>
                <p id="report_name-1" style="display: " class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    有給休暇
                </p>
                <p id="report_name-2" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    バースデイ休暇
                </p>
                <p id="report_name-12" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    欠 勤
                </p>
                <p id="report_name-13" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    遅 刻
                </p>
                <p id="report_name-14" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    早 退
                </p>
                <p id="report_name-15" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    外 出
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
                                                所 属
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                社員番号
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                取得日数
                                            </th>
                                            <th id="bar_title" style="display: "></th>
                                            <th id="remaining_title" style="display: "
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                残日数
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $user->factory->factory_name }}
                                                    @if ($user->department->id != 1)
                                                        ・{{ $user->department->department_name }}
                                                    @endif
                                                    @if ($user->group != null && $user->group->id != 1)
                                                        ・{{ $user->group->group_name }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    {{ $user->employee }}</td>
                                                <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $user->name }}</td>
                                                <td
                                                    class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    <div id="get-1_{{ $user->id }}" style="display: ">
                                                        <x-sum-get-days :user="$user" key=1 /> {{-- 有給 --}}
                                                    </div>
                                                    <div id="get-2_{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=2 /> {{-- バースデイ --}}
                                                    </div>
                                                    <div id="get-12_{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=12 />
                                                        {{-- 欠勤 --}}
                                                    </div>
                                                    <div id="get-13_{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=13 />
                                                        {{-- 遅刻 --}}
                                                    </div>
                                                    <div id="get-14_{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=14 />
                                                        {{-- 早退 --}}
                                                    </div>
                                                    <div id="get-15_{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=15 />
                                                        {{-- 外出 --}}
                                                    </div>
                                                </td>
                                                <td id="bar_{{ $user->id }}" style="display: ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-5 h-6">
                                                        <path fill-rule="evenodd"
                                                            d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </td>
                                                <td id="remaining_data" style="display: "
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
        let remainingData = document.getElementById('remaining_data');
        let barTitle = document.getElementById('bar_title');
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

            users.forEach(e => {
                let getId1 = document.getElementById('get-1_' + e.id);
                let getId2 = document.getElementById('get-2_' + e.id);
                let getId12 = document.getElementById('get-12_' + e.id);
                let getId13 = document.getElementById('get-13_' + e.id);
                let getId14 = document.getElementById('get-14_' + e.id);
                let getId15 = document.getElementById('get-15_' + e.id);
                let remainingId1 = document.getElementById('remaining-1_' + e.id);
                let remainingId2 = document.getElementById('remaining-2_' + e.id);
                let barId = document.getElementById('bar_' + e.id);
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
                barTitle.style.display = '';
                barId.style.display = '';
            });
        }

        function reportDataRemainingOff(repoortCategoryId) {
            let getId = 'get-' + repoortCategoryId;

            users.forEach(e => {
                let getId1 = document.getElementById('get-1_' + e.id);
                let getId2 = document.getElementById('get-2_' + e.id);
                let getId12 = document.getElementById('get-12_' + e.id);
                let getId13 = document.getElementById('get-13_' + e.id);
                let getId14 = document.getElementById('get-14_' + e.id);
                let getId15 = document.getElementById('get-15_' + e.id);
                let remainingId1 = document.getElementById('remaining-1_' + e.id);
                let remainingId2 = document.getElementById('remaining-2_' + e.id);
                let barId = document.getElementById('bar_' + e.id);
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
                barTitle.style.display = 'none';
                barId.style.display = 'none';
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
            remainingData.style.display = '';
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
            remainingData.style.display = 'none';
        }
    </script>
</x-app-layout>
