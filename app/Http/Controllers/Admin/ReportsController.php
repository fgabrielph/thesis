<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Item;
use App\Admin;
use App\Staff;
use App\CustomOrder;
use App\Order;
use App\User;

class ReportsController extends Controller
{
    public function list_items() {

        $items = Item::all();
        return view('admin.reports.list_items')->with('items', $items);

    }

    public function list_orders() {

        $orders = Order::all();
        return view('admin.reports.list_orders')->with('orders', $orders);

    }

    public function list_custom_orders() {

        $custom_orders = CustomOrder::all();
        return view('admin.reports.list_custom_orders')->with('custom_orders', $custom_orders);

    }

    public function list_staffs() {

        $staffs = Staff::all();
        return view('admin.reports.list_staff')->with('staffs', $staffs);

    }

    public function list_admins() {

        $admins = Admin::all();
        return view('admin.reports.list_admins')->with('admins', $admins);

    }

    public function toPDF($select) {

        switch($select) {

            case 'items':

                $items = Item::all();

                $pdf = PDF::loadview('admin.reports.pdf.items', compact('items'));

                return $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('list_items.pdf');

                break;

            case 'admins':

                $admins = Admin::all();

                $pdf = PDF::loadview('admin.reports.pdf.admins', compact('admins'));

                return $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('list_admins.pdf');

                break;

            case 'orders':

                $orders = Order::all();

                $pdf = PDF::loadview('admin.reports.pdf.orders', compact('orders'));

                return $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('list_orders.pdf');

                break;

            case 'custom_orders':
                $custom_orders = CustomOrder::where('payment_status', 1)->get();

                $pdf = PDF::loadview('admin.reports.pdf.custom_orders', compact('custom_orders'));

                return $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('list_custom_orders.pdf');

                break;

            case 'staffs':

                $staffs = Staff::all();

                $pdf = PDF::loadview('admin.reports.pdf.staffs', compact('staffs'));

                return $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream('list_staffs.pdf');

                break;


        }

    }
}