@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1">List of Branches</h5>

                <div class="flex-shrink-0">
                    <a href="{{ route('branches.create') }}" class="btn btn-primary float-right">Add Branch</a>
                </div>
            </div>
            <div class="card-body">
                @if ($branches->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Address</th>
                                <th>Taxable</th>
                                <th>Tax ID</th>
                                <th>Manager</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->type }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td>{{ $branch->taxable ? 'Yes' : 'No' }}</td>
                                    <td>{{ $branch->tax_id }}</td>
                                    <td>{{ $branch->user->name }}</td>
                                    <td>

                                        <a href="{{ route('select.branch', ['branch' => Crypt::encrypt($branch->id)]) }}"
                                            class="btn btn-info btn-sm">Select Branch</a>

                                        <a href="{{ route('branches.show', ['branch' => Crypt::encrypt($branch->id)]) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('branches.edit', ['branch' => Crypt::encrypt($branch->id)]) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this branch?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No branches found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
