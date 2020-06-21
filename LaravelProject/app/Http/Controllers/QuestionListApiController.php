<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Solution;
use DB;

class QuestionListApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $topics = DB::select("SELECT t.id, t.title, t.description, COUNT(t.id) AS TOTAL_ANS, u.id AS 'user_id', u.name AS posted_by, 
                   u.avatar, t.created_at AS question_created_date, s.solution, s.created_at AS answer_created_at 
                   FROM topics t LEFT JOIN solutions s ON s.topic_id = t.id 
                   LEFT JOIN users u ON u.id = t.user_id 
                   GROUP BY t.id 
                   ORDER BY s.created_at DESC"); 
       $arrTopics = array();
       foreach($topics as $topic) {

            $arrSolution = array();
            $solutions = DB::select("SELECT s.id, s.solution, s.created_at, u.name AS posted_by 
                                     FROM solutions s 
                                     INNER JOIN topics t ON t.id = s.topic_id 
                                     INNER JOIN users u ON u.id = s.user_id 
                                     WHERE s.topic_id = ? 
                                     ORDER BY s.created_at DESC", [$topic->id]); 
            if (count($solutions) > 0) {
                foreach($solutions as $solution) {
    
                    $arrSolution[] = array("title"=>$solution->solution,
                                           "created_at" => date("d-m-Y", strtotime($solution->created_at)),   
                                           "posted_by" => $solution->posted_by,
                                           "id" => $solution->id);
                }
            }
            
            $arrTopics[] = array("title"=>$topic->title,
                                     "created_at" => date("d-m-Y", strtotime($topic->question_created_date)),   
                                     "posted_by" => $topic->posted_by,
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
