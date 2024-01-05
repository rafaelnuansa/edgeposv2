@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title">Create New</h5>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('users.index') }}" class="btn btn-dark">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
