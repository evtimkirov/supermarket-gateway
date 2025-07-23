@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col">
            <h1>New product</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Product name <sup>*</sup></label>
                    <select name="name" id="name" class="form-select" required>
                        <option value="">Select a letter</option>
                        @foreach(range('A', 'Z') as $letter)
                            <option value="{{ $letter }}" {{ old('name') == $letter ? 'selected' : '' }}>
                                {{ $letter }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price <sup>*</sup></label>
                    <input
                        type="text"
                        class="form-control"
                        id="price"
                        name="price"
                        value="{{ old('price') }}"
                        required
                    >
                </div>

                <h5>Promotion <small>(optional)</small></h5>
                <hr/>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Count</label>
                        <input
                            type="number"
                            name="promotion[quantity]"
                            class="form-control"
                            min="0"
                            value="{{ old('promotion.quantity') }}"
                        >
                    </div>
                    <div class="col">
                        <label class="form-label">Total</label>
                        <input
                            type="text"
                            name="promotion[total]"
                            class="form-control"
                            value="{{ old('promotion.total') }}"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save product</button>
            </form>
        </div>
    </div>
@endsection
