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
    /**
     * @api {get} /{chain}?token=:token Get chains
     * @apiName Get chains
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Chain
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * [
     *      {
     *          "title": "string",
     *          "description": "string",
     *          "created_at": "string"
     *      }
     * ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /chain?token=:token Create chain
     * @apiName Create chain
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Chain
     *
     * @apiParam {String} title Title
     * @apiParam {String} description Description
     * @apiParam {String} created_at Created At
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * [
     *      {
     *          "title": "string",
     *          "description": "string",
     *          "created_at": "string"
     *      }
     * ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /chain/{chain}?token=:token Update chain
     * @apiName Update chain
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Chain
     *
     * @apiParam {String} title Title
     * @apiParam {String} description Description
     * @apiParam {String} created_at Created At
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *      {
     *          "title": "string",
     *          "description": "string",
     *          "created_at": "string"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {delete} /chain/{chain}?token=:token Delete chain
     * @apiName Delete chain
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Chain
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "success": 1
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::resource('chain', 'ChainController');
});

Route::group(['middleware' => ['auth.jwt', 'own.chain'], 'prefix' => '{chain}'], function () {
    /**
     * @api {get} /{chain}/salon?token=:token Get salons
     * @apiName Get salons
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Salon
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     [
     *          {
     *              "title": "string",
     *              "country": "string",
     *              "city": "string",
     *              "address": "string",
     *              "latitude": 0,
     *              "longitude": 0,
     *              "current_time": "2017-10-24T07:14:40.498Z"
     *          }
     *      ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {get} /{chain}/salon/{salon}?token=:token Get salon
     * @apiName Get salon
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Salon
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "country": "string",
     *          "city": "string",
     *          "address": "string",
     *          "latitude": 0,
     *          "longitude": 0,
     *          "current_time": "2017-10-24T07:14:40.498Z"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/salon/?token=:token Create salon
     * @apiName Create salon
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Salon
     *
     * @apiParam {String} title Title
     * @apiParam {String} country Country
     * @apiParam {String} city City
     * @apiParam {String} address Address
     * @apiParam {String} latitude Latitude
     * @apiParam {String} longitude Longitude
     * @apiParam {String} current_time Current time
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "country": "string",
     *          "city": "string",
     *          "address": "string",
     *          "latitude": 0,
     *          "longitude": 0,
     *          "current_time": "2017-10-24T07:14:40.498Z"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /{chain}/salon/{salon}?token=:token Update salon
     * @apiName Update salon
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Salon
     *
     * @apiParam {String} title Title
     * @apiParam {String} country Country
     * @apiParam {String} image Image
     * @apiParam {String} city City
     * @apiParam {String} address Address
     * @apiParam {String} latitude Latitude
     * @apiParam {String} longitude Longitude
     * @apiParam {String} current_time Current time
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "img": "string",
     *          "country": "string",
     *          "city": "string",
     *          "address": "string",
     *          "latitude": 0,
     *          "longitude": 0,
     *          "current_time": "2017-10-24T07:14:40.498Z"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {delete} /{chain}/salon/{salon}?token=:token Delete salon
     * @apiName Delete salon
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Salon
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "success": 1
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::put('salon/{salon}', 'SalonController@update')->middleware(['own.salon']);
    Route::resource('salon', 'SalonController')->except('update');

    /**
     * @api {get} /{chain}/service_category?token=:token Get categories
     * @apiName Get categories
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Service Category
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     [
     *          {
     *              "id": 0,
     *              "title": "string",
     *              "parent_id": 0,
     *              "created_at": "2017-10-24T07:42:08.256Z",
     *              "updated_at": "2017-10-24T07:42:08.256Z"
     *          }
     *      ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/service_category?token=:token Create category
     * @apiName Create category
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Service Category
     *
     * @apiParam {String} title Title
     * @apiParam {Integer} parent_id Parent ID
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "title": "string",
     *          "parent_id": 0,
     *          "created_at": "2017-10-24T07:48:13.922Z",
     *          "updated_at": "2017-10-24T07:48:13.922Z"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /{chain}/service_category/{service_category}?token=:token Update category
     * @apiName Update category
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Service Category
     *
     * @apiParam {String} title Title
     * @apiParam {Integer} parent_id Parent ID
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "title": "string",
     *          "parent_id": 0,
     *          "created_at": "2017-10-24T07:48:13.922Z",
     *          "updated_at": "2017-10-24T07:48:13.922Z"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::resource('service_category', 'ServiceCategoryController');
    Route::get('category-groups', 'ServiceCategoryController@categoryGroups');
    Route::get('service_categories', 'ServiceCategoryController@categories');
    Route::get('service_groups', 'ServiceCategoryController@groups');
    Route::get('service_categories/{category_id}', 'ServiceCategoryController@groupsByCategory');
    Route::resource('service', 'ServiceController');
    Route::get('salon_schedule/{salon}/salon', 'SalonScheduleController@salon_schedule');
    Route::resource('salon_schedule', 'SalonScheduleController');
    Route::post('employee-schedule', 'EmployeeScheduleController@create');
    Route::put('employee-schedule', 'EmployeeScheduleController@edit');
    Route::resource('employee', 'EmployeeController');
    Route::post('employee-photo-upload', 'EmployeeController@photo');
    Route::resource('position', 'PositionController')->except('index');
    Route::post('position_index', 'PositionController@index');
    Route::resource('schedule', 'ScheduleController');
    Route::resource('service_price', 'ServicePriceController');
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
