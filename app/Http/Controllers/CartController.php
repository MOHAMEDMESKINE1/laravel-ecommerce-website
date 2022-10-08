<?php

namespace App\Http\Controllers;



use App\Models\Product;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;


class CartController extends Controller
{
    //return cart items

    // Here we used Gloudemans package cart
    public function index(){

    
        return view("cart.index")->with([
            "items"=>Cart::content()
        ]);
    }
    // add item to cart
    public function addProductToCart(Request $request,Product $product){
        
       Cart::add(array(
            "id"=>$product->id,
            "name"=>$product->title,
            "price"=>$product->price,
            "qty"=>$request->qty,
            "associate"=>$product,
            // add image 
            'options' => ['size' => 'large', 'image' => $product->image],
            
           
        ));
        return redirect()->route('cart.index');
    }
    // update product 
    public function updateProductOnCart(Request $request,Product $product){
        
        Cart::update($product->id,array(
            "qty"=>array(
                'relative' => false,
                'value' => $request->qty 
            )
          
        ));
        return redirect()->route('cart.index');
    }
    // remove item from cart 
    public function removeProductFromCart(Product $product){
        
        Cart::remove($product->id);

        return redirect()->route("cart.index") ;
    }
}
