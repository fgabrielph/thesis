<?php

namespace App\Http\Controllers\Admin;

use App\CustomOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $custom_orders = CustomOrder::all();

        return view('admin.customorders.index')->with('custom_orders', $custom_orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $customorder = CustomOrder::find($id);

        return view('admin.customorders.customorder')->with('customorder', $customorder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $customorder = CustomOrder::find($id);

        return view('admin.customorders.modifyorder')->with('customorder', $customorder);
    }

    public function accept($id)
    {
        $order = CustomOrder::find($id);
        $order->status = 1;
        $order->save();

        return back()->withInput()->with('success', 'Order Accepted');
    }

    public function decline($id)
    {
        $order = CustomOrder::find($id);
        $order->status = 2;
        $order->save();

        return back()->withInput()->with('error', 'Order Declined');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $customorder = CustomOrder::find($id);
        $completed = $request->completed;
        $stock = $customorder->quantity;
        if ($completed <= $stock) {
            if ($completed <= 0) {
                return back()->with('error', 'Please check your quantity');
            }
            if ($customorder->completed > $stock) {
                return back()->with('error', 'Completed Request exceeds the Given Quantity');
            }
            $customorder->completed = $customorder->completed + $request->completed;
            if ($customorder->completed > $stock) {
                return back()->with('error', 'Completed Request exceeds the Given Quantity');
            } else {
                $customorder->save();
            }
            if ($customorder->completed == $stock) {
                $customorder->status = 3;
                $customorder->save();

                return redirect(route('customorders.index'))->with('success', 'Item Completed');
            }

            return back()->with('success', 'Completed Item is updated');
        } else {
            return back()->with('error', 'Please check your completed request is more than product');
        }
    }

    public function addquantity(Request $request, $id)
    {
        $customorder = CustomOrder::find($id);
        if ($request->quantity <= 0) {
            return back()->with('error', 'Please add a Quantity!');
        } else {
            $customorder->quantity = $request->quantity;
            $customorder->save();
        }

        return redirect()->back()->with('success', 'Quantity Added');
    }

    public function addprice(Request $request, $id)
    {
        $customorder = CustomOrder::find($id);
        // Validation
        $this->validate($request, ['price' => 'required|numeric|min:0.01']);
        $customorder->price = $request->price;
        $customorder->save();

        return redirect()->back()->with('success', 'Price Added');
    }

    public function accept_payment(Request $request, $id)
    {
        $customorder = CustomOrder::find($id);
        $customorder->payment_status = $request->acceptor;
        $customorder->save();

        return back()->with('success', 'Payment Accepted');
    }
}
