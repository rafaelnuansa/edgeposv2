@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Country Details</div>

                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $country->id }}</td>
                            </tr>
                            <tr>
                                <th>Country Code</th>
                                <td>{{ $country->code }}</td>
                            </tr>
                            <tr>
                                <th>Country Name</th>
                                <td>{{ $country->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
