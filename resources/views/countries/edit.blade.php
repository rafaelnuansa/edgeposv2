@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Country</div>

            <div class="card-body">
                <form method="POST" action="{{ route('countries.update', $country->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="code">Country Code:</label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $country->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Country Name:</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $country->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
