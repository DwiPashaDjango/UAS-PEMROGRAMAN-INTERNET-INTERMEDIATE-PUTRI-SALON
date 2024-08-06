<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desginer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $product = Product::with('designer');

        if (!empty($search)) {
            $product->where('nm_produk', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orderBy('id', 'DESC')
                ->paginate(5);
        }

        $products = $product->orderBy('id', 'DESC')->paginate(5);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $designer = Desginer::select('id', 'name')->get();
        return view('admin.product.create', compact('designer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'desginers_id' => 'required',
            'nm_produk' => 'required',
            'type' => 'required',
            'size' => 'required',
            'warna' => 'required',
            'brand' => 'required',
            'stock' => 'required',
            'harga' => 'required',
            'harga_next' => 'required',
            'deskripsi_singkat' => 'required',
            'deskripsi' => 'required',
            'image' => 'required|array',
            'image*' => 'required|mimes:png,jpg,jpeg',
        ]);

        $post = $request->all();

        $price = str_replace('.', '', $request->harga);
        $price_next = str_replace('.', '', $request->harga_next);
        $size = implode('|', $request->size);

        $imagePath = [];
        foreach ($request->image as $img) {
            $imgName = rand() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('produk'), $imgName);

            $imagePath[] = 'produk/' . $imgName;
        }

        $imageString = implode('|', $imagePath);

        $post['harga'] = $price;
        $post['harga_next'] = $price_next;
        $post['size'] = $size;
        $post['image'] = $imageString;

        Product::create($post);
        return redirect()->route('admin.product')->with('message', 'Berhasil Menambahkan Produk');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $designer = Desginer::select('id', 'name')->get();
        return view('admin.product.edit', compact('designer', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'desginers_id' => 'required',
            'nm_produk' => 'required',
            'type' => 'required',
            'size' => 'required',
            'warna' => 'required',
            'brand' => 'required',
            'stock' => 'required',
            'harga' => 'required',
            'harga_next' => 'required',
            'deskripsi_singkat' => 'required',
            'deskripsi' => 'required',
            'image' => 'array',
            'image*' => 'mimes:png,jpg,jpeg',
        ]);

        $data = Product::find($id);

        $put = $request->all();

        $price = str_replace('.', '', $request->harga);
        $price_next = str_replace('.', '', $request->harga_next);
        $size = implode('|', $request->size);

        if ($request->hasFile('image')) {
            $imagePath = [];
            foreach ($request->image as $img) {
                $imgName = rand() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('produk'), $imgName);

                $imagePath[] = 'produk/' . $imgName;
            }

            $imageString = implode('|', $imagePath);
            $put['image'] = $imageString;
        }

        $put['harga'] = $price;
        $put['harga_next'] = $price_next;
        $put['size'] = $size;

        $data->update($put);
        return redirect()->route('admin.product')->with('message', 'Berhasil Mengubah Produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id)->first();

        if (!$product) {
            return Response::json(['status' => 404, 'message' => 'Produk Not Found.']);
        }

        $product->delete();
        return Response::json(['status' => 200, 'message' => 'Berhasil menghapus produk.']);
    }
}
