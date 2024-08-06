@extends('layouts.admin')

@section('title')
    {{$rent->invoice}}
@endsection

@section('content')
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
        <hr>
        <div class="text-md-right">
            <a href="{{route('admin.order.generateInvoice', ['invoice' => $rent->invoice])}}" target="_blank" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Cetak Invoice</a>
        </div>
    </div>
@endsection