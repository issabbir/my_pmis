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

//Route::get('emp-photo-link/{id}', 'Api\AuthController@emp_photo_link')->name('emp-photo-link');
//Route::post('recover', 'Api\V1\AuthController@recover');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::get('/greeting', function () {
    return 'Hello World';
});*/
