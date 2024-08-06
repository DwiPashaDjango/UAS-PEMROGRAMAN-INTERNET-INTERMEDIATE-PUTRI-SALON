@extends('layouts.auth')    

@section('title')
    Login
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
                @if (session()->has('message'))
                    <div class="alert alert-danger">
                        {{session()->get('message')}}
                    </div>
                @endif
                <form action="{{route('login.check')}}" method="POST" class="login-form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Email Addres</label>
                        <input type="text" name="email" value="{{old('email')}}" class="form-control rounded-left @error('email') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Password</label>
                        <input type="password" name="password" class="form-control rounded-left @error('password') is-invalid @enderror" style="border: 1px solid #198754" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback">
                                {{$message}}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn rounded submit px-3" style="background-color: #198754; color: #fff; font: bold">
                            <b>
                                Login
                            </b>
                        </button>
                    </div>
                    <div class="form-group d-md-flex">
                        <div class="w-50">
                            <label class="checkbox-wrap checkbox-primary" style="color: #198754">Remember Me
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-50 text-md-right">
                            <a href="{{route('forgot.password')}}" style="color: #198754">Lupa Password?</a>
                        </div>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    Belum Memiliki Akun? <a href="{{route('register')}}" style="color: #198754">Daftar</a>
                </div>
            </div>
        </div>
    </div>
@endsection