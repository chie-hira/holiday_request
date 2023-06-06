@component('mail::message')
# Introduction

{{ $user_name }}さんが休暇申請アプリに登録されました。
以下のボタンをクリックして、アプリをダウンロードしてください。

@component('mail::button', ['url' => ''])
{{ __('Download') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent