<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
</head>
<body>
<h1>商品一覧</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>価格</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }} 円</td>
        </tr>
    @endforeach
</table>
</body>
</html>
