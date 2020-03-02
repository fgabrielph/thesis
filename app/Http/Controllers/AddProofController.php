<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Suborder;
use Illuminate\Support\Facades\Storage;
use Image;

class AddProofController extends Controller
{
    public function addproof($id)
    {
        $order = Order::find($id);
        if($order->payment_status == 1) {

            return redirect(route('orders.index'))->with('error', 'This Order is already paid');

        } else {

            return view('site.accounts.addproof')->with('order', $order);
        }


    }

    public function upload(Request $request, $id)
    {

        # Validation
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $order = Order::find($id);

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

            # Medium thumbnail name
            $mediumthumbnail = $fileName.'_medium_'.time().'.'.$extension;

            # Upload Image
            $path = public_path('assets/images/' . $fileNameToStore);
            $mediumpath = public_path('assets/images/medium_thumbnail/' . $mediumthumbnail);

            # Create original image
            Image::make($request->file('image'))->save($path);

            # Create medium thumbnail
            Image::make($request->file('image'))->resize(750, 540)->save($mediumpath);


        } else {
            $fileNameToStore = 'noimage.jpg';
            $mediumthumbnail = 'noimage.jpg';
        }

        $order->image = $mediumthumbnail;
        $order->save();

        return back()->with('success', 'Image Uploaded');
    }

}
