<!DOCTYPE html>
<html>

<head>
    <title>app available</title>
</head>

<body>
    <h1>ようこそ休暇申請アプリへ</h1>
    <p>{{ $name }}さんが休暇申請アプリに登録されました。</p>
    <p>以下のIDとパスワードでログインしてください。</p>
    <p>ID:{{ $employee }}</p>
    <p>パスワード:{{ $password }}</p>
    <p>長島製作所 休暇申請アプリ:{{ $url }}</p>
    <hr style="text-align: left; border: dashed;">
    <p>操作方法はログイン後にこちらから確認できます。</p>
    <p>操作説明:{{ $explanations_url }}</p>
</body>

</html>
