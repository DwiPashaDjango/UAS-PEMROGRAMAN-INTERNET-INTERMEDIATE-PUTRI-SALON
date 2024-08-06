@extends('layouts.app')

@section('title')
    Tentang Kami
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
                                Tentang Kami
                            </b>
                        </h2>
                        <p class="mb-4">
                            Temukan keindahan dan keanggunan dalam koleksi kebaya dan jas kami. Mode lebih berkesan dengan penampilan yang tak terlupakan.
                        </p>
                        <p>
                            <a href="{{route('product')}}" class="btn btn-secondary me-2">Koleksi Kami</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap" style="margin-left: 100px">
                        <img src="https://www.dusera.com/wp-content/uploads/2021/01/thumpnail-dusera-sewa-kebaya-jakarta.png" class="img-fluid ml-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between">
                
                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="https://www.dusera.com/wp-content/uploads/2021/01/thumpnail-dusera-sewa-kebaya-jakarta.png" alt="Image" class="img-fluid">
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="section-title">Kenapa Putri Salon?</h2>
                    <p>Karna Kami Menyediakan Seluruh Model Kebaya dan Jas Dari motif Jawa dan Bali Yang Keren Dan Kekinian. Jadi Ayo <b>Sewa Sekarang</b>.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('pages')}}/images/truck.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Easy Delivery & Return</h3>
                                <p>
                                    Pesananmu akan tiba dalam sebuah tas pakaian mewah
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('pages')}}/images/bag.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Easy to Rent</h3>
                                <p>
                                    Kami menyediakan berbagai macam desain, ukuran, dan warna jas dan kebaya, memungkinkan Anda menemukan yang paling sesuai dengan kebutuhan dan selera Anda.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('pages')}}/images/support.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>
                                    Anda dapat memilih dan memesan jas atau kebaya kapan saja dan di mana saja, tanpa perlu mengunjungi toko fisik..
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('pages')}}/images/return.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Hassle Free Returns</h3>
                                <p>
                                    Pengiriman dan pengembalian barang dapat dilakukan dari kenyamanan rumah Anda, menghemat waktu dan tenaga.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Testimoni</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Layanan penyewaan jas dan kebaya ini benar-benar memudahkan saya! Pilihan pakaiannya banyak dan kualitasnya sangat baik. Saya sangat puas dengan jas yang saya sewa untuk acara pernikahan teman saya. Pengiriman cepat dan pengembalian barang juga sangat mudah. Terima kasih!.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{asset('pages')}}/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Siti Lutfihah</h3>
                                                <span class="position d-block mb-3">Penyewa.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Kebaya yang saya sewa untuk pesta pernikahan sangat cantik dan pas di badan. Aplikasi ini sangat membantu dengan berbagai pilihan dan deskripsi yang jelas. Proses pemesanan sangat simpel dan efisien. Saya pasti akan menggunakan layanan ini lagi di masa depan!.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{asset('pages')}}/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Jaenab</h3>
                                                <span class="position d-block mb-3">Penyewa.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Penyewaan kebaya melalui aplikasi ini adalah pengalaman yang luar biasa! Koleksinya modern dan trendy, sesuai dengan selera saya. Pelayanan pelanggannya sangat responsif dan membantu. Kebaya yang saya pilih sesuai dengan gambar dan deskripsi. Pengalaman yang sangat memuaskan!.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{asset('pages')}}/images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Julaeha</h3>
                                                <span class="position d-block mb-3">Penyewa.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->
@endsection