@extends('layout')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Product list</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table id="products-table" class="table table-striped">
                <tr>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Promotion</th>
                    <th width="250">Selected items</th>
                    <th width="200">Final price</th>
                    <th width="100">Action</th>
                </tr>
                @foreach($products as $product)
                <tr data-id="{{ $product['id'] }}">
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>
                        @if(!empty($product['promotion']))
                            {{ $product['promotion']['quantity'] }} for {{ $product['promotion']['total'] }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <input type="text" class="form-control selected-items" disabled/>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="product_bundle_price"
                            value="0"
                            class="form-control"
                            disabled
                        />
                    </td>
                    <td>
                        <button
                            class="btn btn-sm btn-outline-default quantity"
                            data-name="{{ $product['name'] }}"
                        >
                            Add
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-end" colspan="4">
                        <strong>Selected products:</strong>
                    </td>
                    <td colspan="2">
                        <span class="selected-products"></span>
                    </td>
                </tr>
                <tr>
                    <td class="text-end" colspan="4">
                        <strong>Total price:</strong>
                    </td>
                    <td colspan="2">
                        <span class="total-price">0</span>
                        <button
                            id="checkout"
                            class="btn btn-sm btn-outline-success"
                        >
                            Checkout
                        </button>
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
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ordered date</th>
                </tr>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order['sku_string'] }}</td>
                    <td>{{ $order['total'] }}</td>
                    <td>{{ $order['status'] }}</td>
                    <td>{{ $order['created_at'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No available orders.</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/calculator.js') }}"></script>
@endsection
