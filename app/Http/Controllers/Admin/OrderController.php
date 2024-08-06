<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $rents = Rent::with('user', 'product', 'return_product')
                ->whereDoesntHave('return_product')
                ->orderBy('id', 'DESC')
                ->get();
            return DataTables::of($rents)
                ->addColumn('invoice', function ($row) {
                    return '<a href="' . route('admin.order.show', ['invoice' => $row->invoice]) . '"><b>#' . $row->invoice . '</b></a>';
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('telp', function ($row) {
                    return $row->user->telp;
                })
                ->addColumn('days', function ($row) {
                    $startDate = Carbon::parse($row->start_date);
                    $endDate = Carbon::parse($row->end_date);
                    $numberOfDay = $startDate->diffInDays($endDate);
                    return $numberOfDay;
                })
                ->addColumn('total', function ($row) {
                    return 'Rp.' . number_format($row->total);
                })
                ->addColumn('action', function ($row) {
                    if ($row->status === 'sent') {
                        $btn = '<a href="' . route('admin.order.show', ['invoice' => $row->invoice]) . '" class="btn btn-primary btn-sm mr-2" title="Detail Penyewaan"><i class="fas fa-eye"></i></a>';
                    } else {
                        $btn = '<a href="' . route('admin.order.show', ['invoice' => $row->invoice]) . '" class="btn btn-primary btn-sm mr-2" title="Detail Penyewaan"><i class="fas fa-eye"></i></a>';
                        $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-info btn-sm confirmation" title="Konfirmasi Pengiriman"><i class="fas fa-truck"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status === 'pending') {
                        $sts = '<span class="badge bg-warning text-white p-2">Belum Melakukan Pembayaran</span>';
                    } else if ($row->status === 'paid') {
                        $sts = '<span class="badge bg-primary text-white p-2">Menunggu Pengiriman</span>';
                    } else if ($row->status === 'sent') {
                        $sts = '<span class="badge bg-primary text-white p-2">Sudah Di Kirimkan</span>';
                    }
                    return $sts;
                })
                ->rawColumns(['action', 'invoice', 'status'])
                ->toJson();
        }
        return view('admin.order.index');
    }

    public function show($invoice)
    {
        $rent = Rent::with('user', 'product')->where('invoice', $invoice)->first();
        return view('admin.order.show', compact('rent'));
    }

    public function generateInvoice($invoice)
    {
        $rent = Rent::with('user', 'product')->where('invoice', $invoice)->first();
        return view('admin.order.invoice', compact('rent'));
    }

    public function confirmationSendingPackage($id)
    {
        $rent = Rent::find($id);
        $rent->update(['status' => 'sent']);

        return response()->json(200);
    }
}
