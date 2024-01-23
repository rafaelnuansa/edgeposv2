<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1">Products</h5>

                <div class="flex-shrink-0">
                    <a href="{{ route('products.create') }}" class="btn btn-primary float-right">Create New Product</a>
                </div>
            </div>
            <div class="card-body">
                <div class="tables">
                    <table class="table" id="products-table">
                        <thead>
                            <tr>
                                {{-- <th>No</th> --}}
                                <th>Name</th>
                                <th>Category</th>
                                <th>Code</th>
                                <th>Sell Price</th>
                                <th>Cost</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{!! route('products.index') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'name', name: 'name' },
                    { data: 'code', name: 'code' },
                    { data: 'price', name: 'price' },
                    { data: 'cost', name: 'cost' },
                    { data: 'stock', name: 'stock' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
