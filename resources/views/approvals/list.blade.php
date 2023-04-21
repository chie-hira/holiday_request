<x-app-layout>
    <!-- Page Heading -->
    <header class="text-sm bg-pink-50 shadow-md shadow-purple-500/50">
        <div class="flex max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
            <button class="mx-2" onclick="reportChange1()">有給休暇</button>
            <button class="mx-2" onclick="reportChange2()">バースデイ休暇</button>
        </div>
    </header>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">休暇取得状況</h1>
                <p id="report_name-1" style="display: "
                    class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    有給休暇
                </p>
                <p id="report_name-2" style="display: none"
                    class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    バースデイ休暇
                </p>
            </div>

            <div class="container bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 dark:divide-gray-700">
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
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                取得日数
                                            </th>
                                            <th
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                残日数
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $user->factory->factory_name }}工場&ensp;/&ensp;{{ $user->department->department_name }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 dark:text-gray-200">
                                                    {{ $user->employee }}</td>
                                                <td
                                                    class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    {{ $user->name }}</td>
                                                <td 
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 dark:text-gray-200">
                                                    {{-- @if ($user->sum_get_days->first())
                                                        @if ($user->sumGetDaysOnly(1) != 0)
                                                            {{ $user->sumGetDaysOnly(1) }} 日&emsp;
                                                        @endif
                                                        @if ($user->sumGetHours(1) != 0)
                                                            {{ $user->sumGetHours(1) }} 時間
                                                        @endif
                                                        @if ($user->sumGetHours(1) == 0)
                                                            &emsp;&emsp;&emsp;
                                                        @endif
                                                    @endif --}}
                                                    <div id="get-1-{{ $user->id }}" style="display: ">
                                                        <x-sum-get-days :user="$user" key=1 /> {{-- 有給 --}}
                                                    </div>
                                                    <div id="get-2-{{ $user->id }}" style="display: none">
                                                        <x-sum-get-days :user="$user" key=2 /> {{-- バースデイ --}}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 dark:text-gray-200">
                                                    {{-- @if ($user->remainings->first())
                                                        @if ($user->remainingDaysOnly(0) != 0)
                                                            {{ $user->remainingDaysOnly(0) }} 日&emsp;
                                                        @endif
                                                        @if ($user->remainingHours(0) != 0)
                                                            {{ $user->remainingHours(0) }} 時間
                                                        @endif
                                                        @if ($user->remainingHours(0) == 0)
                                                            &emsp;&emsp;&emsp;
                                                        @endif
                                                    @endif --}}
                                                    <div id="remaining-1-{{ $user->id }}" style="display: ">
                                                        <x-remaining-days :user="$user" key=0 /> {{-- 有給 --}}
                                                    </div>
                                                    <div id="remaining-2-{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=1 /> {{-- バースデイ --}}
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

            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('menu') }}"
                    class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="px-2 mt-1">
                        menuへ戻る
                    </div>
                </a>
            </div>
        </div>
    </section>

    <script>
        let reportName1 = document.getElementById('report_name-1');
        // let report1 = document.getElementById('report-1');
        let reportName2 = document.getElementById('report_name-2');
        // let report2 = document.getElementById('report-2');
        const users = @json($users);

        function reportChange1() {
            reportName1.style.display = '';
            reportName2.style.display = 'none';
            users.forEach(e => {
                let getId1 = document.getElementById('get-1-'+e.id);
                let getId2 = document.getElementById('get-2-'+e.id);
                let remainingId1 = document.getElementById('remaining-1-'+e.id);
                let remainingId2 = document.getElementById('remaining-2-'+e.id);
                getId1.style.display = '';
                getId2.style.display = 'none';
                remainingId1.style.display = '';
                remainingId2.style.display = 'none';
            });
        }
        function reportChange2() {
            reportName1.style.display = 'none';
            reportName2.style.display = '';
            users.forEach(e => {
                let getId1 = document.getElementById('get-1-'+e.id);
                let getId2 = document.getElementById('get-2-'+e.id);
                let remainingId1 = document.getElementById('remaining-1-'+e.id);
                let remainingId2 = document.getElementById('remaining-2-'+e.id);
                getId1.style.display = 'none';
                getId2.style.display = '';
                remainingId1.style.display = 'none';
                remainingId2.style.display = '';
            });
        }
    </script>
</x-app-layout>
