@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Customer Details</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ $customer->first_name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ $customer->last_name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="customer_code">Customer Code</label>
                    <input type="text" class="form-control" id="customer_code" name="customer_code"
                        value="{{ $customer->customer_code }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $customer->email }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        value="{{ $customer->phone_number }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address"
                        value="{{ $customer->address }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="{{ $customer->city }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                        value="{{ $customer->postal_code }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="country_id">Country</label>
                    <input type="text" class="form-control" id="country_id" name="country_id"
                        value="{{ $customer->country->name ?? '' }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="dob">Date of Birth</label>
                    <input type="text" class="form-control" id="dob" name="dob"
                        value="{{ $customer->dob }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="credit_limit">Credit Limit</label>
                    <input type="text" class="form-control" id="credit_limit" name="credit_limit"
                        value="{{ $customer->credit_limit }}" readonly>
                </div>
                <a href="{{ route('customers.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
