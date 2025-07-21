@extends('layout')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Product list</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Promotion</th>
                    <th>Final price</th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>
                        <input
                            type="number"
                            min="0"
                            max="20"
                            value="0"
                            class="form-control"
                        />
                    </td>
                    <td>3 for 130</td>
                    <td>0</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-end" colspan="4">
                        <strong>Total:</strong>
                    </td>
                    <td>
                        500
                        <button class="btn btn-sm btn-outline-success">Checkout</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>Product orders</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th>Order</th>
                    <th>Ordered date</th>
                    <th>Total</th>
                </tr>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // JS here...
        });
    </script>
@endsection
