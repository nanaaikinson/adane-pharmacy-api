<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PURCHASE DETAIL</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/bootstrap.min.css') }}">
  </head>

  <body>
    <div class="row mb-5">
      <div class="col-md-6">
        <tr>
          <th>Supplier:</th>
          <td class="pl-3">{{ $purchase->supplier->name }}</td>
        </tr>
        <tr>
          <th>Address:</th>
          <td class="pl-3">{{ $purchase->supplier->address }}</td>
        </tr>
        <tr>
          <th>Email:</th>
          <td class="pl-3">{{ $purchase->supplier->email }}</td>
        </tr>
        <tr>
          <th>Telephone:</th>
          <td class="pl-3">
            {{ $purchase->supplier->primary_telephone }}
          </td>
        </tr>
      </div>

      <div class="col-md-6">
        <tr>
          <th>Purchase ID:</th>
          <td class="pl-3">{{ $purchase->mask }}</td>
        </tr>
        <tr>
          <th>Purchase Date:</th>
          <td class="pl-3">{{ $purchase->purchase_date }}</td>
        </tr>
      </div>
    </div>

    <hr/>

    <div class="table-responsive my-5">
      <table class="table table-bordered">
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
        @foreach($purchase->products as $key => $product)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>{{ $product->pivot->cost_price }}</td>
            <td>{{ (float)$product->pivot->quantity * $product->pivot->cost_price }}</td>
            <td></td>
          </tr>
        @endforeach
        <tr>
          <th>Subtotal:</th>
          <td></td>
          <th></th>
          <td></td>
          <th></th>
        </tr>
        <tr></tr>
        </tbody>
      </table>
    </div>

  </body>
  </html>
