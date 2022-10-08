<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
        // $this->middleware('auth');
    }

    /**
     * Show products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::latest()->paginate(4);
        $categories =Category::has('products')->get();
        
        return view('home')->with([
            "products"=>$products,
            "categories"=>$categories,
        ]);
        // display a cetgory how have a product
        /*
         "categories"=>Category::has('products')->get(),
        */
    }
    /**
     * Show products by category.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProductByCategory(Category $category)
    {
        
        $products = $category->products()->paginate(10);
        $categories = Category::has('products')->get();
        
        return view('home')->with([
            "products"=>$products,
            "categories"=>$categories,
        ]);
       
    }
}
