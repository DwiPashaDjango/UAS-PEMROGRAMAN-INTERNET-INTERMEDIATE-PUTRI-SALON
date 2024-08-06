@extends('layouts.app')

@section('title')
    Sewa (Chekcout)
@endsection

@push('css')
   <style>
        .multiline-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush        

@section('content')
@php
    $startDate = \Carbon\Carbon::parse($rents->start_date);
    $endDate = \Carbon\Carbon::parse($rents->end_date);

    $numberOfDay = $startDate->diffInDays($endDate);


    $priceSewa = $numberOfDay * $rents->product->harga_next;
@endphp
<form action="{{route('users.updatePaidRent', ['invoice' => $rents->invoice])}}" method="POST">
    @csrf
    @method("PUT")
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
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black"> <i class="fas fa-map-marker-alt" style="color: #198754;"></i> Alamat Pengiriman</h2>
                <div class="card rounded mb-5">
                    <div class="card-body">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-3 update" style="border-radius: 30px"><i class="fas fa-pencil" style="font-size: 12px"></i></a>
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
                                <td style="padding-bottom: 20px">Jumlah Hari Penyewaan</td>
                                <td style="padding-bottom: 20px"></td>
                                <td style="padding-bottom: 20px">
                                    <input type="text" name="" id="" class="form-control" value="{{$numberOfDay + 1}} Hari" style="height: 35%; border: 2px solid #198754" disabled> 
                                </td>
                            </tr>
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
                                            <option value="{{$pn['name']}}">{{$pn['name']}} - {{number_format($pn['price'])}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
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
                                                    <td>
                                                        Rp. {{number_format($rents->qty * $rents->product->harga)}} 
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black"> <i class="fas fa-money-bill" style="color: #198754"></i> Metode Pembayaran</h2>
                        <div class="card rounded mb-5">
                            <div class="card-body">
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
                                                            <input type="radio" value="{{$tf['name']}}" name="pembayaran" id="customAmount-{{$index}}">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black"> <i class="fas fa-clipboard-list" style="color: #198754"></i> Rincian Pembayaran</h2>
                        <div class="card rounded mb-5">
                            <div class="card-body">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Subtotal Produk</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($rents->qty * $rents->product->harga)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Ongkos Kirim</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px" id="jasa_kirim_append"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">Durasi Penyewaan</td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">Rp. {{number_format($priceSewa)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            <h6>Total Pembayaran</h6>
                                        </td>
                                        <td style="width: 30%; padding-bottom: 8px"></td>
                                        <td style="width: 30%; padding-bottom: 8px">
                                            @php
                                                $GrandTotal = $rents->qty * $rents->product->harga;
                                            @endphp
                                            <h6 id="grand-total"></h6>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="total" id="total">
                                    <tr>
                                        <td style="width: 30%; padding-bottom: 8px" colspan="3">
                                            <hr class="divide">
                                            <button type="submit" class="btn btn-primary w-100">Buat Penyewaan</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </form> -->
    </div>
</form>
@endsection

@push('modal')
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Update Alamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST">
            @csrf
            @method("PUT")
            <div class="form-group mb-3">
                <label for="">No Telephone</label>
                <input type="text" name="telp" id="telp" class="form-control" value="{{Auth::user()->telp}}" style="border: 2px solid #198754; border-radius: 5px; padding: 10px;">
            </div>
            <div class="form-group mb-3">
                <label for="">Alamat</label>
                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" style="border: 2px solid #198754; border-radius: 5px; padding: 10px; height: 23vh;">
                    {{Auth::user()->alamat}}
                </textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="save">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        const pengiriman = [
            { name: "JNE", price: 20000 },
            { name: "J&T", price: 15000 },
            { name: "Ninja", price: 10000 }
        ];

        const selectElement = document.getElementById('jasa_kirim');
        const priceElement = document.getElementById('jasa_kirim_append');
        const grandTotals = document.getElementById('grand-total');
        const totals = document.getElementById('total');

        priceElement.textContent = "Rp. " + 0;
        const initialTotals = Number({{$GrandTotal + $priceSewa}});

        grandTotals.textContent =  "RP. " + initialTotals.toLocaleString();
        
        selectElement.addEventListener('change', function() {
            const selectedName = this.value;
            const selectedShipping = pengiriman.find(item => item.name === selectedName);
            
            let shippingPrice = 0;
            if (selectedShipping) {
                shippingPrice = selectedShipping.price;
                priceElement.textContent = "Rp. " + selectedShipping.price.toLocaleString();
            } else {
                priceElement.textContent = "Rp. " + 0;
            }

            const totalWithShipping = initialTotals + shippingPrice;
            grandTotals.textContent = "Rp. " + totalWithShipping.toLocaleString();
            totals.value = totalWithShipping;
        });

        $(document).ready(function() {
            $(".update").click(function() {
                $("#profileModal").modal('show');
            })

            $("#save").click(function(e) {
                e.preventDefault();
                let telp = $("#telp").val();
                let alamat = $("#alamat").val();

                $.ajax({
                    url: "{{url('/update-account/' . Auth::user()->id)}}",
                    method: "PUT",
                    data: {
                        telp: telp,
                        alamat: alamat
                    },
                    dataType: 'json',
                    success: function(data) {
                        Toastify({
                            text: data.message,
                            duration: 3000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#729D88",
                            },
                            onClick: function(){} // Callback after click
                        }).showToast();
                        $("#profileModal").modal('hide');
                        setTimeout(() => {
                            window.location.reload()
                        }, 3000);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
@endpush