<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="40">
                        </span>
                    </a>

                    <a href="{{ route('dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="40">
                        </span>
                    </a>


                </div>
                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">




                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-dark btn-sm shadow-none" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                @if (auth()->check() && auth()->user()->active_branch_id)
                     {{ auth()->user()->activeBranch->name }}
                        @else
                            No Branch Selected
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                        @foreach ($branches as $branch)
                            <a href="{{ route('select.branch', ['branch_id' => $branch->id]) }}"
                                class="dropdown-item notify-item language py-2" title="{{ $branch->name }}">
                                <span class="align-middle">{{ $branch->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">

                                    Roles
                                </span>
                            </span>

                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="#"><i
                                class="bx bx-user text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                                data-key="t-logout">Profile</span></a>

                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</header>
