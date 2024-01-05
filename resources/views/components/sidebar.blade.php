<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('logo.png')}}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('logo.png')}}" alt="" height="40">
                {{-- <h3 class="mt-3 mb-3"><i class="bx bx-shopping-bag"></i> Edge POS</h3> --}}
            </span>
            <span class="logo-sm">
                <h3><i class="bx bx-shopping-bag"></i></h3>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">

            <span class="logo-sm">
                <h3><i class="bx bx-shopping-bag"></i></h3>
            </span>
            <span class="logo-lg">
                <img src="{{ asset('logo.png')}}" alt="" height="40">
                {{-- <h3 class="mt-3 mb-3"><i class="bx bx-shopping-bag"></i> VitaPOS</h3> --}}
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="mdi mdi-home"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('sales.index') }}">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-sales">Sales</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link" href="#productsMenu" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="productsMenu">
                        <i class="mdi mdi-shopping-outline"></i> <span data-key="t-products">Products</span>
                    </a>
                    <div class="collapse menu-dropdown" id="productsMenu">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link" data-key="t-products">
                                    Product List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link" data-key="t-categories">
                                    Categories </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('customers.index') }}">
                        <i class="mdi mdi-card-account-phone-outline"></i> <span data-key="t-customers">Customers</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('branches.index') }}">
                        <i class="bx bx-store"></i> <span data-key="t-branches">Branches</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('transactions.index') }}">
                        <i class="bx bx-menu"></i> <span data-key="t-users">Reports</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('countries.index') }}">
                        <i class="bx bx-flag"></i> <span data-key="t-countries">Countries</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('users.index') }}">
                        <i class="bx bx-user"></i> <span data-key="t-users">Users & Employee</span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
