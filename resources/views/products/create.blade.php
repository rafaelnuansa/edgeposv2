@extends('layouts.app')

@section('content')
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">Product Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode"
                                value="{{ old('barcode') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="category_id">Category</label>
                            <select data-choices class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id" required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Price Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cost">Cost</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost"
                                name="cost" value="{{ old('cost') }}" required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Product Stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                                name="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Create Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
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
                            <label for="image">Gambar Produk</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endpush
