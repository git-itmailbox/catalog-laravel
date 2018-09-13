<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show all categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $categories = Category::all();

        return view('admin.categories', ['categories' => $categories]);
    }

    public function get_category($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category', ['category' => $category]);

    }

    public function store_category(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required | max:50'
        ]);

        $category = new Category(['name'=> $request->get('name')]);
        $result  = $category->save();

        if ($result)
        {
            return response(['status'=>'ok'], 201);
        }
        return response(['status'=>'error'], 500);


    }

    public function update_category(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required | max:50'
        ]);

        $category->name = $request->get('name');

        $category->save();

        return view('admin.category', ['category' => $category]);

    }
}
