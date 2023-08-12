<x-app-layout>
    <!-- Page nav -->
    <div class="border-b-2 border-gray-200">
        <nav class="px-4 -mb-0.5 flex space-x-2">
            <x-nav-button onclick="reportChange1()">
                {{ $report_categories[0]->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange4()">
                {{ $report_categories[3]->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange5()">
                {{ $report_categories[4]->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange6()">
                {{ $report_categories[5]->report_name }}
            </x-nav-button>
            <x-nav-button onclick="reportChange16()">
                {{ $report_categories[15]->report_name }}
            </x-nav-button>
        </nav>
    </div>
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">休暇可能日数</h1>
                <h2 id="paid_holiday_update" style="display: " class=" text-right">
                    @can('admin_only')
                        <a href={{ route('remainings.update_form') }}
                            class="inline-flex items-center justify-center text-base mr-2 font-medium text-sky-600 hover:text-sky-50 p-1 rounded-full border-2 border-gray-400 bg-sky-100/60 hover:bg-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 013.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 00-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 00-4.392-4.392 49.422 49.422 0 00-7.436 0A4.756 4.756 0 003.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 101.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 013.01-3.01c1.19-.09 2.392-.135 3.605-.135zm-6.97 6.22a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 004.392 4.392 49.413 49.413 0 007.436 0 4.756 4.756 0 004.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 00-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 01-3.01 3.01 47.953 47.953 0 01-7.21 0 3.256 3.256 0 01-3.01-3.01 47.759 47.759 0 01-.1-1.759L6.97 15.53a.75.75 0 001.06-1.06l-3-3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endcan
                </h2>
                <p id="report_name-1" style="display: " class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories[0]->report_name }}
                </p>
                <p id="report_name-4" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories[3]->report_name }}
                </p>
                <p id="report_name-5" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories[4]->report_name }}
                </p>
                <p id="report_name-6" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories[5]->report_name }}
                </p>
                <p id="report_name-16" style="display: none" class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                    {{ $report_categories[15]->report_name }}
                </p>
            </div>

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
                                                所 属
                                            </th>
                                            <th
                                                class="w-24 py-3 text-right text-xs font-medium text-gray-500 tracking-wider">
                                                社員番号
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
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
                                                    class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                    {{ $user->affiliation->factory->factory_name }}工場
                                                    @if ($user->affiliation->department->id != 1)
                                                        ・{{ $user->affiliation->department->department_name }}
                                                    @endif
                                                    @if ($user->affiliation->group != null && $user->affiliation->group->id != 1)
                                                        ・{{ $user->affiliation->group->group_name }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    {{ $user->employee }}</td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800 ">
                                                    {{ $user->name }}</td>
                                                <td id="remaining_data"
                                                    class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    <div id="remaining-1_{{ $user->id }}" style="display: ">
                                                        <x-remaining-days :user="$user" key=1 />
                                                        {{-- 有給 --}}
                                                    </div>
                                                    <div id="remaining-4_{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=4 />
                                                        {{-- 弔事 --}}
                                                    </div>
                                                    <div id="remaining-5_{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=5 />
                                                        {{-- 弔事 --}}
                                                    </div>
                                                    <div id="remaining-6_{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=6 />
                                                        {{-- 弔事 --}}
                                                    </div>
                                                    <div id="remaining-16_{{ $user->id }}" style="display: none">
                                                        <x-remaining-days :user="$user" key=16 />
                                                        {{-- 介護休業 --}}
                                                    </div>
                                                </td>
                                                <td id="edit"
                                                    class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <div id="edit-1_{{ $user->id }}" style="display: ">
                                                        <x-edit-a-button
                                                            href="{{ route('acquisition_days.edit', $user->remaining(1)->id) }}">
                                                            {{ __('Edit') }}
                                                        </x-edit-a-button>
                                                    </div>
                                                    <div id="edit-4_{{ $user->id }}" style="display: none">
                                                        <x-edit-a-button
                                                            href="{{ route('acquisition_days.edit', $user->remaining(4)->id) }}">
                                                            {{ __('Edit') }}
                                                        </x-edit-a-button>
                                                    </div>
                                                    <div id="edit-5_{{ $user->id }}" style="display: none">
                                                        <x-edit-a-button
                                                            href="{{ route('acquisition_days.edit', $user->remaining(5)->id) }}">
                                                            {{ __('Edit') }}
                                                        </x-edit-a-button>
                                                    </div>
                                                    <div id="edit-6_{{ $user->id }}" style="display: none">
                                                        <x-edit-a-button
                                                            href="{{ route('acquisition_days.edit', $user->remaining(6)->id) }}">
                                                            {{ __('Edit') }}
                                                        </x-edit-a-button>
                                                    </div>
                                                    <div id="edit-16_{{ $user->id }}" style="display: none">
                                                        <x-edit-a-button
                                                            href="{{ route('acquisition_days.edit', $user->remaining(16)->id) }}">
                                                            {{ __('Edit') }}
                                                        </x-edit-a-button>
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
        let paidHolidayUpdate = document.getElementById('paid_holiday_update');
        let reportName1 = document.getElementById('report_name-1');
        let reportName4 = document.getElementById('report_name-4');
        let reportName5 = document.getElementById('report_name-5');
        let reportName6 = document.getElementById('report_name-6');
        let reportName16 = document.getElementById('report_name-16');
        let remainingTitle = document.getElementById('remaining_title');
        let remainingData = document.getElementById('remaining_data');
        const users = @json($users);

        function reportChange1() {
            reportNameRemainingOn(reportName1);
            reportDataRemainingOn(1);
            editSwitch(1);
            paidHolidayUpdate.style.display = '';
        }

        function reportChange4() {
            reportNameRemainingOn(reportName4);
            reportDataRemainingOn(4);
            editSwitch(4);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange5() {
            reportNameRemainingOn(reportName5);
            reportDataRemainingOn(5);
            editSwitch(5);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange6() {
            reportNameRemainingOn(reportName6);
            reportDataRemainingOn(6);
            editSwitch(6);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportChange16() {
            reportNameRemainingOn(reportName16);
            reportDataRemainingOn(16);
            editSwitch(16);
            paidHolidayUpdate.style.display = 'none';
        }

        function reportDataRemainingOn(repoortCategoryId) {
            let remainingId = 'remaining-' + repoortCategoryId;

            users.forEach(e => {
                let remainingId1 = document.getElementById('remaining-1_' + e.id);
                let remainingId4 = document.getElementById('remaining-4_' + e.id);
                let remainingId5 = document.getElementById('remaining-5_' + e.id);
                let remainingId6 = document.getElementById('remaining-6_' + e.id);
                let remainingId16 = document.getElementById('remaining-16_' + e.id);
                const remainingIds = [remainingId1, remainingId4, remainingId5, remainingId6, remainingId16];

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

        function editSwitch(repoortCategoryId) {
            let editId = 'edit-' + repoortCategoryId;

            users.forEach(e => {
                let editId1 = document.getElementById('edit-1_' + e.id);
                let editId4 = document.getElementById('edit-4_' + e.id);
                let editId5 = document.getElementById('edit-5_' + e.id);
                let editId6 = document.getElementById('edit-6_' + e.id);
                let editId16 = document.getElementById('edit-16_' + e.id);
                const editIds = [editId1, editId4, editId5, editId6, editId16];

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
            const reportNames = [reportName1, reportName4, reportName5, reportName6, reportName16];
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
    </script>
</x-app-layout>
