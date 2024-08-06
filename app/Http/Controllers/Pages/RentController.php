<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RentController extends Controller
{
    public function index($invoice)
    {
        $rents = Rent::with('user', 'product')->where('invoice', $invoice)->first();
        return view('pages.rent.index', compact('rents'));
    }

    public function generateRent(Request $request)
    {
        $request->validate([
            'size' => 'required',
            'qty' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $latest_index = Rent::latest()->first();
        $rents_index = $latest_index == null ? 1 : $latest_index["rents_index"] + 1;
        $invoice = "";

        for ($i = 0; $i < 4 - Str::length($rents_index); $i++) {
            $invoice .= "0";
        }

        $post = $request->all();

        $invoiceSave = "INV-" . $invoice . $rents_index;
        $post['invoice'] = $invoiceSave;
        $post['rents_index'] = $rents_index;
        $post['users_id'] = Auth::user()->id;
        $post['products_id'] = $request->products_id;
        $post['size'] = $request->size;
        $post['qty'] = $request->qty;
        $post['start_date'] = $request->start_date;
        $post['end_date'] = $request->end_date;

        Rent::create($post);

        return redirect()->route('rent', ['invoice' => $invoiceSave]);
    }

    public function updatePaidRent(Request $request, $invoice)
    {
        $request->validate([
            'jasa_kirim' => 'required',
            'pembayaran' => 'required',
        ]);

        $rents = Rent::where('invoice', $invoice)->first();

        if ($rents) {
            $rents->update([
                'jasa_kirim' => $request->jasa_kirim,
                'pembayaran' => $request->pembayaran,
                'catatan' => $request->catatan,
                'total' => $request->total,
                'status' => 'paid'
            ]);

            $title = 'Success';
            $message = 'Berhasil Melakukan Penyewaan';
        } else {
            $title = 'Invalid';
            $message = 'Gagal Melakukan Penyewaan';
        }

        return redirect()->route('alert.rent', ['title' => $title, 'message' => $message]);
    }
}
