<?php

namespace App\Http\Controllers\Staff;

use App\Logs;
use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('staff.brands.index')->with('brands', $brands);
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
            'name' => 'required|unique:brands|max:160',
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
            $largethumbnail = 'nobrandimage.jpg';
        }

        # Create Brand
        $brand = new Brand;
        $brand->image = $largethumbnail;
        $brand->name = $request->input('name');  //$post->user_id = auth()->user()->id; //This Gets the Currently User Logged in
        $brand->save();

        # Added Log
        $log = new Logs;
        $log->action = 'Added a Brand';
        $log->staff_id = Auth::user()->id;
        $log->save();

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
            'image' => 'nullable|max:1999|'
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

        //Update Item
        $brand = Brand::find($id);
        $brand->name = $request->input('name');
        if($request->hasFile('image')){
            if ($brand->image != 'nobrandimage.jpg') {
                Storage::delete('public/assets/images/large_thumbnail'.$brand->image);
            }
            $brand->image = $largethumbnail;
        }
        $brand->save();

        # Updated Logs
        $log = new Logs;
        $log->action = 'Updated a Brand';
        $log->staff_id = Auth::user()->id;
        $log->save();

        return back()->with('success', 'Brand Updated');
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
}
