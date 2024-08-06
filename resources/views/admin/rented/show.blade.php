@extends('layouts.admin')

@section('title')
    {{$rented->invoice}}
@endsection

@section('content')
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Invoice Pengembalian</h2>
                        <div class="invoice-number">Order #{{$rented->invoice}}</div>
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
                                {{$rented->user->name}}<br>
                                {{$rented->user->telp}}<br>
                                {{$rented->user->alamat}}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($rented->denda != null)
                                <address>
                                    <strong>Metode Pembayaran:</strong><br>
                                    {{$rented->rent->pembayaran}}<br>
                                    {{$rented->user->email}}
                                </address>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>Tanggal Pengembalian:</strong><br>
                                {{\Carbon\Carbon::parse($rented->created_at)->translatedFormat('d F Y')}}<br><br>
                            </address>
                        </div>
                        <div class="col-md-6">
                            @if ($rented->denda != null)
                                <address>
                                    <strong>Selisih Hari Pengembalian:</strong><br>
                                    @php
                                        $endDate = \Carbon\Carbon::parse($rented->rent->end_date);
                                        $rentedDate = \Carbon\Carbon::parse($rented->created_at);

                                        $selisih = $endDate->diffInDays($rentedDate);
                                    @endphp         
                                    {{$selisih}} Hari<br><br>
                                </address>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-right">
                            @if ($rented->denda != null)
                                <address>
                                    <strong>Jumlah Denda:</strong><br>
                                    Rp. {{number_format($rented->denda->total_denda)}}<br><br>
                                </address>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="section-title">Produk Yang Di Kembalikan</div>
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
                                <td>{{$rented->product->nm_produk}}</td>
                                <td class="text-center">{{$rented->rent->size}}</td>
                                <td class="text-center">{{number_format($rented->product->harga)}}</td>
                                <td class="text-center">{{$rented->rent->qty}}</td>
                                <td class="text-right">Rp. {{number_format($rented->rent->qty * $rented->product->harga)}}</td>
                            </tr>
                        </table>
                    </div>
                    @if ($rented->denda != null)
                        <div class="row mt-4">
                            <div class="col-lg-8">
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Jumlah Denda/Hari</div>
                                    <div class="invoice-detail-value">Rp. 20.000</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Jumlah Selisih Hari Pengembalian</div>
                                    <div class="invoice-detail-value">{{$selisih}} Hari</div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total Denda</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">Rp. {{number_format($rented->denda->total_denda)}}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection