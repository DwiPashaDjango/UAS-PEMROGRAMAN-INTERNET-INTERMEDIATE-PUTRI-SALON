<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\Whislist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.cart');
    }

    public function getWhislist()
    {
        $whislist = Whislist::with('product')
            ->where('users_id', Auth::user()->id)
            ->get();

        if (!$whislist) {
            return Response::json(['status' => 404, 'message' => 'Whislist Not Found.']);
        }

        foreach ($whislist as $value) {
            $image = explode('|', $value->product->image);
            $value->image = asset($image[0]);
            $value->price = number_format($value->product->harga);
            $value->total = number_format($value->total);
            $value->nm_produk = Str::limit($value->product->nm_produk, 20, '...');
        }

        return Response::json(['status' => 200, 'data' => $whislist]);
    }

    public function incrase($id)
    {
        $whislist = Whislist::with('product')->find($id);
        $qty = $whislist->qty + 1;
        $total = $qty * $whislist->product->harga;

        $whislist->qty = $qty;
        $whislist->total = $total;
        $whislist->save();
        return Response::json(['status' => 200, 'message' => true]);
    }

    public function decrease($id)
    {
        $whislist = Whislist::with('product')->find($id);
        $qty = $whislist->qty - 1;
        $total = $qty * $whislist->product->harga;

        $whislist->qty = $qty;
        $whislist->total = $total;
        $whislist->save();
        return Response::json(['status' => 200, 'message' => true]);
    }

    public function show($id)
    {
        $whislist = Whislist::with('product')->where('id', $id)->first();

        if (!$whislist) {
            return Response::json(['status' => 400, 'message' => 'Data Not Found.']);
        }

        return Response::json(['status' => 200, 'data' => $whislist]);
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

        $invoiceSave = "INV-" . $invoice . $rents_index;

        Rent::create([
            'invoice' => $invoiceSave,
            'rents_index' => $rents_index,
            'users_id' => Auth::user()->id,
            'products_id' => $request->products_id,
            'size' => $request->size,
            'qty' => $request->qty,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        Whislist::where('id', $request->whislists_id)->delete();

        return redirect()->route('rent', ['invoice' => $invoiceSave]);
    }

    public function destroy($id)
    {
        $whislist = Whislist::where('id', $id)->first();

        if (!$whislist) {
            return Response::json(['status' => 400, 'message' => 'Whislist Not Found.']);
        }

        $whislist->delete();

        return Response::json(['status' => 200, 'message' => 'Berhasil menghapus whislist.']);
    }
}
