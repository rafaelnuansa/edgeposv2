@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ul class="nav nav-pills mb-4">
            @foreach ($categories as $category)
                <li class="nav-item">
                    <a class="btn btn-danger text-white" href="#">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Price: {{ $product->price }}</p>
                                    {{-- Add to Cart Form --}}
                                    <form action="{{ route('sales.add_to_cart', ['productId' => $product->id]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-light w-100">Add to Cart</button>
                                    </form>
                                    {{-- End Add to Cart Form --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">

                                <a href="#" class="btn btn-success w-100">Add Customers</a>
                            </div>

                            <div class="col-md-6">
                                <a href="#" class="btn btn-primary w-100">Refresh</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $cartItem)
                                            <tr>
                                                <td>{{ $cartItem->product->name }}</td>
                                                <td>{{ $cartItem->qty }}</td>
                                                <td>{{ $cartItem->price * $cartItem->qty }}</td>
                                                <td>
                                                    {{-- Cancel Item Form --}}
                                                    <form action="{{ route('sales.cancel_item', ['cartItemId' => $cartItem->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="mdi mdi-delete"></i> <!-- Bootstrap trash icon -->
                                                        </button>
                                                    </form>
                                                    {{-- End Cancel Item Form --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6"> <a href="#" class="btn btn-dark w-100">Hold Order </a></div>
                    <div class="col-lg-6"> <a href="{{ route('sales.charge')}}" class="btn btn-danger w-100">Proceed </a></div>
                </div>
            </div>
        </div>

    </div>
@endsection
