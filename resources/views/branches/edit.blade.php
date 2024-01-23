@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Branch</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('branches.update', encrypt($branch->id)) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $branch->name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="type">Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="retail" {{ $branch->type == 'retail' ? 'selected' : '' }}>Retail</option>
                        <option value="resto" {{ $branch->type == 'resto' ? 'selected' : '' }}>Resto</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $branch->address }}">
                </div>
                <div class="form-group mb-3">
                    <label for="taxable">Taxable</label>
                    <input type="checkbox" class="form-check-input" id="taxable" name="taxable" value="1" {{ $branch->taxable ? 'checked' : '' }}>
                </div>
                <div class="form-group mb-3">
                    <label for="tax_id">Tax ID</label>
                    <input type="text" class="form-control" id="tax_id" name="tax_id" value="{{ $branch->tax_id }}">
                </div>
                <div class="form-group mb-3">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $branch->user_id }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Branch</button>
            </form>
        </div>
    </div>
</div>
@endsection
