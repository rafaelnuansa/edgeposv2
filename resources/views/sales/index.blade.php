@extends('layouts.app')

@section('content')

<center><h1>On Progress</h1></center>

{{-- <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Point of Sale</h5>
            </div>
            <div class="card-body">
                <!-- Your POS form goes here -->
                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="category">Select Category:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product">Select Product:</label>
                        <select name="product" id="product" class="form-control">
                            <!-- Product options will be populated dynamically based on the selected category -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Complete Sale</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Display the list of selected products and their quantities -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Selected Products</h5>
            </div>
            <div class="card-body">
                <!-- Display the selected products and their quantities here -->
                <ul id="selected-products-list">
                    <!-- This list will be populated dynamically as products are added -->
                </ul>
            </div>
        </div>
    </div>
</div> --}}

<script>
    // Add JavaScript logic to dynamically update the product options based on the selected category
    document.getElementById('category').addEventListener('change', function () {
        var categoryId = this.value;
        var productSelect = document.getElementById('product');

        // Clear existing options
        productSelect.innerHTML = '<option value="">-- Select Product --</option>';

        // Fetch products based on the selected category and populate the options
        // You may need to use AJAX to fetch products dynamically from the server
        // and update the productSelect options accordingly
    });
</script>

@endsection
