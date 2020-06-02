<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Factory;
use Illuminate\Http\Request;
use App\Topic;
use App\Like;
use App\Solution;
use Auth;
use App\Category;

class TopicController extends Controller
{
    public function SaveTopic(Request $request, \Illuminate\Validation\Factory $validator)
    {

        $validation = $validator->make($request->all(), [
            "category_id" => "required",
            "title" => "required",
            "description" => "required"
        ]);

        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation)->withInput();

        } else {

            $topic = new Topic();
            $topic->title = $request->input("title");
            $topic->description = $request->input("description");
            $id = $topic->addTopic($request->input("title"), $request->input("description"), $request->input("category_id"));
            $objTopic = $topic->findTopic($id);
            
            return redirect()->route('user.add')->with('success', 'Topic created successfully.<i>'. $objTopic->title.'</i>');
        }
    }

    public function UpdateTopic(Request $request)
    {
            $objTopic =  Topic::find($request->id);
            $objTopic->title  = $request->title;
            $objTopic->description  = $request->description;
            $objTopic->save();
            return redirect('/user/edit/'.$request->id)->with('success', 'Topic updated successfully.<i>'. $objTopic->title.'</i>');
    }

    public function deleteTopic(Request $request)
    {
        $objTopic =  Topic::find($request->id);
        $objTopic->delete();
        return redirect('/')->with('success', 'Topic deleted successfully.<i>'. $objTopic->title.'</i>');
    }

    public function SaveLike($id)
    {

       if(!Auth::check()) {
            return redirect()->back();
       } 

       $user = Auth::user();
       $user->id;
       
       $objTopic = Topic::find($id);
       $like = new Like();
       $like->user_id = $user->id;
       $objTopic->likes()->save($like);
       $user->likes()->save($like);
       
        return redirect()->back();
    }

    public function AddSolution($id)
    {
        $objTopic = Topic::find($id);
        return view("solution", ["topic"=>$objTopic]);
    }

    public function SaveSolution(Request $request, \Illuminate\Validation\Factory $validator)
    {

       // Auth::user()->id;

        

        $validation = $validator->make($request->all(), [
            "id" => "required",
            "solution" => "required"
        ]);

        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation)->withInput();

        } else {

            $topic = Topic::find($request->input('id'));
            $solution = new Solution();
            $solution->solution = $request->input('solution');
            $solution->user_id = Auth::user()->id;
            $topic->solutions()->save($solution);
            
            return redirect()->back()->with('success', 'Solution added successfully for <i>'. $topic->title.'</i>');
        }

        
    }

    public function AddTopic()
    {
        $categories = Category::orderBy("name", "ASC")->get();

        return view("add", ["categories" => $categories]);
    }

    public function getDetail($id)
    {

        $topic = Topic::find($id);
        $solutions = Solution::find($id);
        return view("detail", ["topic"=> $topic, "solutions"=>$topic->solutions, "name"=>$topic->user->name]);
    }

    public function getTopics()
    {
        $topic = new Topic();
        $topics = $topic->getTopics();
        return view("mytopics", ["topics" => $topics]);
    }
}
