<?php

use Illuminate\Support\Facades\Route;
use \App\Topic;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/about', function () {
    return view("about");
});

Route::get('/modelData', function () {

    return view('popup');
     
});

Route::get('/', "IndexController@Index");

Route::group(['prefix' => 'user'], function () {

    // Route::get('like', function () {
    //     return view("add");
    // })->name("user.add");

    Route::get('edit/{id}', function ($id) {
       $objTopic =  Topic::find($id);
       return view("edit", ["topic"=> $objTopic]);
    })->name("user.edit");

    Route::post('update', ["uses"=>"TopicController@UpdateTopic", "as"=>"user.topic.update", "middleware" => "auth"]);
    Route::post('delete', ["uses"=>"TopicController@deleteTopic", "as"=>"user.topic.delete", "middleware" => "auth"]);
    Route::post('solution',["uses"=>"TopicController@SaveSolution", "as"=>"user.solution.save", "middleware" => "auth"]);
    Route::post('save', ["uses"=>"TopicController@SaveTopic", "as"=>"user.topic.save", "middleware" => "auth"]);
    Route::get('{id}/like', ["uses"=>"TopicController@SaveLike", "as"=>"user.like", "middleware" => "auth"]);
    Route::get('{id}/unlike', ["uses"=>"TopicController@DeleteLike", "as"=>"user.unlike", "middleware" => "auth"]);


    Route::get('{id}/solution/like', ["uses"=>"TopicController@SaveSolutionLike", "as"=>"user.solution.like", "middleware" => "auth"]);
    Route::get('{id}/solution/unlike', ["uses"=>"TopicController@DeleteSolutionLike", "as"=>"user.solution.unlike", "middleware" => "auth"]);
    
    Route::get('{id}/detail', ["uses"=>"TopicController@getDetail", "as"=>"user.topic.detail"]);
    Route::get('add', ["uses"=>"TopicController@AddTopic", "as"=>"user.add", "middleware" => "auth", "middleware" => "auth"]);
    Route::get('mytopics', ["uses"=>"TopicController@getTopics", "as"=>"user.topics", "middleware" => "auth", "middleware" => "auth"]);
    Route::get('{id}/add-solution', ["uses"=>"TopicController@AddSolution", "as"=>"user.add-solution"]);

    
});

Route::group(['prefix' => 'profile'], function () {
    
    Route::get('viewprofile/{id}', ["uses"=>"ProfileController@ViewProfile", "as"=>"profile.view"]);
    Route::get('display', ["uses"=>"ProfileController@Display", "as"=>"profile.display", "middleware" => "auth"]);
    Route::post('update', ["uses"=>"ProfileController@UpdateProfile", "as"=>"profile.update", "middleware" => "auth"]);
    Route::get('mytopics', ["uses"=>"ProfileController@MyTopics", "as"=>"profile.mytopics", "middleware" => "auth"]);
    
});

Auth::routes();