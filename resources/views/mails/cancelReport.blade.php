@component('mail::message')
# 届出の取消が申請されました
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
届出書を確認して取消確認してください<br>


@component('mail::button', ['url' => $url])
{{ __('Open') }}
@endcomponent

{{ config('app.name') }}
@endcomponent
