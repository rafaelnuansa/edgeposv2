@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="card-title">

                    <h5>Sales</h5>

                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Payment Method</th>
                                <th>Paid</th>
                                <th>Change</th>
                                <th>Discount</th>
                                <th>Total Amount</th>
                                <th>Remaining</th>
                                <th>Status</th>
                                <th>Cashier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>

                                    <td><span class="badge bg-dark">{{ $transaction->created_at }}</span></td>
                                    <td><span class="badge bg-primary">{{ $transaction->invoice }}</span></td>
                                    <td><span class="badge bg-primary">{{ $transaction->payment_method }}</span></td>
                                    <td>${{ number_format($transaction->cash, 2) }}</td>
                                    <td>${{ number_format($transaction->change, 2) }}</td>
                                    <td>${{ number_format($transaction->discount, 2) }}</td>
                                    <td>${{ number_format($transaction->total_amount, 2) }}</td>
                                    <td>${{ number_format($transaction->remaining_amount, 2) }}</td>
                                    <td><span class="badge bg-success text-uppercase">{{ $transaction->status }}</span></td>
                                    <td><span class="badge bg-dark">{{ $transaction->cashier->name }}</span></td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
