<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        // admin qui a l'autorisation de faire crud except index et show qui seront affiché au public  ...

        // $this->middleware("auth:admin")->except([
        //     "index","show"
        // ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(4);
        $categories = Category::has('products')->get();
    
        return view('home')->with([
            "products"=> $products,
            "categories"=> $categories,
          

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        
        return view("admin.products.create")->with([
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //validation
        $validated = $request->validated();

        //insert data
        if($request->has('image')){

            // get the image
            $file = $request->image ;
            // path image
            $image = "images/products/".time()."_".$file->getClientOriginalName();
            // insert image
            $file->move(public_path("images/products"),$image);
            
            // title
            $title = $request->title;
            // description
            $description = $request->description;
            // price
            $price = $request->price;
            // old_price
            $old_price = $request->old_price;
            // inStock
            $inStock = $request->inStock;
            // category_id
            $category_id = $request->category_id;
            // old_price
            $old_price = $request->old_price;

            Product::create([
                "title"=>$title,
                "slug"=>Str::slug($title),
                "description"=> $description, 
                "price"=> $price, 
                "old_price"=> $old_price, 
                "inStock"=> $inStock, 
                "category_id"=> $category_id, 
                "image"=> $image, 
            ]);
            // redirection

            return redirect()->route('admin.products')->withSuccess("Product est bien ajouté !");
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        if($product){

            return view("products.show")->with([
                "product"=> $product
            ]);
        }
        // not find product
        abort(404);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();

        return view("admin.products.edit")->with([
            "product" => $product,
            "categories" => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        
                //validation
                $this->validate($request, [
                    "title" => "required|min:3",
                    "description" => "required|min:5",
                    "image" => "image|mimes:png,jpg,jpeg|max:2048",
                    "price" => "required|numeric",
                    "category_id" => "required|numeric",
                ]);

                //update data
                if($request->has('image')){                 
                    // path image
                    $image_path =public_path("images/products/".$product->image);
                  
                    if(File::exists($image_path)){
                        // unlink ==> remove image  
                        unlink($image_path);
                    }
                    // store image in public folder
                    $file  = $request->image;
                    $imageName = "images/products/".time()."_".$file->getClientOriginalName();
                    $file->move(public_path("images/products"),$imageName);
                   
                    // update image
                    $product->image = $imageName;
                }  
                    // title
                    $title = $request->title;
                    // description
                    $description = $request->description;
                    // price
                    $price = $request->price;
                    // old_price
                    $old_price = $request->old_price;
                    // inStock
                    $inStock = $request->inStock;
                    // category_id
                    $category_id = $request->category_id;
                    // old_price
                    $old_price = $request->old_price;
                    // image
                    $image = $request->image;
        

                    $product->update([
                        "title"=>$title,
                        "slug"=>Str::slug($title),
                        "description"=> $description, 
                        "price"=> $price, 
                        "old_price"=> $old_price, 
                        "inStock"=> $inStock, 
                        "category_id"=> $category_id, 
                        "image"=>  $image, 
                    ]);

                    // redirection
                    return redirect()->route('admin.products')->withSuccess("Product est bien modifié");
                      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //delete image path
        $image_path = public_path("images/products/".$product->image);

        if(File::exists($image_path)){
            unlink($image_path);
        }
        // delete data
        $product->delete();

        //redirect to admin products
        return redirect()->route('admin.products')->withSuccess("Produit est bien supprimé ");
    }
}
