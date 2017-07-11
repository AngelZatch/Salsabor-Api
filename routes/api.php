<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){
    Route::resource('users', 'UserController');
    Route::get('users/{id}/products', 'UserController@products');
    Route::get('users/{id}/transactions', 'UserController@transactions');

    Route::resource('products', 'ProductController');
    Route::post('products/sales', 'ProductController@sales');

    Route::post('planning/frequentation', 'PlanningController@frequentation');
});