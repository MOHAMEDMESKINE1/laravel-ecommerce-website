<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PayPalPaymentsController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(["reset"=>false]);

Route::view('/welcome','welcome');

Route::get('/',[HomeController::class,'index']);



// activation email
route::controller(CartController::class)->group(function(){

    Route::get("/activate/{code}",'activateUserAccount')->name("user.activate");
    Route::get("/resend/{email}",'resendActivationCode')->name("code.resend");
    
});



// product routes
Route::resource("/products",'App\\Http\\Controllers\ProductController');
Route::get("products/category/{category}",[HomeController::class,'getProductByCategory'])->name("category.products");



// cart routes
route::controller(CartController::class)
->group(function(){

    Route::get("/cart",'index')->name("cart.index");
    Route::post("/add/cart/{product}",'addProductToCart')->name('add.cart');
    Route::put("/update/{product}/cart",'updateProductOnCart')->name('update.cart');
    Route::delete("/remove/{product}/cart",'removeProductFromCart')->name('remove.cart');
});


// payment routes
route::controller(PayPalPaymentsController::class)
->group(function(){

    Route::get("/handle-payment",'handlePayment')->name('make.payment');
    Route::get("/cancel-payment",'cancelPayment')->name('cancel.payment');
    Route::get("/success-payment",'paiementSuccess')->name('success.payment');
    
});


// admin routes 
route::controller(AdminController::class)
->prefix('admin')
->name('admin.')
->group(function(){

    Route::get('/','index')->name('index');
    Route::get('/login','ShowAdminLoginForm')->name('login');
    Route::post('/login','adminLogin')->name('login');
    Route::get('/logout','adminLogout')->name('logout');
    Route::get('/products','getProducts')->name('products');
    Route::get('/orders','getOrders')->name('orders');

});

// orders routes
Route::resource("/orders",'App\\Http\\Controllers\OrderController');

