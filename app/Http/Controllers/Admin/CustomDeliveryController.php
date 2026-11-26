<?php

namespace App\Http\Controllers\Admin;

use App\CustomDelivery;
use App\CustomOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $deliveries = CustomDelivery::all();

        return view('admin.deliveries.custom_deliveries')->with('deliveries', $deliveries);
    }

    public function EDA(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|after:'.date('m/d/Y').'|before_or_equal:'.date('m/d/Y', strtotime('+1 week')).'',
        ]);

        $customOrder = CustomOrder::findOrFail($id);

        if (! in_array($customOrder->status, [1, 4], true)) {
            return back()->with('error', 'Custom order is not ready for delivery');
        }

        $delivery = CustomDelivery::firstOrNew(['custom_order_id' => $customOrder->id]);

        if ($delivery->exists && in_array($delivery->status, ['Completed', 'Return'], true)) {
            return back()->with('error', 'Delivery is already closed');
        }

        DB::transaction(function () use ($request, $customOrder, $delivery) {
            $delivery->status = 'On Delivery';
            $delivery->customer_name = $customOrder->name;
            $delivery->ETA = $request->date;
            $delivery->save();

            $customOrder->status = 4;
            $customOrder->save();
        });

        return back()->with('success', 'Custom Order has been placed to Delivery Table');
    }

    public function edit_EDA(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|after:'.date('m/d/Y').'|before_or_equal:'.date('m/d/Y', strtotime('+1 week')).'',
        ]);

        $delivery = CustomDelivery::findOrFail($id);

        if (in_array($delivery->status, ['Completed', 'Return'], true)) {
            return back()->with('error', 'Delivery is already closed');
        }

        $customOrder = CustomOrder::findOrFail($delivery->custom_order_id);

        DB::transaction(function () use ($request, $delivery, $customOrder) {
            $delivery->status = 'On Delivery';
            $delivery->ETA = $request->date;
            $delivery->save();

            $customOrder->status = 4;
            $customOrder->save();
        });

        return back()->with('success', 'Delivery Status has changed');
    }

    public function change_status($change, $id)
    {
        $delivery = CustomDelivery::findOrFail($id);
        $customOrder = CustomOrder::findOrFail($delivery->custom_order_id);

        $allowedFrom = [
            'Completed' => ['On Delivery'],
            'Return' => ['On Delivery', 'Completed'],
            'On Delivery' => ['On Delivery'],
        ];

        if (! in_array($delivery->status, $allowedFrom[$change] ?? [], true)) {
            return back()->with('error', 'Invalid delivery status transition');
        }

        switch ($change) {
            case 'Completed':
                DB::transaction(function () use ($delivery, $customOrder) {
                    $delivery->status = 'Completed';
                    $delivery->save();
                    $customOrder->status = 5;
                    $customOrder->save();
                });

                return back()->with('success', 'Delivery Status has changed');
            case 'Return':
                DB::transaction(function () use ($delivery, $customOrder) {
                    $delivery->status = 'Return';
                    $delivery->save();
                    $customOrder->status = 6;
                    $customOrder->save();
                });

                return back()->with('success', 'Delivery Status has changed');
            case 'On Delivery':
                return back()->with('success', 'Order has been placed to Delivery Table');
            default:
                return back()->with('error', 'Error Input Mismatched');
        }
    }
}
