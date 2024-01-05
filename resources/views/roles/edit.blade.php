@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Role: {{ $role->name }}</h5>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm float-right">Back to Roles</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Role Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="permissions">Permissions:</label>
                            <select name="permissions[]" id="permissions" class="form-control" multiple required>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
