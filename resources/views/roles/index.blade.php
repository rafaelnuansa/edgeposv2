@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Role Management</h5>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Create Role</a>
                    </div>
                    <div class="card-body">
                        @if ($roles->isEmpty())
                            <p>No roles found.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge badge-primary">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
