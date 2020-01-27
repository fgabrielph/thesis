<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;
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

        if($request->paymentMethod == 'paypal') {

            return $this->paywithpepal();

        }

        return 'Cash on Delivery';

    }

    public function storePayment(Request $request) {

        dd($request->all);
        //return 'Create the Order';

    }

    public function paypalsuccess(Request $request) {

//        $userid = auth()->user()->orders;
//        dd($userid);

        $provider = new ExpressCheckout;

        $token = $request->token;
        $PayerID = $request->PayerID;

        $response = $provider->getExpressCheckoutDetails($token);

        $invoiceId = $response['INVNUM'] ?? uniqid();
        $data = $this->cartData($invoiceId);

        $response = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
        //return 'Create the Order';

        //$product = Item::find();

        $orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->first();
        $orders->payment_status = 1;
        $orders->status = 1;
        $orders->save();

        Cart::destroy();

        /*
         * Modify ORDER STATUS I DUNNO HOW
         * $order = Order::find($userid);
         * dd($order);
         *
        */
        return redirect('/cart')->with('success', 'Order Completed');

    }

    public function paywithpepal() {

        $provider = new ExpressCheckout;
        $invoiceId = uniqid();
        $data = $this->cartData($invoiceId);


        $response = $provider->setExpressCheckout($data);

        // This will redirect user to PayPal
        return redirect($response['paypal_link']);

    }

    protected function cartData($invoiceId) {

        $data = [];
        $data['items'] = [];

        foreach(Cart::content() as $key => $cart){
            $itemDetail = [
                'name' => $cart->name,
                'price' => $cart->price,
                'qty' => $cart->qty
            ];

            $data['items'][] = $itemDetail;
        }

        $data['invoice_id'] = $invoiceId;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.paypalSuccess');
        $data['cancel_url'] = redirect('/cart')->with('error', 'Payment is Canceled');

        $total = Cart::total();

        $data['total'] = $total;


        return $data;
    }

}
