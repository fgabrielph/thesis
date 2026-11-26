<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Order;
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

        return view('staff.orders.index')->with('orders', $orders);
    }
}
