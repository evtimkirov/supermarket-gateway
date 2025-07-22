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
                    <th width="100">Quantity</th>
                    <th>Promotion</th>
                    <th width="200">Final price</th>
                </tr>
                @foreach($products as $product)
                <tr data-id="{{ $product['id'] }}">
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>
                        <input
                            type="number"
                            name="quantity"
                            min="0"
                            max="20"
                            value="0"
                            class="form-control quantity"
                        />
                    </td>
                    <td>3 for 130</td>
                    <td>
                        <input
                            type="text"
                            name="product_bundle_price"
                            value="0"
                            class="form-control"
                            disabled
                        />
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-end" colspan="4">
                        <strong>Total:</strong>
                    </td>
                    <td>
                        <span class="total-price">0</span>
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
                <tr>
                    <td colspan="3">No available orders.</td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/calculator.js') }}"></script>
@endsection
