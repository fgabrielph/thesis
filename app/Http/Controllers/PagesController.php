<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Brand;
use Illuminate\Support\Arr;

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
        $data['items'] = Item::all();
        $data['brands'] = Brand::all();

        return view('site.pages.shop', $data);
    }

    public function categories($id) {

        $data['items'] = Item::where('category_id', $id)->get();
        $data['categories'] = Category::orderby('name','asc')->paginate(12);
        $data['category_name'] = Category::find($id);
        return view('site.pages.category', $data);

    }

    public function show($id) {

        $item = Item::find($id);

        return view('site.pages.product')->with('item', $item);
    }



}
