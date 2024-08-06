@extends('layouts.admin')

@section('title')
    Data Pengembalian
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center" id="table" style="width: 100%">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white text-center">#Invoice</th>
                        <th class="text-white text-center">Nama Penyewa</th>
                        <th class="text-white text-center">Tanggal Penyewaan</th>
                        <th class="text-white text-center">Tanggal Pengembalian</th>
                        <th class="text-white text-center">Selisih Hari</th>
                        <th class="text-white text-center">Denda</th>
                        <th class="text-white text-center">#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{asset('admin')}}/modules/sweetalert/sweetalert.min.js"></script>
    <script src="{{asset('admin')}}/js/page/modules-sweetalert.js"></script>
    <script>
        $(document).ready(function() {
            let table = $("#table").DataTable({
                serverSide: true,
                ajax: "{{route('admin.rented')}}",
                columns: [
                    {data: "invoice"},
                    {data: "name"},
                    {data: "tgl_sewa"},
                    {data: "tgl_kembali"},
                    {data: "selisih"},
                    {data: "denda"},
                    {data: "action"},
                ]
            })

            // $(document).on('click', '.confirmation', function(e) {
            //     e.preventDefault();
            //     let id = $(this).data('id');
            //     swal({
            //         title: 'Info',
            //         text: 'Apakah anda yakin ingin mengkonfirmasi pengiriman produk ini?',
            //         icon: 'info',
            //         buttons: true,
            //         dangerMode: true,
            //     })
            //     .then((willDelete) => {
            //         if (willDelete) {
            //             $.ajax({
            //                 url: `{{url('admins/orders/${id}/confirmationSendingPackage')}}`,
            //                 method: 'PUT',
            //                 dataType: 'json',
            //                 success: function(data) {
            //                     Toastify({
            //                         text: "Berhasil Mengirimkan Pesanan.",
            //                         duration: 3000,
            //                         close: true,
            //                         gravity: "top", // `top` or `bottom`
            //                         position: "right", // `left`, `center` or `right`
            //                         stopOnFocus: true, // Prevents dismissing of toast on hover
            //                         style: {
            //                             background: "#729D88",
            //                         },
            //                         onClick: function(){} // Callback after click
            //                     }).showToast();
            //                     table.draw();
            //                 },
            //                 error: function(err) {
            //                     console.log(err);
            //                 }
            //             })
            //         }
            //     });
            // })
        })
    </script>
@endpush