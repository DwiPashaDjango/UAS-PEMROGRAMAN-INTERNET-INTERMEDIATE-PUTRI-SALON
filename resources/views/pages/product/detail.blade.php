@extends('layouts.app')

@section('title')
    Detail Products
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('pages/css/detail-product.css')}}">
    <style>
        .multiline-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #description {
            overflow: hidden;
            max-height: 300px;
            transition: max-height 0.7s;
        }

        #description.open {
            max-height: 1000px;
            transition: max-height 0.7s;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
@endpush    

@section('content')
    <section class="py-0 mb-3 mt-3">
        <form action="{{route('users.generateRent')}}" method="POST">
            @csrf
            <input type="hidden" name="products_id" id="products_id" value="{{$product->id}}">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row gx-5">
                            @php
                                $imageExplode = explode('|', $product->image);
                            @endphp
                            <aside class="col-lg-6 images">
                                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                                    <a class="rounded-4" href="{{asset($imageExplode[0])}}">
                                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="{{asset($imageExplode[0])}}" />
                                    </a>
                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    @foreach ($imageExplode as $img)
                                        <a id="images" class="border rounded-2 m-2" href="{{asset($img)}}">
                                            <img width="80" height="80" class="rounded-2" src="{{asset($img)}}" />
                                        </a>
                                    @endforeach
                                </div>
                            </aside>
                            <main class="col-lg-6">
                                <div class="alert alert-info">
                                    <b>
                                        Jika Penyewaan Lebih Dari 1 Hari Maka Akan Di Kenakan Biaya Tambahan Sebesar Rp.{{number_format($product->harga_next)}}
                                    </b>
                                </div>
                                <div class="ps-lg-3 mt-4">
                                    <h4 class="title text-dark">
                                        {{$product->nm_produk}} - {{$product->warna}}
                                    </h4>
                                    <div class="d-flex flex-row my-3">
                                        <div class="text-warning mb-1 me-2">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>{{$product->stock}} Stock</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="h5">Rp.{{number_format($product->harga, 2)}}</span>
                                        <span class="text-muted">/{{$product->type}}</span>
                                    </div>
                                    <p class="multiline-truncate">
                                        {{$product->deskripsi_singkat}}
                                    </p>
                                    <div class="row">
                                        <dt class="col-3">Type:</dt>
                                        <dd class="col-9">{{$product->type}}</dd>
                                        <dt class="col-3">Warna:</dt>
                                        <dd class="col-9">{{$product->warna}}</dd>
                                        <dt class="col-3">Designer:</dt>
                                        <dd class="col-9">{{$product->designer->name}}</dd>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <label class="mb-2">Ukuran</label>
                                            <select class="form-select border border-secondary mt-2" name="size" id="size" style="height: 35px;">
                                                <option value="">- Pilih -</option>
                                                @foreach (explode('|', $product->size) as $sz)
                                                    <option value="{{$sz}}">{{$sz}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <label class="mb-2 d-block">Jumlah</label>
                                            <div class="input-group mb-3 quantity-container" style="width: 200px;">
                                                <button class="btn btn-warning px-3 decrease" type="button" id="button-addon1" data-mdb-ripple-color="dark">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" name="qty" id="qty" class="form-control text-center quantity-amount" value="1" min="1"/>
                                                <button class="btn btn-primary px-3 increase" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @auth
                                            <div class="col-md-6 col-6 mb-3">
                                                <label class="mb-2">Tanggal Mulai Sewa</label>
                                                <input type="date" name="start_date" class="form-control" style="height: 35px; border: 2px solid #198754; width: 100%" id="start_date">
                                            </div>
                                            <div class="col-md-6 col-6 mb-3">
                                                <label class="mb-2">Tanggal Selesai Sewa</label>
                                                <input type="date" name="end_date" class="form-control" style="height: 35px; border: 2px solid #198754; width: 100%" id="end_date">
                                            </div>
                                        @endauth
                                    </div>
                                    @auth
                                        <hr class="divide">
                                        <div class="mt-3">
                                            <a href="javascript:void(0)" class="btn btn-outline-primary shadow whislist"><i class="fas fa-heart"></i></a>
                                            <button type="submit" class="btn btn-primary shadow">Sewa Sekarang</button>
                                        </div>
                                    @else
                                        <a href="{{route('login')}}" class="btn btn-primary shadow w-100">Login</a>
                                    @endauth
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="py-0 mb-3">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow px-3 py-2">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item d-flex" role="presentation">
                                    <a style="background-color: #3b5d50" class="nav-link d-flex active" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1" aria-selected="true">
                                        Deskripsi Produk
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" style="padding-left: 20px;" id="description">
                                    {!! $product->deskripsi !!}
                                </div>

                                <div class="mt-3 d-flex justify-content-center">
                                    <a href="javascript:void(0)" id="show-more" class="" style="color:#198754; text-decoration:none; font-weight: bold" >Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow px-3 py-2 mt-2">
                        <div class="card-body p-4">
                            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item d-flex" role="presentation">
                                    <a style="background-color: #3b5d50" class="nav-link d-flex active" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1" aria-selected="true">
                                        Ulasan Produk
                                    </a>
                                </li>
                            </ul>
                            <hr class="divide">
                            <div id="items_container">
                                @forelse ($comment as $cmt)
                                    <div class="d-flex flex-start mb-4">
                                        <img class="rounded-circle shadow-1-strong me-3" src="{{asset($cmt->user->image)}}" alt="avatar" width="65" height="65" />
                                        <div class="flex-grow-1 flex-shrink-1">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="mb-1">
                                                        {{$cmt->user->name}} <span class="small">- {{\Carbon\Carbon::parse($cmt->created_at)->diffForHumans()}}</span>
                                                    </p>
                                                </div>
                                                <p class="small mb-0">
                                                    {{$cmt->body}}
                                                </p>
                                                @if ($cmt->image != null)
                                                    <p>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <img src="{{asset($cmt->image)}}" width="200" class="img-thumbnail" alt="">
                                                            </div>
                                                        </div>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="divide">
                                @empty 
                                    <div class="alert alert-info text-center">
                                        Belum Ada Ulasan    
                                    </div>                                
                                @endforelse
                            </div>
                            @if (count($comment) > 0)
                                <center>
                                    <a href="javascript:void(0)" id="load_more_button" data-page="{{ $comment->currentPage() + 1 }}" style="color:#198754; text-decoration:none; font-weight: bold">Lihat Semua</a>
                                </center>
                            @endif
                        </div>
                    </div>

                    @auth
                        <div class="card shadow mt-2">
                            <div class="card-body">
                                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="products_id" id="products_id" value="{{$product->id}}">
                                    <div class="form-group mb-3">
                                        <label for="body" class="mb-2"><b>Ulasan</b></label>
                                        <div class="input-group">
                                            <input type="text" name="body" id="body" class="form-control @error('body') is-invalid @enderror">
                                            <div class="input-group-append">
                                                <label for="image-input" class="input-group-text" style="height: 100%; background-color: #3b5d50; cursor: pointer; border-radius: 0 5px 5px 0">
                                                    <i class="fas fa-camera text-white"></i>
                                                </label>
                                                <input type="file" name="image" id="image-input" style="display: none;">
                                            </div>
                                        </div>
                                        @error('body')
                                            <span class="invalid-feedback">
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
                <div class="col-lg-4">
                    <div class="card shadow px-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <b>Produk Terbaru</b>
                            </h5>
                            <hr class="divide">
                            @foreach ($latestProduct as $lts)
                                <div class="d-flex mb-3">
                                    <a href="{{route('product.show', ['id' => $lts->id])}}" class="me-3">
                                        @php
                                            $image = explode('|', $lts->image);
                                        @endphp
                                        <img src="{{asset($image[0])}}" style="height: 100%;" width="250" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="{{route('product.show', ['id' => $lts->id])}}" class="nav-link mb-1 text-muted">
                                            {{$lts->nm_produk}}
                                            <br />
                                            {{$lts->warna}}
                                        </a>
                                    </div>
                                </div>
                                <hr class="divide">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/jquery.magnific-popup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.images').magnificPopup({
                delegate: 'a',
                type:'image',
                gallery:{
                    enabled:true
                }
            });

            let start = 3;

            $('#load_more_button').click(function() {
                let products_id = $("#products_id").val()
                $.ajax({
                    url: "{{ route('product.comment') }}",
                    method: "GET",
                    data: {
                        start: start,
                        products_id: products_id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#load_more_button').html('Loading...');
                        $('#load_more_button').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.data.length > 0) {
                        var html = '';
                        for (var i = 0; i < data.data.length; i++) {
                            if (data.data[i].image != null) {
                                html += `<div class="d-flex flex-start mb-4">
                                            <img class="rounded-circle shadow-1-strong me-3" src="`+ data.data[i].profile +`" alt="avatar" width="65" height="65" />
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            `+ data.data[i].user.name +` <span class="small">- `+ data.data[i].tgl +`</span>
                                                        </p>
                                                    </div>
                                                    <p class="small mb-0">
                                                        `+ data.data[i].body +`
                                                    </p>
                                                    <p>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <img src="`+ data.data[i].images +`" width="200" class="img-thumbnail" alt="">
                                                            </div>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="divide">`;
                            } else {
                                html += `<div class="d-flex flex-start mb-4">
                                            <img class="rounded-circle shadow-1-strong me-3" src="`+ data.data[i].profile +`" alt="avatar" width="65" height="65" />
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1">
                                                            `+ data.data[i].user.name +` <span class="small">- `+ data.data[i].tgl +`</span>
                                                        </p>
                                                    </div>
                                                    <p class="small mb-0">
                                                        `+ data.data[i].body +`
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="divide">`;
                            }
                        }

                        $('#items_container').append($(html).hide().fadeIn(1000));
                        $('#load_more_button').html('Lihat Semua');
                        $('#load_more_button').attr('disabled', false);
                        start = data.next;

                        if (!data.hasMore) {
                            $('#load_more_button').html('Tidak Ada Data Ulasan Lagi.');
                            $('#load_more_button').attr('disabled', true);
                        }
                    } else {
                        $('#load_more_button').html('Tidak Ada Data Ulasan Lagi.');
                        $('#load_more_button').attr('disabled', true);
                    }
                    }
                });
            });

            $(".whislist").click(function() {
                let products_id = $("#products_id").val();
                let size = $("#size").val();
                let qty = $("#qty").val();

                $.ajax({
                    url: "{{route('product.save.whislist')}}",
                    method: "POST",
                    data: {
                        products_id: products_id,
                        size: size,
                        qty: qty,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.errors) {
                            $.each(data.errors, function(index, value) {
                                iziToast.show({
                                    id: null, 
                                    class: '',
                                    title: 'Oops: ',
                                    titleColor: '',
                                    titleSize: '',
                                    titleLineHeight: '',
                                    message: value,
                                    messageColor: '#ffff',
                                    messageSize: '',
                                    messageLineHeight: '',
                                    backgroundColor: '#FF5238',
                                    theme: 'light', // dark
                                    color: 'white', // blue, red, green, yellow
                                    icon: '',
                                    iconText: '',
                                    iconColor: '',
                                    iconUrl: null,
                                    image: '',
                                    imageWidth: 50,
                                    maxWidth: null,
                                    zindex: null,
                                    layout: 1,
                                    balloon: false,
                                    close: true,
                                    closeOnEscape: false,
                                    closeOnClick: false,
                                    displayMode: 0, // once, replace
                                    position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                                    target: '',
                                    targetFirst: true,
                                    timeout: 5000,
                                    rtl: false,
                                    animateInside: true,
                                    drag: true,
                                    pauseOnHover: true,
                                    resetOnHover: false,
                                    progressBar: true,
                                    progressBarColor: '',
                                    progressBarEasing: 'linear',
                                    overlay: false,
                                    overlayClose: false,
                                    overlayColor: 'rgba(0, 0, 0, 0.6)',
                                    transitionIn: 'fadeInUp',
                                    transitionOut: 'fadeOut',
                                    transitionInMobile: 'fadeInUp',
                                    transitionOutMobile: 'fadeOutDown',
                                    buttons: {},
                                    inputs: {},
                                    onOpening: function () {},
                                    onOpened: function () {},
                                    onClosing: function () {},
                                    onClosed: function () {}
                                });
                            })
                        } else {
                            iziToast.show({
                                id: null, 
                                class: '',
                                title: 'Oops: ',
                                titleColor: '',
                                titleSize: '',
                                titleLineHeight: '',
                                message: data.message,
                                messageColor: '#ffff',
                                messageSize: '',
                                messageLineHeight: '',
                                backgroundColor: '#90E05C',
                                theme: 'light', // dark
                                color: 'white', // blue, red, green, yellow
                                icon: '',
                                iconText: '',
                                iconColor: '',
                                iconUrl: null,
                                image: '',
                                imageWidth: 50,
                                maxWidth: null,
                                zindex: null,
                                layout: 1,
                                balloon: false,
                                close: true,
                                closeOnEscape: false,
                                closeOnClick: false,
                                displayMode: 0, // once, replace
                                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                                target: '',
                                targetFirst: true,
                                timeout: 5000,
                                rtl: false,
                                animateInside: true,
                                drag: true,
                                pauseOnHover: true,
                                resetOnHover: false,
                                progressBar: true,
                                progressBarColor: '',
                                progressBarEasing: 'linear',
                                overlay: false,
                                overlayClose: false,
                                overlayColor: 'rgba(0, 0, 0, 0.6)',
                                transitionIn: 'fadeInUp',
                                transitionOut: 'fadeOut',
                                transitionInMobile: 'fadeInUp',
                                transitionOutMobile: 'fadeOutDown',
                                buttons: {},
                                inputs: {},
                                onOpening: function () {},
                                onOpened: function () {},
                                onClosing: function () {},
                                onClosed: function () {}
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })
        });


        let description = document.getElementById("description");
        let btn = document.getElementById("show-more");
        
        btn.onclick  = function() {
            if (description.className === 'open') {
                description.className = "";
                btn.innerHTML = "Lihat";
            } else {
                description.className = "open";
                btn.innerHTML = "Tutup";
            }
        }
    </script>
@endpush