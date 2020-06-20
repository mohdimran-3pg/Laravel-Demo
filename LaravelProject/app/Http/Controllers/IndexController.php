<?php

namespace App\Http\Controllers;

use App\Topic;
use Gate;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
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
        

         /*
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://127.0.0.1:8001/api/topics');
        $response = $request->getBody();

        print_r($response);*/

        return view("index", ["topics" => $topics, "loggedInUser" => $loggedInUser]);
    }

    public function SubmitForm(Request $request)
    {
        
        var_dump($request->input("title"));
    }
}
