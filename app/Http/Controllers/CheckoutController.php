<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use Cart;
use App\Item;

class CheckoutController extends Controller
{

    public function getCheckout(Request $request) {

        //Validation
        $this->validate($request, [
            'firstName' => 'required|max:160',
            'lastName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required|numeric',
            'mobile_num' => 'required|numeric|digits:11',
        ]);


        $order = new Order;
        $order->order_number = 'ORD-'.strtoupper(uniqid());
        $order->user_id = auth()->user()->id;
        $order->first_name = $request->firstName;
        $order->last_name = $request->lastName;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip_code = $request->zip;
        $order->phone_number = $request->mobile_num;
        $order->notes = $request->notes;
        $order->payment_method = $request->paymentMethod;
        $order->payment_status = 0;
        $order->item_count = Cart::count();
        $order->grand_total = Cart::total();
        $order->status = 0;
        $order->save();

//        if($request->paymentMethod == 'paypal') {
//
//
//        }

        //$orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->first();
        //$orders->payment_status = 1;
        //$orders->status = 1;
        //$orders->save();

        return 'Cash on Delivery';

    }


}
