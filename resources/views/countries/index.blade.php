@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Country List</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $country)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $country->code }}</td>
                                        <td>{{ $country->name }}</td>
                                        {{-- <td>
                                            <a href="{{ route('countries.show', $country->id) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                            <a href="{{ route('countries.edit', $country->id) }}"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="{{ route('countries.destroy', $country->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this country?')">Delete</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $countries->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
