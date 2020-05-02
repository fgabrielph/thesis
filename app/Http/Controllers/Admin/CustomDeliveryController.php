<?php

namespace App\Http\Controllers\Admin;

use App\CustomDelivery;
use App\CustomOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = CustomDelivery::all();
        return view('admin.deliveries.custom_deliveries')->with('deliveries', $deliveries);
    }

    public function EDA(Request $request, $id) {

        //dd($request->date);
        # Validation
        $this->validate($request, [
            'date' => 'required|after:' . date("m/d/yy").'|before_or_equal:' . date("m/d/yy", strtotime("+1 week")).''
        ]);

        // 0 is Pending, 1 is Accepted, 2 is Declined, 3 is Completed, 4 is On Delivery, 5 is Delivered, 6 is Return
        $custom_order = CustomOrder::find($id);
        $custom_order->status = 4;
        $custom_order->save();

        $delivery = new CustomDelivery;
        $delivery->custom_order_id = $custom_order->id;
        $delivery->status = 'On Delivery';
        $delivery->customer_name = $custom_order->name;
        $delivery->ETA = $request->date;
        $delivery->save();

        return back()->with('success', 'Custom Order has been placed to Delivery Table');
    }

    public function edit_EDA(Request $request, $id)
    {
        //strtotime($request->date)
        # Validation
        $this->validate($request, [
            'date' => 'required|after:' . date("m/d/yy") . '|before_or_equal:' . date("m/d/yy", strtotime("+1 week")) . ''
        ]);

        $delivery = CustomDelivery::find($id);

        $delivery->status = 'On Delivery';
        $delivery->ETA = $request->date;
        $delivery->save();

        $custom_order = CustomOrder::find($delivery->custom_order_id);
        $custom_order->status = 4;
        $custom_order->save();

        return back()->with('success', 'Delivery Status has changed');

    }

    public function change_status($change, $id)
    {
        $delivery = CustomDelivery::find($id);

        switch($change){

            case 'Completed':
                $delivery->status = 'Completed';
                $delivery->save();

                $custom_order = CustomOrder::find($delivery->custom_order_id);
                $custom_order->status = 5;
                $custom_order->save();

                return back()->with('success', 'Delivery Status has changed');

                break;

            case 'Return':

                $delivery->status = 'Return';
                $delivery->save();

                $custom_order = CustomOrder::find($delivery->custom_order_id);
                //dd($custom_order);
                $custom_order->status = 6;
                $custom_order->save();

                return back()->with('success', 'Delivery Status has changed');

                break;

            case 'On Delivery':

                $delivery->status = 'On Delivery';
                $delivery->save();

                $custom_order = CustomOrder::find($delivery->custom_order_id);
                $custom_order->status = 4;
                $custom_order->save();

                return back()->with('success', 'Delivery Status has changed');

                break;

            default:

                return back()->with('error', 'Error Input Mismatched');
                break;
        }
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
