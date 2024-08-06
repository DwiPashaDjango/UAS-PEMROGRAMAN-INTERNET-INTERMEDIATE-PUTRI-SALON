@extends('layouts.app')

@section('title')
    PenyewaanKu
@endsection

@section('content')
    <div class="container py-5">
        <div class="alert alert-primary d-flex align-items-center" role="alert" style="background-color: #3b5d50; border: none; color: #fff">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle mr-3" style="margin-right: 20px" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg>
            <div>
                Peringatan Silahkan Kembalikan Produk Yang Sudah Di Sewa Sesuai Dengan Waktu Pengembalian Yang Sudah Ditentukan. 
                Jika Pengembalian Melewati Batas Waktu Yang Sudah Ditentukan Maka Akan Terkena Denda Sebesar <b>Rp. 20.000</b>
            </div>
        </div>

        <div class="py-2">
            <div class="row">
                @foreach ($rents as $item)
                    @if ($item->status === 'pending')
                        <div class="col-lg-4">
                            <div class="card p-3 mb-3 rounded-lg bg-white">
                                <div class="alert alert-warning text-center" style="background-color: #e8ce24; border: none; color: #3b3b3b">
                                    <b>Silahkan Melakukan Pembayaran Di Produk Ini</b>
                                </div>
                                <div class="about-product text-center mt-2">
                                    @php
                                        $image = explode('|', $item->product->image);
                                    @endphp
                                    <img src="{{asset($image[0])}}" width="200">
                                    <div>
                                        <h4 class="py-3">{{$item->product->nm_produk}} - {{$item->product->warna}}</h4>
                                    </div>
                                </div>
                                <div class="stats mt-2">
                                    <div class="d-flex justify-content-between p-price">
                                        <span>Tanggal Sewa</span>
                                        <span>{{\Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y')}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between p-price">
                                        <span>Tanggal Selesai Sewa</span>
                                        <span>{{\Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y')}}</span>
                                    </div>
                                    <hr class="divide">
                                    <div class="d-flex justify-content-between p-price">
                                        <div>
                                            <a href="javascript:void(0)" onclick="return canceledRent('{{$item->id}}')" class="btn btn-danger w-100">Batalkan Sewa</a>
                                        </div>
                                        <div>
                                            <a href="{{route('rent', ['invoice' => $item->invoice])}}" class="btn btn-primary w-100">Bayar Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-4">
                            <div class="card p-3 mb-3 rounded-lg bg-white">
                                @if ($item->return_product_count > 0)
                                    <div class="alert alert-primary text-center" style="background-color: #3b5d50; border: none; color: #fff">
                                        <b>Status Produk Sudah Dikembalikan</b>
                                    </div>
                                @else
                                    <div class="alert alert-primary text-center" style="background-color: #3b5d50; border: none; color: #fff">
                                        <b>Status Produk Belum Dikembalikan</b>
                                    </div>
                                @endif
                                <div class="about-product text-center mt-2">
                                    @php
                                        $image = explode('|', $item->product->image);
                                    @endphp
                                    <img src="{{asset($image[0])}}" width="200">
                                    <div>
                                        <h4 class="py-3">{{$item->product->nm_produk}} - {{$item->product->warna}}</h4>
                                    </div>
                                </div>
                                <div class="stats mt-2">
                                    <div class="d-flex justify-content-between p-price">
                                        <span>Tanggal Sewa</span>
                                        <span>{{\Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y')}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between p-price">
                                        <span>Tanggal Selesai Sewa</span>
                                        <span>{{\Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y')}}</span>
                                    </div>
                                    @php
                                        $now = \Carbon\Carbon::now();

                                        $startDate = \Carbon\Carbon::parse($item->start_date);
                                        $endDates = \Carbon\Carbon::parse($item->end_date);

                                        $numberOfDay = $now->diffInDays($endDates);

                                        $jumlahHari = $numberOfDay;

                                        $endDate = $item->end_date;

                                        $denda = 0;
                                        if ($now->greaterThan($endDate)) {
                                            $denda = 20000 * $jumlahHari;
                                        }
                                    @endphp
                                    @if ($jumlahHari > 0)
                                        <hr class="divide">
                                        <div class="d-flex justify-content-between p-price">
                                            <span>Jumlah Hari Terlewat</span>
                                            <span>{{$jumlahHari}} Hari</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-price">
                                            <span>Denda</span>
                                            <span>Rp. {{number_format($denda)}}</span>
                                        </div>
                                    @endif
                                    <hr class="divide">
                                    <div class="d-flex justify-content-between p-price">
                                        <div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Invoice
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" target="_blank" href="{{route('rent.generateRentInvoice', ['invoice' => $item->invoice])}}">Invoice Penyewaan</a></li>
                                                    @if ($item->return_product_count > 0)
                                                        <li><a class="dropdown-item" target="_blank" href="{{route('rent.generateReturnInvoice', ['invoice' => $item->return_product->invoice])}}">Invoice Pengembalian</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            @if ($item->return_product_count > 0)
                                                <a href="javascript:void(0)" class="btn btn-primary w-100 disabled">Selesai</a>
                                            @else
                                                <a href="{{route('rented.show', ['invoice' => $item->invoice])}}" class="btn btn-primary w-100">Return</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function canceledRent(id) {
            Swal.fire({
                title: "Warning !",
                text: "Anda yakin ingin membatalkan penyewaan ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Tidak",
                confirmButtonText: "Ya",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('renteds/canceled')}}/" + id,
                        method: "DELETE",
                        success: function(data) {
                            let timerInterval;
                            Swal.fire({
                                icon: "success",
                                title: "Barhasil...",
                                html: "Merefresh page dalam <b></b> milliseconds.",
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                    window.location.reload();
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            });
        }
    </script>
@endpush