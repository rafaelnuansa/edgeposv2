@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Transactions {{ $transaction->invoice }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Invoice</th>
                                <td><span class="badge bg-primary">{{ $transaction->invoice }} </span></td>
                            </tr>
                            <tr>
                                <th>Cash</th>
                                <td>${{ number_format($transaction->cash, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Change</th>
                                <td>${{ number_format($transaction->change, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>${{ number_format($transaction->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>${{ number_format($transaction->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Remaining Amount</th>
                                <td>${{ number_format($transaction->remaining_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-success">{{ $transaction->status }}</span></td>
                            </tr>
                            <tr>
                                <th>Cashier</th>
                                <td><span class="badge bg-dark">{{ $transaction->cashier->name }}</span></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><span class="badge bg-dark">{{ $transaction->created_at }}</span></td>
                            </tr>
                            <tr>
                                <th>Products</th>
                                <td>
                                    <ul>
                                        @foreach($transaction->details as $detail)
                                            <li>
                                                {{ $detail->product->name }} ${{ $detail->product->price}}
                                                <br> (Quantity: {{ $detail->qty }}) - ${{ $detail->price }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn btn-primary">Back to Transactions</a>
        </div>
    </div>
@endsection
