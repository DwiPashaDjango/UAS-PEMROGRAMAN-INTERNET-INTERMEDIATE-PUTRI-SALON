<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Whislist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $product = Product::with('designer');

        if (!empty($search)) {
            $product->where('nm_produk', 'like', '%' . $search . '%')->paginate(8);
        }

        $products = $product->orderBy('id', 'DESC')->paginate(8);

        return view('pages.product.product', compact('products'));
    }

    public function show(string $id)
    {
        $product = Product::with('designer')->where('id', $id)->first();
        $comment = Comment::with('user')->where('products_id', $id)->orderBy('id', 'DESC')->paginate(3);

        $latestProduct = Product::take(5)->orderBy('id', 'DESC')->get();

        return view('pages.product.detail', compact('product', 'comment', 'latestProduct'));
    }

    public function saveWhislist(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'size' => 'required',
            'qty' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json(['status' => 400, 'errors' => $validation->errors()]);
        }

        $product = Product::where('id', $request->products_id)->first();
        $total = $request->qty * $product->harga;

        Whislist::create([
            'users_id' => Auth::user()->id,
            'products_id' => $request->products_id,
            'size' => $request->size,
            'qty' => $request->qty,
            'total' => $total
        ]);

        return Response::json(['status' => 200, 'message' => 'Berhasil menambahkan produk ke whislist.']);
    }
}
