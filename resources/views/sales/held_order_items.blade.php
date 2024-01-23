@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Held Order Items</h2>

        <p><strong>Hold Name:</strong> {{ $heldOrder->hold_name ?? 'N/A' }}</p>
        <p><strong>Customer:</strong> {{ $heldOrder->customer ? $heldOrder->customer->name : 'N/A' }}</p>
        @if ($heldItems->isEmpty())
            <p>No held order items available.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($heldItems as $heldItem)
                        <tr>
                            <td>{{ $heldItem->product->name ?? 'No'}}</td>
                            <td>{{ $heldItem->qty }}</td>
                            <td>{{ $heldItem->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('sales.held_orders') }}" class="btn btn-primary">Back to Held Orders</a>
    </div>
@endsection
