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

Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth.jwt')->resource('salon', 'SalonController');

Route::group(array('prefix' => 'user'), function()
{
    Route::post('signup','UserController@signup');
    Route::post('signin','UserController@signin');
    Route::post('logout','UserController@logout');
});
