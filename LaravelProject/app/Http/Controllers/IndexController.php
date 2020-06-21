<?php

namespace App\Http\Controllers;

use App\Topic;
use Gate;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use DB;

class IndexController extends Controller
{
    public function Index()
    {
        $rows = DB::select("SELECT t.created_at AS topic_date, u.avatar, u.id AS 'user_id', t.id, t.description, t.title, t.id, u.name, 
        COUNT(t.id) AS TOTAL_ANS, s.solution, s.created_at, 
        (SELECT COUNT(id) FROM likes WHERE topic_id = t.id AND solution_id is NULL AND user_id = "."'".Auth::id()."'".") AS isUserLiked,
        (SELECT COUNT(id) FROM likes WHERE topic_id = t.id AND solution_id is NULL) AS TOTAL_LIKE
        FROM topics t 
        LEFT JOIN solutions s ON s.topic_id = t.id 
        LEFT JOIN users u ON u.id = t.user_id
        GROUP BY t.id 
        ORDER BY s.created_at DESC");
        
        $arrTopics = [];
        foreach($rows as $row) {
            $arrTopics[] = get_object_vars($row);
        }

        $loggedInUser = Auth::user();
        return view("index", ["topics" => $arrTopics, "loggedInUser" => $loggedInUser]);
    }

    public function SubmitForm(Request $request)
    {
        
        var_dump($request->input("title"));
    }
}
