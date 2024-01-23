@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order #{{ $transaction->invoice }}</h5>
                        <div class="flex-shrink-0">
                            <a href="apps-invoices-details.html" class="btn btn-success btn-sm"><i
                                    class="ri-download-2-fill align-middle me-1"></i> Invoice</a>

                                    <a href="{{ route('transactions.print', ['id' => $transaction->id]) }}" class="btn btn-primary">
                                        <i class="mdi mdi-printer align-middle me-1"></i> Print Receipt
                                    </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Product Details</th>
                                    <th scope="col">Item Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col" class="text-end">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->details as $detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $detail->product->image }}" alt=""
                                                        class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15"><a href="#" class="link-primary">
                                                            {{ $detail->product->name }}</a></h5>
                                                    {{-- <p class="text-muted mb-0">Color: <span class="fw-medium">Pink</span></p>
                                            <p class="text-muted mb-0">Size: <span class="fw-medium">M</span></p> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $detail->price }}</td>
                                        <td>{{ $detail->qty }}</td>

                                        <td class="fw-medium text-end">
                                            {{ $detail->qty * $detail->price }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="border-top border-top-dashed">
                                    <td colspan="3"></td>
                                    <td colspan="2" class="fw-medium p-0">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <td><span class="badge bg-primary">{{ $transaction->invoice }} </span>
                                                    </td>
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
                                                    <th>Status</th>
                                                    <td><span class="badge bg-success">{{ $transaction->status }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Cashier</th>
                                                    <td><span
                                                            class="badge bg-dark">{{ $transaction->cashier->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td><span class="badge bg-dark">{{ $transaction->created_at }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td class="text-end">$359.96</td>
                                                </tr>
                                                <tr>
                                                    <td>Discount <span class="text-muted">(VELZON15)</span> : :</td>
                                                    <td class="text-end">-$53.99</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charge :</td>
                                                    <td class="text-end">$65.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Estimated Tax :</td>
                                                    <td class="text-end">$44.99</td>
                                                </tr>
                                                <tr class="border-top border-top-dashed">
                                                    <th scope="row">Total (USD) :</th>
                                                    <th class="text-end">$415.96</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->

        </div>
        <!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i
                                class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> Logistics Details</h5>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary fs-11">Track Order</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop"
                            colors="primary:#4b38b3,secondary:#0ab39c" style="width:80px;height:80px"></lord-icon>
                        <h5 class="fs-16 mt-2">RQK Logistics</h5>
                        <p class="text-muted mb-0">ID: MFDS1400457854</p>
                        <p class="text-muted mb-0">Payment Mode : Debit Card</p>
                    </div>
                </div>
            </div>
            <!--end card-->

        </div>
        <!--end col-->
    </div>


@endsection
