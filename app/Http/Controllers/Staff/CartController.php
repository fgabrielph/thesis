<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.walkin.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicates = Cart::search(function($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return back()->with('success', 'Item is already in your cart!');
        }

        $product = Item::findorFail($request->id);
        $stock = $product->stocks;

        if($request->quantity <= 0) {

            return back()->with('error', 'Please add a Quantity!');

        } else if($request->quantity > $stock) {

            return back()->with('error', 'Item Requested is exceeds the stock!');

        } else {
            Cart::add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Item');

        }

//        if($request->buynow == 1) {
//            return view('site.pages.cart');
//        }



        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $qty = $request->qty;
        $proID = $request->proID;
        $product = Item::findOrFail($proID);
        $stock = $product->stocks;

        if($qty < $stock) {
            if($qty <= 0) {
                return back()->with('error', 'Please check your quantity is less than product');
            }

            Cart::update($id, $request->qty);
            return back()->with('success', 'Cart is updated');

        } else {

            return back()->with('error', 'Please check your quantity is more than product');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success', 'Item has been removed!');
    }

    public function clear() {
        Cart::destroy();
        return redirect()->back()->with('success', 'Cart Cleared!');
    }
}
