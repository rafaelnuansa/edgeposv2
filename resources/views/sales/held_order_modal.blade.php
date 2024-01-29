<!-- resources/views/sales/held_order_modal.blade.php -->

<div class="modal fade" id="heldOrdersModal" tabindex="-1" role="dialog" aria-labelledby="heldOrdersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="heldOrdersModalLabel">Held Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display a table of held orders here -->
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Orders</th>
                            <th>Customers</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heldOrders as $heldOrder)
                            <tr>
                                <td>{{ $heldOrder->hold_name ?? 'Helds order' }}</td>
                                <td>{{ $heldOrder->customer->name ?? 'General' }}</td>
                                <td>{{ $heldOrder->created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-icon btn-sm"><i class="bx bx-left-arrow-circle"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No held orders available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
