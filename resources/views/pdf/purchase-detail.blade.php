<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<table>
  <thead>
  <tr>
    <th>SL.</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Cost Price</th>
    <th>Amount</th>
  </tr>
  </thead>
  <tbody>
  @foreach($data as $key => $str)
    {{--      <tr>--}}
    {{--        <td>{{ $key + 1 }}</td>--}}
    {{--        <td>{{ $product->pivot->quantity }}</td>--}}
    {{--        <td>{{ $product->pivot->cost_price }}</td>--}}
    {{--        <td>{{ (float)$product->pivot->quantity * $product->pivot->cost_price }}</td>--}}
    {{--      </tr>--}}
    <tr>
      <td>{{$str}}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  @endforeach
  <tr></tr>
  </tbody>
</table>

</body>
</html>
