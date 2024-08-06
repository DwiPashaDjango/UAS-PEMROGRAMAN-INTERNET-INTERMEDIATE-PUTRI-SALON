<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class RentedController extends Controller
{
    public function index()
    {
        $rents = Rent::with('product', 'return_product')
            ->where('users_id', Auth::user()->id)
            ->withCount('return_product')
            ->orderBy('id', 'DESC')
            ->get();
        return view('pages.rented.index', compact('rents'));
    }

    public function show($invoice)
    {
        $rents = Rent::with('product', 'user')->where('invoice', $invoice)->first();
        return view('pages.rented.show', compact('rents'));
    }

    public function returnRents(Request $request)
    {
        if ($request->status === 'denda') {
            $request->validate([
                'jasa_kirim' => 'required',
                'pembayaran' => 'required'
            ]);
        } else {
            $request->validate([
                'jasa_kirim' => 'required',
            ]);
        }

        $latest_index = Pengembalian::latest()->first();
        $return_index = $latest_index == null ? 1 : $latest_index["return_index"] + 1;

        $invoice = "";

        for ($i = 0; $i < 4 - Str::length($return_index); $i++) {
            $invoice .= "0";
        }

        $invoiceSave = "RTN-" . $invoice . $return_index;

        if ($request->status === 'denda') {
            $return = Pengembalian::create([
                'invoice' => $invoiceSave,
                'return_index' => $return_index,
                'users_id' => Auth::user()->id,
                'rents_id' => $request->rents_id,
                'products_id' => $request->products_id,
                'jasa_kirim' => $request->jasa_kirim,
                'pembayaran' => $request->pembayaran,
                'catatan' => $request->catatan,
            ]);

            Denda::create([
                'rents_id' => $request->rents_id,
                'pengembalians_id' => $return->id,
                'total_denda' => $request->total_denda,
            ]);
        } else {
            Pengembalian::create([
                'invoice' => $invoiceSave,
                'return_index' => $return_index,
                'users_id' => Auth::user()->id,
                'rents_id' => $request->rents_id,
                'products_id' => $request->products_id,
                'jasa_kirim' => $request->jasa_kirim,
                'pembayaran' => $request->pembayaran,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('alert.rent', ['title' => 'Success', 'message' => 'Berhasil Melakukan Pengembalian Produk']);
    }

    public function canceled($id)
    {
        $rents = Rent::where('id', $id)->first();

        if (!$rents) {
            return Response::json(['status' => 404, 'message' => 'Rents Not Found.']);
        }

        $rents->delete();

        return Response::json(['status' => 200, 'message' => 'Berhasil membatalkan penyewaan.']);
    }

    public function generateRentInvoice($invoice)
    {
        $rents = Rent::with('product', 'user')->where('invoice', $invoice)->first();
        return view('pages.rented.invoice-sewa', compact('rents'));
    }

    public function generateReturnInvoice($invoice)
    {
        $return = Pengembalian::with('rent', 'rent.product', 'user', 'denda')->where('invoice', $invoice)->first();
        return view('pages.rented.invoice-return', compact('return'));
    }
}
