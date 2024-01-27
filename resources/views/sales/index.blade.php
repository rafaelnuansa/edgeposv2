@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" placeholder="Search Product" aria-label="Search" id="search"
                                        aria-describedby="search" class="form-control rounded-right"> <!---->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown keep-inside-clicks-open w-100 product-category-filter show"><button
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                        class="btn w-100 btn-outline-dark dropdown-toggle d-flex justify-content-between align-items-center">
                                        Category
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right p-2">
                                        <div class="category-options-wrapper custom-scrollbar ">
                                            <div class="row" id="category-options-container">
                                                <!-- Kategori akan dimasukkan di sini oleh JavaScript -->
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-between align-items-center filter-footer">
                                            <a href="#" class="btn btn-sm btn-danger"
                                                onclick="clearFilters()">Clear</a>
                                            <button class="btn btn-dark btn-sm" onclick="applyFilters()">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="products-container"></div>
        </div>
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-9">
                            <div class="input-group">
                                <input type="text" placeholder="Search Customers" aria-label="Search"
                                    aria-describedby="search" class="form-control pr-4 rounded w-100">
                                <div class="dropdown-menu dropdown-menu-right w-100">
                                    <div class="px-3 py-1 text-center">
                                        No result found
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right w-100">
                                    <div class="px-3 py-1 text-center">
                                        No result found
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3"><span>
                                <a data-bs-toggle="modal" data-bs-target="#addCustomerModal" href="#"
                                    class="btn btn-dark btn-icon"><i class="la la-user-plus"></i></a></span></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table" id="cart-table">

                                <tbody id="cart-items-container"></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="cart-section-3" class="text-sm product-card-font">
                        <div class="row mx-0 px-3 py-2 font-weight-bold border-top border-bottom">
                            <div class="col-6 p-0">
                                Sub Total
                            </div>
                            <div class="col-6 p-0 text-right">
                                0
                            </div>
                        </div>

                        <div id="pop_mouse1" class="row mx-0 px-3 py-2  border-bottom">
                            <div class="col-6 p-0">
                                Discount on all items (%)

                            </div>
                            <div class="col-3 p-0 text-center">
                                <div role="group" class="btn-group dropright"></div>
                            </div>
                            <div class="col-3 p-0 text-right">
                                <span><i class="la la-edit discount-all-item-popover"></i>

                                </span>
                            </div>
                        </div>
                        <div id="pop_mouse2" class="row mx-0 px-3 py-2">
                            <div class="col-6 p-0">
                                Discount on subtotal
                            </div>
                            <div class="col-3 p-0 text-center">
                                <div role="group" class="btn-group dropright"><!----></div>
                            </div>
                            <div class="col-3 p-0 text-right"><span><i class="la la-edit discount-on-subtotal-popover"></i>
                                </span></div>
                        </div> <!---->
                        <div class="row mx-0 px-3 py-2 border-top border-bottom">
                            <div class="col-6 p-0"><span class="font-weight-bold">
                                    Total
                                </span> <span><span>( Tax</span> <span>Excluded )</span></span></div>
                            <div class="col-3 p-0 text-center">
                                <div role="group" class="btn-group dropright"></div>
                            </div>
                            <div class="col-3 p-0 text-right"><span><a data-toggle="modal" data-target="#tax-edit-modal"
                                        href="#" class=""><i
                                            class="la la-edit discount-all-item-popover"></i></a></span> <span
                                    class="col-6 p-0 font-weight-bold text-right">

                                </span></div>
                        </div>
                        <div class="row mx-0 px-3 py-2 font-weight-bold border-bottom">
                            <div class="col-4 p-0 custom-line-height">
                                Order Type
                            </div>
                            <div class="col-8 p-0 text-right">
                                <button class="btn btn-dark mr-2 btn-sm selected-btn-dark"><i class="la la-cutlery"></i>
                                    Dine In
                                </button>
                                <button class="btn btn-dark btn-sm"><i class="la la-shopping-cart"></i>
                                    Take Away
                                </button>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <a href="{{ route('sales.charge') }}" class="btn btn-dark w-100">
                                Place Order
                            </a>
                        </div>
                        <div class="row mx-0">
                            <a href="#" class="col-4 p-0 text-center border-right hold-items disabled">
                                <i class="la la-recycle la-2x p-2 app-color-text hold-icon"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#holdModal"
                                class="col-4 p-0 text-center border-right hold-cart"><i
                                    class="la la-pause la-2x p-2 text-warning"></i></a>
                            <a href="#" data-toggle="modal" data-target="#clear-cart-modal"
                                class="col-4 p-0 text-center clear-cart"><i
                                    class="la la-times-circle la-2x p-2 text-danger"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('sales.hold_modal')
    @include('sales.add_customer_modal')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @push('scripts')
        <script>
            function fetchProductsAndCategories(searchQuery, selectedCategories) {
                var params = {
                    search: searchQuery,
                    categories: selectedCategories
                };

                axios.get('/fetchProductsAndCategories', {
                        params: params
                    })
                    .then(response => {
                        if (response.data.error) {
                            console.error(response.data.error);
                        } else {
                            updateProductsUI(response.data.products);
                            updateCategoriesUI(response.data.categories);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function updateProductsUI(products) {
                var productsContainer = document.getElementById('products-container');
                productsContainer.innerHTML = '';

                products.forEach(product => {
                    var productCard = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="${product.image}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">Price: ${product.price}</p>
                                    <button class="btn btn-dark w-100" onclick="addToCart(${product.id})">Add to Cart</button>
                                </div>
                            </div>
                        </div>`;
                    productsContainer.innerHTML += productCard;
                });
            }

            function updateCategoriesUI(categories) {
                var categoriesContainer = document.getElementById('category-options-container');

                if (!categoriesContainer) {
                    console.error("Element with id 'category-options-container' not found.");
                    return;
                }

                categoriesContainer.innerHTML = '';

                categories.forEach(category => {
                    var categoryCheckbox = `
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="product-category${category.id}" class="custom-control-input category-checkbox" value="${category.id}">
                    <label for="product-category${category.id}" class="custom-control-label">${category.name}</label>
                </div>
            </div>`;
                    categoriesContainer.innerHTML += categoryCheckbox;
                });
            }

            function clearFilters() {
                var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
                categoryCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                fetchProductsAndCategories(document.getElementById('search').value, []);
            }

            function applyFilters() {
                var searchQuery = document.getElementById('search').value;
                var selectedCategories = getSelectedCategories();

                fetchProductsAndCategories(searchQuery, selectedCategories);
                updateSelectedCategoriesUI(selectedCategories);
            }

            function updateSelectedCategoriesUI(selectedCategories) {
                var selectedCategoriesContainer = document.getElementById('selected-categories-container');

                // Clear previous content
                while (selectedCategoriesContainer.firstChild) {
                    selectedCategoriesContainer.removeChild(selectedCategoriesContainer.firstChild);
                }

                selectedCategories.forEach(categoryId => {
                    // Fetch category name based on categoryId (you may need to adjust this based on your data structure)
                    var categoryName = getCategoryNameById(categoryId);

                    var selectedCategoryBadge = document.createElement('span');
                    selectedCategoryBadge.className = 'badge badge-pill badge-info';
                    selectedCategoryBadge.textContent = categoryName;

                    selectedCategoriesContainer.appendChild(selectedCategoryBadge);
                });
            }

            function getCategoryNameById(categoryId) {
                // You need to fetch the category name based on the categoryId from your data
                // Replace this with your actual implementation
                // For example, if your categories are stored in an array, you can do something like:
                // var category = categories.find(category => category.id === categoryId);
                // return category ? category.name : '';
                return "Category " + categoryId;
            }


            document.getElementById('search').addEventListener('input', function() {
                fetchProductsAndCategories(this.value, getSelectedCategories());
            });

            var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            categoryCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    filterProductsByCategory(this.value);
                });
            });

            function getSelectedCategories() {
                return Array.from(categoryCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
            }

            function filterProductsByCategory(categoryId) {
                fetchProductsAndCategories(document.getElementById('search').value, getSelectedCategories());
            }

            fetchProductsAndCategories('', []);


            function updateProductsUI(products) {
                var productsContainer = document.getElementById('products-container');
                productsContainer.innerHTML = '';

                products.forEach(product => {
                    var productCard = `
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="${product.image}" class="card-img-top" alt="${product.name}">
          <div class="card-body">
            <h5 class="card-title">${product.name}</h5>
            <p class="card-text">Price: ${product.price}</p>
            <button class="btn btn-dark w-100" onclick="addToCart(${product.id})">Add to Cart</button>
          </div>
        </div>
      </div>`;
                    productsContainer.innerHTML += productCard;
                });
            }

            function addToCart(productId) {
                axios.get(`/sales/add_to_cart/${productId}`)
                    .then(response => {
                        if (response.data.success) {
                            console.log('Product added to cart successfully');
                            fetchCart();
                        } else {
                            console.error(response.data.error);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function fetchCart() {
                axios.get('/fetchCart')
                    .then(response => {
                        if (response.data.cartItems) {
                            updateCartUI(response.data.cartItems);
                            console.log('Fetched cart:', response.data.cartItems);
                        } else {
                            console.error('Failed to fetch cart:', response.data.error);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function updateCartUI(cartItems) {
                var cartItemsContainer = document.getElementById('cart-items-container');
                cartItemsContainer.innerHTML = '';

                if (cartItems.length === 0) {
                    var emptyCartMessage = `
            <tr>
                <td colspan="4" class="text-center">Empty Cart</td>
            </tr>`;
                    cartItemsContainer.innerHTML = emptyCartMessage;
                } else {
                    cartItems.forEach(cartItem => {
                        var cartRow = `
                <tr>
                    <td>${cartItem.product.name}</td>
                    <td>${cartItem.qty}</td>
                    <td>${cartItem.price * cartItem.qty}</td>
                    <td>
                        <a onclick="cancelItem(${cartItem.id})">
                            <i class="la la-trash del-icon-color"></i>
                        </a>
                    </td>
                </tr>`;
                        cartItemsContainer.innerHTML += cartRow;
                    });
                }
            }

            function cancelItem(cartItemId) {
                const token = document.head.querySelector('meta[name="csrf-token"]').content;

                axios.delete(`/sales/cancel_item/${cartItemId}`, {
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(response => {
                        if (response.data.status === 'success') {
                            fetchCart();
                        } else {
                            console.error('Failed to cancel item:', response.data.error);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            fetchProductsAndCategories();
            fetchCart();
        </script>
    @endpush
@endsection
