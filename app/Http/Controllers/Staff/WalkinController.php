<?php

namespace App\Http\Controllers\Staff;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Response;

class WalkinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Item::orderBy('created_at', 'desc')->paginate(8);
        $categories = Category::all();

        return view('staff.walkin.products')->with('items', $products)->with('categories', $categories);
    }

    public function categories($id)
    {
        $data['items'] = Item::where('category_id', $id)->paginate(8);
        $data['categories'] = Category::orderby('name', 'asc')->get();
        $data['category_name'] = Category::find($id);

        return view('staff.walkin.categories', $data);
    }
}
