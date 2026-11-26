<?php

namespace App\Http\Controllers\Staff;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
