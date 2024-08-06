<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::take(4)->orderBy('id', 'DESC')->get();
        return view('pages.home', compact('product'));
    }
}
