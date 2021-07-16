<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', 'App\Http\Controllers\SuppliesController@index');
Route::get('/categories/new', 'App\Http\Controllers\SuppliesController@newCategory')->name('new_category');
Route::post('/categories/new', 'App\Http\Controllers\SuppliesController@store')->name('add_category');

Route::get('/products', 'App\Http\Controllers\SuppliesController@showProducts');
Route::get('/products/new', 'App\Http\Controllers\SuppliesController@newProduct')->name('new_product');
Route::post('/products/new', 'App\Http\Controllers\SuppliesController@storeProduct')->name('add_product');

//for vue component

//showing product list
Route::get('/products02', 'App\Http\Controllers\SuppliesController@apiIndex');
Route::get('/categories02', 'App\Http\Controllers\SuppliesController@apiCategories');

//deleting product
Route::delete('/products02/{id}', 'App\Http\Controllers\SuppliesController@destroy');
