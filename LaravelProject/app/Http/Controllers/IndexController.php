<?php

namespace App\Http\Controllers;

use App\Topic;
use Gate;
use Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Index()
    {
        $topic = new Topic();
        $topics = $topic->getTopics();
        $loggedInUser = Auth::user();
        foreach($topics as $t) {
            $t->isUserLiked = $this->isUserLikedTopic($t->likes);;
        }
        
        return view("index", ["topics" => $topics, "loggedInUser" => $loggedInUser]);
    }

    public function SubmitForm(Request $request)
    {
        
        var_dump($request->input("title"));
    }
}
