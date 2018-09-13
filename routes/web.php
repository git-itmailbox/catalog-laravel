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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function (){

    Route::get('/', 'AdminController@index')->name('admin_dashboard');
    Route::get('/category', 'AdminController@categories')->name('categories');
    Route::post('/category', 'AdminController@store_category')->name('store_category');
    Route::get('/category/{id}', 'AdminController@get_category')->name('category');
    Route::put('/category/{id}', 'AdminController@update_category')->name('category');

});

