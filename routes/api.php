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
//Route::resource('salon','SalonController');
Route::get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>['auth.jwt']], function()
{
    Route::resource('chain','ChainController');
});
Route::group(['middleware'=>['auth.jwt','own.chain'],'prefix' => '{chain}'], function()
{
    Route::put('salon/{salon}','SalonController@update')->middleware(['own.salon']);
    Route::resource('salon','SalonController')->except('update');
    Route::resource('service_category','ServiceCategoryController');
    Route::get('service_groups','ServiceCategoryController@groups');
    Route::resource('service','ServiceController');
    Route::get('salon_schedule/{salon}/salon','SalonScheduleController@salon_schedule');
    Route::resource('salon_schedule','SalonScheduleController');
    Route::resource('employee','EmployeeController');
    Route::post('employee-photo-upload','EmployeeController@photo');
    Route::resource('position','PositionController');
    Route::resource('schedule','ScheduleController');
});


//Route::middleware(['auth.jwt'])->resource('salon', 'SalonController');

Route::group(array('prefix' => 'user'), function()
{
    Route::post('signup','UserController@signup');
    Route::post('signin','UserController@signin');
    Route::get('logout','UserController@logout');
    Route::get('users','UserController@users');
});

Route::group(['prefix' => '{chain}'], function(){
    Route::group(array('prefix' => 'user'), function()
    {
        Route::post('login','UserController@login');
    });
});
