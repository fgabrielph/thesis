<?php

Route::group(['prefix'  =>  'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');

    // ============================ MIDDLEWARE ========================================================================================= //
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

        Route::resource('staffs', 'Admin\StaffController');
        Route::resource('customers', 'Admin\CustomerController');
        Route::resource('categories', 'Admin\CategoryController');
        Route::resource('brands', 'Admin\BrandController');
        Route::resource('items', 'Admin\ItemController');
        Route::resource('admin_orders', 'Admin\OrderController');
        Route::resource('customorders', 'Admin\CustomOrderController');



    });
    // ================================================================================================================================ //

});
