@component('mail::message')
# ようこそ休暇申請アプリへ

{{ $user_name }}さんが休暇申請アプリに登録されました。<br>
下記のIDとパスワードでログインしてください。<br>
ID:{{ $employee }}<br>
パスワード:{{ $password }}<br>

@component('mail::button', ['url' => $url])
{{ __('長島製作所 休暇申請アプリ') }}
@endcomponent

{{-- 操作方法はログイン後にこちらから確認できます。 --}}
{{-- 操作説明:{{ $explanations_url }} --}}

{{ config('app.name') }}
@endcomponent
