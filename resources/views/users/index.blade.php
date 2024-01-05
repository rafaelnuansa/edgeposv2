@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Users & Employee</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fa fa-user me-2"></i>Create
                            New</a>
                    </div>
                    <div class="table-responsive">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            On dev
                                        </td>
                                        <td>
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
