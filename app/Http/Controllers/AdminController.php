<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    // public function __construct()
    // {
    //     // seule  l'admin a le droit de voir AdminLoginForm et faire adminLogin
    //     $this->middleware("auth:admin")->except(['ShowAdminLoginForm','adminLogin']);
    // }

    public function index(){

        $products = Product::all();
        $orders = Order::all();

        return view ("admin.index")->with([
            "products"=>$products,
            "orders"=>$orders,
        ]);
    }

    public function ShowAdminLoginForm(){

        if(auth()->guard("admin")->check()){
            return redirect("/admin");
        }
        return view("admin.auth.login");
    }

    public function adminLogin(Request $request){
    
        // $request->validate([

        //     "email"=>["required","email"],
        //     "password"=>["required","min:4"]
        // ]);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        if(auth()->guard("admin")->attempt([

            "email" => $request->email,
            "password" => $request->password

            
        ],$request->get("remember"))){
            
            return redirect("/admin");

        }else{
            // $x = auth()->guard("admin")->attempt([  "email" => $request->email,  "password" => $request->password]);

            // dd($x);
            return redirect()->route("admin.login")->with([
                "errorLink"=>"email au mot de passe est incorrect"
            ]);
           
        }
    }
    public function adminLogout(){
        
        auth()->guard('admin')->logout();

        return redirect()->route("admin.login"); 
    }

    public function getProducts()
    {
        $products = Product::latest()->paginate(4);

        return view("admin.products.index")->with([
            "products" => $products
        ]);
        
    }

    public function getOrders()
    { 
        $orders = Order::latest()->paginate(4);

        return view("admin.orders.index")->with([
            "orders" => $orders
        ]);
        
        
    }
}   
