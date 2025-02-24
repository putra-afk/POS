<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Page</title>
</head>
<body>
    <h1>Sales Page</h1>
    <p>Here you can view all sales</p>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->product_name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->price }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>