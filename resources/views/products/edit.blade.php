@extends('layouts.app')

@section('content')
{{-- @dd($product) --}}
    <form method="POST" action="{{ route('products.update', encrypt($product->id)) }}" enctype="multipart/form-data">

        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Product</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">Product Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code', $product->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode"
                                value="{{ old('barcode', $product->barcode) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="category_id">Category</label>
                            <select data-choices class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cost">Cost</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost"
                                name="cost" value="{{ old('cost', $product->cost) }}" required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                                name="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Product Image</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="image">Product Image</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($product->image)
                            <img class="img-fluid" src="{{ $product->image }}" alt="{{ $product->name }}" />
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endpush
