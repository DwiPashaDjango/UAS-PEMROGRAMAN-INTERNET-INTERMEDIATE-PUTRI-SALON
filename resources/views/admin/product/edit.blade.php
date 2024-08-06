@extends('layouts.admin')

@section('title')
    Edit Produk
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('admin')}}/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="{{asset('admin')}}/modules/select2/dist/css/select2.min.css">
@endpush

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{$error}}    
                        </li>                        
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <form action="{{route('admin.product.update', ['id' => $product->id])}}" method="POST" enctype="multipart/form-data">
        <div class="card card-primary mb-2">
            <div class="card-body">
                @csrf
                @method("PUT")
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="mb-2">Nama Produk</label>
                            <input type="text" name="nm_produk" id="nm_produk" class="form-control" value="{{$product->nm_produk}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="mb-2">Designer</label>
                            <select class="form-control select2" name="desginers_id" id="desginers_id">
                                <option value="">- Pilih -</option>
                                @foreach ($designer as $item)
                                    <option value="{{$item->id}}" {{$product->desginers_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="mb-2">Jenis Produk</label>
                            <select class="form-control select2" name="type" id="type">
                                <option value="">- Pilih -</option>
                                <option value="Satuan" {{$product->type === "Satuan" ? 'selected' : ''}}>Satuan</option>
                                <option value="Perset" {{$product->type === "Perset" ? 'selected' : ''}}>Perset</option>
                                <option value="Paket" {{$product->type === "Paket" ? 'selected' : ''}}>Paket</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="mb-2">Ukuran</label>
                            <select class="form-control select2" tabindex="-1" aria-hidden="true" name="size[]" id="size" multiple="">
                                @php
                                    $size = [
                                        "S",
                                        "M",
                                        "L",
                                        "XL", 
                                        "XXL"
                                    ];

                                    $sizeArray = explode('|', $product->size);
                                @endphp
                                @foreach ($size as $sz)
                                    <option value="{{$sz}}" @if(in_array($sz, $sizeArray)) selected @endif>{{$sz}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="mb-2">Warna</label>
                            <input type="text" name="warna" id="warna" class="form-control" value="{{$product->warna}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="mb-2">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" value="{{$product->brand}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="mb-2">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{$product->stock}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="mb-2">Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control" value="{{$product->harga}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="mb-2">Harga Untuk Lebih Dari 1 Hari</label>
                            <input type="text" name="harga_next" id="harga_next" class="form-control" value="{{$product->harga_next}}"> 
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="mb-2">Deskripsi Singkat Produk</label>
                            <textarea name="deskripsi_singkat" id="deskripsi_singkat" class="form-control" cols="30" rows="5">
                                {{$product->deskripsi_singkat}}
                            </textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="mb-2">Deskripsi Lengkap Produk</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control summernote" cols="30" rows="5">
                                {{$product->deskripsi}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="">Foto Produk</label>
                    <div class="custom-file">
                        <input type="file" name="image[]" multiple="" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Pilih Foto</label>
                    </div>
                </div>
                <div class="row gutters-sm mt-3" id="showImage">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ubah</button>
    </form>
@endsection

@push('js')
    <script src="{{asset('admin')}}/modules/summernote/summernote-bs4.js"></script>
    <script src="{{asset('admin')}}/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('admin')}}/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
    <script src="{{asset('admin')}}/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script>
        function formatIDR(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }

        $("#harga").on('input', function(e) {
            var idr = $(this).val();
            $('#harga').val(formatIDR(idr))
        })

        $("#harga_next").on('input', function(e) {
            var idr = $(this).val();
            $('#harga_next').val(formatIDR(idr))
        })

        var fileList = [];
        $("#customFile").change(function() {
            var files = this.files;
            var newFiles = Array.from(files);

            if (newFiles.length > 0) {
                $('.gutters-sm').removeClass('d-none');
                newFiles.forEach(function(file) {
                    fileList.push(file);
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var row = $('<div class="col-4 col-md-4 col-sm-6"></div>');
                        var label = $('<label class="imagecheck mb-4"></label>');
                        var figure = $('<figure class="imagecheck-figure"></figure>');
                        var img = $('<img alt="" class="imagecheck-image">').attr('src', e.target.result);
                        var removeButton = $('<button class="btn btn-danger mt-2 w-100">Batal</button>');

                        removeButton.click(function() {
                            var index = fileList.indexOf(file);
                            if (index !== -1) {
                                fileList.splice(index, 1);
                                row.remove();
                                updateFileInput();
                            }
                        });

                        figure.append(img);
                        label.append(figure);
                        label.append(removeButton);
                        row.append(label);
                        $("#showImage").append(row);
                    };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
            } else {
                $(".gutters-sm").addClass('d-none');
            }
        });


        function updateFileInput() {
            var dataTransfer = new DataTransfer();

            fileList.forEach(function(file) {
                dataTransfer.items.add(file);
            });

            $("#image")[0].files = dataTransfer.files;
        }
    </script>
@endpush