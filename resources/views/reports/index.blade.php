<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-7xl px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">出退勤届け一覧</h1>
                <div class="mx-auto">
                    <p class="flex text-left leading-relaxed text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="text-sm">
                            <span class="text-red-600">未承認</span>の届出書は<span class="font-bold">編集、削除</span>できます。
                        </span>
                    </p>
                    <p class="flex text-left leading-relaxed text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="text-sm">
                            <span class="text-sky-700">承認後</span>の届出書は<span class="font-bold">修正できません</span>。
                        </span>
                    </p>
                    <p class="flex text-left leading-relaxed text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        <span class="text-sm">
                            <span class="text-sky-700">承認後</span>の届出書を<span class="font-bold">修正する場合</span>は、取消してから<span
                                class="font-bold">再提出</span>してください。
                        </span>
                    </p>
                </div>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container max-w-7xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                届出日
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                内 容
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                期 間
                                            </th>
                                            <th scope="col"
                                                class="w-32 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                日数・時間
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                            <th scope="col" colspan="3"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">

                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-100 ">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    {{ $report->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-report-name :report="$report" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
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
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    @if ($report->cancel == 1)
                                                        <span class="text-red-600">取消確認中</span>
                                                    @else
                                                        @if ($report->approval1 == 0 || $report->approval2 == 0 || $report->approval3 == 0)
                                                            <span class="text-red-600">未承認</span>
                                                        @else
                                                            <span class="text-sky-600">承認</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-show-a-button href="{{ route('reports.show', $report) }}"
                                                        class="px-3 py-1">
                                                        {{ __('Show') }}
                                                    </x-show-a-button>
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    @if ($report->cancel == 0 && $report->approved == 0)
                                                        @can('update', $report)
                                                            <x-edit-a-button href="{{ route('reports.edit', $report) }}">
                                                                {{ __('Edit') }}
                                                            </x-edit-a-button>
                                                        @endcan
                                                    @endif
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if ($report->cancel == 0 && $report->approved == 0)
                                                        @can('delete', $report)
                                                            <form action="{{ route('reports.destroy', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-delete-input-button value="取消"
                                                                    onclick="if(!confirm('届けを取消しますか？')){return false};" />
                                                            </form>
                                                        @endcan
                                                    @endif
                                                    @if ($report->cancel == 0 && $report->approved == 1)
                                                        {{-- @can('general_only') --}}
                                                        <form action="{{ route('reports.approved_cancel', $report) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" value="取消"
                                                                onclick="if(!confirm('承認済みの届けを取消しますか？工場長とGLの確認後に届けが削除されます。')){return false};"
                                                                class="px-3 py-1 text-sm text-red-500 border-2 border-gray-400 rounded-full bg-red-100/60 hover:text-white hover:font-semibold hover:bg-red-500">
                                                        </form>
                                                        {{-- @endcan --}}
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
