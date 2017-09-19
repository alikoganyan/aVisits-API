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
Route::group(['middleware'=>['auth.jwt','own.chain'],'prefix' => '{chain}/salon'], function()
{
    Route::resource('/','SalonController');
});

//Route::middleware(['auth.jwt'])->resource('salon', 'SalonController');

Route::group(array('prefix' => 'user'), function()
{
    Route::post('signup','UserController@signup');
    Route::post('signin','UserController@signin');
    Route::get('logout','UserController@logout');
    Route::get('users','UserController@users');
});
