@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Store Details</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID:</dt>
                <dd class="col-sm-9">{{ $store->id }}</dd>

                <dt class="col-sm-3">Name:</dt>
                <dd class="col-sm-9">{{ $store->name }}</dd>

                <dt class="col-sm-3">Branch Type:</dt>
                <dd class="col-sm-9">{{ $store->branch_type }}</dd>

                <dt class="col-sm-3">Address:</dt>
                <dd class="col-sm-9">{{ $store->address }}</dd>

                <dt class="col-sm-3">Taxable:</dt>
                <dd class="col-sm-9">{{ $store->taxable ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-3">Tax ID:</dt>
                <dd class="col-sm-9">{{ $store->tax_id }}</dd>

                <dt class="col-sm-3">User ID:</dt>
                <dd class="col-sm-9">{{ $store->user_id }}</dd>

                <dt class="col-sm-3">Created At:</dt>
                <dd class="col-sm-9">{{ $store->created_at }}</dd>

                <dt class="col-sm-3">Updated At:</dt>
                <dd class="col-sm-9">{{ $store->updated_at }}</dd>
            </dl>
            <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this store?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
