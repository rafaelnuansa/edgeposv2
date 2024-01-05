@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Customer</h5>
            </div>
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $customer->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_code">Customer Code</label>
                        <input type="text" class="form-control" id="customer_code" name="customer_code"
                            value="{{ $customer->customer_code }}" required readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number">Phone Number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number"
                            value="{{ $customer->phone_number }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $customer->address }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $customer->city }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="postal_code">Postal Code</label>
                        <input type="number" class="form-control" id="postal_code" name="postal_code"
                            value="{{ $customer->postal_code }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="country_id">Country</label>
                        <select class="form-control" data-choices id="country_id" name="country_id">
                            <option value="" selected disabled>Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $customer->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="{{ $customer->dob }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="credit_limit">Credit Limit</label>
                        <input type="number" class="form-control" id="credit_limit" name="credit_limit"
                            value="{{ $customer->credit_limit }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-dark">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endpush
