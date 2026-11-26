<?php

namespace App\Http\Controllers\Staff;

use App\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

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

        return view('staff.deliveries.index')->with('deliveries', $deliveries);
    }
}
