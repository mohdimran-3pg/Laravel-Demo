<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Topic;
use App\Solution;
use App\Like;

class QuestionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "category_id" => "required",
            "title" => "required",
            "description" => "required"
        ]);
        
        if ($validation->fails()) {

            return response()->json(["error" => $validation->errors()], 400);

        } else {
            $userId = Auth::id();
            $topic = new Topic();
            
            $topic->title = $request->input("title");
            $topic->description = $request->input("description");
            $topic->category_id = $request->input("category_id");
            $user = User::find($userId);
            $user->topics()->save($topic);
            
            return response()->json(["Question added successfully"],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $topic =  Topic::find($id);
       if ($topic != null) {
            $topicObj = array();
            $arrSolution = array();
            if (count($topic->solutions) > 0) {
                $solutions = $topic->solutions()->orderBy("created_at", "DESC")->get();
                foreach($solutions as $solution) {
    
                    $arrSolution[] = array("title"=>$solution->solution,
                                            "created_at" => date("d-m-Y", strtotime($solution->created_at)),   
                                            "posted_by" => $solution->user->name,
                                            "id" => $solution->id);
                }
            }
            $topicObj = array("title"=>$topic->title,
                                        "created_at" => date("d-m-Y", strtotime($topic->created_at)),   
                                        "posted_by" => $topic->user->name,
                                        "id" => $topic->id,
                                        "answers" => $arrSolution);                
            
            return response()->json($topicObj, 200); 
       } else {
            return response()->json(array("msg"=>"Topic not found"), 400); 
       }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic =  Topic::find($id);
        if ($topic != null) {
            if (Auth::id() == $topic->user->id){
                $topicObj = array();
                 
                $topicObj = array("title"=>$topic->title,
                                            "created_at" => date("d-m-Y", strtotime($topic->created_at)),   
                                            "posted_by" => $topic->user->name,
                                            "id" => $topic->id);                
                
                return response()->json($topicObj, 200);
            } else {
                return response()->json(["msg" => "You can not edit other user's topic"], 200);
            }

             
       } else {
            return response()->json(array("msg"=>"Topic not found"), 400); 
       } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $objTopic =  Topic::find($id);
        if($objTopic != null) {
            $validation = Validator::make($request->all(), [
                "category_id" => "required",
                "title" => "required",
                "description" => "required"
            ]);
            
            if ($validation->fails()) {
    
                return response()->json(["error" => $validation->errors()], 400);
    
            } else {
    
                if($objTopic->user->id != Auth::id()) {
                    return response()->json(["error" => "You can not Edit other user question"], 400);
                } else {
                    $objTopic->category_id = $request->input('category_id');
                    $objTopic->title = $request->input('title');
                    $objTopic->description = $request->input('description');
                    $objTopic->save();
                    return response()->json(["msg" => "Question edited successfully"], 200);
                }
            }
        } else {
            return response()->json(["msg" => "Question does not exists"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objTopic =  Topic::find($id);
        if ($objTopic != null) {
            $user_id = Auth::id();
            if($objTopic->user->id != $user_id) {
                return response()->json(["error" => "You can not delete other user question"], 400);
            } else if(count($objTopic->solutions) > 0) {
                return response()->json(["error" => "You can not delete this question because it has some answers"], 400);
            } else {
                $objTopic->delete();
                return response()->json(["msg" => "Question deleted successfully"], 200);
            }
        } else {
            return response()->json(["msg" => "Question does not exists"], 400);
        }
        
    }
}
