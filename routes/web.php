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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/p{id}', 'HomeController@showProduct')->name('show_product');


Route::prefix('admin')->group(function (){

    Route::get('/', 'AdminController@index')->name('admin_dashboard');

    Route::prefix('category')->group(function (){
        Route::get('/', 'AdminController@categories')->name('categories');
        Route::post('/', 'AdminController@store_category')->name('store_category');
        Route::get('/{id}', 'AdminController@get_category')->name('category');
        Route::put('/{id}', 'AdminController@update_category')->name('update_category');

    });


    Route::get('/products', 'AdminController@products')->name('admin.products');
    Route::get('/products/p{id}', 'AdminController@get_product')->name('admin.product');
    Route::put('/products/p{id}', 'AdminController@update_product')->name('admin.update_product');
    Route::delete('/products/p{id}', 'AdminController@deleteProduct')->name('admin.delete_product');
    Route::post('/products/p{id}/add_pictures', 'AdminController@addPictures')->name('admin.add_pictures');
    Route::get('/add_product', 'AdminController@add_product')->name('admin.add_product');
    Route::post('/add_product', 'AdminController@store_product')->name('admin.store_product');


    Route::delete('/pictures/delete_many', 'AdminController@deleteManyPictures')->name('admin.delete_pictures');

});
