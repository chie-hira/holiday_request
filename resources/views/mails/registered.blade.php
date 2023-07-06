@component('mail::message')
# 休暇申請アプリに登録されました

{{ $user_name }}さんが休暇申請アプリに登録されました。<br>
ログインID,パスワードを管理者に確認して、ログインしてください。<br>

@component('mail::button', ['url' => $url])
{{ __('Open') }}
@endcomponent

{{ config('app.name') }}
@endcomponent
