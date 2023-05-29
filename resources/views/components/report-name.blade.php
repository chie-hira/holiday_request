@props(['report'])

@if ($report->report_id == 1)
    @if ($report->sub_report_id == 1 || $report->sub_report_id == 2)
        {{ $report->report_category->report_name }}
    @else
        {{ $report->sub_report_category->sub_report_name }}
    @endif
@else
    {{ $report->report_category->report_name }}
@endif
