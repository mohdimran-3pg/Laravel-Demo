<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Solution;

class QuestionListApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $topics = Topic::orderBy('created_at', 'DESC')->get();
       $arrTopics = array();
       foreach($topics as $topic) {

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
            
            $arrTopics[] = array("title"=>$topic->title,
                                     "created_at" => date("d-m-Y", strtotime($topic->created_at)),   
                                     "posted_by" => $topic->user->name,
                                     "id" => $topic->id,
                                     "answers" => $arrSolution);
       }
       return response()->json($arrTopics, 200);
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
            return response()->json(array("msg"=>"Question not found"), 400); 
       }
    }     
}
