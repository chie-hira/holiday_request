<table>
    <thead>
        <tr>
            <th>{{ __('所属') }}</th>
            <th>{{ __('社員番号') }}</th>
            <th>{{ __('氏名') }}</th>
            <th>{{ __('休暇の種類') }}</th>
            <th>{{ __('取得期間') }}</th>
            <th></th>
            <th></th>
            <th>{{ __('取得日数') }}</th>
            <th>{{ __('シフト') }}</th>
            <th>{{ __('届出日') }}</th>
            <th>{{ __('理由') }}</th>
            <th>{{ __('理由詳細') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>
                    {{ $report->user->team_all }}
                </td>
                <td>
                    @if (Str::length($report->user->employee) == 1)
                        &ensp;&ensp;
                    @endif
                    @if (Str::length($report->user->employee) == 2)
                        &ensp;
                    @endif
                    {{ $report->user->employee }}
                </td>
                <td>
                    {{ $report->user->name }}
                </td>
                <td>
                    <x-report-name :report="$report" />
                </td>
                <td>
                    @if ($report->start_date != null)
                        {{ $report->start_date }}
                    @endif
                </td>
                <td>
                    @if ($report->start_time != null)
                        {{ Str::substr($report->start_time, 0, 5) }}
                    @endif
                    @if ($report->am_pm != null)
                        {{ $report->am_pm == 1 ? '午 前' : '午 後' }}
                    @endif
                    @if ($report->end_date != null)
                        {{ $report->end_date }}
                    @endif
                </td>
                <td>
                    @if ($report->end_time != null)
                        {{ Str::substr($report->end_time, 0, 5) }}
                    @endif
                </td>
                <td>
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
                <td>
                    ナンバー{{ $report->shift_category->shift_code }}
                </td>
                <td>
                    {{ $report->report_date }}
                </td>
                <td>
                    {{ $report->reason_category->reason }}
                </td>
                <td>
                    {{ $report->reason_detail }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
