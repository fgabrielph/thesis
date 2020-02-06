<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Item;
use App\Suborder;
use App\Category;
use DB;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    public function index() {

        $orders = Order::all();
        $users = User::all();
        $items = Item::orderBy('updated_at', 'desc')->paginate(5);
        //$categories = Category::all()->pluck('name')->toArray();
        $categories = Category::withCount('items')->get();

//        dd($categories);

//        $result = array();
//        foreach ($categories as $c) {
//            $data = $c->items_count;
//            array_push($result, $data);
//        }
//
//        dd($result);








        $pending_deliveries = $orders->where('status', 'LIKE','Pending');
        //$data['item_updates'] = DB::table('items')->where('id', 'LIKE', 50)->get();
        //dd($data['item_updates']);



        return view('admin.dashboard.index', ['categories' => $categories])->with('orders', $orders)->with('users', $users)->with('items', $items)->with('pending_deliveries', $pending_deliveries);
    }
}
