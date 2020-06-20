<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Factory;
use Illuminate\Http\Request;
use App\Topic;
use App\Like;
use App\Solution;
use Auth;
use App\Category;
use Gate;
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
        if(Gate::denies('validate-delete-topic', $objTopic->user->id) == false) {
            
            $objTopic->title  = $request->title;
            $objTopic->description  = $request->description;
            $objTopic->save();
            return redirect('/user/edit/'.$request->id)->with('success', 'Topic updated successfully.<i>'. $objTopic->title.'</i>');
        } else {
            return redirect()->back()->with('error', "You can not update other user's Topic updated.<i>");
        }

            
    }

    public function deleteTopic(Request $request)
    {
        $objTopic =  Topic::find($request->id);
        if(Gate::denies('validate-delete-topic', $objTopic->user->id) == false) {
        
            $totalSolution = count($objTopic->solutions);
             
            if ($totalSolution > 0) {
                return redirect()->back()->with('error', 'You can not delete the Topic, it has '. $totalSolution. " answers");
            } else {
                $objTopic->delete();
                return redirect()->back()->with('success', 'Topic deleted successfully.<i>'. $objTopic->title.'</i>');
            }
        } else {
            return redirect('/')->withError('You can not delete others topic');
        }
        
    }

    public function SaveLike($id)
    {

       $user = Auth::user();
       $user->id;
       
       $objTopic = Topic::find($id);
       $like = new Like();
       $like->user_id = $user->id;
       $objTopic->likes()->save($like);
       $user->likes()->save($like);
       
        return redirect()->back();
    }

    public function DeleteLike($id)
    {

       $user = Auth::user();
       $like = Like::where([
           ["topic_id", "=", $id],
           ["user_id", "=", $user->id]
           ]);
       $like->delete();
       return redirect()->back();
    }

    public function AddSolution($id)
    {
        $objTopic = Topic::find($id);
        return view("solution", ["topic"=>$objTopic]);
    }

    public function SaveSolution(Request $request, \Illuminate\Validation\Factory $validator)
    {

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
        $solutions = array();
        if (count($topic->solutions) > 0) {
            $solutions = $topic->solutions()->orderBy("created_at", "DESC")->get();

            foreach($solutions as $solution) {

                $solution->isUserLikedTopic = $this->isUserLikedTopic($solution->likes);

            }
        }

        $user_id = 0;
        $user = Auth::user();

        if ($user != null) {
            $user_id = $user->id;
        }
        
        $topic->isUserLiked = $this->isUserLikedTopic($topic->likes);;
        return view("detail", ["topic"=> $topic, "solutions"=>$solutions, "name"=>$topic->user->name, "user_id" => $user_id]);
    }

    public function getTopics()
    {
        $topic = new Topic();
        $topics = $topic->getTopics();
        return view("mytopics", ["topics" => $topics]);
    }

    public function SaveSolutionLike($id)
    {
        $user = Auth::user();
        
        $solution = Solution::find($id);

        $like = new Like();
        $like->user_id = $user->id;
        $solution->likes()->save($like);
        $user->likes()->save($like);

        return redirect()->back();
    }

    public function DeleteSolutionLike($id)
    {
        $user = Auth::user();
        $like = Like::where([
            ["solution_id", "=", $id],
            ["user_id", "=", $user->id]
            ]);
        $like->delete();
        return redirect()->back();
    }
}
