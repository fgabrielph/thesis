<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $data['items'] = Item::orderBy('created_at', 'desc')->paginate(10);
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();

        return view('admin.items.index', $data);
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
            // Get filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //small thumbnail name
            $smallthumbnail = $fileName.'_small_'.time().'.'.$extension;

            //medium thumbnail name
            $mediumthumbnail = $fileName.'_medium_'.time().'.'.$extension;

            //large thumbnail name
            $largethumbnail = $fileName.'_large_'.time().'.'.$extension;

            // Upload Image
            $path = $request->file('image')->storeAs('public/assets/images', $fileNameToStore);
            $smallpath = $request->file('image')->storeAs('public/assets/images/small_thumbnail', $smallthumbnail);
            $mediumpath = $request->file('image')->storeAs('public/assets/images/medium_thumbnail', $mediumthumbnail);
            $largepath = $request->file('image')->storeAs('public/assets/images/large_thumbnail', $largethumbnail);

            //create small thumbnail
            $smallthumbnailpath = public_path('storage/assets/images/small_thumbnail/'.$smallthumbnail);
            $this->createThumbnail($smallthumbnailpath, 150, 93);

            //create medium thumbnail
            $mediumthumbnailpath = public_path('storage/assets/images/medium_thumbnail/'.$mediumthumbnail);
            $this->createThumbnail($mediumthumbnailpath, 300, 185);

            //create large thumbnail
            $largethumbnailpath = public_path('storage/assets/images/large_thumbnail/'.$largethumbnail);
            $this->createThumbnail($largethumbnailpath, 550, 340);

        } else {
            $fileNameToStore = 'noimage.jpg';
            $smallthumbnail = 'noimage.jpg';
            $mediumthumbnail = 'noimage.jpg';
            $largethumbnail = 'noimage.jpg';
        }

        //Create Item
        $item = new Item;
        $item->category_id = $request->category;
//        if(!is_integer($item->category_id)){
//            return redirect('/admin/table/items')->with('error', 'Select a Category');
//        }
        $item->name = $request->input('name');
        $item->brand_id = $request->brand;
        $item->image = $largethumbnail;
        $item->price_stocks = $request->input('price_stocks');                                                        //$post->user_id = auth()->user()->id; //This Gets the Currently User Logged in
        $item->stocks = $request->input('stocks');
        $item->description = $request->input('description');
        $item->save();

        return back()->with('success', 'Item Updated');
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
        //Validation
        $this->validate($request, [
            'name' => 'required|max:160',
            'brand' => 'required',
            'price_stocks' => 'required|numeric|min:1',
            'stocks' => 'required|numeric|min:1',
            'description' => 'required',
            'category' => 'required',
            'image' => 'nullable|max:1999|mimes:jpeg,bmp,png'
        ]);

        //Handle File Upload

        if($request->hasFile('image')){
            // Get filename with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //small thumbnail name
            $smallthumbnail = $fileName.'_small_'.time().'.'.$extension;

            //medium thumbnail name
            $mediumthumbnail = $fileName.'_medium_'.time().'.'.$extension;

            //large thumbnail name
            $largethumbnail = $fileName.'_large_'.time().'.'.$extension;

            // Upload Image
            $path = $request->file('image')->storeAs('public/assets/images', $fileNameToStore);
            $smallpath = $request->file('image')->storeAs('public/assets/images/small_thumbnail', $smallthumbnail);
            $mediumpath = $request->file('image')->storeAs('public/assets/images/medium_thumbnail', $mediumthumbnail);
            $largepath = $request->file('image')->storeAs('public/assets/images/large_thumbnail', $largethumbnail);

            //create small thumbnail
            $smallthumbnailpath = public_path('storage/assets/images/small_thumbnail/'.$smallthumbnail);
            $this->createThumbnail($smallthumbnailpath, 150, 93);

            //create medium thumbnail
            $mediumthumbnailpath = public_path('storage/assets/images/medium_thumbnail/'.$mediumthumbnail);
            $this->createThumbnail($mediumthumbnailpath, 300, 185);

            //create large thumbnail
            $largethumbnailpath = public_path('storage/assets/images/large_thumbnail/'.$largethumbnail);
            $this->createThumbnail($largethumbnailpath, 550, 340);

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
        //$item->image = $largethumbnail;
        $item->price_stocks = $request->price_stocks;                                                        //$post->user_id = auth()->user()->id; //This Gets the Currently User Logged in
        $item->stocks = $request->stocks;
        $item->description = $request->description;
        $item->save();

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
