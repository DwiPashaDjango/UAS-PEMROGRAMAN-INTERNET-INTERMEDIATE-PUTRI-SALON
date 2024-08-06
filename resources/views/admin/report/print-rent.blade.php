<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Laporan Penyewaan &mdash; LuxBliss Vogue</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin')}}/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin')}}/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

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

<body class="layout-3" onload="window.print()">
    <div id="app" class="mt-5">
        <div class="main-wrapper container">
            <h3 class="text-center py-3">Laporan Penyewaan Bulan {{$month}} Tahun {{$years}}</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white">No</th>
                            <th class="text-white">Nama Penyewa</th>
                            <th class="text-white">Produk</th>
                            <th class="text-white">Harga</th>
                            <th class="text-white">Qty</th>
                            <th class="text-white">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rents as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->product->nm_produk}}</td>
                                <td>{{number_format($item->product->harga)}}</td>
                                <td>{{$item->qty}}</td>
                                <td>
                                    Rp. {{number_format($item->qty * $item->product->harga)}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @if (!empty($month) && !empty($year))
                                    <td colspan="6">Tidak Ada Data Penyewaan Di Bulan {{$month}} Tahun {{$years}} </td>
                                @else
                                    <td colspan="6">Tidak Ada Data Penyewaan Di Bulan Tahun </td>
                                @endif
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
</body>

</html>