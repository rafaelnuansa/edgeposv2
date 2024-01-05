@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Category</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('categories.update', $category->id) }}">
                    @csrf
                    @method('PUT') <!-- Metode HTTP untuk pembaruan -->
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-dark">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
