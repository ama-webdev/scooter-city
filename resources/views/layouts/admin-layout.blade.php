<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('./assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('./assets/img/favicon.png') }}">
    <title>
        Scooter City
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('./assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fas5/css/all.min.css') }}">
    <link href="{{ asset('./assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('./assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    @yield('style')
    <style>
        .page-item.active .page-link,
        .page-item span {
            color: white;
        }
    </style>
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}" target="_blank">
                <span class="ms-1 font-weight-bold">Bike Rental System</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">

                {{-- dashboard --}}
                <li class="nav-item">
                    <a class="nav-link @yield('dash-active')" href="{{ route('admin.dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-home text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                @role('admin')
                    {{-- users --}}
                    <li class="nav-item">
                        <a class="nav-link @yield('user-active')" href="{{ route('admin.users.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-ninja text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Users</span>
                        </a>
                    </li>
                @endrole
                {{-- categories --}}
                <li class="nav-item">
                    <a class="nav-link @yield('cat-active')" href="{{ route('admin.categories.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-list text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Categories</span>
                    </a>
                </li>
                {{-- brands --}}
                <li class="nav-item">
                    <a class="nav-link @yield('brand-active')" href="{{ route('admin.brands.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-boxes text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Brands</span>
                    </a>
                </li>
                {{-- bikes --}}
                <li class="nav-item">
                    <a class="nav-link @yield('bike-active')" href="{{ route('admin.bikes.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-motorcycle text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Bikes</span>
                    </a>
                </li>
                {{-- orders --}}
                <li class="nav-item">
                    <a class="nav-link @yield('order-active')" href="{{ route('admin.orders.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-cubes text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Orders</span>
                    </a>
                </li>
                {{-- change password --}}
                <li class="nav-item">
                    <a class="nav-link @yield('auth-change-active')" href="{{ route('admin.show-change-password') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-lock text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Change Password</span>
                    </a>
                </li>
                @role('admin')
                    {{-- reset password --}}
                    <li class="nav-item">
                        <a class="nav-link @yield('auth-reset-active')" href="{{ route('admin.show-reset-password') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-sharp fa-solid fa-lock-open text-primary text-sm opacity-10"></i>

                            </div>
                            <span class="nav-link-text ms-1">Reset Password</span>
                        </a>
                    </li>
                @endrole
                {{-- logout --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-right-from-bracket text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder text-white mb-0">@yield('content-title')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
    <!--   Core JS Files   -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ asset('./assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('./assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('./assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $(".back-btn").click(function(e) {
                e.preventDefault();
                window.history.go(-1)
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#show_hide_password").change(function(event) {
                event.preventDefault();
                if (this.checked) {
                    $('.password').attr('type', 'text');
                } else {
                    $('.password').attr('type', 'password');
                }
            });
        });
    </script>
    @yield('script')
</body>

</html>
