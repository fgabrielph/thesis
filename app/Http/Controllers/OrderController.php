<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use App\Order;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['orders'] = Order::orderBy('created_at', 'desc')->paginate(20);
        //$orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id);
        $orders = auth()->user()->orders;
        //$orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->first(); //WORKING ATTRIBUTE GETTING THE RECENT ORDERS


       //dd($orders->id);
        return view('site.accounts.orders')->with('orders', $orders);

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
        $order = Order::find($id);

        if($order->invoice_id == null) {
            return back()->with('error', 'This Order is not yet paid');
        }
        //$invoice = Invoice::where('invoice_id', $order->id)->get();

        return view('site.accounts.showorder')->with('order', $order);
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

}
