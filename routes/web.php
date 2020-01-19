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

Route::view('/', 'site.pages.homepage')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/accounts/profile', 'PagesController@index')->name('account.index');
});

Auth::routes(/*['verify' => true]*/);

//Route::get('/home', 'HomeController@index')->name('home');

require 'admin.php';
require 'staff.php';
