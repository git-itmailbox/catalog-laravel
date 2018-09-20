<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('home', ['products' => $products]);
    }

    /**
     * Show one product.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        $product = Product::with('pictures')->find($id);
        $categories = $product->categories;

        return view('product', ['product' => $product, 'categories'=> $categories]);
    }
}
