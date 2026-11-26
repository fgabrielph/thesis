<?php

namespace App\Http\Controllers\Admin;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Order;
use App\Services\OrderStockService;
use App\Support\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $deliveries = Delivery::all();

        return view('admin.deliveries.index')->with('deliveries', $deliveries);
    }

    public function change_status($change, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $order = Order::findOrFail($delivery->order_id);

        switch ($change) {
            case 'Completed':
                if (! OrderStatus::canTransition($delivery->status, OrderStatus::COMPLETED)
                    || ! OrderStatus::canTransition($order->status, OrderStatus::COMPLETED)) {
                    return back()->with('error', 'Invalid delivery status transition');
                }

                DB::transaction(function () use ($delivery, $order) {
                    $delivery->status = OrderStatus::COMPLETED;
                    $delivery->save();

                    $order->status = OrderStatus::COMPLETED;
                    if ($order->payment_method == 'cod') {
                        $order->payment_status = 1;
                        app(OrderStockService::class)->deductOnce($order);
                    }
                    $order->save();
                });

                return back()->with('success', 'Delivery Status has changed');
            case 'Return':
                if (! OrderStatus::canTransition($delivery->status, OrderStatus::RETURNED)
                    || ! OrderStatus::canTransition($order->status, OrderStatus::RETURNED)) {
                    return back()->with('error', 'Invalid delivery status transition');
                }

                DB::transaction(function () use ($delivery, $order) {
                    $delivery->status = OrderStatus::RETURNED;
                    $delivery->save();
                    $order->status = OrderStatus::RETURNED;
                    $order->save();
                });

                return back()->with('success', 'Delivery Status has changed');
            case 'On Delivery':
                if ($delivery->status !== OrderStatus::ON_DELIVERY) {
                    return back()->with('error', 'Invalid delivery status transition');
                }

                $order->status = OrderStatus::ON_DELIVERY;
                $order->save();

                return back()->with('success', 'Order has been placed to Delivery Table');
            default:
                return back()->with('error', 'Error Input Mismatched');
        }
    }

    public function EDA(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|after:'.date('m/d/Y').'|before_or_equal:'.date('m/d/Y', strtotime('+1 week')).'',
        ]);

        $order = Order::findOrFail($id);

        if (! in_array($order->status, [OrderStatus::CONFIRMED, OrderStatus::ON_DELIVERY], true)) {
            return back()->with('error', 'Order is not ready for delivery');
        }

        $delivery = Delivery::firstOrNew(['order_id' => $order->id]);

        if ($delivery->exists && in_array($delivery->status, [OrderStatus::COMPLETED, OrderStatus::RETURNED], true)) {
            return back()->with('error', 'Delivery is already closed');
        }

        DB::transaction(function () use ($request, $order, $delivery) {
            $delivery->status = OrderStatus::ON_DELIVERY;
            $delivery->customer_name = $order->first_name.' '.$order->last_name;
            $delivery->ETA = $request->date;
            $delivery->save();

            $order->status = OrderStatus::ON_DELIVERY;
            $order->save();
        });

        return back()->with('success', 'Order has been placed to Delivery Table');
    }

    public function edit_EDA(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|after:'.date('m/d/Y').'|before_or_equal:'.date('m/d/Y', strtotime('+1 week')).'',
        ]);

        $delivery = Delivery::findOrFail($id);

        if (in_array($delivery->status, [OrderStatus::COMPLETED, OrderStatus::RETURNED], true)) {
            return back()->with('error', 'Delivery is already closed');
        }

        $order = Order::findOrFail($delivery->order_id);

        DB::transaction(function () use ($request, $delivery, $order) {
            $delivery->status = OrderStatus::ON_DELIVERY;
            $delivery->ETA = $request->date;
            $delivery->save();

            $order->status = OrderStatus::ON_DELIVERY;
            $order->save();
        });

        return back()->with('success', 'Delivery Status has changed');
    }
}
