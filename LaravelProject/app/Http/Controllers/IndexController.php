<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Index()
    {
        $topic = new Topic();
        $topics = $topic->getTopics();
        return view("index", ["topics" => $topics]);
    }

    public function SubmitForm(Request $request)
    {
        
        var_dump($request->input("title"));
    }
}
