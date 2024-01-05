@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales by Category</h3>
                </div>
                <div class="card-body">
                    @if(count($salesByCategory) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesByCategory as $sales)
                                    <tr>
                                        <td>{{ $sales->category_name }}</td>
                                        <td>{{ $sales->total_sold }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No sales data available by category.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
