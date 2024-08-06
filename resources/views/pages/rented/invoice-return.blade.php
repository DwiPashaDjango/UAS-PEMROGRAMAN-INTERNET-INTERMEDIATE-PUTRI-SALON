<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>{{$return->invoice}}</title>
    <style>
        body{margin-top:20px;
        background:#eee;
        }

        .invoice {
            padding: 30px;
        }

        .invoice h2 {
            margin-top: 0px;
            line-height: 0.8em;
        }

        .invoice .small {
            font-weight: 300;
        }

        .invoice hr {
            margin-top: 10px;
            border-color: #ddd;
        }

        .invoice .table tr.line {
            border-bottom: 1px solid #ccc;
        }

        .invoice .table td {
            border: none;
        }

        .invoice .identity {
            margin-top: 10px;
            font-size: 1.1em;
            font-weight: 300;
        }

        .invoice .identity strong {
            font-weight: 600;
        }


        .grid {
            position: relative;
            width: 100%;
            background: #fff;
            color: #666666;
            border-radius: 2px;
            margin-bottom: 25px;
            box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
        }

    </style>
  </head>
  <body onload="window.print()">
    <div class="container">
        <div class="row">
            <!-- BEGIN INVOICE -->
            <div class="col-xs-12">
                <div class="grid invoice">
                    <div class="grid-body">
                        <div class="invoice-title">
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="http://vergo-kertas.herokuapp.com/assets/img/logo.png" alt="" height="35">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>Invoice Pengembalian<br>
                                        <span class="small">return #{{$return->invoice}}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <address>
                                        <strong>Pengirim:</strong><br>
                                        {{$return->user->name}}<br>
                                        {{$return->user->alamat}}<br>
                                        <abbr></abbr> {{$return->user->telp}}
                                    </address>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <strong>Penerima:</strong><br>
                                    LuxBliss Vogue<br>
                                    Jl. Raya Cempaka arum, Cempaka, Kec. Talun, Kabupaten Cirebon<br>
                                    Jawa Barat 45171<br>
                                    <abbr></abbr>08xxxxxxxxxx
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <strong>Metode Pembayaran & Pengiriman:</strong><br>
                                    {{$return->pembayaran}}<br>
                                    {{$return->jasa_kirim}}<br>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <address>
                                    <strong>Tanggal Penyewaan:</strong><br>
                                    {{\Carbon\Carbon::parse($return->rent->start_date)->translatedFormat('d F Y')}}
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <address>
                                    <strong>Jumlah Denda:</strong><br>
                                    @if ($return->denda != null)
                                        {{number_format($return->denda->total_denda)}}
                                    @else
                                        -
                                    @endif
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td><strong>#</strong></td>
                                            <td class=""><strong>Produk</strong></td>
                                            <td class="text-center"><strong>Harga</strong></td>
                                            <td class="text-center"><strong>Ukuran</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-right"><strong>SubTotal</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <strong>{{$return->rent->product->nm_produk}}</strong>
                                            </td>
                                            <td class="text-center">{{number_format($return->rent->product->harga)}}</td>
                                            <td class="text-center">{{$return->rent->size}}</td>
                                            <td class="text-center">{{$return->rent->qty}}</td>
                                            <td class="text-right">
                                                {{number_format($return->rent->product->harga * $return->rent->qty)}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right identity">
                                @if ($return->denda != null)
                                    <p><b>Jumlah Denda</b> : Rp. {{number_format($return->denda->total_denda)}}</p>
                                    <p><b>Total Pembayaran</b> : Rp. {{number_format($return->denda->total_denda)}} </p>
                                    @else
                                    <p><b>Jumlah Denda</b> : Rp. 0</p>
                                    <p><b>Total Pembayaran</b> : Rp. 0</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>