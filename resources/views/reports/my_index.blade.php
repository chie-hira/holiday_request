<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-7xl px-5 py-8 md:py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-4xl text-3xl ZenMaruGothic title-font mb-6 text-gray-900">My申請一覧</h1>
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p>
                            <span class="text-amber-500">承認待ち</span>の申請は<span class="font-bold">編集、取消</span>できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            <span class="text-sky-500">承認済み</span>の申請は<span class="font-bold">修正できません</span>。
                            <span class="text-sky-500">承認済み</span>の申請を<span
                                class="font-bold">修正する場合は、申請を取消してから再申請</span>してください。
                        </p>
                    </x-info>
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
                                                class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Date') }}
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('状 態') }}
                                            </th>
                                            <th scope="col" colspan="3"
                                                class="px-2 py-3 whitespace-nowrap text-right text-xs font-medium text-gray-500 tracking-wider">
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Report Category') }}
                                            </th>
                                            <th scope="col" colspan="2"
                                                class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Span') }}
                                            </th>
                                            <th scope="col"
                                                class="w-32 px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Rest Days') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($reports as $report)
                                            <tr class="hover:bg-gray-100 ">
                                                <td
                                                    class="pl-4 pr-3 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $report->report_date }}
                                                </td>
                                                <td
                                                    class="px-3 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                    @if ($report->approved == 0 && $report->cancel == 0)
                                                        <span class="text-amber-500">承認待ち</span>
                                                    @endif
                                                    @if ($report->approved == 1 && $report->cancel == 0)
                                                        <span class="text-sky-500">承認済み</span>
                                                    @endif
                                                    @if ($report->cancel == 1)
                                                        <span class="text-red-500">取消確認中</span>
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
                                                        @can('update', $report)
                                                            <form action="{{ route('reports.approved_cancel', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <x-delete-input-button value="取消申請"
                                                                    onclick="if(!confirm('承認済みの届出を取消しますか？')){return false};" />
                                                            </form>
                                                        @endcan
                                                    @endif
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
                                                    @if ($report->acquisition_days != 0)
                                                        {{ $report->acquisition_days }} 日&emsp;
                                                    @endif
                                                    @if ($report->acquisition_hours != 0)
                                                        {{ $report->acquisition_hours }} 時間
                                                    @endif
                                                    @if ($report->acquisition_minutes != 0)
                                                        {{ $report->acquisition_minutes }} 分
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
