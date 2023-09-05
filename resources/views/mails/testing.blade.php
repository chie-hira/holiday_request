<!DOCTYPE html>
<html>

<head>
    <title>Test mail</title>
</head>

<body>
    <h1>これはテストメールです</h1>
    <p>{{ $name }}さんが休暇申請アプリに登録されました。</p>
    <p>以下のIDとパスワードでログインしてください。</p>
    <p>ID:{{ $employee }}</p>
    <p>パスワード:非表示</p>
    <hr style="text-align: left; border: dashed;">
    <p>操作方法はログイン後にこちらから確認できます。</p>
    <p>操作説明:非表示</p>
</body>

</html>
