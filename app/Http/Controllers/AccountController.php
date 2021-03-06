<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suborder;
use App\Order;
use App\Item;
use App\Invoice;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use Illuminate\Support\Facades\Storage;
use Hash;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        # Getting the user id of paid orders in Orders Table
        # $paid = DB::table('orders')->where([['user_id', Auth::user()->id], ['payment_status', 1]])->pluck('id'); GETTING ERRORS ON NEW USERS


        # Getting the details of the Orders based on completed transactions
        # $data['transaction'] = Suborder::with('order')->where('order_id', $paid)->paginate(3); GETTING ERRORS ON NEW USERS


        $orders = Auth::user()->orders()->orderby('updated_at', 'desc')->where('payment_status', 1)->paginate(3);
        return view('site.accounts.profile')->with('orders', $orders);


    }

    public function picture(Request $request, $id) {

        # Validation
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
            $fileNameToStore = 'noavatar.jpg';
            $smallthumbnail = 'noavatar.jpg';
            $mediumthumbnail = 'noavatar.jpg';
            $largethumbnail = 'noavatar.jpg';
        }

        //Update Item
        $user = Auth::user();
        if($request->hasFile('image')){
            if ($user->avatar != 'noavatar.jpg') {
                Storage::delete('public/assets/images/large_thumbnail'.$user->avatar);
            }
            $user->avatar = $largethumbnail;
        }
        $user->save();

        return back()->with('success', 'Profile Picture Updated');
    }

    public function nameoremail(Request $request) {

        # Validation
        $this->validate($request, [
            'first_name' => 'required|max:160',
            'last_name' => 'required|max:160',
            'email' => 'required|email'
        ]);

        $user = Auth::user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        $user->save();

        return back()->with('success', 'Profile Updated');

    }

    public function address(Request $request) {

        # Validation
        $this->validate($request, [
            'address' => 'required|max:160'
        ]);

        $user = Auth::user();
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Address Updated');
    }

    public function birthday(Request $request) {

        # Validation
        $this->validate($request, [
            'birthday' => 'required|max:160'
        ]);

        $user = Auth::user();
        $user->birthday = $request->birthday;
        $user->save();

        return back()->with('success', 'Birthday Updated');
    }

    public function change_password(Request $request) {

        $user = Auth::user();
        $data = Hash::check($request->get('password'), $user->password);

        if($data == true) {

            # Validation
            $this->validate($request, [
                'newpass' => 'required|min:8|max:16',
                'confirmpass' => 'same:newpass'
            ]);

            $user->password = bcrypt($request->newpass);
            $user->save();

            return back()->with('success', 'Password Updated');
        }

        return back()->with('error', 'Wrong Password');

    }

    public function change_mobile(Request $request) {

        # Validation
        $this->validate($request, [
            'mobile_num' => 'required|numeric|digits:11'
        ]);

        $user = Auth::user();
        $user->mobile_number = $request->mobile_num;
        $user->save();

        return back()->with('success', 'Mobile Number Updated');
    }

}
