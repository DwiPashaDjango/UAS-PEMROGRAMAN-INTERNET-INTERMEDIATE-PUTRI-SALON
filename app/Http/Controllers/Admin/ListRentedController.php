<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListRentedController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $rented = Pengembalian::with('user', 'rent', 'denda')->orderBy('id', 'DESC')->get();
            return DataTables::of($rented)
                ->addColumn('invoice', function ($row) {
                    return '<a href="' . route('admin.rented.show', ['invoice' => $row->invoice]) . '"><b>#' . $row->invoice . '</b></a>';
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('tgl_sewa', function ($row) {
                    return Carbon::parse($row->rent->start_date)->translatedFormat('d F Y') . ' - ' . Carbon::parse($row->rent->end_date)->translatedFormat('d F Y');
                })
                ->addColumn('tgl_kembali', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('selisih', function ($row) {
                    $endDate = Carbon::parse($row->rent->end_date);
                    $rentedDate = Carbon::parse($row->created_at);

                    $selisih = $endDate->diffInDays($rentedDate);
                    return $selisih;
                })
                ->addColumn('denda', function ($row) {
                    $endDate = Carbon::parse($row->rent->end_date);
                    $rentedDate = Carbon::parse($row->created_at);

                    $selisih = $endDate->diffInDays($rentedDate);
                    return 'Rp. ' . number_format($selisih * 20000);
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.rented.show', ['invoice' => $row->invoice]) . '" class="btn btn-primary btn-sm mr-2" title="Detail Penyewaan"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->RawColumns(['action', 'invoice'])
                ->toJson();
        }
        return view('admin.rented.index');
    }

    public function show($invoice)
    {
        $rented = Pengembalian::with('user', 'rent', 'denda', 'product')->where('invoice', $invoice)->first();
        return view('admin.rented.show', compact('rented'));
    }
}
