@component('mail::message')
# Introduction

{{ $user_name }}さんが届出を更新しました。<br>
承認してください。
{{ $url }}

@component('mail::button', ['url' => ''])
{{ __('Open') }}
@endcomponent

長島製作所<br>
@endcomponent
