<?php

namespace App\Http\Controllers;

use App\Category;
use App\ItemPicture;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
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

    /**
     * Get category
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_category($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category', ['category' => $category]);

    }

    /**
     * Saving new category
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store_category(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required | max:50'
        ]);

        $category = new Category(['name' => $request->get('name')]);
        $result = $category->save();

        if ($result) {
            return response(['status' => 'ok'], 201);
        }
        return response(['status' => 'error'], 500);


    }

    /**
     * Updating  category
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * Show list of products
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function products(Request $request)
    {
        $products = Product::orderBy('id','desc')->paginate(10);
        return view('admin.products', ['products' => $products]);

    }


    /**
     * Get form for adding new product
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_product(Request $request)
    {
        $categories = Category::all();
        return view('admin.new_product', ['categories' => $categories]);
    }

    public function get_product($id)
    {
        $product = Product::with('pictures')->findOrFail($id);
        $categories =  Category::orderBy('name')->get();
        return view('admin.product', ['product' => $product, 'categories' => $categories]);

    }

    public function update_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required | max:50',
            'price' => 'required | numeric | min:0 | max:9999999',
            'description' => 'max:1000',
            'category'  => 'array',
            'category.*'  => 'numeric | integer',
        ]);

        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = floatval($request->get('price')) * Product::FACTOR;
        $productCategories = $request->get('category');

        $product->save();
        $product->categories()->sync($productCategories);
        $categories =  Category::orderBy('name')->get();

        session()->flash('alert-success', 'Product successfully updated');

        return view('admin.product', ['product' => $product, 'categories' => $categories]);

    }

    public function store_product(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required | max:50',
            'price' => 'required | numeric | min:0 | max:9999999',
            'description' => 'max:1000',
            'image_small.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
            'image_medium.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
            'image_large.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
            'category'  => 'array',
            'category.*'  => 'numeric | integer',
        ]);
        $productCategories = $request->get('category');

        $product = Product::create($request->all());
        $product->price = ceil($product->price * Product::FACTOR);
        $product->save();
        $product->categories()->sync($productCategories);

        foreach (['image_small','image_medium','image_large'] as $size)
        {
            if ($request->hasFile($size))
            {
                foreach ($request->file($size) as $image) {
                    $this->createItemPicture($image, $product->id, $size );
                }
            }
        }

        return redirect('admin', 201);
    }

    public function addPictures(Request $request, $id)
    {
        $validate = $request->validate([
            'image_small.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
            'image_medium.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
            'image_large.*' => 'image | mimes:jpeg,png,jpg,gif | max:2048',
        ]);

        $product = Product::findOrFail($id);
        foreach (['image_small','image_medium','image_large'] as $size)
        {
            if ($request->hasFile($size))
            {
                foreach ($request->file($size) as $image) {
                    $this->createItemPicture($image, $product->id, $size );
                }
            }
        }

        return response('ok');
    }

    public function deleteManyPictures(Request $request)
    {
        $validate = $request->validate([
            'ids' => 'array',
            'ids.*' => 'numeric | integer',
        ]);

        $ids = collect($request->get('ids'));
        $deleteCounter = 0;
        $pictures = ItemPicture::find($ids);
        if($pictures->isEmpty())
        {
            return response()->json(['status'=> 'error', 'count' => $deleteCounter,
                'message'=>'Not found any pictures, try check some checkboxes or reload page pls'],404);
        }
        $pictures->map(function ($picture) use (&$deleteCounter){
               if (Storage::exists('public/'.$picture->path)){

                   if(Storage::delete('public/'.$picture->path))
                   {
                       $deleteCounter++;
                   }
               }
              $picture->delete();
        });

        $responseData = [
            'status'    => "ok",
            'count'     => $deleteCounter,

        ];
        return response()->json($responseData,200);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        $result = $product->delete();
        if ($result)
        {
            session()->flash('alert-info',"Product with id: $id has been deleted");
        }
        return response()->json(['status'=>'ok'], 200);

    }

    /**
     * @param $image
     * @param $product
     * @return array
     */
    private function createItemPicture($image, int $product_id, string $size): array
    {
        switch ($size)
        {
            case 'image_large':
                $type = ItemPicture::IMAGE_SIZE_450;
                break;
            case 'image_medium':
                $type = ItemPicture::IMAGE_SIZE_250;
                break;
            case 'image_small':
            default:
                $type = ItemPicture::IMAGE_SIZE_110;
                break;
        }

        $path = $image->store('public/images');
        $filename = explode('/', $path);
        ItemPicture::create([
            'product_id' => $product_id,
            'size' => $type,
            'path' => implode('/', [$filename[1], $filename[2]])
        ]);
        return $filename;
    }
}
