@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit User</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT') <!-- Metode HTTP untuk pembaruan -->
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">New Password (Optional)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-dark">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
