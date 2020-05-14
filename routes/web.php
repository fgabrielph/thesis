<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Page Controller Routes
Route::view('/', 'site.pages.homepage')->name('home');
Route::view('/about', 'site.pages.about')->name('about');
Route::view('/contact', 'site.pages.contact')->name('contact');
Route::view('/privacy_policy','site.pages.privacypolicy')->name('policy');
Route::view('/terms_and_conditions','site.pages.terms')->name('terms');
Route::view('/refunds_returns', 'site.pages.returns_policy')->name('rr');
Route::view('/faqs', 'site.pages.faqs')->name('faqs');
Route::get('/shop', 'PagesController@shop')->name('site.shop');
Route::get('/inquire', 'PagesController@inquire')->name('site.inquire');
Route::get('/shop/{id}', 'PagesController@categories')->name('site.categories');
Route::get('/product/{id}', 'PagesController@show')->name('site.product');

# Cart Controller Routes
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::put('/cart/update/{id}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{item}', 'CartController@destroy')->name('cart.remove');
Route::get('/cart/empty', 'CartController@clear')->name('cart.clear');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/account/profile', 'AccountController@index')->name('account.index');
    Route::put('/account/profile/{id}', 'AccountController@picture')->name('account.picture');
    Route::post('/account/profile/name', 'AccountController@nameoremail')->name('account.name');
    Route::post('/account/profile/address', 'AccountController@address')->name('account.address');
    Route::post('/account/profile/birthday', 'AccountController@birthday')->name('account.birthday');
    Route::post('/account/profile/change_password', 'AccountController@change_password')->name('account.password');
    Route::post('/account/profile/change_mobile', 'AccountController@change_mobile')->name('account.mobile');

    # Inquiry Controller
    Route::get('/custom_order', 'InquiryController@index')->name('custom_order.index');
    Route::put('/inquiry', 'InquiryController@insert_order')->name('inquiry');
    Route::get('/custom_order/{id}', 'InquiryController@show')->name('custom_order.show');
    Route::put('/custom_order/{id}/payment', 'InquiryController@addpaymentmethod')->name('custom_order.payment');

    # Checkout Controller Routes
    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');

    # PayPal checkout
    Route::post('/checkout/paypal', 'CheckoutController@payWithpaypal')->name('paypal.checkout');

    //Route::post('/checkout/checkpayment', 'CheckoutController@payment_method')->name('check.checkout');

    # PayPal status callback
    Route::get('status', 'CheckoutController@getPaymentStatus');

    # Order Resource
    Route::resource('orders', 'OrderController');

    Route::put('/proof/{id}/upload', 'AddProofController@upload')->name('proof.upload');
    Route::get('/proof/{id}/', 'AddProofController@addproof')->name('proof.add');


    # Get the Invoice
    Route::get('/invoice/{id}', 'InvoiceController@show')->name('invoice.show');

});

Auth::routes(['verify' => true]);

require 'admin.php';
require 'staff.php';
