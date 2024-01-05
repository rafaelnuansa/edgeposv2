@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Add New Branch</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('branches.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="type">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="retail" {{ old('type') == 'retail' ? 'selected' : '' }}>Retail</option>
                        <option value="resto" {{ old('type') == 'resto' ? 'selected' : '' }}>Resto</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                <button type="submit" class="btn btn-primary">Add Branch</button>
            </form>
        </div>
    </div>
</div>
@endsection
