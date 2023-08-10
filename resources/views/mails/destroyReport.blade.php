@component('mail::message')
# 届出が取消されました
## 届出者:{{ $user_name }}さん<br>
---

- 休暇種類:{{ $report_category }}
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

{{ config('app.name') }}
@endcomponent
