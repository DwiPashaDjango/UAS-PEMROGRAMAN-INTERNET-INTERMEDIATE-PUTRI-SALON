@extends('layouts.auth')    

@section('title')
    Daftar
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
                    <img src="{{asset('1.png')}}" width="60" alt="">
                </div>
                <hr class="divide">
                <form action="{{route('register.check')}}" method="POST" class="login-form">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control rounded-left @error('name') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Nama Lengkap">
                        @error('name')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="mb-2">Email Addres</label>
                        <input type="text" name="email" value="{{old('email')}}" class="form-control rounded-left @error('email') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="mb-2">Password</label>
                        <input type="password" name="password" class="form-control rounded-left @error('password') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-left @error('password_confirmation') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Konfirmasi Password">
                        @error('password_confirmation')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="form-control btn rounded submit px-3" style="background-color: #198754; color: #fff; font: bold">
                            <b>
                                Daftar
                            </b>
                        </button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    Sudah Memiliki Akun? <a href="{{route('login')}}" style="color: #198754">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection