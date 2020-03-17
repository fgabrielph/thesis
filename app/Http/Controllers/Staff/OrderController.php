<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item as Product;
use App\Order;
use App\Suborder;
use App\Delivery;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return view('staff.orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        $order->status = $request->status;
        if(!(empty($order->image)) && $request->status == 'Confirmed') {
            $order->payment_status = 1;
        }
        $order->save();

        return back()->with('success', 'Order Status Updated');
    }

    public function decide($choice, $id)
    {
        $order = Order::find($id);

        switch($choice) {

            case 'Accept':
                $order->status = 'Confirmed';
                $order->payment_status = 1;
                $order->save();

                # We Decrease the stocks based on sub orders
                $suborders = Suborder::where('order_id', $id)->get();
                foreach($suborders as $suborder){
                    $item = $suborder->item_id;
                    $quantity = $suborder->quantity;
                    Product::where('id', $item)->decrement('stocks', $quantity);
                }

                return back()->with('success', 'Order has been modified');

                break;

            case 'Decline':

                $order->status = 'Canceled';
                $order->payment_status = 0;
                $order->save();

                return back()->with('success', 'Order has been modified');

                break;

            case 'Confirmed':

                $order->status = 'Confirmed';

//                if($order->payment_method != 'cod') {
//
//                    $order->payment_status = 1;
//                    $order->save();
//
//                    # We Decrease the stocks based on sub orders
//                    $suborders = Suborder::where('order_id', $id)->get();
//                    foreach($suborders as $suborder){
//                        $i = $suborder->item_id;
//                        $qty = $suborder->quantity;
//                        Product::where('id', $i)->decrement('stocks', $qty);
//                    }
//                }

                $order->save();

                return back()->with('success', 'Order has been modified');

                break;

            case 'On Delivery':

                $order->status = 'On Delivery';
                $order->save();

                $delivery = new Delivery;
                $delivery->order_id = $order->id;
                $delivery->status = 'On Delivery';
                $delivery->customer_name = $order->first_name . ' ' . $order->last_name;
                $delivery->save();

                return back()->with('success', 'Order has been placed to Delivery Table');

                break;

            default:

                return back()->with('error', 'Error Input Field');
                break;

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
