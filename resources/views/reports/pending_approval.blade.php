<x-app-layout>
{{-- //TODO:届出順にorder --}}
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900"><span
                        class="text-red-500">{{ __('承認待ち') }}</span>{{ __('一覧') }}</h1>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                届出日
                                            </th>
                                            <th scope="col"
                                                class="pl-4 pr-1 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Team') }}
                                            </th>
                                            <th scope="col"
                                                class="py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee') }}
                                            </th>
                                            <th scope="col"
                                                class="pl-1 pr-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Name') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                内 容
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                期 間
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                日数・時間
                                            </th>
                                            <th scope="col"
                                                class="pl-2 pr-1 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Approver') }}
                                            </th>
                                            <th scope="col"
                                                class="pl-1 pr-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Leader') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-100 ">
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->team }}
                                                </td>
                                                <td
                                                    class="px-2 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    @if (Str::length($report->user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($report->user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $report->user->employee }}
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->start_date != null)
                                                        {{ $report->start_date }}
                                                    @else
                                                        -
                                                    @endif
                                                    @if ($report->start_time != null)
                                                        &emsp;{{ Str::substr($report->start_time, 0, 5) }}
                                                    @endif
                                                </td>
                                                <td class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->end_date != null)
                                                        ~&emsp;&emsp;{{ $report->end_date }}
                                                    @endif
                                                    @if ($report->end_time != null)
                                                        ~&emsp;&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                    @endif
                                                    @if ($report->am_pm != null)
                                                        {{ $report->am_pm == 1 ? '午 前' : '午 後' }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                    @if ($report->get_days_only != 0)
                                                        {{ $report->get_days_only }} 日&emsp;
                                                    @endif
                                                    @if ($report->get_hours != 0)
                                                        {{ $report->get_hours }} 時間
                                                    @endif
                                                    @if ($report->get_minutes != 0)
                                                        {{ $report->get_minutes }} 分
                                                    @endif
                                                </td>
                                                @if ($report->cancel == 0)
                                                    <td class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        @if ($report->approval1 == 1)
                                                            <span class="text-blue-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="currentColor"
                                                                    class="w-4 h-4 mx-auto">
                                                                    <path fill-rule="evenodd"
                                                                        d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                        @if ($report->approval2 == 1)
                                                            <span class="text-blue-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="currentColor"
                                                                    class="w-4 h-4 mx-auto">
                                                                    <path fill-rule="evenodd"
                                                                        d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td colspan="3"
                                                        class="px-2 py-4 text-center text-red-600 whitespace-nowrap text-sm">
                                                        取消確認中
                                                    </td>
                                                @endif
                                                <td
                                                    class="flex px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <x-show-a-button href="{{ route('reports.show', $report) }}"
                                                        class="px-3 py-1">
                                                        {{ __('Show') }}
                                                    </x-show-a-button>
                                                    @if (Auth::user()->approvals->where('department_id', '!=', 7)->where('approval_id', 2)->first())
                                                        @foreach (Auth::user()->approvals->where('department_id', '!=', 7)->where('approval_id', 2) as $approval)
                                                            @if ($report->user->factory_id == $approval->factory_id && $report->approval1 == 0 && $report->cancel == 0)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                            @if ($report->user->factory_id == $approval->factory_id && $report->approval1 == 1 && $report->cancel == 1)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if (Auth::user()->approvals->where('department_id', 7)->where('approval_id', 2)->first())
                                                        @foreach (Auth::user()->approvals->where('department_id', 7)->where('approval_id', 2) as $approval)
                                                            @if ($report->user->department_id == $approval->department_id && $report->approval1 == 0 && $report->cancel == 0)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                            @if ($report->user->department_id == $approval->department_id && $report->approval1 == 1 && $report->cancel == 1)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if (Auth::user()->approvals->where('approval_id', 3)->first())
                                                        @foreach (Auth::user()->approvals->where('approval_id', 3) as $approval)
                                                            @if (
                                                                $report->user->factory_id == $approval->factory_id &&
                                                                    $report->user->department_id == $approval->department_id &&
                                                                    $report->user->group_id == $approval->group_id &&
                                                                    $report->approval2 == 0 &&
                                                                    $report->cancel == 0)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                            @if (
                                                                $report->user->factory_id == $approval->factory_id &&
                                                                    $report->user->department_id == $approval->department_id &&
                                                                    $report->user->group_id == $approval->group_id &&
                                                                    $report->approval2 == 1 &&
                                                                    $report->cancel == 1)
                                                                <div class="mt-2 -ml-3">
                                                                    <x-check-mark />
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
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
</x-app-layout>
