<?php

namespace App\Http\Controllers;

use App\Order;
use App\Suborder;
use Cart;
use Illuminate\Http\Request as Requesting;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    public function index()
    {
        if (count(Cart::content()) == 0) {
            return redirect(route('cart.index'))->with('error', 'You need to add something on Cart');
        }

        return view('site.pages.checkout');
    }

    public function store(Requesting $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:160',
            'lastName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required|numeric',
            'mobile_num' => 'required|numeric|digits:11',
        ]);

        if (! in_array($request->paymentMethod, ['cod', 'bank'], true)) {
            return Redirect::back()->with('error', 'Unsupported payment method.');
        }

        // Removing Commas in thousands for Grand Total
        $string_grand_total = Cart::total();
        $formatted_grand_total = str_replace(',', '', $string_grand_total);

        $order = new Order;
        $order->order_number = 'ORD-'.strtoupper(uniqid());
        $order->user_id = auth()->user()->id;
        $order->first_name = $request->firstName;
        $order->last_name = $request->lastName;
        $order->deliver_to = $request->deliver_to;
        $order->deliver_to_address = $request->deliver_to_address;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip_code = $request->zip;
        $order->phone_number = $request->mobile_num;
        $order->notes = $request->notes;
        $order->payment_method = $request->paymentMethod;
        $order->payment_status = 0;
        $order->item_count = Cart::count();
        $order->grand_total = $formatted_grand_total;
        $order->status = 'Pending';
        $order->save();

        foreach (Cart::content() as $item) {
            $suborder = new Suborder;
            $suborder->order_id = $order->id;
            $suborder->item_id = $item->id;
            $suborder->price = $item->price;
            $suborder->quantity = $item->qty;
            $suborder->save();
        }

        Cart::destroy();

        return Redirect::to('/cart')->with('success', 'Your order has been placed. Thank you.');
    }
}
