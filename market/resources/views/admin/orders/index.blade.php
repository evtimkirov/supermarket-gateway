@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Order list</h1>
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
                    <th>Change status</th>
                </tr>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order['sku_string'] }}</td>
                    <td>{{ $order['total'] }}</td>
                    <td>{{ $order['status'] }}</td>
                    <td>{{ $order['created_at'] }}</td>
                    <td>
                        <form action="{{ route('orders.updateStatus', $order['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                @foreach(\App\Models\Order::STATUSES as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
