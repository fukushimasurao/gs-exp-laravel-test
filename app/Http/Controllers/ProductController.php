<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // DBの中身を取得
        // それをviewに渡す
        $products = Product::all();
        return view('products', compact('products'));
    }
}
