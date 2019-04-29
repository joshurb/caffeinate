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


//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::get('/user', function (Request $request) {
    //dd($request);
    return 'user: '.$request->user();
});

Route::get('/drinks', 'DrinkController@index');
Route::get('/drinks-consumed', 'ConsumedDrinkController@index');
Route::get('/total-caffeine', 'ConsumedDrinkController@totalCaffeine');
Route::get('/suggest-drink', 'ConsumedDrinkController@suggestMaximumDrink');
Route::post('/drank', 'ConsumedDrinkController@store');
Route::delete('/delete-consumed-drink/{id}', 'ConsumedDrinkController@destroy');
