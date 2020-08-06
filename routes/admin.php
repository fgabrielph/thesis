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
        Route::get('low_items', 'Admin\ItemController@lowitem')->name('admin.lowitems');
        Route::resource('admin_orders', 'Admin\OrderController');
        Route::get('admin_orders/status/{status}/{id}', 'Admin\OrderController@decide')->name('admin_orders.status');

        # Logs Controller
        Route::get('logs', 'Admin\LogsController@index')->name('logs.index');

        # Custom Orders Controller
        Route::resource('customorders', 'Admin\CustomOrderController');
        Route::get('customorders/{customorder}/decline', 'Admin\CustomOrderController@decline')->name('customorders.decline');
        Route::get('customorders/{customorder}/accept', 'Admin\CustomOrderController@accept')->name('customorders.accept');
        Route::put('customorders/{customorder}/add_quantity', 'Admin\CustomOrderController@addquantity')->name('customorders.addquantity');
        Route::put('customorders/{customorder}/add_price', 'Admin\CustomOrderController@addprice')->name('customorders.addprice');
        Route::put('customorders/{customorder}/accept', 'Admin\CustomOrderController@accept_payment')->name('customorders.accept');

        # Deliveries Controller
        Route::resource('deliveries', 'Admin\DeliveryController');
        Route::get('deliveries/{status}/{id}', 'Admin\DeliveryController@change_status')->name('deliveries.status');
        Route::post('deliveries/{id}', 'Admin\DeliveryController@EDA')->name('deliveries.eda');
        Route::post('deliveries/edit/{id}', 'Admin\DeliveryController@edit_EDA')->name('deliveries.edit_eda');

        #Custom Deliveries Controller
        Route::resource('custom_deliveries', 'Admin\CustomDeliveryController');
        Route::post('custom_deliveries/{id}', 'Admin\CustomDeliveryController@EDA')->name('custom_deliveries.eda');
        Route::post('custom_deliveries/edit/{id}', 'Admin\CustomDeliveryController@edit_EDA')->name('custom_deliveries.edit_eda');
        Route::get('custom_deliveries/{status}/{id}', 'Admin\CustomDeliveryController@change_status')->name('custom_deliveries.status');

        # Reports Controller
        Route::get('reports/list_items', 'Admin\ReportsController@list_items')->name('report.items');
        Route::get('reports/list_orders', 'Admin\ReportsController@list_orders')->name('report.orders');
        Route::get('reports/list_custom_orders', 'Admin\ReportsController@list_custom_orders')->name('report.custom_orders');
        Route::get('reports/list_staffs', 'Admin\ReportsController@list_staffs')->name('report.staffs');
        Route::get('reports/list_admins', 'Admin\ReportsController@list_admins')->name('report.admins');
        Route::get('reports/list_deliveries', 'Admin\ReportsController@list_deliveries')->name('report.deliveries');
        Route::get('reports/list_critical_level', 'Admin\ReportsController@list_critical_level')->name('report.critical_level');
        Route::get('reports/list_sales', 'Admin\ReportsController@monthly_sales')->name('report.monthly_sales');

        # To PDF Function
        Route::get('reports/pdf/{name}/download', 'Admin\ReportsController@toPDF')->name('export');


        # Data Visualization
        Route::get('analysis/orders', 'Admin\DataAnalysisController@sales_order')->name('analysis.orders');
        Route::get('analysis/demand', 'Admin\DataAnalysisController@demand_custom_order')->name('analysis.demand');
        Route::post('analysis_forecast/orders/{id}', 'Admin\DataAnalysisController@forecast_order')->name('forecast.orders');
        Route::post('analysis_forecast/demand/{id}', 'Admin\DataAnalysisController@forecast_custom_order')->name('forecast.demand');


    });
    // ================================================================================================================================ //

});
