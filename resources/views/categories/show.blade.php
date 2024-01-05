@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Category Details</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name"><strong>Name:</strong></label>
                    <p>{{ $category->name }}</p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
