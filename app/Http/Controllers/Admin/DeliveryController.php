<?php

namespace App\Http\Controllers\Admin;

use App\Delivery;
use App\Order;
use App\Http\Controllers\Controller;
use App\Suborder;
use Illuminate\Http\Request;
use App\Item as Product;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $deliveries = Delivery::all();
        return view('admin.deliveries.index')->with('deliveries', $deliveries);
    }

    public function change_status($change, $id)
    {
        $delivery = Delivery::find($id);
        switch($change){

            case 'Completed':

                $delivery->status = 'Completed';
                $delivery->save();

                $order = Order::find($delivery->order_id);
                $order->status = 'Completed';
                if($order->payment_method == 'cod') {

                    $order->payment_status = 1;

                    # We Decrease the stocks based on sub orders
                    $suborders = Suborder::where('order_id', $order->id)->get();
                    foreach($suborders as $suborder){
                        $i = $suborder->item_id;
                        $qty = $suborder->quantity;
                        Product::where('id', $i)->decrement('stocks', $qty);
                    }
                }
                $order->save();

                return back()->with('success', 'Delivery Status has changed');

                break;

            case 'Return':

                $delivery->status = 'Return';
                $delivery->save();

                $order = Order::find($delivery->order_id);
                $order->status = 'Return';
                $order->save();

                return back()->with('success', 'Delivery Status has changed');

                break;

            case 'On Delivery':

                $delivery->status = 'On Delivery';
                $delivery->save();

                $order = Order::find($delivery->order_id);
                $order->status = 'On Delivery';
                $order->save();

                return back()->with('success', 'Order has been placed to Delivery Table');

                break;

            default:

                return back()->with('error', 'Error Input Mismatched');
                break;

        }
    }

    public function EDA(Request $request, $id) {

        //dd($request->date);
        # Validation
        $this->validate($request, [
            'date' => 'required|after:' . date("m/d/yy").'|before_or_equal:' . date("m/d/yy", strtotime("+1 week")).''
        ]);

        $order = Order::find($id);
        $order->status = 'On Delivery';
        $order->save();

        $delivery = new Delivery;
        $delivery->order_id = $order->id;
        $delivery->status = 'On Delivery';
        $delivery->customer_name = $order->first_name . ' ' . $order->last_name;
        $delivery->ETA = $request->date;
        $delivery->save();

        return back()->with('success', 'Order has been placed to Delivery Table');


    }

    public function edit_EDA(Request $request, $id) {
        //strtotime($request->date)
        # Validation
        $this->validate($request, [
            'date' => 'required|after:' . date("m/d/yy").'|before_or_equal:' . date("m/d/yy", strtotime("+1 week")).''
        ]);

        $delivery = Delivery::find($id);

        $delivery->status = 'On Delivery';
        $delivery->ETA = $request->date;
        $delivery->save();

        $order = Order::find($delivery->order_id);
        $order->status = 'On Delivery';
        $order->save();

        return back()->with('success', 'Delivery Status has changed');

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
        //
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
