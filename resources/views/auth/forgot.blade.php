@extends('layouts.auth')    

@section('title')
    Lupa Password
@endsection

@push('css')
    <style>
        .border: {
            border: 2px solid #198754;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="login-wrap p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center" style="background-color: #198754">
                    <img src="{{asset('logo.png')}}" width="50" alt="">
                </div>
                <hr class="divide">
                <div class="py-2">
                    <div class="alert alert-info" style="font-size: 14px; background-color: #198754; color: #fff">
                        <b>Silahkan Masukan Email Anda Untuk Melakukan Pengiriman Link Reset Password</b>
                    </div>
                </div>

                <form action="#" class="login-form">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Email Addres</label>
                        <input type="text" class="form-control rounded-left" style="border: 1px solid #198754" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn rounded submit px-3" style="background-color: #198754; color: #fff; font: bold">
                            <b>
                                Kirim
                            </b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection