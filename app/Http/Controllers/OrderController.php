<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $data['orders'] = Order::orderBy('created_at', 'desc')->paginate(20);
        // $orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id);
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->get();

        // $orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->first(); //WORKING ATTRIBUTE GETTING THE RECENT ORDERS
        // dd(count($orders));
        // dd($orders->id);
        return view('site.accounts.orders')->with('orders', $orders);
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

        return view('site.accounts.showorder')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = 'Canceled';
        $order->save();

        return back()->with('success', 'Your Order was Canceled');
    }
}
