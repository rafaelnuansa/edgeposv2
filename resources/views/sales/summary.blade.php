@extends('layouts.app')

@section('content')
    <div class="row ">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-lg-2">
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                            <div class="col-md-3 col-lg-2" id="customTime">
                                <label for="start_time">Start Time:</label>
                                <input type="time" id="start_time" name="start_time" class="form-control">
                            </div>
                            <div class="col-md-3 col-lg-2" id="customTime">
                                <label for="end_time">End Time:</label>
                                <input type="time" id="end_time" name="end_time" class="form-control">
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="customer">Customer:</label>
                                <select data-choices id="customer" name="customer" class="form-control">
                                    <option value="all">All </option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="cashier">Cashier:</label>
                                <select   data-choices id="cashier" name="cashier" class="form-control">
                                    <option value="all">All</option>
                                    @foreach ($cashiers as $cashier)
                                    <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <button type="submit" class="btn btn-primary mt-4 btn-block">Apply Filter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5>Sales Chart</h5>
                </div>
                <div class="card-body">
                    {{-- Donut Percentage Chart  --}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sales Summary</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Cashier</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $transaction->invoice }}</span></td>
                                    <td>{{ $transaction->cashier->name }}</td>
                                    <td>{{ $transaction->customer ? $transaction->customer->name : 'N/A' }}</td>
                                    <td>{{ $transaction->total_amount }}</td>
                                    <td><span class="badge bg-success">{{ $transaction->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endpush

