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

    // Route::get('add', function () {
    //     return view("add");
    // })->name("user.add");

    Route::get('like', function () {
        return view("add");
    })->name("user.add");

    Route::get('edit/{id}', function ($id) {
       $objTopic =  Topic::find($id);
       return view("edit", ["topic"=> $objTopic]);
    })->name("user.edit");

    Route::post('update', "TopicController@UpdateTopic");
    Route::post('delete', "TopicController@deleteTopic");
    Route::post('solution', "TopicController@SaveSolution");
    Route::post('save',"TopicController@SaveTopic");
    Route::get('{id}/like', ["uses"=>"TopicController@SaveLike", "as"=>"user.like"]);
    Route::get('{id}/detail', ["uses"=>"TopicController@getDetail", "as"=>"user.topic.detail"]);
    Route::get('add', ["uses"=>"TopicController@AddTopic", "as"=>"user.add"]);
    Route::get('mytopics', ["uses"=>"TopicController@getTopics", "as"=>"user.topics"]);
    Route::get('{id}/add-solution', ["uses"=>"TopicController@AddSolution", "as"=>"user.add-solution"]);

    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
