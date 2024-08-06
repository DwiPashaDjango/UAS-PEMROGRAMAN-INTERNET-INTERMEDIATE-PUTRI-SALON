@extends('layouts.admin')

@section('title')
    Data Designer
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <a href="javascript:void(0)" class="btn btn-primary add"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
            <thead class="bg-primary">
                <tr>
                    <th class="text-white text-center">No</th>
                    <th class="text-white text-center">Nama Designer</th>
                    <th class="text-white text-center">Specialist Designer</th>
                    <th class="text-white text-center">No Telephone</th>
                    <th class="text-white text-center">#</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('modal')
    <x-modal id="designerModal">
        <div class="modal-header">
            <h5 class="modal-title" id="designerModaltitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="submit">
            <div class="modal-body">
                <div id="loading"></div>
                <input type="hidden" name="id" id="id">
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Nama Designer</label>
                    <input type="text" name="name" id="name" class="form-control name">
                    <span class="text-danger-name"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Specialist Designer</label>
                    <input type="text" name="specialist" id="specialist" class="form-control specialist">
                    <span class="text-danger-specialist"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">No Telephone</label>
                    <input type="text" name="telp" id="telp" class="form-control telp">
                    <span class="text-danger-telp"></span>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Batal</button>
                <button type="submit" id="save" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </x-modal>
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{asset('admin')}}/modules/sweetalert/sweetalert.min.js"></script>
    <script src="{{asset('admin')}}/js/page/modules-sweetalert.js"></script>
    <script>
        $(document).ready(function() {
            let table = $('#table').DataTable({
                serverSide: true,
                ajax: "{{route('designer')}}",
                columns: [
                    {data: "DT_RowIndex"},
                    {data: "name", "searchlabel": true},
                    {data: "specialist", "searchlabel": true},
                    {data: "telp", "searchlabel": true},
                    {data: "action", "searchlabel": false},
                ]
            });

            $(".add").click(function(e) {
                e.preventDefault();
                $("#designerModal").modal('show');
                $("#designerModaltitle").html('Tambah Designer');
                $("#save").addClass('store');
                $("#save").removeClass('update');
            })

            $(".cancel").click(function() {
                $("#submit")[0].reset()
                $("#save").removeClass('store');
                $("#save").removeClass('update');
            })

            $(document).on('click', '.store', function(e) {
                e.preventDefault();

                let form = document.getElementById('submit')
                let formData = new FormData(form);

                $("#loading").html('<div class="alert alert-primary"><b>Menyimpan Data....</b></div>');

                $.ajax({
                    url: "{{route('designer.store')}}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#loading").html('');
                        if (data.errors) {
                            $.each(data.errors, function(index, value) {
                                $("#" + index).addClass('is-invalid');

                                Toastify({
                                    text: value,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "#FD6161",
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();

                                setTimeout(() => {
                                    $("#" + index).removeClass('is-invalid');
                                }, 3000);
                            })
                        } else {
                            $("#designerModal").modal('hide');
                            $("#submit")[0].reset()
                            Toastify({
                                text: "Berhasil Menyimpan Data.",
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
                            table.draw();
                        }
                    },
                    erorr: function(err) {
                        Toastify({
                            text: "Server Error.",
                            duration: 3000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#FD6161",
                            },
                            onClick: function(){} // Callback after click
                        }).showToast();
                    }
                })
            });

            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{url('admins/designers/show')}}/" + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let datas = data.data;
                        $("#designerModal").modal('show');
                        $("#designerModaltitle").html('Edit Designer');
                        $("#save").removeClass('store');
                        $("#save").addClass('update');

                        $("#id").val(datas.id);
                        $("#name").val(datas.name);
                        $("#specialist").val(datas.specialist);
                        $("#telp").val(datas.telp);
                    },
                    error: function(err) {
                        console.log(err);
                        Toastify({
                            text: "Server Error.",
                            duration: 3000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#FD6161",
                            },
                            onClick: function(){} // Callback after click
                        }).showToast();
                    }
                })
            })

            $(document).on('click', '.update', function(e) {
                e.preventDefault();

                let form = document.getElementById('submit')
                let formData = new FormData(form);

                $("#loading").html('<div class="alert alert-primary"><b>Mengubah Data....</b></div>');

                $.ajax({
                    url: "{{route('designer.update')}}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#loading").html('');
                        if (data.errors) {
                            $.each(data.errors, function(index, value) {
                                $("#" + index).addClass('is-invalid');

                                Toastify({
                                    text: value,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "#FD6161",
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();

                                setTimeout(() => {
                                    $("#" + index).removeClass('is-invalid');
                                }, 3000);
                            })
                        } else {
                            $("#designerModal").modal('hide');
                            $("#submit")[0].reset()
                            Toastify({
                                text: "Berhasil Mengubah Data.",
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
                            table.draw();
                        }
                    },
                    erorr: function(err) {
                        Toastify({
                            text: "Server Error.",
                            duration: 3000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#FD6161",
                            },
                            onClick: function(){} // Callback after click
                        }).showToast();
                    }
                })
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                swal({
                    title: 'Warning !',
                    text: 'Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{url('admins/designers/destroy')}}/" + id,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(data) {
                                Toastify({
                                    text: "Berhasil Menghapus Data.",
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
                                table.draw();
                            },
                            error: function(err) {
                                console.log(err);
                                Toastify({
                                    text: "Server Error.",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "#FD6161",
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();
                            }
                        })
                    }
                });
            })
        })
    </script>
@endpush