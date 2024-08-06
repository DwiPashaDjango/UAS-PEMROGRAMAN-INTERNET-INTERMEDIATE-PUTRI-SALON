<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Rent #{{$rent->invoice}} &mdash; LuxBliss Vogue</title>
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

<body class="layout-3" onload="window.print()">
    <div id="app">
        <div class="main-wrapper container">
           <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice Penyewaan</h2>
                                <div class="invoice-number">Rent #{{$rent->invoice}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Pengirim:</strong><br>
                                        Putri Salon<br>
                                        081320580046<br>
                                        Jl. Raya Pangeran Sutajaya, Babakan Cirebon, Jawa Barat, Indonesia
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Penerima:</strong><br>
                                        {{$rent->user->name}}<br>
                                        {{$rent->user->telp}}<br>
                                        {{$rent->user->alamat}}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Metode Pembayaran:</strong><br>
                                        {{$rent->pembayaran}}<br>
                                        {{$rent->user->email}}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Tanggal Penyewaan:</strong><br>
                                        {{\Carbon\Carbon::parse($rent->start_date)->translatedFormat('d F Y')}} - {{\Carbon\Carbon::parse($rent->end_date)->translatedFormat('d F Y')}}<br>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($rent->start_date);
                                            $endDate = \Carbon\Carbon::parse($rent->end_date);

                                            $numberOfDay = $startDate->diffInDays($endDate);
                                        @endphp
                                        {{$numberOfDay}} - Hari
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Produk Yang Di Sewa</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Produk</th>
                                        <th class="text-center">Ukuran</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>{{$rent->product->nm_produk}}</td>
                                        <td class="text-center">{{$rent->size}}</td>
                                        <td class="text-center">{{number_format($rent->product->harga)}}</td>
                                        <td class="text-center">{{$rent->qty}}</td>
                                        <td class="text-right">{{number_format($rent->qty * $rent->product->harga)}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                </div>
                                @php
                                    if ($rent->jasa_kirim === 'JNE') {
                                        $ongkir = 20000;
                                    } else if($rent->jasa_kirim === 'J&T') {
                                        $ongkir = 15000;
                                    } else {
                                        $ongkir = 10000;
                                    }
                                @endphp 
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">Rp. {{number_format($rent->qty * $rent->product->harga)}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Ongkir</div>
                                        <div class="invoice-detail-value">
                                            Rp. {{number_format($ongkir)}}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Grand Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            Rp. {{number_format($rent->qty * $rent->product->harga + $ongkir)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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