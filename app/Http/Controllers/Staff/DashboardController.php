<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use App\Order;
use App\User;
use App\Item;
use App\Suborder;
use App\Category;
use DB;
use Illuminate\Support\Arr;
use App\CustomOrder;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->status == 0) {
            Auth::logout();
            return back()->with('error', "You're deactivated please contact admin");
        }

        $lowitem = Item::where('stocks', '<=', 5)->get();
        $number_of_lowitem = count($lowitem);

        //dd($number_of_lowitem);

        if($number_of_lowitem <= 5) {
            $alert = $number_of_lowitem . 'item(s) low stock';
        }

        $all_orders = Order::all();
        $orders = Order::where('status', 'Pending')->get();
        $users = User::all();
        $items = Item::orderBy('updated_at', 'desc')->paginate(5);
        //$categories = Category::all()->pluck('name')->toArray();
        $categories = Category::withCount('items')->get();

        #Get Custom Orders DYNAMICALLY
        $cust_allmonths = CustomOrder::where('payment_status', 1)->get();
        $store_cust_month = array();
        foreach ($cust_allmonths as $cust_all_m) {
            array_push($store_cust_month, date('Y-m', strtotime($cust_all_m->created_at)));
        }

        # We Calculate the Custom Order Sales
        $final_cust_sales = array();

        $cust_getMonth = array_values(array_unique($store_cust_month));
        //dd($cust_getMonth);

        # We get the sales to 12 as static since we plot data from January to December
        for($i = 1; $i <= count($cust_getMonth); $i++) {
            if($i == 10 || $i == 11 || $i == 12) {
                $value = CustomOrder::where('created_at', "like", '%2020-'.$i. '%')->sum('price');
            } else {
                $value = CustomOrder::where('created_at', "like", '%2020-0'.$i. '%')->sum('price');
            }

            array_push($final_cust_sales, $value);
        }

        $cust_forecasted = trader_sma($final_cust_sales, (count($final_cust_sales)));
        //dd($cust_forecasted);


        # Get all Orders DYNAMICALLY
        $allmonths = Order::where('payment_status', 1)->get();
        $store_month = array();
        foreach ($allmonths as $all_m) {
            array_push($store_month, date('Y-m', strtotime($all_m->created_at)));
        }
        $getMonth = array_values(array_unique($store_month));

        # We Calculate the Sales
        $final_sales = array();
        foreach($getMonth as $s) {
            $value = Order::where('created_at', "like", '%'. $s .'%')->sum('grand_total');
            array_push($final_sales, $value);
        }

        #We use user input here
        $user_input = 1;

        # We forecast sales using SMA
        $forecasted = trader_sma($final_sales, (count($final_sales) - $user_input));
        //dd($sales);


        $pending_deliveries = $all_orders->where('status', '=', 'On Delivery');
        $returns = $all_orders->where('status', 'LIKE', 'Return');
        //$data['item_updates'] = DB::table('items')->where('id', 'LIKE', 50)->get();
        //dd($data['item_updates']);




        return view('staff.dashboard.index', ['categories' => $categories])->with('orders', $orders)
            ->with('users', $users)
            ->with('items', $items)
            ->with('pending_deliveries', $pending_deliveries)
            ->with('sales', $final_sales)
            ->with('forecasted', $forecasted)
            ->with('cust_sales', $final_cust_sales)
            ->with('cust_forecasted', $cust_forecasted)
            ->with('returns', $returns)
            ->with('lowitem', $number_of_lowitem);
    }
}
