<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Item as Product;
use App\Order;
use App\Suborder;
use Illuminate\Http\Request;
use Cart;

class CheckoutController extends Controller
{
    public function index() {
        return view('staff.walkin.checkout');
    }

    public function invoice(Request $request) {

        $this->validate($request, [
            'firstName' => 'required|max:160',
            'lastName' => 'required',
            'mobile_num' => 'required|numeric|digits:11',
        ]);

        # Removing Commas in thousands for Grand Total
        $string_grand_total = Cart::total();
        $formatted_grand_total = str_replace(',', '', $string_grand_total);

        # Removing Commas in thousands for Sub Total
        $string_sub_total = Cart::subtotal();
        $formatted_sub_total = str_replace(',', '', $string_sub_total);

        $order = new Order;
        $order->order_number = 'ORD-'.strtoupper(uniqid());
        $order->first_name = $request->firstName;
        $order->last_name = $request->lastName;
        $order->address = "1101 D. Gomez St. Bo. Obrero Tondo";
        $order->city = "Manila";
        $order->zip_code = "1013";
        $order->phone_number = $request->mobile_num;
        $order->payment_method = "cash";
        $order->payment_status = 1;
        $order->item_count = Cart::count();
        $order->grand_total = $formatted_grand_total;
        $order->status = 'Completed';
        $order->save();

        foreach (Cart::content() as $item) {

            $suborder = new Suborder();
            $suborder->order_id = $order->id;
            $suborder->item_id = $item->id;
            $suborder->price = $item->price;
            $suborder->quantity = $item->qty;
            $suborder->save();

            # We Decrease the stocks based on sub orders
            Product::where('id', $suborder->item_id)->decrement('stocks', $suborder->quantity);
        }

        Cart::destroy();


        return redirect(route('staff_cart.index'))->with('success', 'The order is completed. Thank you.');

    }

}
