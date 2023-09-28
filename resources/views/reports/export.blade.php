<table>
    <thead>
        <tr>
            <th>{{ __('Affiliation') }}</th>
            <th>{{ __('Employee') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Report Category') }}</th>
            <th>{{ __('Rest Span') }}</th>
            <th></th>
            <th></th>
            <th>{{ __('Rest Days') }}</th>
            {{-- <th>{{ __('Shift') }}</th>
            <th></th> --}}
            <th>{{ __('Report Date') }}</th>
            <th>{{ __('Reason') }}</th>
            <th>{{ __('Reason Detail') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>
                    {{ $report->user->affiliation_name }}
                </td>
                <td>
                    {{ $report->user->employee }}
                </td>
                <td>
                    {{ $report->user->name }}
                </td>
                <td>
                    <x-report-name :report="$report" />
                </td>
                <td>
                    {{ $report->start_date }}
                </td>
                <td>
                    @if ($report->start_time != null)
                        {{ Str::substr($report->start_time, 0, 5) }}
                    @endif
                    @if ($report->am_pm != null)
                        {{ $report->am_pm == 1 ? '前半' : '後半' }}
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
                {{-- <td>
                    シフト{{ $report->shift_category->shift_code }}
                </td>
                <td>
                    {{ $report->shift_category->start_time_hm }} ~
                    {{ $report->shift_category->end_time_hm }}
                </td> --}}
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
