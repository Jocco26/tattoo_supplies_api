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