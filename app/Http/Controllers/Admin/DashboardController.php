<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Item;
use App\Suborder;
use App\Category;
use DB;
use Illuminate\Support\Arr;
use App\CustomOrder;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
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
        //dd($final_cust_sales);

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




        return view('admin.dashboard.index', ['categories' => $categories])->with('orders', $orders)
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

    # OLD DATA FOR REFERENCE MANUAL
    //        #Sales of Orders
    //        $jansales = Order::where('created_at', "like", '%2020-01%')->get();
    //        $febsales = Order::where('created_at', "like", '%2020-02%')->get();
    //
    //        # We Create array to put sales
    //        $january = array();
    //        $febuary = array();
    //
    //        # We Push sales in the array
    //        foreach ($jansales as $jan) {
    //            array_push($january, $jan->grand_total);
    //        }
    //        foreach ($febsales as $feb) {
    //            array_push($febuary, $feb->grand_total);
    //        }
    //
    //        # We Sum the Order Sales
    //        $january_sale = array_sum($january);
    //        $febuary_sale = array_sum($febuary);
    //
    //        $sales = array();
    //        array_push($sales, $january_sale, $febuary_sale);


    # Category Reference OLD
    //        dd($categories);

    //        $result = array();
    //        foreach ($categories as $c) {
    //            $data = $c->items_count;
    //            array_push($result, $data);
    //        }
    //
    //        dd($result);

    # Date and Time OLD
    //        $current = new DateTime();
    //        $current1 = new DateTime();
    //        $current2 = new DateTime();
    //
    //        $numberOfMonths = 2;
    //
    //        $exactBeforeDate = $current->sub(new DateInterval('P' . $numberOfMonths . 'M'));
    //        $exactBeforeDate1 = $current1->sub(new DateInterval('P' . $numberOfMonths . 'M'));
    //        $exactBeforeDate2 = $current2->sub(new DateInterval('P' . $numberOfMonths . 'M'));
    //        $current2->sub(new DateInterval('P1M'));
    //
    //        $firstMonthExactBeforeDate = $exactBeforeDate1->add(new DateInterval('P1M'));
    //        $secondMonthExactBeforeDate = $exactBeforeDate2->add(new DateInterval('P1M'));
    //
    //        dd($secondMonthExactBeforeDate);

    # MANUALLY CUSTOM ORDER GET DATA

    #Sales of Custom Orders
    //        $cust_jansales = CustomOrder::where('created_at', "like", '%2020-01%')->where('payment_status', 1)->get();
    //        $cust_febsales = CustomOrder::where('created_at', "like", '%2020-02%')->where('payment_status', 1)->get();
    //
    //            # We Create array to put sales
    //        $cust_january = array();
    //        $cust_february = array();
    //
    //            # We Push sales in the array
    //        foreach($cust_jansales as $cust_jan) {
    //        array_push($cust_january, $cust_jan->price);
    //        }
    //        foreach($cust_febsales as $cust_feb) {
    //            array_push($cust_february, $cust_feb->price);
    //        }
    //
    //        # We Sum the Custom Order Sales
    //        $cust_january_sale = array_sum($cust_january);
    //        $cust_febuary_sale = array_sum($cust_february);
    //
    //        $cust_sales = array();
    //        array_push($cust_sales, $cust_january_sale, $cust_febuary_sale);


    # We use this code of existing datas
    //       array_push($final_cust_sales, 0);
    //       foreach ($cust_getMonth as $cust_s) {
    //           $value = CustomOrder::where('created_at', "like", '%'. $cust_s . '%')->sum('price');
    //           array_push($final_cust_sales, $value);
    //       }
    //      $cust_getMonth = array_values(array_unique($store_cust_month));


}
