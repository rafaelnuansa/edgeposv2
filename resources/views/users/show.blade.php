@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            User Information
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Roles:</strong>
                @foreach($user->roles as $role)
                {{ $role->name }}
                @endforeach
            </p>
        </div>
    </div>
</div>
@endsection
