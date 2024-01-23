<!-- resources/views/printers/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Printers
            </div>
            <div class="card-body">

                <a href="{{ route('printers.create') }}" class="btn btn-primary">Add Printer</a>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($printers as $printer)
                            <tr>
                                <td>{{ $printer->name }}</td>
                                <td>{{ $printer->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('printers.show', $printer->id) }}"
                                        class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('printers.edit', $printer->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('printers.destroy', $printer->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No printers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
