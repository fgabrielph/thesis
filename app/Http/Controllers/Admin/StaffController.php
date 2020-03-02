<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logs;
use Illuminate\Http\Request;
use App\Staff;
use Illuminate\Support\Facades\Auth;
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
        $staffs = Staff::all();
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

            # Status Log
            $log = new Logs;
            $log->action = 'Staff Activated';
            $log->admin_id = Auth::user()->id;
            $log->save();
        }

        if($status == 1) {
            $staff->status = '0';
            $staff->save();

            # Status Log
            $log = new Logs;
            $log->action = 'Staff Deactivated';
            $log->admin_id = Auth::user()->id;
            $log->save();
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

        # Status Log
        $log = new Logs;
        $log->action = 'Deleted an account';
        $log->admin_id = Auth::user()->id;
        $log->save();
        return back()->withInput()->with('success', 'Account Deleted');
    }
}
