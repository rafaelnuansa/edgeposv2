@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Held Orders</h2>

        @if ($heldOrders->isEmpty())
            <p>No held orders available.</p>
        @else
            <ul>
                @foreach ($heldOrders as $heldOrder)
                    <li>
                        <strong>Hold Name:</strong> {{ $heldOrder->hold_name ?? 'N/A' }} |
                        <strong>Customer:</strong> {{ $heldOrder->customer ? $heldOrder->customer->name : 'N/A' }} |
                        <a href="{{ route('sales.held_order_items', ['holdId' => $heldOrder->id]) }}">View Items</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
