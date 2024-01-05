@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">List of Stores</h5>
            <a href="{{ route('stores.create') }}" class="btn btn-primary float-right">Add Store</a>
        </div>
        <div class="card-body">
            @if($stores->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Branch Type</th>
                            <th>Address</th>
                            <th>Taxable</th>
                            <th>Tax ID</th>
                            <th>User ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stores as $store)
                            <tr>
                                <td>{{ $store->id }}</td>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->branch_type }}</td>
                                <td>{{ $store->address }}</td>
                                <td>{{ $store->taxable ? 'Yes' : 'No' }}</td>
                                <td>{{ $store->tax_id }}</td>
                                <td>{{ $store->user_id }}</td>
                                <td>
                                    <a href="{{ route('stores.show', $store->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this store?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No stores found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
