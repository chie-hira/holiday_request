<table>
    <thead>
        <tr>
            <th>{{ __('届出日') }}</th>
            <th>{{ __('社員番号') }}</th>
            <th>{{ __('氏名') }}</th>
            <th>{{ __('内容') }}</th>
            <th>{{ __('日付(開始)') }}</th>
            <th>{{ __('日付(終了)') }}</th>
            <th>{{ __('時間(開始)') }}</th>
            <th>{{ __('時間(終了)') }}</th>
            <th>{{ __('取得日数') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>{{ $report->report_date }}</td>
                <td>{{ $report->user->employee }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->report_category->report_name }}</td>
                <td>{{ $report->start_date }}</td>
                <td>{{ $report->end_date }}</td>
                <td>{{ $report->start_time }}</td>
                <td>{{ $report->end_time }}</td>
                <td>{{ $report->get_days }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
