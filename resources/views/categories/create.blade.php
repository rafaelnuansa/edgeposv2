@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5>Create Category</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-dark">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
