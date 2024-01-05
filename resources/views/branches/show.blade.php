@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Branch Details</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID:</dt>
                <dd class="col-sm-9">{{ $branch->id }}</dd>

                <dt class="col-sm-3">Name:</dt>
                <dd class="col-sm-9">{{ $branch->name }}</dd>

                <dt class="col-sm-3">Type:</dt>
                <dd class="col-sm-9">{{ $branch->type }}</dd>

                <dt class="col-sm-3">Address:</dt>
                <dd class="col-sm-9">{{ $branch->address }}</dd>

                <dt class="col-sm-3">Taxable:</dt>
                <dd class="col-sm-9">{{ $branch->taxable ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-3">Tax ID:</dt>
                <dd class="col-sm-9">{{ $branch->tax_id }}</dd>

                <dt class="col-sm-3">User ID:</dt>
                <dd class="col-sm-9">{{ $branch->user_id }}</dd>

                <dt class="col-sm-3">Created At:</dt>
                <dd class="col-sm-9">{{ $branch->created_at }}</dd>

                <dt class="col-sm-3">Updated At:</dt>
                <dd class="col-sm-9">{{ $branch->updated_at }}</dd>
            </dl>
            <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this branch?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
