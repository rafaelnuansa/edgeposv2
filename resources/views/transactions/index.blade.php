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

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Transactions</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Export</button>
                                <button class="btn btn-soft-danger" id="remove-actions" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search for order ID, customer, order status or something...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input type="text" class="form-control flatpickr-input" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Select date" readonly="readonly">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control choices__input" data-choices="" data-choices-search-false="" name="choices-single-default" id="idStatus" hidden="" tabindex="-1" data-choice="active"><option value="all" data-custom-properties="[object Object]">All</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="all" data-custom-properties="[object Object]" aria-selected="true">All</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--idStatus-item-choice-8" class="choices__item choices__item--choice choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="8" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Status</div><div id="choices--idStatus-item-choice-1" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="1" data-value="all" data-select-text="Press to select" data-choice-selectable="">All</div><div id="choices--idStatus-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Cancelled" data-select-text="Press to select" data-choice-selectable="">Cancelled</div><div id="choices--idStatus-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Delivered" data-select-text="Press to select" data-choice-selectable="">Delivered</div><div id="choices--idStatus-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Inprogress" data-select-text="Press to select" data-choice-selectable="">Inprogress</div><div id="choices--idStatus-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="Pending" data-select-text="Press to select" data-choice-selectable="">Pending</div><div id="choices--idStatus-item-choice-6" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="6" data-value="Pickups" data-select-text="Press to select" data-choice-selectable="">Pickups</div><div id="choices--idStatus-item-choice-7" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="7" data-value="Returns" data-select-text="Press to select" data-choice-selectable="">Returns</div></div></div></div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control choices__input" data-choices="" data-choices-search-false="" name="choices-single-default" id="idPayment" hidden="" tabindex="-1" data-choice="active"><option value="all" data-custom-properties="[object Object]">All</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="all" data-custom-properties="[object Object]" aria-selected="true">All</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--idPayment-item-choice-5" class="choices__item choices__item--choice choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="5" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Select Payment</div><div id="choices--idPayment-item-choice-1" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="1" data-value="all" data-select-text="Press to select" data-choice-selectable="">All</div><div id="choices--idPayment-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="COD" data-select-text="Press to select" data-choice-selectable="">COD</div><div id="choices--idPayment-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Mastercard" data-select-text="Press to select" data-choice-selectable="">Mastercard</div><div id="choices--idPayment-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Paypal" data-select-text="Press to select" data-choice-selectable="">Paypal</div><div id="choices--idPayment-item-choice-6" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="6" data-value="Visa" data-select-text="Press to select" data-choice-selectable="">Visa</div></div></div></div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1" role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> All Orders
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Delivered" href="#delivered" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Delivered
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link py-3 Pickups" data-bs-toggle="tab" id="Pickups" href="#pickups" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-truck-line me-1 align-bottom"></i> Pickups <span class="badge bg-danger align-middle ms-1">2</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="Returns" href="#returns" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Returns
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Cancelled" href="#cancelled" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Cancelled
                                </a>
                            </li>
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>Invoice</th>
                                        <th>Method</th>
                                        <th>Paid</th>
                                        <th>Change</th>
                                        <th>Discount</th>
                                        <th>Total Amount</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Cashier</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all"><tr>
                                    @foreach ($transactions as $transaction)
                                    <tr>

                                        <td>{{ $transaction->invoice }}</td>
                                        <td><span class="badge bg-primary text-uppercase">{{ $transaction->payment_method }}</span></td>
                                        <td>${{ number_format($transaction->cash, 2) }}</td>
                                        <td>${{ number_format($transaction->change, 2) }}</td>
                                        <td>${{ number_format($transaction->discount, 2) }}</td>
                                        <td>${{ number_format($transaction->total_amount, 2) }}</td>
                                        <td>${{ number_format($transaction->remaining_amount, 2) }}</td>
                                        <td>
                                            @if($transaction->status == 'paid')
                                                <span class="badge bg-success text-uppercase">{{ $transaction->status }}</span>
                                            @elseif($transaction->status == 'unpaid')
                                                <span class="badge bg-primary text-uppercase">{{ $transaction->status }}</span>
                                            @endif
                                        </td>

                                        <td><span class="badge bg-dark">{{ $transaction->cashier->name }}</span></td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

        </div>
        <!--end col-->
    </div>
@endsection
