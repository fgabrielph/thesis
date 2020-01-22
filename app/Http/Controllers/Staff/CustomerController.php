<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::all();
        return view('staff.customers.index')->with('customers', $customers);
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
            'name' => 'required|max:160',
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

        $customer = new User;
        $customer->name = $request->name;
        $customer->avatar = $largethumbnail;
        $customer->email = $request->email;
        $customer->password = bcrypt($request->password);
        $customer->save();

        return back()->withInput()->with('success', 'Customer Added');
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
        $customer = User::find($id);
        $status = $customer->status;

        if($status == 0) {
            $customer->status = '1';
            $customer->save();
        }

        if($status == 1) {
            $customer->status = '0';
            $customer->save();
        }


        $message = $customer->status ? 'Account Activated' : 'Account Deactivated';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::find($id);

        //$cust_id = User::whereRaw('id = (select max(`id`) from users)')->get();
        //$id_max = DB::table('users')->max('id') + 1;
        //DB::statement("ALTER TABLE users AUTO_INCREMENT = $id_max");

        $customer->delete();
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
