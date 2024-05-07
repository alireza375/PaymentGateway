<?php

namespace App\Http\Controllers;

use App\Models\Stripe;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function Stripe(Request $request){

        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->create([
        'line_items' => [
            [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $request->product_name
                ],
                'unit_amount' =>$request->price*100,
            ],

            'quantity' => $request->quantity,
            ],
        ],
        'mode' => 'payment',
        'success_url' => route('success.stripe').'?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('cancle.stripe'),
        ]);
        // dd($response);
        if(isset($response->id) && $response->id != ''){
            session()->put('product_name', $request->product_name);
            session()->put('quantity', $request->quantity);
            session()->put('price', $request->price);

            return redirect($response->url);
        }else{
            return redirect()->route('cancle.stripe');
        }
    }

    public function Success(Request $request){

        if(isset($request->session_id)){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            $payment = new Stripe();
            $payment->payment_id = $response->id;
            $payment->product_name = session()->get('product_name');
            $payment->quantity = session()->get('quantity');
            $payment->price = session()->get('price');
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name;
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->payment_status;
            $payment->payment_method = 'Stripe';

            $payment->save();


            // dd($response);
            return "Payment Has been Success";

            unset($request->session_id);
            session()->forget('producrt_name');
            session()->forget('quantity');
            session()->forget('price');
        }else{
            return redirect()->route('cancle.stripe');
        }
    }


    public function Cancle(){
        return "Payment Has been Cancled";
    }
}
