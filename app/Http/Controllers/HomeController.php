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
     * Show all products
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query()->orderBy('id','desc');
        $queries = [];
        $queryCategories = explode(',',$request->get('categories'));
        if ( request()->has('categories') )
        {
            $products = $products->hasCategories($queryCategories);

            $queries[ 'categories' ] = request('categories');
        }

        $links = $products->paginate(12)->appends($queries)->links();

//        $products = Product::orderBy('id','desc')->paginate(12);
        $categories = Category::all();

        return view('home', ['products' => $products->get(), 'links' => $links, 'categories'=> $categories]);
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

    /**
     * List of products by category.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProductsByCategory($id)
    {
        $products = Product::with('pictures')->hasCategories([$id]);
        $categories = Category::all();

        $links = $products->paginate(12)->links();

        return view('home', ['products' => $products->get(), 'categories'=> $categories, 'links' => $links, 'currentCategory'=>$id]);
    }
}
