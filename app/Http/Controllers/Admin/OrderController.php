<?php

namespace App\Http\Controllers\Admin;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Order;
use App\Services\OrderStockService;
use App\Support\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orders = Order::all();

        //        $test = array();
        //        foreach($orders as $order){
        //            $try = $order->user->name;
        //            array_push($test, $try);
        //        }
        //        dd($test);
        return view('admin.orders.index')->with('orders', $orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        return view('admin.orders.showorder')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (! OrderStatus::canTransition($order->status, $request->status)) {
            return back()->with('error', 'Invalid order status transition');
        }

        $order->status = $request->status;
        if (! empty($order->image) && $request->status == OrderStatus::CONFIRMED) {
            $order->payment_status = 1;
        }
        $order->save();

        return back()->with('success', 'Order Status Updated');
    }

    public function decide($choice, $id)
    {
        $order = Order::findOrFail($id);

        switch ($choice) {
            case 'Accept':
                if (! OrderStatus::canTransition($order->status, OrderStatus::CONFIRMED)) {
                    return back()->with('error', 'Invalid order status transition');
                }

                $order->status = OrderStatus::CONFIRMED;
                $order->payment_status = 1;
                $order->save();
                app(OrderStockService::class)->deductOnce($order);

                return back()->with('success', 'Order has been modified');
            case 'Decline':
                if (! OrderStatus::canTransition($order->status, OrderStatus::CANCELED)) {
                    return back()->with('error', 'Invalid order status transition');
                }

                $order->status = OrderStatus::CANCELED;
                $order->payment_status = 0;
                $order->save();

                return back()->with('success', 'Order has been modified');
            case 'Confirmed':
                if (! OrderStatus::canTransition($order->status, OrderStatus::CONFIRMED)) {
                    return back()->with('error', 'Invalid order status transition');
                }

                $order->status = OrderStatus::CONFIRMED;
                $order->save();

                return back()->with('success', 'Order has been modified');
            case 'On Delivery':
                if (! OrderStatus::canTransition($order->status, OrderStatus::ON_DELIVERY)) {
                    return back()->with('error', 'Invalid order status transition');
                }

                $order->status = OrderStatus::ON_DELIVERY;
                $order->save();

                Delivery::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status' => OrderStatus::ON_DELIVERY,
                        'customer_name' => $order->first_name.' '.$order->last_name,
                    ]
                );

                return back()->with('success', 'Order has been placed to Delivery Table');
            default:
                return back()->with('error', 'Error Input Field');
        }
    }
}
