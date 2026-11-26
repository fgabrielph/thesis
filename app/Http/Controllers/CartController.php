<?php

namespace App\Http\Controllers;

use App\Item;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('site.pages.cart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });
        if ($duplicates->isNotEmpty()) {
            return back()->with('success', 'Item is already in your cart!');
        }
        $product = Item::findorFail($request->id);
        $stock = $product->stocks;
        if ($request->quantity <= 0) {
            return back()->with('error', 'Please add a Quantity!');
        } elseif ($request->quantity > $stock) {
            return back()->with('error', 'Item Requested is exceeds the stock!');
        } else {
            Cart::add($product->id, $product->name, $request->quantity, $product->price_stocks)->associate('App\Item');
        }
        if ($request->buynow == 1) {
            return view('site.pages.cart');
        }

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $qty = $request->qty;
        $proID = $request->proID;
        $product = Item::findOrFail($proID);
        $stock = $product->stocks;
        if ($qty < $stock) {
            if ($qty <= 0) {
                return back()->with('error', 'Please check your quantity is less than product');
            }
            Cart::update($id, $request->qty);

            return back()->with('success', 'Cart is updated');
        } else {
            return back()->with('error', 'Please check your quantity is more than product');
        }
    }

    public function destroy($id)
    {
        Cart::remove($id);

        return back()->with('success', 'Item has been removed!');
    }

    public function clear()
    {
        Cart::destroy();

        return redirect()->back()->with('success', 'Cart Cleared!');
    }
}
