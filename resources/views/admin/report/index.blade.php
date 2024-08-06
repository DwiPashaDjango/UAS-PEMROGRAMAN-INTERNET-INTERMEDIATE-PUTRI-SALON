@extends('layouts.admin')

@section('title')
    Laporan Bulanan
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <nav class="nav nav-pills flex-column flex-sm-row">
                <a class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="{{route('admin.report')}}">Laporan Penyewaan</a>
                <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="{{route('admin.report.rented')}}">Laporan Pengembalian</a>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-2 mt-2">
                <form action="{{route('admin.report')}}" method="GET">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                @php
                                    $months = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember'
                                    ];
                                @endphp
                                <select name="month" id="month" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @foreach ($months as $number => $name)
                                        <option value="{{ $number }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                @php
                                    $currentYear = date('Y');
                                @endphp
                                <select name="year" id="year" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @for ($year = $currentYear; $year > $currentYear - 5; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary w-100 mt-1">Tampilkan</button>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($month) && !empty($years))
                                <a target="_blank" href="{{route('admin.report.printReportRent', ['month' => $month, 'years' => $years])}}" class="btn btn-danger w-100 mt-1">Cetak</a>
                            @else
                                <a target="_blank" href="{{route('admin.report.printReportRent', ['month' => \Carbon\Carbon::now()->month, 'years' => \Carbon\Carbon::now()->year])}}" class="btn btn-danger w-100 mt-1">Cetak</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="alert alert-primary">
                @if (!empty($month) && !empty($years))
                    Laporan Penyewaan Bulan {{$month}} Tahun {{$years}}
                @else
                    Laporan Penyewaan Bulan {{\Carbon\Carbon::now()->month}} Tahun {{\Carbon\Carbon::now()->year}}
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white">No</th>
                            <th class="text-white">Nama Penyewa</th>
                            <th class="text-white">Produk</th>
                            <th class="text-white">Harga</th>
                            <th class="text-white">Qty</th>
                            <th class="text-white">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rents as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->product->nm_produk}}</td>
                                <td>{{number_format($item->product->harga)}}</td>
                                <td>{{$item->qty}}</td>
                                <td>
                                    Rp. {{number_format($item->qty * $item->product->harga)}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @if (!empty($month) && !empty($year))
                                    <td colspan="6">Tidak Ada Data Penyewaan Di Bulan {{$month}} Tahun {{$years}} </td>
                                @else
                                    <td colspan="6">Tidak Ada Data Penyewaan Di Bulan Tahun </td>
                                @endif
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('js')
    
@endpush