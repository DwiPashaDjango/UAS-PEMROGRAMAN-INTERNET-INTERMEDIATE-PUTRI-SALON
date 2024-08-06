@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
<form action="{{route('account.profile', ['id' => Auth::user()->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="container">
        <div class="row py-3">
            <div class="col-lg-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-primary">
                        {{session()->get('message')}}
                    </div>
                @endif
                <div class="card shadow my-3">
                    <div class="card-body m-2">
                        <h4 style="color:black;">
                            Profile Saya
                        </h4>
                        <p style="color:black;">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                        <hr class="divide">
                        <table style="width:100%; color:black;">
                            <tr style="">
                                <td style="padding-bottom:15px; width:25%;">Nama Lengkap</td>
                                <td style="padding-bottom:15px; width:10%;"></td>
                                <td style="padding-bottom:15px; width:65%;">
                                    <input name="name" id="name" class="form-control" style="border:2px solid #198754; width:100%; height:40px;" value="{{Auth::user()->name}}" type="text" placeholder="Masukkan Nama Lengkap">
                                </td>                                
                            </tr>
                            <tr>
                                <td style="padding-bottom:15px; width:25%;">Email</td>
                                <td style="padding-bottom:15px; width:10%;"></td>
                                <td style="padding-bottom:15px; width:65%;">
                                    <input name="email" id="email" class="form-control" style="border:2px solid #198754; width:100%; height:40px;" value="{{Auth::user()->email}}" type="text" placeholder="Masukkan Email">
                                </td>                               
                            </tr>
                            <tr>
                                <td style="padding-bottom:15px; width:25%;">Nomor Telepon</td>
                                <td style="padding-bottom:15px; width:10%;"></td>
                                <td style="padding-bottom:15px; width:65%;">
                                    <input name="telp" id="telp" class="form-control" style="border:2px solid #198754; width:100%; height:40px;" value="084512356889" type="text" placeholder="Masukkan No Telepon     ">
                                </td>                               
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow my-3">
                    <div class="card-body">
                        <h4 style="color:black;">
                            Alamat Saya
                        </h4>
                        <hr class="divide">
                        <textarea name="alamat" id="alamat" style="border: 2px dashed #198754; padding: 10px; border-radius: 2px" rows="5" cols="5" class="form-control">
                            {{Auth::user()->alamat}}
                        </textarea>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center">
                @php
                    if (Auth::user()->image === 'default.png') {
                        $image = 'foto/rama.jpg';
                    } else {
                        $image = Auth::user()->image;
                    }
                @endphp
                <img id="profilePicture" src="{{ asset($image) }}" alt="Profile Picture" class="rounded-circle my-3" style="width: 200px; height: 200px;">
                <br>
                <input type="file" id="imageInput" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                <button type="button" class="btn" style="background-color: transparent; color: #198754; border: 2px solid #198754;" onclick="document.getElementById('imageInput').click();">Pilih Gambar</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
    <script>
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const img = document.getElementById('profilePicture');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                img.src = "{{ asset($image) }}";
            }
        }
    </script>
@endpush