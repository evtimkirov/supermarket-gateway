@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Product list</h1>
        </div>
        <div class="col">
            <a
                href="{{ route('products.create') }}"
                class="btn btn-sm btn-success mt-2 float-end"
            >
                New product
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Single price</th>
                    <th>Created at</th>
                    <th>Modified at</th>
                    <th width="200">Actions</th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>{{ $product['created_at'] ?? '-' }}</td>
                    <td>{{ $product['updated_at'] ?? '-' }}</td>
                    <td>
                        <a
                            href="{{ route('products.edit', $product->id) }}"
                            class="btn btn-sm btn-warning"
                        >
                            Edit
                        </a>
                        <form
                            action="{{ route('products.delete', $product->id) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this product?')"
                            >
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
