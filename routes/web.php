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

//Page Controller Routes
Route::view('/', 'site.pages.homepage')->name('home');
Route::get('/shop', 'PagesController@shop')->name('site.shop');
Route::get('/shop/{id}', 'PagesController@categories')->name('site.categories');
Route::get('/product/{id}', 'PagesController@show')->name('site.product');

//Cart Controller Routes
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::put('/cart/update/{id}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{item}', 'CartController@destroy')->name('cart.remove');
Route::get('/cart/empty', 'CartController@clear')->name('cart.clear');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/accounts/profile', 'AccountController@index')->name('account.index');
});

Auth::routes(['verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home');

require 'admin.php';
require 'staff.php';
