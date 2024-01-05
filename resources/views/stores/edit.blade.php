@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Store</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('stores.update', $store->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $store->name }}" required>
                </div>
                <div class="form-group">
                    <label for="branch_type">Branch Type</label>
                    <input type="text" class="form-control" id="branch_type" name="branch_type" value="{{ $store->branch_type }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $store->address }}">
                </div>
                <div class="form-group">
                    <label for="taxable">Taxable</label>
                    <input type="checkbox" class="form-check-input" id="taxable" name="taxable" value="1" {{ $store->taxable ? 'checked' : '' }}>
                </div>
                <div class="form-group">
                    <label for="tax_id">Tax ID</label>
                    <input type="text" class="form-control" id="tax_id" name="tax_id" value="{{ $store->tax_id }}">
                </div>
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $store->user_id }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Store</button>
            </form>
        </div>
    </div>
</div>
@endsection
