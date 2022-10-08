<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Srmklive\PayPal\Services\ExpressCheckout ;
class PayPalPaymentsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function handlePayment(){
        $data = [];
        $data['items'] = [];

        foreach (Cart::content() as $item) {
           
            array_push($data['items'], [
                'name' => $item->name,
                'price' => (int) ($item->price / 9),
                'desc' => $item->associate('product')->description,
                'qty' => $item->quantity
            ]);
        }


        $data['invoice_id'] = auth()->user()->id;
        $data['invoice_description'] = "Commande #{$data['invoice_id']}";
        $data['return_url'] = route('success.payment');
        $data['cancel_url'] = route('cancel.payment');

        $total = 0;
        
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
        $paypalModule = new ExpressCheckout;

        $res = $paypalModule->setExpressCheckout($data);
        $res = $paypalModule->setExpressCheckout($data, true);

        return redirect($res['paypal_link']);
    }

    public function cancelPayment(){
        
        return redirect()->route('cart.index')->with([
            "info"=>"vous avez anuulé le paiment"
        ]);
    }
    
    public function paiementSuccess(Request $request){

        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->getExpressionCheckoutDetails($request->token);

        if(in_array(strtoupper($response['ACK']),['SUCCESS','SUCCESSWITHWARNING'])){

            foreach (Cart::content() as $item) {

                Order::create([
                    
                    "user_id"=>auth()->user()->id,
                    "product_name"=>$item->name,
                    "qty"=>$item->qty,
                    "price"=>$item->price,
                    "total"=>$item->price * $item->qty,
                    "paid"=>1,

                ]);
                Cart::clear();
            }
        }
        return redirect()->route('cart.index')->with([
            'success' => 'Paid successfully'
        ]);
    }
}
