<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Item;
use App\Suborder;
use DB;

class DashboardController extends Controller
{
    public function index() {

        $orders = Order::all();
        $users = User::all();
        $items = Item::orderBy('updated_at', 'desc')->paginate(5);
        //$items = Item::orderBy('updated_at', 'desc')->get();

//        foreach($items as $item) {
//
//          if($item->stock < $item->stock) {
//              echo 'Decreasing';
//          } elseif ($item->stock > $item->stock) {
//              echo 'Increasing';
//          }
//
//        }


        $data['pending_deliveries'] = $orders->where('status', 'pending');
        //$data['item_updates'] = DB::table('items')->where('id', 'LIKE', 50)->get();
        //dd($data['item_updates']);

        return view('admin.dashboard.index', $data)->with('orders', $orders)->with('users', $users)->with('items', $items);
    }
}
