<?php

Route::group(['prefix'  =>  'staff'], function () {

    Route::get('login', 'Staff\LoginController@showLoginForm')->name('staff.login');
    Route::post('login', 'Staff\LoginController@login')->name('staff.login.post');
    Route::get('logout', 'Staff\LoginController@logout')->name('staff.logout');

    Route::group(['middleware' => ['auth:staff']], function () {

        Route::get('/', function () {
            if(Auth::user()->status != 0) {
                return view('staff.dashboard.index');
            }

            Auth::logout();
            return back()->with('error', "You're Blocked");

        })->name('staff.dashboard');

        Route::resource('staff_customer', 'Staff\CustomerController');

    });

});
