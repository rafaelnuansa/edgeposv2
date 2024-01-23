

<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="customerModalLabel">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                {{-- <span aria-hidden="true">&times;</span> --}}
            </button>
        </div>
        <div class="modal-body">
            <!-- Form for adding a new customer -->
            <form action="{{ route('sales.add_customer') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="new_customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="new_customer_name" name="new_customer_name"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Customer</button>
            </form>
        </div>
    </div>
</div>
</div>
