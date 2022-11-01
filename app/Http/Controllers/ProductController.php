<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();

        return view('product', compact('products'));
    }
    public function checkout()
    {
        $cartItems = \Cart::getContent();
        
        return view('checkout', compact('cartItems'));
    }
    public function proceedCheckout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $lineItems = [];
        foreach(\Cart::getContent() as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => 
                    [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout', [], true),
        ]);
        $order = new Order;
        $order->status = 'unpaid';
        $order->total_price = \Cart::getTotal();
        $order->session_id = $session->id;
        $order->save();
        
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
            if(!$session){
                throw new NotFoundHttpException();
            }
            $customer = \Stripe\Customer::retrieve($session->customer);
            $order = Order::where('session_id', $session->id)
                    ->where('status', 'unpaid')
                    ->first();
        }
        catch(\Exception $ex) {
            throw new NotFoundHttpException();
        }
        
        return view('success', compact('customer', 'order'));
    }

    public function cancel()
    {
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        // $stripe->paymentIntents->cancel('pi_32AkjQ5H4Bas2eAolX13', []);
        return view('cancel');
    }
}
