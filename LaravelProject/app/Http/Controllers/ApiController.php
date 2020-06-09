<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Topic;


class ApiController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken("MyApp")->accessToken;
            return response()->json(["success" => $success], 200);
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
       return response()->json(["data" => Topic::all()], 200);
    }

    public function topic($id)
    {
       return response()->json(["data" => Topic::find($id)], 200);
    }
}
