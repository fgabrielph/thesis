<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Brand;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function shop()
    {
        $data['categories'] = Category::orderBy('name', 'asc')->paginate(20);
        $data['items'] = Item::orderBy('created_at', 'desc')->paginate(8);
        $data['brands'] = Brand::all();

        return view('site.pages.shop', $data);
    }

    public function categories($id) {

        $data['items'] = Item::where('category_id', $id)->paginate(8);
        $data['categories'] = Category::orderby('name','asc')->get();
        $data['category_name'] = Category::find($id);
        return view('site.pages.category', $data);

    }

    public function show($id) {

        $item = Item::find($id);

        return view('site.pages.product')->with('item', $item);
    }



}
