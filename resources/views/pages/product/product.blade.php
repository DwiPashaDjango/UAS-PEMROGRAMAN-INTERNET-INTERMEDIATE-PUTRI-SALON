@extends('layouts.app')

@section('title')
    Koleksi
@endsection

@section('content')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h2 class="text-white">
                            <b>
                                Koleksi
                            </b>
                        </h2>
                        <p class="mb-4">
                            Temukan keindahan dan keanggunan dalam koleksi kebaya dan jas kami. Mode lebih berkesan dengan penampilan yang tak terlupakan.
                        </p>
                    </div>
                </div>
                {{-- <div class="col-lg-7">
                    <div class="hero-img-wrap mb-3">
                        <img src="https://www.dusera.com/wp-content/uploads/2021/01/thumpnail-dusera-sewa-kebaya-jakarta.png" class="img-fluid ml-5">
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- End Hero Section -->


    <!-- Start Product Section -->
    <div class="product-section">
        <div class="container">
            <div class="mb-3" style="padding-bottom: 50px">
                <form action="{{route('product')}}">
                    <div class="d-flex justify-content-between">
                        <div>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Search..." style="border: 1px solid #407963">
                                <div class="input-group-append">
                                    <button class="btn" style="height:100%; background-color: #407963; border: none; color: #fff; border-radius: 0 10px 10px 0" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <!-- Start Column 2 -->
                @forelse ($products as $item)
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="{{route('product.show', ['id' => $item->id])}}">
                            @php
                                $imageArray = explode('|', $item->image);
                                $randomIndex = array_rand($imageArray);
                                $randomImage = $imageArray[$randomIndex];
                            @endphp
                            <img src="{{asset($randomImage)}}" class="img-fluid product-thumbnail">
                            <h3 class="product-title">{{$item->nm_produk}}.</h3>
                            <strong class="product-price">Rp. 125.000</strong>
                        </a>
                        <span class="icon-cross" onclick="return alert('Oke')">
                            <img src="{{asset('asset/heart.png')}}" width="18" class="img-fluid">
                        </span>
                    </div>
                @empty
                    
                @endforelse
                <!-- End Column 2 -->
            </div>
            <div class="d-flex justify-content-center">
                {{$products->links()}}
            </div>
        </div>
    </div>
    <!-- End Product Section -->
@endsection