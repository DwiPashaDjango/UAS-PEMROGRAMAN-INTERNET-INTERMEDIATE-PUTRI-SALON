<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Putri Salon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin')}}/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin')}}/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

    @stack('css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->

</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            @include('layouts.admin.topbar')

            @include('layouts.admin.navbar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title')</h1>
                        @php
                            $routeCheck = Request::routeIs('admin.product')
                        @endphp
                        <div class="section-header-breadcrumb">
                            @if ($routeCheck)
                                <a href="{{route('admin.product.create')}}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Produk</a>
                            @else
                                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
                                <div class="breadcrumb-item"><a href="#">Pages</a></div>
                                <div class="breadcrumb-item">@yield('title')</div>
                            @endif
                        </div>
                    </div>

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{date('Y')}} Putri Salon
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    @stack('modal')

    <!-- General JS Scripts -->
    <script src="{{asset('admin')}}/modules/jquery.min.js"></script>
    <script src="{{asset('admin')}}/modules/popper.js"></script>
    <script src="{{asset('admin')}}/modules/tooltip.js"></script>
    <script src="{{asset('admin')}}/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{asset('admin')}}/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{asset('admin')}}/modules/moment.min.js"></script>
    <script src="{{asset('admin')}}/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="{{asset('admin')}}/modules/datatables/datatables.min.js"></script>
    <script src="{{asset('admin')}}/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <!-- Template JS File -->
    <script src="{{asset('admin')}}/js/scripts.js"></script>
    <script src="{{asset('admin')}}/js/custom.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('js')
</body>

</html>