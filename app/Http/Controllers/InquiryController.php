<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomOrder;
use Illuminate\Support\Facades\Auth;
use Image;

class InquiryController extends Controller
{
    public function index() {
        $custom_orders = CustomOrder::all();

        return view('site.accounts.custom_order')->with('custom_orders', $custom_orders);
    }

    public function show($id) {

        $custom_order = CustomOrder::find($id);

        return view('site.accounts.show_custom')->with('custom_order', $custom_order);
    }

    public function insert_order(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:160',
            'contactnum' => 'required|numeric|digits:11',
            'description' => 'required',
        ]);

        # Handle File Upload
        if($request->hasFile('image')){

            # Get filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            # Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();

            # Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            # Upload Image
            $path = $request->file('image')->storeAs('public/assets/images', $fileNameToStore);


        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $custom_order = new CustomOrder;
        $custom_order->user_id = Auth::user()->id;
        $custom_order->name = $request->name;
        $custom_order->image = $fileNameToStore;
        $custom_order->description = $request->description;
        $custom_order->save();

        return back()->with('success', 'Your inquiry has been sent');

    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}