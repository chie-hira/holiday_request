@component('mail::message')
# 申請が承認されました
## 申請者:{{ $user_name }}さん<br>
---

- 休暇内容:{{ $report_category }}
@if ($end_date)
- 休暇期間:{{ $start_date }}~{{ $end_date }}
@else
- 休暇期間:{{ $start_date }}
@if ($am_pm)
&ensp;{{ $am_pm }}
@elseif ($end_time)
&ensp;{{ $start_time }}~{{ $end_time }}
@endif
@endif

---

@component('mail::button', ['url' => $url])
{{ __('Open') }}
@endcomponent

{{ config('app.name') }}
@endcomponent