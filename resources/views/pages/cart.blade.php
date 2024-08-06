@extends('layouts.app')

@section('title')
    Whislit
@endsection

@section('content')
    <div class="container py-5">
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
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Foto</th>
                                    <th class="product-name">Produk</th>
                                    <th class="product-name">Size</th>
                                    <th class="product-price">Harga</th>
                                    <th class="product-quantity">Qty</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">#</th>
                                </tr>
                            </thead>
                            <tbody id="append">
                                
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
@endsection

@push('modal')
    <div class="modal fade" id="sewaModal" tabindex="-1" aria-labelledby="sewaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sewaModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('whislist.generateRent')}}" method="POST">
                    @csrf
                    <input type="hidden" name="whislists_id" id="whislists_id">
                    <input type="hidden" name="products_id" id="products_id">
                    <input type="hidden" name="size" id="size">
                    <input type="hidden" name="qty" id="qty">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" name="start_date" class="form-control" style="height: 35px; border: 2px solid #198754; width: 100%" id="start_date">
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Tanggal Selesai Sewa</label>
                            <input type="date" name="end_date" class="form-control" style="height: 35px; border: 2px solid #198754; width: 100%" id="end_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Sewa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            getWhislist();

            $(document).on('click', '.increase', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let qty = $(".quantity-amount").val();

                $.ajax({
                    url: "{{url('whislists/incrase')}}/" + id,
                    method: "PUT",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        getWhislist();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            $(document).on('click', '.decrease', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let qty = $(".quantity-amount").val();

                $.ajax({
                    url: "{{url('whislists/decrease')}}/" + id,
                    method: "PUT",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        getWhislist();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            $(document).on('click', '.checkout', function(e) {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{url('whislists/show')}}/" + id,
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#sewaModal").modal('show');

                        $("#sewaModalLabel").html(data.data.product.nm_produk);
                        $("#whislists_id").val(data.data.id);
                        $("#products_id").val(data.data.products_id);
                        $("#size").val(data.data.size);
                        $("#qty").val(data.data.qty);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: "Warning !",
                    text: "Anda yakin ingin membatalkan penyewaan ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Tidak",
                    confirmButtonText: "Ya",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('whislists/destroy')}}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                let timerInterval;
                                Swal.fire({
                                    icon: "success",
                                    title: "Barhasil...",
                                    html: "Merefresh page dalam <b></b> milliseconds.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector("b");
                                        timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                        getWhislist();
                                    }
                                }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        getWhislist();
                                    }
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                });
            })

            function getWhislist() {
                $.ajax({
                    url: "{{route('whislist.getWhislist')}}",
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        let html = '';
                        console.log(data);
                        if (data.data.length > 0) {
                            $.each(data.data, function(index, value) {
                                if (value.qty > 1) {
                                    html += `<tr>
                                                <td class="product-thumbnail">
                                                    <img src="${value.image}" width="80" alt="Image" class="img-fluid">
                                                </td>
                                                <td class="product-name">
                                                    <h4 class="h5 text-black text-start">${value.nm_produk}</h4>
                                                </td>
                                                <td>${value.size}</td>
                                                <td>Rp. ${value.price}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-outline-black decrease" data-id="${value.id}" type="button">&minus;</button>
                                                            </div>
                                                            <input type="text" class="form-control text-center quantity-amount" value="${value.qty}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-black increase" data-id="${value.id}" type="button">&plus;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp. ${value.total}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-black btn-sm checkout">Sewa Sekarang</a>
                                                    <a href="#">|</a>
                                                    <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-black btn-sm delete">Hapus</a>
                                                </td>
                                            </tr>`;
                                } else {
                                    html += `<tr>
                                                <td class="product-thumbnail">
                                                    <img src="${value.image}" width="80" alt="Image" class="img-fluid">
                                                </td>
                                                <td class="product-name">
                                                    <h4 class="h5 text-black text-start">${value.nm_produk}</h4>
                                                </td>
                                                <td>Rp. ${value.price}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                                                            <div class="input-group-prepend">
                                                            </div>
                                                            <input type="text" class="form-control text-center quantity-amount" value="${value.qty}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-black increase" data-id="${value.id}" type="button">&plus;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp. ${value.total}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-black btn-sm checkout">Sewa Sekarang</a>
                                                    <a href="javascript:void(0)">|</a>
                                                    <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-black btn-sm delete">Hapus</a>
                                                </td>
                                            </tr>`;
                                }
                            });
                        } else {
                            html += `<tr>
                                        <td colspan="7">Tidak Ada Data Whislist</td>
                                    </tr>`;
                        }
                        $("#append").html(html)
                    }, 
                    error: function(err) {
                        console.log(err);
                    }
                })
            }
        })
    </script>
@endpush