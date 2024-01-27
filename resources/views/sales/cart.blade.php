<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">

                    <select class="form-control" id="customer_id" name="customer_id">
                        <option value="">Select Customer (Optional)</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <!-- Tombol untuk menampilkan modal tambah pelanggan baru -->
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                        data-bs-target="#addCustomerModal">
                        Add New Customer
                    </button>
                    <a href="#" class="btn btn-success w-100">Select Customers</a>
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
                                            <button type="submit" class="btn btn-icon btn-sm">
                                                <i class="ri-close-fill fs-16"></i>
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
        <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#holdModal">
            Hold Order
        </button>
        <div class="col-lg-6">
            <a href="{{ route('sales.charge') }}" class="btn btn-danger w-100">Proceed</a>
        </div>
    </div>
</div>
