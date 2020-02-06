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
            $path = $request->file('image')->storeAs('public/assets/images', $fileNameToStore);
            $mediumpath = $request->file('image')->storeAs('public/assets/images/medium_thumbnail', $mediumthumbnail);

            # Create medium thumbnail
            $mediumthumbnailpath = public_path('storage/assets/images/medium_thumbnail/'.$mediumthumbnail);
            $this->createThumbnail($mediumthumbnailpath, 750, 540);


        } else {
            $fileNameToStore = 'noimage.jpg';
            $mediumthumbnail = 'noimage.jpg';
        }

        $order->image = $mediumthumbnail;
        $order->save();

        return back()->with('success', 'Image Uploaded');
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
