<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Item;
use App\Brand;
use App\Category;
use Image;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['items'] = Item::all();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();

        return view('admin.items.index', $data);
    }

    public function lowitem()
    {
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['items'] = Item::where('stocks', '<=', 5)->get();

        return view('admin.items.lowitems', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|unique:items|max:160',
            'brand' => 'required',
            'price_stocks' => 'required|numeric|min:0.01',
            'stocks' => 'required|numeric|min:1',
            'description' => 'required',
            'category' => 'required',
            'image' => 'nullable|max:1999|mimes:jpeg,bmp,png'
        ]);

        //Handle File Upload

        if($request->hasFile('image')){

            # Get filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            # Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();

            # Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            # Small thumbnail name
            $smallthumbnail = $fileName.'_small_'.time().'.'.$extension;

            # Medium thumbnail name
            $mediumthumbnail = $fileName.'_medium_'.time().'.'.$extension;

            # Large thumbnail name
            $largethumbnail = $fileName.'_large_'.time().'.'.$extension;

            # Upload Image
            $path = public_path('assets/images/' . $fileNameToStore);
            $smallpath = public_path('assets/images/small_thumbnail/' . $smallthumbnail);
            $mediumpath = public_path('assets/images/medium_thumbnail/' . $mediumthumbnail);
            $largepath = public_path('assets/images/large_thumbnail/' . $largethumbnail);

            # Create original image
            Image::make($request->file('image'))->save($path);

            # Create small thumbnail
            Image::make($request->file('image'))->resize(150, 93)->save($smallpath);

            # Create medium thumbnail
            Image::make($request->file('image'))->resize(300, 185)->save($mediumpath);

            # Create large thumbnail
            Image::make($request->file('image'))->resize(550, 340)->save($largepath);

        } else {
            $fileNameToStore = 'noimage.jpg';
            $smallthumbnail = 'noimage.jpg';
            $mediumthumbnail = 'noimage.jpg';
            $largethumbnail = 'noimage.jpg';
        }

        # Create Item
        $item = new Item;
        $item->category_id = $request->category;
        $item->name = $request->input('name');
        $item->brand_id = $request->brand;
        $item->image = $largethumbnail;
        $item->price_stocks = $request->input('price_stocks');
        $item->stocks = $request->input('stocks');
        $item->description = $request->input('description');
        $item->save();

        # Add Log
        $log = new Logs;
        $log->action = 'Added an Item';
        $log->admin_id = Auth::user()->id;
        $log->save();


        return back()->with('success', 'Item Added');
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
        # Validation
        $this->validate($request, [
            'name' => 'required|max:160',
            'brand' => 'required',
            'price_stocks' => 'required|numeric|min:1',
            'stocks' => 'required|numeric|min:1',
            'description' => 'required',
            'category' => 'required',
            'image' => 'nullable|max:1999|mimes:jpeg,bmp,png'
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

            # Small thumbnail name
            $smallthumbnail = $fileName.'_small_'.time().'.'.$extension;

            # Medium thumbnail name
            $mediumthumbnail = $fileName.'_medium_'.time().'.'.$extension;

            # Large thumbnail name
            $largethumbnail = $fileName.'_large_'.time().'.'.$extension;

            # Upload Image
            $path = public_path('assets/images/' . $fileNameToStore);
            $smallpath = public_path('assets/images/small_thumbnail/' . $smallthumbnail);
            $mediumpath = public_path('assets/images/medium_thumbnail/' . $mediumthumbnail);
            $largepath = public_path('assets/images/large_thumbnail/' . $largethumbnail);

            # Create original image
            Image::make($request->file('image'))->save($path);

            # Create small thumbnail
            Image::make($request->file('image'))->resize(150, 93)->save($smallpath);

            # Create medium thumbnail
            Image::make($request->file('image'))->resize(300, 185)->save($mediumpath);

            # Create large thumbnail
            Image::make($request->file('image'))->resize(550, 340)->save($largepath);

        } else {
            $fileNameToStore = 'noimage.jpg';
            $smallthumbnail = 'noimage.jpg';
            $mediumthumbnail = 'noimage.jpg';
            $largethumbnail = 'noimage.jpg';
        }

        $item = Item::find($id);
        $item->name = $request->name;
        $item->brand_id = $request->brand;
        if($request->hasFile('image')){
            if ($item->image != 'noimage.jpg') {
                Storage::delete('public/assets/images/large_thumbnail'.$item->image);
            }
            $item->image = $largethumbnail;
        }
        $item->price_stocks = $request->price_stocks;
        $item->stocks = $request->stocks;
        $item->description = $request->description;
        $item->save();

        # Update Log
        $log = new Logs;
        $log->action = 'Updated an Item';
        $log->admin_id = Auth::user()->id;
        $log->save();

        return back()->with('success', 'Item Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
