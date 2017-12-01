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
 * @apiParam {String} login Login
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *       {
 *          "data": {
 *              "chains": [
 *                  {
 *                      "id": 0,
 *                      "title": "string"
 *                  }
 *              ]
 *          },
 *          "status": "OK"
 *       }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "Invalid input"
 *     }
 *
 *     HTTP/1.1 404
 *     {
 *       "data":{
 *              "chains":[]
 *          },
 *       "status": "USER NOT FOUND"
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
 * @apiParam {String} login Login
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

/**
 * @api {post} /user/login-info Login Info
 * @apiName Login Info
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} login Login
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *          "success": true,
 *          "errors": [],
 *          "data": {
 *              "email": ":email",
 *              "phone": ":phone"
 *          }
 *     }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "success": "false",
 *       "errors": {
 *         ":fieldName":[
 *              ":errorMessage"
 *         ]
 *       }
 *     }
 */
Route::post('/user/login-info', 'UserController@loginInfo');

/**
 * @api {post} /user/forgot-password Forgot Password
 * @apiName Forgot Password
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} email Email if type(1)
 * @apiParam {String} phone Phone if type(2)
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *          "success": "true",
 *          "errors": "[]"
 *     }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "success": "false",
 *       "errors": {
 *         ":fieldName":[
 *              ":errorMessage"
 *         ]
 *       }
 *     }
 */
Route::post('/user/forgot-password', 'UserController@forgotPassword');

/**
 * @api {post} /user/reset-password Reset Password
 * @apiName Reset Password
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiParam {String} token Token
 * @apiParam {String} phone Phone number
 * @apiParam {String} password Password
 * @apiParam {String} confirm_password Confirm Password
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *          "success": "true",
 *          "errors": "[]"
 *     }
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 400
 *     {
 *       "success": "false",
 *       "errors": {
 *         ":fieldName":[
 *              ":errorMessage"
 *         ]
 *       }
 *     }
 */
Route::post('/user/reset-password', 'UserController@resetPassword');

/**
 * @api {post} /user/generate-password Generate Password
 * @apiName Generate Password
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Content-Type": "Application/json"
 *     }
 * @apiGroup Authentication
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200
 *     {
 *          "success": "true",
 *          "password": ":password"
 *     }
 */
Route::post('/user/generate-password', 'UserController@generatePassword');
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
     *     {
     *          "data": {
     *              "chain": {
     *                  "id": 0,
     *                  "title": "string",
     *                  "phone_number": "string",
     *                  "created_at": "2017-10-25 11:16:52",
     *                  "updated_at": "2017-10-25 11:16:52",
     *                  "levels": [
     *                  {
     *                      "id": 0,
     *                      "level": "string",
     *                      "chain_id": 0,
     *                      "created_at": "2017-10-25 11:49:08",
     *                      "updated_at": "2017-10-25 11:49:08"
     *                  }
     *                  ]
     *              }
     *          }
     *    }
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
     * @apiParam {String} phone_number Phone number
     * @apiParam {String} description Description
     * @apiParam {Object} levels [{"level":"1"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "data": {
     *              "chain": {
     *                  "id": 0,
     *                  "title": "string",
     *                  "phone_number": "string",
     *                  "created_at": "2017-10-25 11:16:52",
     *                  "updated_at": "2017-10-25 11:16:52",
     *                  "levels": [
     *                  {
     *                      "id": 0,
     *                      "level": "string",
     *                      "chain_id": 0,
     *                      "created_at": "2017-10-25 11:49:08",
     *                      "updated_at": "2017-10-25 11:49:08"
     *                  }
     *                  ]
     *              }
     *          },
     *          "status":"OK"
     *     }
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
     * @apiParam {String} phone_number Phone number
     * @apiParam {String} description Description
     * @apiParam {Object} levels [{"id":"0","level":"1"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "data": {
     *              "chain": {
     *                  "id": 0,
     *                  "title": "string",
     *                  "phone_number": "string",
     *                  "created_at": "2017-10-25 11:16:52",
     *                  "updated_at": "2017-10-25 11:16:52",
     *                  "levels": [
     *                  {
     *                      "id": 0,
     *                      "level": "string",
     *                      "chain_id": 0,
     *                      "created_at": "2017-10-25 11:49:08",
     *                      "updated_at": "2017-10-25 11:49:08"
     *                  }
     *                  ]
     *              }
     *          },
     *          "status":"OK"
     *     }
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
     *          "current_time": "2017-10-24T07:14:40.498Z",
     *          "notify_about_appointments":["1h11","2h11","3h11"]
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
     * @apiParam {String} street_number City
     * @apiParam {String} address Address
     * @apiParam {String} latitude Latitude
     * @apiParam {String} longitude Longitude
     * @apiParam {String} current_time Current time
     * @apiParam {Array} notify_about_appointments Reminders of default notes. Available Values: ["1h11","2h11","3h11","1d19","1d12","2d12","3d12","7d12"]
     * @apiParam {Array}  schedule [
     *                                 {   "id":schedule_id,
     *                                     "num_of_day":"1",
     *                                     "working_status" :"1",
     *                                     "start": "18:27",
     *                                     "end": "20:20"
     *                                 }
     *                             ]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "country": "string",
     *          "city": "string",
     *          "street_number": "string",
     *          "address": "string",
     *          "schedule": "[]",
     *          "latitude": 0,
     *          "longitude": 0,
     *          "current_time": "2017-10-24T07:14:40.498Z",
     *          "notify_about_appointments": ["1h11","2h11","3h11"]
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
     * @apiParam {String} street_number Street Number
     * @apiParam {String} address Address
     * @apiParam {String} latitude Latitude
     * @apiParam {String} longitude Longitude
     * @apiParam {String} current_time Current time
     * @apiParam {Array} notify_about_appointments Reminders of default notes. Available Values: ["1h11","2h11","3h11","1d19","1d12","2d12","3d12","7d12"]
     * @apiParam {Array}  schedule [
     *                                 {   "id":schedule_id,
     *                                     "num_of_day":"1",
     *                                     "working_status" :"1",
     *                                     "start": "18:27",
     *                                     "end": "20:20"
     *                                 }
     *                             ]
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "img": "string",
     *          "country": "string",
     *          "city": "string",
     *          "address": "string",
     *          "street_number": "string",
     *          "latitude": 0,
     *          "longitude": 0,
     *          "schedule": "[]",
     *          "current_time": "2017-10-24T07:14:40.498Z",
     *          "notify_about_appointments":["1h11","2h11","3h11"]
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
     * @apiGroup Category
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
     * @apiGroup Category
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
     * @apiGroup Category
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
     * @api {delete} /{chain}/service_category/{service_category}?token=:token Delete category
     * @apiName Delete category
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Category
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
    Route::resource('service_category', 'ServiceCategoryController');

    /**
     * @api {get} /{chain}/category-groups?token=:token Get category with groups
     * @apiName Get category with groups
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Category
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *          "categories": [
     *              {
     *                  "id": 0,
     *                  "parent_id": null,
     *                  "title": "string",
     *                  "created_at": null,
     *                  "updated_at": null,
     *                  "groups": [
     *                      {
     *                          "id": 0,
     *                          "parent_id": 0,
     *                          "title": "fsdfsdsfsdf",
     *                          "created_at": null,
     *                          "updated_at": null,
     *                          "services": []
     *                      }
     *                  ]
     *              }
     *          ]
     *      }
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {get} /{chain}/service_groups?token=:token Get groups
     * @apiName Get groups
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Category
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *         "groups": [
     *              {
     *                  "id": 0,
     *                  "parent_id": 0,
     *                  "title": "string",
     *                  "created_at": null,
     *                  "updated_at": null
     *              }
     *          ]
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {get} /{chain}/service_groups/{category}?token=:token Get groups by category
     * @apiName Get groups by category
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Category
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *         "groups": [
     *              {
     *                  "id": 0,
     *                  "parent_id": 0,
     *                  "title": "string",
     *                  "created_at": null,
     *                  "updated_at": null
     *              }
     *          ]
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::get('category-groups', 'ServiceCategoryController@categoryGroups');
    Route::get('service_categories', 'ServiceCategoryController@categories');
    Route::get('service_groups', 'ServiceCategoryController@groups');
    Route::get('service_categories/{category_id}', 'ServiceCategoryController@groupsByCategory');
    Route::resource('service', 'ServiceController');
    Route::get('salon_schedule/{salon}/salon', 'SalonScheduleController@salon_schedule');
    Route::resource('salon_schedule', 'SalonScheduleController');
    /**
     * @api {get} /{chain}/employee?token=:token Get employees
     * @apiName Get employees
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "first_name": "string",
     *          "last_name": "string",
     *          "father_name": "string",
     *          "photo": "string",
     *          "sex": "male",
     *          "birthday": "string",
     *          "email": "string",
     *          "phone": "string",
     *          "address": "string",
     *          "card_number": 0,
     *          "card_number_optional": 0,
     *          "deposit": 0,
     *          "bonuses": 0,
     *          "invoice_sum": 0,
     *          "position_id": 0,
     *          "public_position": "string",
     *          "comment": "string",
     *          "chain_id": 0,
     *          "created_at": "2017-10-24T08:51:55.385Z",
     *          "updated_at": "2017-10-24T08:51:55.385Z",
     *          "phone_2": "string"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/employee?token=:token Create employees
     * @apiName Create employees
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee
     *
     * @apiParam {String} first_name First Name
     * @apiParam {String} last_name Last Name
     * @apiParam {String} father_name Father Name
     * @apiParam {String} photo Photo
     * @apiParam {String} sex Sex
     * @apiParam {String} birthday Birthday
     * @apiParam {String} email E-mail
     * @apiParam {String} phone Phone
     * @apiParam {String} address Address
     * @apiParam {String} card_number Card Number
     * @apiParam {String} card_number_option Card Number Optional
     * @apiParam {String} deposit Deposit
     * @apiParam {String} bonuses Bonuses
     * @apiParam {String} invoice_sum Invoice Sum
     * @apiParam {String} position_id Position ID
     * @apiParam {String} public_position Public Position
     * @apiParam {String} comment Comment
     * @apiParam {String} phone_2 Phone 2
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "first_name": "string",
     *          "last_name": "string",
     *          "father_name": "string",
     *          "photo": "string",
     *          "sex": "male",
     *          "birthday": "string",
     *          "email": "string",
     *          "phone": "string",
     *          "address": "string",
     *          "card_number": 0,
     *          "card_number_optional": 0,
     *          "deposit": 0,
     *          "bonuses": 0,
     *          "invoice_sum": 0,
     *          "position_id": 0,
     *          "public_position": "string",
     *          "comment": "string",
     *          "chain_id": 0,
     *          "created_at": "2017-10-24T08:51:55.385Z",
     *          "updated_at": "2017-10-24T08:51:55.385Z",
     *          "phone_2": "string"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/employee/{employee}?token=:token Update employees
     * @apiName Update employees
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee
     *
     * @apiParam {String} first_name First Name
     * @apiParam {String} last_name Last Name
     * @apiParam {String} father_name Father Name
     * @apiParam {String} photo Photo
     * @apiParam {String} sex Sex
     * @apiParam {String} birthday Birthday
     * @apiParam {String} email E-mail
     * @apiParam {String} phone Phone
     * @apiParam {String} address Address
     * @apiParam {String} card_number Card Number
     * @apiParam {String} card_number_option Card Number Optional
     * @apiParam {String} deposit Deposit
     * @apiParam {String} bonuses Bonuses
     * @apiParam {String} invoice_sum Invoice Sum
     * @apiParam {String} position_id Position ID
     * @apiParam {String} public_position Public Position
     * @apiParam {String} comment Comment
     * @apiParam {String} phone_2 Phone 2
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "first_name": "string",
     *          "last_name": "string",
     *          "father_name": "string",
     *          "photo": "string",
     *          "sex": "male",
     *          "birthday": "string",
     *          "email": "string",
     *          "phone": "string",
     *          "address": "string",
     *          "card_number": 0,
     *          "card_number_optional": 0,
     *          "deposit": 0,
     *          "bonuses": 0,
     *          "invoice_sum": 0,
     *          "position_id": 0,
     *          "public_position": "string",
     *          "comment": "string",
     *          "chain_id": 0,
     *          "created_at": "2017-10-24T08:51:55.385Z",
     *          "updated_at": "2017-10-24T08:51:55.385Z",
     *          "phone_2": "string"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {delete} /{chain}/employee/{employee}?token=:token Delete employees
     * @apiName Delete employees
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "success": 1
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/employee-schedule?token=:token Create employee schedule for type shifts
     * @apiName Create employee schedule for type shifts
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Schedule
     *
     * @apiParam {String} employee_id Employee ID
     * @apiParam {String} salon_id Salon ID
     * @apiParam {Integer} type Type
     * @apiParam {String} date Date
     * @apiParam {String} working_days Working Days
     * @apiParam {String} weekends Weekends
     * @apiParam {String} periods "periods":[{"start":"18:40","end":"14:47"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *          "id": 7,
     *          "salon_id": 3,
     *          "employee_id": 2,
     *          "working_status": 1,
     *          "created_at": "2017-10-23 11:43:46",
     *          "updated_at": "2017-10-24 10:00:45",
     *          "type": "1",
     *          "working_days": 5,
     *          "weekend": 2,
     *          "num_of_day": null,
     *          "date": "2017-10-23",
     *          "periods": [
     *              {
     *                  "id": 13,
     *                  "schedule_id": 7,
     *                  "start": "18:40",
     *                  "end": "14:47",
     *                  "created_at": "2017-10-23 12:35:00",
     *                  "updated_at": "2017-10-24 10:00:45"
     *              }
     *          ]
     *     },
     *     "status": "OK"
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */


    /**
     * @api {put} /{chain}/employee-schedule?token=:token Update employee schedule for type shifts
     * @apiName Update employee schedule for type shifts
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Schedule
     *
     * @apiParam {String} id Schedule ID
     * @apiParam {String} employee_id Employee ID
     * @apiParam {String} salon_id Salon ID
     * @apiParam {Integer} type Type
     * @apiParam {String} date Date
     * @apiParam {String} working_days Working Days
     * @apiParam {String} weekends Weekends
     * @apiParam {String} periods "periods":[{"id":schedule_id,"start":"18:40","end":"14:47"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *          "id": 7,
     *          "salon_id": 3,
     *          "employee_id": 2,
     *          "working_status": 1,
     *          "created_at": "2017-10-23 11:43:46",
     *          "updated_at": "2017-10-24 10:00:45",
     *          "type": "1",
     *          "working_days": 5,
     *          "weekend": 2,
     *          "num_of_day": null,
     *          "date": "2017-10-23",
     *          "periods": [
     *              {
     *                  "id": 13,
     *                  "schedule_id": 7,
     *                  "start": "18:40",
     *                  "end": "14:47",
     *                  "created_at": "2017-10-23 12:35:00",
     *                  "updated_at": "2017-10-24 10:00:45"
     *              }
     *          ]
     *     },
     *     "status": "OK"
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/employee-schedule?token=:token Create employee schedule for type days of week
     * @apiName Create employee schedule for type days of week
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Schedule
     *
     * @apiParam {String} employee_id Employee ID
     * @apiParam {String} salon_id Salon ID
     * @apiParam {Integer} type Type
     * @apiParam {String} date Date
     * @apiParam {String} days "days" :[{"1":[{"working_status":"1","start":"14:40","end":"14:30"}]}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *          "id": 7,
     *          "salon_id": 3,
     *          "employee_id": 2,
     *          "working_status": 1,
     *          "created_at": "2017-10-23 11:43:46",
     *          "updated_at": "2017-10-24 10:00:45",
     *          "type": "1",
     *          "working_days": 5,
     *          "weekend": 2,
     *          "num_of_day": null,
     *          "date": "2017-10-23",
     *          "periods": [
     *              {
     *                  "id": 13,
     *                  "schedule_id": 7,
     *                  "start": "18:40",
     *                  "end": "14:47",
     *                  "created_at": "2017-10-23 12:35:00",
     *                  "updated_at": "2017-10-24 10:00:45"
     *              }
     *          ]
     *     },
     *     "status": "OK"
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /{chain}/employee-schedule?token=:token Update employee schedule for type days of week
     * @apiName Update employee schedule for type days of week
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Schedule
     *
     * @apiParam {String} employee_id Employee ID
     * @apiParam {String} salon_id Salon ID
     * @apiParam {Integer} type Type
     * @apiParam {String} date Date
     * @apiParam {String} days "days" :[{"1":[{"id":schedule_id,"working_status":"1","start":"14:40","end":"14:30"}]}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * {
     *      "data": {
     *          "id": 7,
     *          "salon_id": 3,
     *          "employee_id": 2,
     *          "working_status": 1,
     *          "created_at": "2017-10-23 11:43:46",
     *          "updated_at": "2017-10-24 10:00:45",
     *          "type": "1",
     *          "working_days": 5,
     *          "weekend": 2,
     *          "num_of_day": null,
     *          "date": "2017-10-23",
     *          "periods": [
     *              {
     *                  "id": 13,
     *                  "schedule_id": 7,
     *                  "start": "18:40",
     *                  "end": "14:47",
     *                  "created_at": "2017-10-23 12:35:00",
     *                  "updated_at": "2017-10-24 10:00:45"
     *              }
     *          ]
     *     },
     *     "status": "OK"
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::post('employee-schedule', 'EmployeeScheduleController@create');
    Route::put('employee-schedule', 'EmployeeScheduleController@edit');
    Route::resource('employee', 'EmployeeController');
    Route::post('employee-photo-upload', 'EmployeeController@photo');

    /**
     * @api {get} /{chain}/position?token=:token Get position
     * @apiName Get position
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Position
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     [
     *          {
     *              "id": 0,
     *              "title": "string",
     *              "description": "string",
     *              "create_at": "string",
     *              "updated_at": "string"
     *          }
     *     ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {post} /{chain}/position?token=:token Create position
     * @apiName Create position
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Position
     *
     * @apiParam {String} title Title
     * @apiParam {String} description Description
     * @apiParam {String} created_at Created At
     * @apiParam {String} updated_at Updated At
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "title": "string",
     *          "description": "string",
     *          "create_at": "string",
     *          "updated_at": "string"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /{chain}/position/{position}?token=:token Update position
     * @apiName Update position
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Position
     *
     * @apiParam {String} title Title
     * @apiParam {String} description Description
     * @apiParam {String} created_at Created At
     * @apiParam {String} updated_at Updated At
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "id": 0,
     *          "title": "string",
     *          "description": "string",
     *          "create_at": "string",
     *          "updated_at": "string"
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {delete} /{chain}/position/{position}?token=:token Delete position
     * @apiName Delete position
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Position
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
    Route::resource('position', 'PositionController')->except('index');
    Route::post('position_index', 'PositionController@index');
    Route::resource('schedule', 'ScheduleController');

    /**
     * @api {post} /{chain}/service_price?token=:token Add service price
     * @apiName Add service price
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Service price
     *
     * @apiParam {String} service_id Service ID
     * @apiParam {String} date Date
     * @apiParam {String} prices [{"price_id":"0","price_from":"0","price_to":"0"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *      "data": {
     *          "id": 1,
     *          "service_category_id": 8,
     *          "title": "dfsf",
     *          "description": "sdfsdf",
     *          "duration": 50,
     *          "created_at": "2017-10-26 06:26:17",
     *          "updated_at": "2017-10-26 04:16:31",
     *          "available_for_online_recording": 1,
     *          "only_for_online_recording": 1,
     *          "service_price": [
     *          {
     *              "id": 2,
     *              "price_level_id": 19,
     *              "service_id": 1,
     *              "price": "50.00",
     *              "max_price": 40,
     *              "inactive": 0,
     *              "from": "2017-08-20",
     *              "created_at": "2017-10-26 11:38:39",
     *              "updated_at": "2017-10-26 11:38:39",
     *              "level": {
     *                  "id": 19,
     *                  "level": "1",
     *                  "chain_id": 7,
     *                  "created_at": "2017-10-25 11:55:17",
     *                  "updated_at": "2017-10-25 11:55:17"
     *              }
     *          }
     *      "status": "OK"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */

    /**
     * @api {put} /{chain}/service_price?token=:token Edit service price
     * @apiName Edit service price
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Service price
     *
     * @apiParam {String} service_id Service ID
     * @apiParam {String} date Date
     * @apiParam {String} prices [{"id":"0","price_id":"0","price_from":"0","price_to":"0"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *      "data": {
     *          "id": 1,
     *          "service_category_id": 8,
     *          "title": "dfsf",
     *          "description": "sdfsdf",
     *          "duration": 50,
     *          "created_at": "2017-10-26 06:26:17",
     *          "updated_at": "2017-10-26 04:16:31",
     *          "available_for_online_recording": 1,
     *          "only_for_online_recording": 1,
     *          "service_price": [
     *          {
     *              "id": 2,
     *              "price_level_id": 19,
     *              "service_id": 1,
     *              "price": "50.00",
     *              "max_price": 40,
     *              "inactive": 0,
     *              "from": "2017-08-20",
     *              "created_at": "2017-10-26 11:38:39",
     *              "updated_at": "2017-10-26 11:38:39",
     *              "level": {
     *                  "id": 19,
     *                  "level": "1",
     *                  "chain_id": 7,
     *                  "created_at": "2017-10-25 11:55:17",
     *                  "updated_at": "2017-10-25 11:55:17"
     *              }
     *          }
     *      "status": "OK"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::put('service_price', 'ServicePriceController@update');
    Route::resource('service_price', 'ServicePriceController');
    /**
     * @api {post} /{chain}/employee-salon?token=:token Add employee salons each other
     * @apiName Add employee salons each other
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Salon
     *
     * @apiParam {Integer} employee_id Employee ID
     * @apiParam {String} salons [{"salon":"0"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "employee": {
     *              "id": 0,
     *              "first_name": "string",
     *              "last_name": "string",
     *              "father_name": "string",
     *              "photo": null,
     *              "viber": null,
     *              "whatsapp": null,
     *              "birthday": null,
     *              "email": "string",
     *              "phone": "string",
     *              "address": null,
     *              "comment": null,
     *              "position_id": 0,
     *              "public_position": null,
     *              "created_at": "2017-10-25 14:41:15",
     *              "updated_at": "2017-10-25 14:41:15",
     *              "employment_date": null,
     *              "dismissed": 0,
     *              "dismissed_date": null,
     *              "displayed_in_records": null,
     *              "available_for_online_recording": null,
     *              "access_profile_id": null,
     *                  "salons": [
     *                  {
     *                      "id": 0,
     *                      "salon_id": 0,
     *                      "employee_id": 4,
     *                      "created_at": "2017-10-25 15:12:09",
     *                      "updated_at": "2017-10-25 15:12:09",
     *                      "salon": [
     *                      {
     *                          "id": 3,
     *                          "title": "string",
     *                          "img": null,
     *                          "country": "string",
     *                          "city": "string",
     *                          "address": "string",
     *                          "street_number": "string",
     *                          "latitude": "string",
     *                          "longitude": "string",
     *                          "user_id": 0,
     *                          "chain_id": 0,
     *                          "current_time": "2017-10-19 10:32:40",
     *                          "created_at": "2017-10-23 07:40:25",
     *                          "updated_at": "2017-10-23 07:41:27",
     *                          "notify_about_appointment":"[]",
     *                      }
     *                      ]
     *            },
     *            "status": "OK"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::post('employee-salon', 'EmployeeSalonController@create');

    /**
     * @api {put} /{chain}/employee-salon?token=:token Edit employee salons each other
     * @apiName Edit employee salons each other
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Employee Salon
     *
     * @apiParam {Integer} employee_id Employee ID
     * @apiParam {String} salons [{"id":"employee_salon_id","salon":"0"}]
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "employee": {
     *              "id": 0,
     *              "first_name": "string",
     *              "last_name": "string",
     *              "father_name": "string",
     *              "photo": null,
     *              "viber": null,
     *              "whatsapp": null,
     *              "birthday": null,
     *              "email": "string",
     *              "phone": "string",
     *              "address": null,
     *              "comment": null,
     *              "position_id": 0,
     *              "public_position": null,
     *              "created_at": "2017-10-25 14:41:15",
     *              "updated_at": "2017-10-25 14:41:15",
     *              "employment_date": null,
     *              "dismissed": 0,
     *              "dismissed_date": null,
     *              "displayed_in_records": null,
     *              "available_for_online_recording": null,
     *              "access_profile_id": null,
     *                  "salons": [
     *                  {
     *                      "id": 0,
     *                      "salon_id": 0,
     *                      "employee_id": 4,
     *                      "created_at": "2017-10-25 15:12:09",
     *                      "updated_at": "2017-10-25 15:12:09",
     *                      "salon": [
     *                      {
     *                          "id": 3,
     *                          "title": "string",
     *                          "img": null,
     *                          "country": "string",
     *                          "city": "string",
     *                          "address": "string",
     *                          "street_number": "string",
     *                          "latitude": "string",
     *                          "longitude": "string",
     *                          "user_id": 0,
     *                          "chain_id": 0,
     *                          "current_time": "2017-10-19 10:32:40",
     *                          "created_at": "2017-10-23 07:40:25",
     *                          "updated_at": "2017-10-23 07:41:27"
     *                      }
     *                      ]
     *            },
     *            "status": "OK"
     *      }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::put('employee-salon', 'EmployeeSalonController@edit');
    Route::put('widget','WidgetController@update');
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

Route::group(['prefix' => 'widget/{chain}'], function () {
    /**
     * @api {get} /widget/{chain}/cities Get Cities
     * @apiName Get Cities
     *
     * @apiGroup Widget
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     "cities": [
     *          "Краснодар",
     *          "Москва",
     *          "Санкт-Петербург",
     *          "Сочи",
     *          "Ростов"
     *      ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::get('cities','Widget\WidgetSalonController@salonsCities');
    /**
     * @api {post} /widget/{chain}/salons_address Get Salons
     * @apiName Get Salons
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Widget
     *
     * @apiParam {String{255}} [city] The city name for filtering salons
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     "salons": [
     *          {
     *              "id": 2,
     *              "title": "string",
     *              "img": "/images/HONDB6edlaF2Ehx6.png",
     *              "country": "Россия",
     *              "city": "Москва",
     *              "address": "string",
     *              "street_number": "string",
     *              "latitude": "0.00000000",
     *              "longitude": "0.00000000"
     *          }
     *      ]
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::post('salons_address','Widget\WidgetSalonController@salons');
    /**
     * @api {post} /widget/{chain}/employees  Get Employees
     * @apiName Get Employees
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Widget
     *
     * @apiParam {String{255}} [salon_id] The Id of salon for filtering Employees data
     * @apiParam {Object} [address] The address of salons for filtering Employees data
     * @apiParam {Object} [location] The location (latitude,longitude) of salons for filtering Employees data
     *
     * @apiParamExample {json} Request-Example:
     *
     * {"salon_id":1,
     * "address": {"city": "Москва","country": "Россия","address": "string"},
     * "location": {"latitude": "0.00000000","longitude": "0.00000000"}}
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     *     {
     *          "employees": [
     *              {
     *                  "id": 2,
     *                  "first_name": "name",
     *                  "last_name": "last name",
     *                  "father_name": "father name",
     *                  "photo": null,
     *                  "sex": "male",
     *                  "birthday": "2017-10-31",
     *                  "position_id": 1,
     *                  "public_position": "Parikmaxer",
     *                  "position": {
     *                      "id": 1,
     *                      "title": "PArikmaxer",
     *                      "description": null
     *                  }
     *              }
     *          ]
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::post('employees','Widget\WidgetEmployeeController@employees');

    /**
     * @api {post} /widget/{chain}/services  Get Services
     * @apiName Get Services
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "Application/json"
     *     }
     * @apiGroup Widget
     *
     * @apiParam {String{255}} salon_id The Id of salon
     * @apiParam {Array} [employees] The array of Employees Ids
     *
     * @apiParamExample {json} Request-Example:
     *
     * {
     *  "salon_id":1,
     *  "employees":["2"]
     * }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200
     * When filtered By Salon_id and  Employees
     *     {
     *          "employees": [{
     *              "employee_id": 2,
     *              "service_groups": [{
     *                  "id": 2,
     *                  "parent_id": 1,
     *                  "title": "Strijka",
     *                  "services": [{
     *                      "price": "50.00",
     *                      "duration": 30,
     *                      "id": 2,
     *                      "service_category_id": 2,
     *                      "title": "aaaaaaaaaa",
     *                      "default_duration": 100,
     *                      "description": "aaasdasdasd",
     *                      "available_for_online_recording": 1,
     *                      "only_for_online_recording": 1
     *                  }]
     *              }]
     *          }]
     *     }
     * When filtered only By Salon_id
     * {
     *      "service_groups": [{
     *          "id": 2,
     *          "parent_id": 1,
     *          "title": "Strijka",
     *          "services": [{
     *              "id": 1,
     *              "service_category_id": 2,
     *              "title": "strijk goryachimi nojnicami",
     *              "default_duration": 25,
     *              "description": "desc",
     *              "available_for_online_recording": 1,
     *              "only_for_online_recording": 1
     *          }]
     *      }]
     * }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "Invalid input"
     *     }
     */
    Route::post('services','Widget\WidgetServiceController@services');
    Route::post('free_times','Widget\WidgetSchedulesController@freeTimes');
});
