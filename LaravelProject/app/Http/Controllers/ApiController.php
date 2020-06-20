<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Topic;
use App\Solution;
use App\Like;
class ApiController extends Controller
{

    function __construct() {
        //$this->middleware("auth");
        // $this->middleware('log', [
        //     'only', ['createTopic1']
        // ]);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success["name"] = $user->name;
            $success['token'] = $user->createToken("MyApp")->accessToken;
            return response()->json($success, 200);
        } else {
            return response()->json(["error" => "Unauthorize"], 400);
        }
    }

    public function register(Request $request)
    {

        $validation = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "confirm_password" => "required|same:password"
        ]); 

        if ($validation->fails()) {
            return response()->json(["error" => $validation->errors()], 400);
        } else {

            $input_fields = $request->all();
            $input_fields["password"] = bcrypt($input_fields["password"]);
            $user = User::create($input_fields);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $input_fields['name'];
            return response()->json(["success" => $success], 200);
        }
    }

    public function topics()
    {

       $topics =  Topic::all();
       $arrTopics = array();
       foreach($topics as $topic) {

            $arrTopics[] = array("name"=>$topic->title,
                             "created_at" => date("d-m-Y", strtotime($topic->created_at)),   
                             "posted_by" => $topic->user->name,
                            "id" => $topic->id,
                            "likes" => count($topic->likes),
                            "avatar" => asset('/images/'.$topic->user->avatar));
       }
       return response()->json($arrTopics, 200);
    }

    public function topic($id)
    {
        die("------".Auth::id());
        $topic = Topic::find($id);
        $arrSolution = array();
        
        if (count($topic->solutions) > 0) {
            $solutions = $topic->solutions()->orderBy("created_at", "DESC")->get();

            foreach($solutions as $solution) {

                $arrSolution[] = array("name"=>$solution->solution,
                                        "created_at" => date("d-m-Y", strtotime($solution->created_at)),   
                                        "posted_by" => $solution->user->name,
                                        "id" => $solution->id,
                                        "likes" => count($solution->likes),
                                        "isUserLiked" => true,
                                        "avatar" => asset('/images/'.$solution->user->avatar));
            }
        }

        $topic = array("name"=>$topic->title,
                             "created_at" => date("d-m-Y", strtotime($topic->created_at)),   
                             "posted_by" => $topic->user->name,
                            "id" => $topic->id,
                            "likes" => count($topic->likes),
                            "isUserLiked" => $this->isUserLikedTopic($topic->likes),
                            "avatar" => asset('/images/'.$topic->user->avatar),
                        "desc" => $topic->description);

        return response()->json(["topic"=> $topic, "solutions"=>$arrSolution], 200);                    
    }

    public function createTopic(Request $request)
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
            
            return response()->json(["Question added successfully".$topic->id],200);
        }
        
    }

    public function UpdateQuestion(Request $request)
    {
        $objTopic =  Topic::find($request->id);
        if($objTopic->user->id != Auth::id()) {
            return response()->json(["error" => "You can not update other user's Topic updated.<i>"],200);
        } else {
            $objTopic->title  = $request->title;
            $objTopic->description  = $request->description;
            $objTopic->save();
            return redirect('/user/edit/'.$request->id)->with('success', 'Topic updated successfully.<i>'. $objTopic->title.'</i>');
            
        }

            
    }

    public function SaveSolution(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "topic_id" => "required",
            "solution" => "required"
            ]);

        if ($validation->fails()) {

            return response()->json(["error" => $validation->errors()], 400);

        } else {

            $topic = Topic::find($request->input('topic_id'));
            $solution = new Solution();
            $solution->solution = $request->input('solution');
            $solution->user_id = Auth::id();
            $topic->solutions()->save($solution);
            
            return response()->json(["msg" => "Your solution has been addedd successfully"], 200);
        }
    }

    public function deleteTopic($id)
    {
        $objTopic =  Topic::find($id);
        $user_id = Auth::id();
        if($objTopic->user->id != $user_id) {
            return response()->json(["error" => "You can not delete other user question"], 400);
        } else if(count($objTopic->solutions) > 0) {
            return response()->json(["error" => "You can not delete this question because it has some answers"], 400);
        } else {
            $objTopic->delete();
            return response()->json(["msg" => "Topic deleted successfully"], 200);
        }
    }

    public function SaveTopicLike($id)
    {

       $user = Auth::user();
       $user->id;
       
       $objTopic = Topic::find($id);
       $like = new Like();
       $like->user_id = $user->id;
       $objTopic->likes()->save($like);
       $user->likes()->save($like);
       
       return response()->json(["msg" => "You liked the topic successfully"], 200);
    }

    public function DeleteTopicLike($id)
    {

       $user = Auth::user();
       $like = Like::where([
           ["topic_id", "=", $id],
           ["user_id", "=", $user->id]
           ]);
       $like->delete();
       return response()->json(["msg" => "You DisLiked the topic successfully"], 200);
    }

    public function SaveSolutionLike($id)
    {
        $user = Auth::user();
        
        $solution = Solution::find($id);

        $like = new Like();
        $like->user_id = $user->id;
        $solution->likes()->save($like);
        $user->likes()->save($like);

        return response()->json(["msg" => "You liked the solution successfully"], 200);
    }

    public function DeleteSolutionLike($id)
    {
        $user = Auth::user();
        $like = Like::where([
            ["solution_id", "=", $id],
            ["user_id", "=", $user->id]
            ]);
        $like->delete();
        return response()->json(["msg" => "You DisLiked the solution successfully"], 200);
    }


    public function MyGetMethod()
    {
        die("This is user id::::".Auth::id());
    }

    protected function isUserLiked($likes)
    {

        $isUserLiked = false;
        $loggedInUser = $this->auth->user();
        

        if ($loggedInUser == null) {

            return $isUserLiked;
        }

        foreach($likes as $like) {

            if ($like->user->id == $loggedInUser->id) {
                $isUserLiked = true;
                break;
            }
        }
        return $isUserLiked;
    }
}
