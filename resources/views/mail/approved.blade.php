@component('mail::message')
# Introduction

{{ $user_name }}さんの届出が承認されました。<br>
{{ $url }}


@component('mail::button', ['url' => ''])
{{ __('Open') }}
@endcomponent

長島製作所<br>
@endcomponent
