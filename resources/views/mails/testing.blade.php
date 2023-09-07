<!DOCTYPE html>
<html>

<head>
    <title>Test mail</title>
</head>

<body>
    <h1>これはテストメールです</h1>
    <p>氏名、所属、社員番号を確認し、間違いがあるときは下記アドレスに報告してください。 <br>
        chi-hirabayashi@nagashima-s.co.jp</p>
    <p>正しいときは報告不要です。</p>
    <hr style="text-align: left; border: dashed;">
    <ul style="list-style:none;">
        <li>氏 名: {{ $name }}</li>
        <li>所 属: {{ $affiliation }}</li>
        <li>社員番号: {{ $employee }}</li>
    </ul>
    <hr style="text-align: left; border: dashed;">
    <p>工場長と部長には工場長・部長承認権限が、GLとGLのいない課の課長にはGL承認権限があります。<br>
        権限の範囲と種類は以下のとおりです。 <br>
        権限の内容が正しいか確認してください。</p>
    @foreach ($approvals as $approval)
        <ul>
            <li>{{ $approval->affiliation->factory->factory_name }}
                @if ($approval->affiliation->department_id != 1)
                    {{ $approval->affiliation->department->department_name }}
                @endif
                / {{ $approval->approval_category->approval_name }}
            </li>
        </ul>
    @endforeach
</body>

</html>
