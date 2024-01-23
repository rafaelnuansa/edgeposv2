   <!-- Hold Modal -->
   <div class="modal fade" id="holdModal" tabindex="-1" role="dialog" aria-labelledby="holdModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="holdModalLabel">Hold Order</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                   {{-- <span aria-hidden="true">&times;</span> --}}
               </button>
           </div>
           <div class="modal-body">
               <form action="{{ route('sales.hold_cart') }}" method="POST">
                   @csrf
                   <div class="form-group mb-3">
                       <label for="hold_name">Hold Name (Optional)</label>
                       <input type="text" class="form-control" id="hold_name" name="hold_name">
                   </div>
                   <div class="form-group mb-3">
                       <label for="customer_id">Customer</label>
                       <select class="form-control" id="customer_id" name="customer_id">
                           <option value="">Select Customer (Optional)</option>
                           @foreach ($customers as $customer)
                               <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                           @endforeach
                       </select>
                       <!-- Tombol untuk menampilkan modal tambah pelanggan baru -->



                   </div>
                   <button type="submit" class="btn btn-dark w-100">Hold Order</button>
               </form>
           </div>
       </div>
   </div>
</div>
