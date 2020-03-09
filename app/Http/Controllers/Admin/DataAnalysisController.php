<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\CustomOrder;

class DataAnalysisController extends Controller
{
    public function sales_order() {

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
            $value = Order::where('created_at', "like", '%'. $s .'%')->where('payment_status', 1)->sum('grand_total');
            array_push($final_sales, $value);
        }



        $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        //dd($final_sales[1]);
        //dd(number_format($final_sales[1], 2));
        return view('admin.visualization.sales_order')->with('sales', $final_sales)->with('months', $months);

    }

    public function demand_custom_order() {

        # Get all Custom Orders DYNAMICALLY
        $allmonths = CustomOrder::where('payment_status', 1)->get();

        $store_month = array();
        foreach ($allmonths as $all_m) {
            array_push($store_month, date('Y-m', strtotime($all_m->created_at)));
        }
        $getMonth = array_values(array_unique($store_month));

        # We Calculate the Demand
        $demand = array();

        for($i = 1; $i <= count($getMonth); $i++) {
            if($i == 10 || $i == 11 || $i == 12) {
                $value = CustomOrder::where('created_at', "like", '%2020-'.$i. '%')->where('payment_status', 1)->get();
                $count = count($value);
            } else {
                $value = CustomOrder::where('created_at', "like", '%2020-0'.$i. '%')->where('payment_status', 1)->get();
                $count = count($value);
            }

            array_push($demand, $count);
        }

        $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        return view('admin.visualization.demand_custom_orders')->with('demand', $demand)->with('months', $months);
    }

    public function forecast_order(Request $user_input) {



        //dd($user_input->forecast + 3);

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
            $value = Order::where('created_at', "like", '%'. $s .'%')->where('payment_status', 1)->sum('grand_total');
            array_push($final_sales, $value);
        }

        $number = $user_input->forecast;
        $counter = count($final_sales);
        $num_of_days = $counter - $number;
        //dd($num_of_days);

        if($number > $num_of_days) {
            return back()->with('error', 'Not enough previous data to forecast');
        }
        # We forecast sales using SMA
        $forecasted = trader_sma($final_sales, $num_of_days);

        //dd($forecasted);
        $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


        return view('admin.visualization.forecast.forecast_order')
            ->with('sales', $final_sales)
            ->with('forecasted', $forecasted)
            ->with('months', $months);
    }

    public function forecast_custom_order(Request $user_input) {

        # Get all Custom Orders DYNAMICALLY
        $allmonths = CustomOrder::where('payment_status', 1)->get();

        $store_month = array();
        foreach ($allmonths as $all_m) {
            array_push($store_month, date('Y-m', strtotime($all_m->created_at)));
        }
        $getMonth = array_values(array_unique($store_month));

        # We Calculate the Demand
        $demand = array();

        for($i = 1; $i <= count($getMonth); $i++) {
            if($i == 10 || $i == 11 || $i == 12) {
                $value = CustomOrder::where('created_at', "like", '%2020-'.$i. '%')->where('payment_status', 1)->get();
                $count = count($value);
            } else {
                $value = CustomOrder::where('created_at', "like", '%2020-0'.$i. '%')->where('payment_status', 1)->get();
                $count = count($value);
            }

            array_push($demand, $count);
        }

        $number = $user_input->forecast;
        $counter = count($demand);
        $num_of_days = $counter - $number;

        if($number > $num_of_days) {
            return back()->with('error', 'Not enough previous data to forecast');
        }
        # We forecast sales using SMA
        $forecasted = trader_sma($demand, $num_of_days);

        $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        return view('admin.visualization.forecast.forecast_demand_custom_order')
            ->with('forecasted', $forecasted)
            ->with('months', $months)
            ->with('demand', $demand);
    }
}
