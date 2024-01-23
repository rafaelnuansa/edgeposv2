@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Customer List</h5>

                <a href="{{ route('customers.create') }}" class="btn btn-success mt-3">Create Customer</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer Code</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                        <tr>
                            <td><span class="badge bg-primary">{{ $customer->customer_code }}</span></td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>
                                <a href="{{ route('customers.show', encrypt($customer->id)) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('customers.edit', encrypt($customer->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('customers.destroy', encrypt($customer->id)) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
