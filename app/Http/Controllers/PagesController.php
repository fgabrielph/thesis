<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Item;
use Illuminate\Contracts\Support\Renderable;

class PagesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function shop()
    {
        $data['categories'] = Category::orderBy('name', 'asc')->get();
        $data['items'] = Item::orderBy('created_at', 'desc')->paginate(8);
        $data['brands'] = Brand::all();

        return view('site.pages.shop', $data);
    }

    public function inquire()
    {
        return view('site.pages.inquire');
    }

    public function categories($id)
    {

        $data['items'] = Item::where('category_id', $id)->paginate(8);
        $data['categories'] = Category::orderby('name', 'asc')->get();
        $data['category_name'] = Category::find($id);

        return view('site.pages.category', $data);

    }

    public function show($id)
    {

        $item = Item::find($id);

        return view('site.pages.product')->with('item', $item);
    }
}
