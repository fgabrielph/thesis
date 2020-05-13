<?php

Route::group(['prefix'  =>  'staff'], function () {

    Route::get('login', 'Staff\LoginController@showLoginForm')->name('staff.login');
    Route::post('login', 'Staff\LoginController@login')->name('staff.login.post');
    Route::get('logout', 'Staff\LoginController@logout')->name('staff.logout');

    Route::group(['middleware' => ['auth:staff']], function () {

        Route::get('/', 'Staff\DashboardController@index')->name('staff.dashboard');

        Route::resource('staff_customer', 'Staff\CustomerController');
        Route::resource('walkin', 'Staff\WalkinController');
        Route::resource('staff_categories', 'Staff\CategoryController');
        Route::resource('staff_brands', 'Staff\BrandController');
        Route::resource('staff_items', 'Staff\ItemController');
        Route::get('low_items', 'Staff\ItemController@lowitem')->name('staff.lowitems');
        Route::resource('staff_orders', 'Staff\OrderController');
        Route::get('staff_orders/status/{status}/{id}', 'Admin\OrderController@decide')->name('staff_orders.status');

        Route::get('/item/{id}', 'Staff\WalkinController@categories')->name('staff.categories');

        # Cart Controller Routes
        Route::get('/cart', 'Staff\CartController@index')->name('staff_cart.index');
        Route::post('/cart', 'Staff\CartController@store')->name('staff_cart.store');
        Route::put('/cart/update/{id}', 'Staff\CartController@update')->name('staff_cart.update');
        Route::delete('/cart/{item}', 'Staff\CartController@destroy')->name('staff_cart.remove');
        Route::get('/cart/empty', 'Staff\CartController@clear')->name('staff_cart.clear');

        # Checkout Controller
        Route::get('/checkout', 'Staff\CheckoutController@index')->name('staff_checkout.index');
        Route::post('/checkout', 'Staff\CheckoutController@invoice')->name('staff_checkout.invoice');

        # Deliveries Controller
        Route::resource('staff_deliveries', 'Staff\DeliveryController');
        Route::get('staff_deliveries/{status}/{id}', 'Admin\DeliveryController@change_status')->name('staff_deliveries.status');
        Route::post('staff_deliveries/{id}', 'Admin\DeliveryController@EDA')->name('staff_deliveries.eda');
        Route::post('staff_deliveries/edit/{id}', 'Admin\DeliveryController@edit_EDA')->name('staff_deliveries.edit_eda');

    });

});
