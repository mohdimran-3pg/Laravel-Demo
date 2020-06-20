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

/*
Route::middleware('auth:api', function () {
     
});*/

Route::middleware('auth:api')->post('createTopic', "ApiController@createTopic");
Route::middleware('auth:api')->post('SaveSolution', "ApiController@SaveSolution");
Route::middleware('auth:api')->get('deleteTopic/{id}', "ApiController@deleteTopic");

Route::middleware('auth:api')->get('SaveLike/{id}', "ApiController@SaveLike");
Route::middleware('auth:api')->get('DeleteLike/{id}', "ApiController@DeleteLike");

Route::middleware('auth:api')->get('SaveSolutionLike/{id}', "ApiController@SaveSolutionLike");
Route::middleware('auth:api')->get('DeleteSolutionLike/{id}', "ApiController@DeleteSolutionLike");

Route::post('login',  "ApiController@login");
Route::post('register',  "ApiController@register");
Route::get('topic/{id}', "ApiController@topic");
Route::get('topics', "ApiController@topics");


Route::post('user/forgot_password', 'UserApiController@forgot_password');
Route::post('user/login', 'UserApiController@login');
Route::resource('user', 'UserApiController');

Route::group(['middleware' => 'auth:api'], function() {

    Route::resource('question', 'QuestionApiController', ['except' => ['index', 'show']])->middleware('auth:api');
    Route::resource('answer', 'AnswerApiController', ['only' => ['destroy']])->middleware('auth:api');

});

Route::resource('questionlist', 'QuestionListApiController', ['only' => ['index', 'show']]);
                