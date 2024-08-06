@extends('layouts.app')

@section('title')
    Retun (Pengembalian) - {{$rents->invoice}}
@endsection

@push('css')
   <style>
        .multiline-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush        

@section('content')
<form action="{{route('rent.returnRents')}}" method="POST">
    @csrf
    <input type="hidden" name="products_id" id="products_id" value="{{$rents->products_id}}">
    <input type="hidden" name="rents_id" id="rents_id" value="{{$rents->id}}">
    @php
        $now = \Carbon\Carbon::now();

        $startDate = \Carbon\Carbon::parse($rents->start_date);
        $endDates = \Carbon\Carbon::parse($rents->end_date);

        $numberOfDay = $now->diffInDays($endDates);

        $jumlahHari = $numberOfDay;

        $endDate = $rents->end_date;

        $denda = 0;
        if ($now->greaterThan($endDate)) {
            $denda = 20000 * $jumlahHari;
        }
    @endphp
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $errors)
                        <li>
                            {{$errors}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($jumlahHari > 0)
            <div class="alert alert-primary d-flex align-items-center" role="alert" style="background-color: #3b5d50; border: none; color: #fff">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle mr-3" style="margin-right: 20px" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <div>
                    <b>Rp. Anda Terlambat Mengembalikan Produk Yang Di Sewa Selama {{$jumlahHari}} Hari Maka Anda Di Kenakan Denda Sebesar Rp. {{number_format($denda)}}</b>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black"> <i class="fas fa-map-marker-alt" style="color: #198754;"></i> Alamat Pengiriman</h2>
                <div class="card rounded mb-5">
                    <div class="card-body">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-3" style="border-radius: 30px"><i class="fas fa-pencil" style="font-size: 12px"></i></a>
                        <div style="border: 2px dashed #198754; border-radius: 5px; padding: 10px; height: 23vh;">
                            <p style="word-break: break-all">
                                {{$rents->user->name}}
                                <br>
                                {{$rents->user->telp}}
                                <br>
                                <br>
                                {{$rents->user->alamat}}
                            </p>
                        </div>
                    </div>
                </div>

                <h2 class="h3 mb-3 text-black"> <i class="fas fa-clock" style="color: #198754"></i> Durasi Penyewaan</h2>
                <div class="card rounded mb-5">
                    <div class="card-body">
                        <table style="width: 100%">
                            <tr>
                                <td style="padding-bottom: 20px">Pesan</td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px">
                                    <input type="text" name="catatan" id="catatan" class="form-control" placeholder="(Optional) Tinggal Pesan Ke Toko" style="height: 35%; border: 2px solid #198754">
                                </td>
                            </tr>
                            <tr> 
                                <td>Opsi Pengiriman</td>
                                <td></td>
                                <td>
                                    <select name="jasa_kirim" id="jasa_kirim" class="form-control" style="height: 35%; border: 2px solid #198754">
                                        <option value="">- Pilih -</option>
                                        @php
                                            $pengiriman = [
                                                [
                                                    "name" => "JNE",
                                                    "price" => 20000
                                                ],
                                                [
                                                    "name" => "J&T",
                                                    "price" => 15000
                                                ],
                                                [
                                                    "name" => "Ninja",
                                                    "price" => 10000
                                                ],
                                            ];
                                        @endphp 
                                        @foreach ($pengiriman as $pn)
                                            <option value="{{$pn['name']}}" {{$pn['name'] === $rents->jasa_kirim ? 'selected' : ''}}>{{$pn['name']}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @if ($jumlahHari > 0)
                                <tr> 
                                    <td style="padding-top:20px;">Metode Pembayaran</td>
                                    <td style="padding-top:20px;"></td>
                                    <td style="padding-top:20px;">
                                        <div class="border p-3 mb-3">
                                            <h3 class="h6 mb-0">
                                                <a class="d-block" data-bs-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">
                                                    E-Wallet
                                                </a>
                                            </h3>
        
                                            <div class="collapse" id="collapsecheque">
                                                <div class="py-2">
                                                    @php
                                                        $ewallet = [
                                                            [
                                                                "name" => "Dana",
                                                                "image" => asset('asset/wallet/dana.png')
                                                            ],
                                                            [
                                                                "name" => "Ovo",
                                                                "image" => asset('asset/wallet/ovo.png')
                                                            ],
                                                            [
                                                                "name" => "Sea Bank",
                                                                "image" => asset('asset/wallet/seabank.png')
                                                            ],
                                                            [
                                                                "name" => "Shoppepay",
                                                                "image" => asset('asset/wallet/spay.png')
                                                            ],
                                                        ];
                                                    @endphp
                                                    @foreach ($ewallet as $index => $wl)
                                                        <div class="d-flex align-items-center justify-content-between p-3 customRounded">
                                                            <div class="d-flex align-items-center">
                                                                <input type="radio" value="{{$wl['name']}}" name="pembayaran" id="customAmount-{{$index}}">
                                                                <label for="customAmount-{{$index}}" class="ms-3">
                                                                    <strong>{{$wl['name']}}</strong><br />
                                                                </label>
                                                            </div>
                                                            <div>
                                                                <img src="{{$wl['image']}}" alt="Amex Logo" height="28">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mb-3">
                                            <h3 class="h6 mb-0">
                                                <a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">
                                                    Transfer Bank
                                                </a>
                                            </h3>

                                            <div class="collapse" id="collapsebank">
                                                <div class="py-2">
                                                    <div class="border customRounded">
                                                        @php
                                                            $transfer = [
                                                                [
                                                                    "name" => "BCA",
                                                                    "image" => asset('asset/bank/bca.png')
                                                                ],
                                                                [
                                                                    "name" => "Mandiri",
                                                                    "image" => asset('asset/bank/mandiri.png')
                                                                ],
                                                                [
                                                                    "name" => "BNI",
                                                                    "image" => asset('asset/bank/bni.png')
                                                                ],
                                                                [
                                                                    "name" => "BRI",
                                                                    "image" => asset('asset/bank/bri.png')
                                                                ],
                                                            ];
                                                        @endphp
                                                        @foreach ($transfer as $index => $tf)
                                                            <div class="d-flex align-items-center justify-content-between p-3 customRounded">
                                                                <div class="d-flex align-items-center">
                                                                    <input type="radio" value="{{$wl['name']}}" name="pembayaran" id="customAmount-{{$index}}">
                                                                    <label for="customAmount-{{$index}}" class="ms-3">
                                                                        <strong>Bank {{$tf['name']}}</strong><br />
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <img src="{{$tf['image']}}" alt="Amex Logo" height="28">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <input type="hidden" name="status" id="status" value="denda">
                            @else
                                <input type="hidden" name="status" id="status" value="not_denda">
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black"> <i class="fas fa-shopping-bag" style="color: #198754"></i> Produk Yang Di Sewa</h2>
                        <div class="card rounded mb-5">
                            <div class="card-body">
                                <div class="row gx-5">
                                    <aside class="col-lg-4">
                                        <div class="border rounded-4 mb-3 d-flex justify-content-center">
                                            @php
                                                $image = explode('|', $rents->product->image);
                                            @endphp
                                            <img style="max-width: 100%; height: 16vh; margin: auto;" class="rounded-4 fit" src="{{asset($image[0])}}" />
                                        </div>
                                    </aside>
                                    <main class="col-lg-8">
                                        <div class="ps-lg">
                                            <h4 class="title text-dark">
                                                {{$rents->product->nm_produk}} - {{$rents->product->warna}}
                                            </h4>
                                            <p class="multiline-truncate">
                                                {{$rents->product->deskripsi_singkat}}
                                            </p>
                                        </div>
                                    </main>
                                    <main class="col-lg-12">
                                        <div class="ps-lg">
                                            <table class="table table-bordered text-center">
                                                <tr>
                                                    <th>Ukuran</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                                <tr>
                                                    <td>{{$rents->size}}</td>
                                                    <td>{{number_format($rents->product->harga)}}</td>
                                                    <td>{{$rents->qty}}</td>
                                                    <td>{{number_format($rents->qty * $rents->product->harga)}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black"> <i class="fas fa-clipboard-list" style="color: #198754"></i> Rincian Penyewaan</h2>
                        <div class="card rounded mb-5">
                            <div class="card-body">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Subtotal Produk</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($rents->product->harga * $rents->qty)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Ongkos Kirim</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                         @php
                                            if ($rents->jasa_kirim === "JNE") {
                                                $ongkir = 20000;
                                            } elseif($rents->jasa_kirim === "J&T") {
                                                $ongkir = 15000;
                                            } else {
                                                $ongkir = 10000;
                                            }
                                        @endphp
                                        <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($ongkir)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Durasi Penyewaan</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($rents->start_date);
                                            $endDate = \Carbon\Carbon::parse($rents->end_date);

                                            $numberOfDay = $startDate->diffInDays($endDate);

                                            $priceSewa = $numberOfDay * $rents->product->harga_next;
                                        @endphp
                                        <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($priceSewa)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            <h6>Total Pembayaran</h6>
                                        </td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            <h6>Rp. {{number_format($rents->product->harga * $rents->qty + $priceSewa + $ongkir)}}</h6>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black"> <i class="fas fa-clipboard-list" style="color: #198754"></i> Rincian Pengembalian</h2>
                        <div class="card rounded mb-5">
                            <div class="card-body">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Denda</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        @if ($now->greaterThan($endDate))
                                            <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($denda)}}</td>
                                        @else
                                            <td style="width: 30%; padding-bottom: 8px">Rp. 0</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            <h6>Total Pembayaran</h6>
                                        </td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            @if ($now->greaterThan($endDate))
                                                <input type="hidden" name="total_denda" id="total_denda" value="{{$denda}}">
                                                <h6>Rp. {{number_format($denda)}}</h6>
                                            @else
                                                <h6>Rp. 0</h6>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px" colspan="3">
                                            <hr class="divide">
                                            <button type="submit" class="btn btn-primary w-100">Return Product</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection