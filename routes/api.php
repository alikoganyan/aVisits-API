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

/**
 * @api {post} /user/signup Sign up
 * @apiName Sign up
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} name Name
 * @apiParam {String} phone Phone
 * @apiParam {String} email Email
 * @apiParam {String} password Password
 * @apiParam {String} password_confirmation Password Confirmation
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *       "successful operation"
 *     }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "Invalid input"
 *     }
 */

/**
 * @api {post} /user/signin Authentication First step
 * @apiName Authentication First step
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} phone Phone
 * @apiParam {String} email Email
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *       {
 *          "user": {
 *          "id": 0,
 *          "name": "string",
 *          "email": "string",
 *          "last_name": "string",
 *          "father_name": "string",
 *          "phone": "string",
 *          "created_at": "2017-10-19T13:11:49.858Z",
 *          "updated_at": "2017-10-19T13:11:49.858Z",
 *          "chains": [
 *              {
 *                  "id": 0,
 *                  "title": "string",
 *                  "description": "string",
 *                  "user_id": 0,
 *                  "created_at": "string",
 *                  "updated_at": "string"
 *              }
 *          ]
 *        }
 *       }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "Invalid input"
 *     }
 */

/**
 * @api {post} /user/signup Sign up
 * @apiName Sign up
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} name Name
 * @apiParam {String} phone Phone
 * @apiParam {String} email Email
 * @apiParam {String} password Password
 * @apiParam {String} password_confirmation Password Confirmation
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *       "successful operation"
 *     }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "Invalid input"
 *     }
 */

/**
 * @api {post} /{chain}/user/login Authentication Second step
 * @apiName Authentication Second step
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} phone Phone
 * @apiParam {String} email Email
 * @apiParam {String} password Password
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 * {
 *  "token": "string",
 *  "redirect_to_create_salon": 0,
 *  "chain": {
 *      "id": 0
 *  },
 *  "user": {
 *      "id": 0,
 *      "name": "string",
 *      "email": "string",
 *      "last_name": "string",
 *      "father_name": "string",
 *      "phone": "string",
 *      "created_at": "2017-10-19T13:18:30.277Z",
 *      "updated_at": "2017-10-19T13:18:30.277Z"
 *  }
 * }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "Invalid input"
 *     }
 */
Route::get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth.jwt']], function () {
    Route::resource('chain', 'ChainController');
});

Route::group(['middleware'=>['auth.jwt','own.chain'],'prefix' => '{chain}'], function()
{
    Route::put('salon/{salon}','SalonController@update')->middleware(['own.salon']);
    Route::resource('salon','SalonController')->except('update');
    Route::resource('service_category','ServiceCategoryController');
    Route::get('category-groups','ServiceCategoryController@categoryGroups');
    Route::get('service_categories','ServiceCategoryController@categories');
    Route::get('service_groups','ServiceCategoryController@groups');
    Route::get('service_categories/{category_id}','ServiceCategoryController@groupsByCategory');
    Route::resource('service','ServiceController');
    Route::get('salon_schedule/{salon}/salon','SalonScheduleController@salon_schedule');
    Route::resource('salon_schedule','SalonScheduleController');
    Route::post('employee-schedule','EmployeeScheduleController@create');
    Route::put('employee-schedule','EmployeeScheduleController@edit');
    Route::resource('employee','EmployeeController');
    Route::post('employee-photo-upload','EmployeeController@photo');
    Route::resource('position','PositionController')->except('index');
    Route::post('position_index','PositionController@index');
    Route::resource('schedule','ScheduleController');
    Route::resource('service_price','ServicePriceController');
});


//Route::middleware(['auth.jwt'])->resource('salon', 'SalonController');

Route::group(array('prefix' => 'user'), function () {
    Route::post('signup', 'UserController@signup');
    Route::post('signin', 'UserController@signin');
    Route::get('logout', 'UserController@logout');
    Route::get('users', 'UserController@users');
});

Route::group(['prefix' => '{chain}'], function () {
    Route::group(array('prefix' => 'user'), function () {
        Route::post('login', 'UserController@login');
    });
});
