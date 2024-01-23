@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-8">

                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive table-responsive table-card">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Details</th>
                                        <th scope="col">Item Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-sm bg-light rounded p-1">
                                                        <img src="{{ $cartItem->product->image }}" alt=""
                                                            class="img-fluid d-block">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="fs-15"><a href="#" class="link-primary">
                                                                {{ $cartItem->product->name }}</a></h5>
                                                        <p class="text-muted mb-0"><span
                                                                class="fw-medium">{{ $cartItem->product->price }}</span></p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $cartItem->product->price }}</td>
                                            <td>{{ $cartItem->qty }}</td>

                                            <td>{{ $cartItem->product->price * $cartItem->qty }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-payment mt-2">

                            <form method="post" action="{{ route('sales.proceed') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="cash">Cash</label>
                                    <input type="text" name="cash" id="cash" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="payment_method">Payment Method</label>
                                    <div class="d-flex gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" checked>
                                            <label class="form-check-label" for="payment_cash">
                                                <span class="mdi mdi-cash"></span> Cash
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card">
                                            <label class="form-check-label" for="payment_card">
                                                <span class="mdi mdi-credit-card"></span> Card
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('sales.index') }}" class="btn btn-dark">Back to Sales</a>
                                <button type="submit" class="btn btn-primary">Proceed</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="sticky-side-div">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                        <div class="card-header bg-light-subtle border-bottom-dashed">
                            <div class="text-center">
                                <h6 class="mb-2">Have a <span class="fw-semibold">promo</span> code ?</h6>
                            </div>
                            <div class="hstack gap-3 px-3 mx-n3">
                                <input class="form-control me-auto" type="text" placeholder="Enter coupon code"
                                    aria-label="Add Promo Code here...">
                                <button type="button" class="btn btn-success w-xs">Apply</button>
                            </div>
                        </div>
                        <div class="card-body pt-2">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total :</td>
                                            <td class="text-end" id="cart-subtotal">BND {{ $totalAmount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount : </td>
                                            <td class="text-end" id="cart-discount">- BND 0</td>
                                        </tr>
                                        <tr class="table-active">
                                            <th>Total (BND) :</th>
                                            <td class="text-end">
                                                <span class="fw-semibold" id="cart-total">
                                                    {{ $totalAmount }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>

                    <div class="alert border-dashed alert-danger" role="alert">
                        <div class="d-flex align-items-center">
                            <lord-icon src="https://cdn.lordicon.com/nkmsrxys.json" trigger="loop"
                                colors="primary:#121331,secondary:#f06548" style="width:80px;height:80px"></lord-icon>
                            <div class="ms-2">
                                <h5 class="fs-14 text-danger fw-semibold"> Buying for a loved one?</h5>
                                <p class="text-body mb-1">Gift wrap and personalized message on card, <br>Only for <span
                                        class="fw-semibold">$9.99</span> USD </p>
                                <button type="button"
                                    class="btn ps-0 btn-sm btn-link text-danger text-uppercase shadow-none">Add Gift
                                    Wrap</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
