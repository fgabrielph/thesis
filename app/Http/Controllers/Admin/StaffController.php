<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Staff;
use Illuminate\Support\Facades\Storage;
use Image;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::orderBy('id', 'asc')->paginate(10);
        return view('admin.staffs.index')->with('staffs', $staffs);
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
            'name' => 'required|unique:staff|max:160',
            'email' => 'required|unique:staff|email',
            'password' => 'required|min:8|max:16',
            'confirm_pass' => 'same:password'
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

        $staff = new Staff;
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->image = $largethumbnail;
        $staff->password = bcrypt($request->password);
        $staff->save();

        return back()->withInput()->with('success', 'Staff Added');


    }

    public function edit($id) {

        $staff = Staff::find($id);

        $status = $staff->status;

        if($status == 0) {
            $staff->status = '1';
            $staff->save();
        }

        if($status == 1) {
            $staff->status = '0';
            $staff->save();
        }

        $message = $staff->status ? 'Account Activated' : 'Account Deactivated';

        return back()->withInput()->with('success', $message);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);

        $staff->delete();
        return back()->withInput()->with('success', 'Account Deleted');
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
