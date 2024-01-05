@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add New Store</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('stores.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="branch_type">Branch Type</label>
                    <input type="text" class="form-control" id="branch_type" name="branch_type" required>
                </div>
                <div class="form-group mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                <div class="form-group mb-3">
                    <label for="taxable">Taxable</label>
                    <input type="checkbox" class="form-check-input" id="taxable" name="taxable" value="1">
                </div>
                <div class="form-group mb-3">
                    <label for="tax_id">Tax ID</label>
                    <input type="text" class="form-control" id="tax_id" name="tax_id">
                </div>
                <div class="form-group mb-3">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id">
                </div>
                <button type="submit" class="btn btn-primary">Add Store</button>
            </form>
        </div>
    </div>
</div>
@endsection
