<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
</head>
<body>
<h1>メンバー一覧</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>所属部署</th>
    </tr>
    @foreach ($members as $member)
        <tr>
            <td>{{ $member->id }}</td>
            <td>{{ $member->name }}</td>
            <td>{{ $member->department }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
