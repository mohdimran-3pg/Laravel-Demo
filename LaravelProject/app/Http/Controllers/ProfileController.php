<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User; 

class ProfileController extends Controller
{
    public function UpdateProfile(Request $request)
    {

        $validation = array();
        if ($request->file('avatar') != null) {
            
            $validation = Validator::make(
                $request->all(),
                [
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'name' => 'required',
                ]
            );
             
        } else {
            $validation = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );
             
        }

        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation)->withInput();;
        }
    
        $user = Auth::user();  
        $user->name = $request->input('name');
        if ($request->file('avatar') != null) {
            $image = $request->file('avatar');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imagename']);
            
            $user->avatar = $input['imagename'];
        }
        $user->save();
        
        return back()->with('success','Profile updated successful');
    }

    public function Display()
    {
        $user = Auth::user();

        return view('profile', ["name" => $user->name, "image" => $user->avatar]);
    }

    public function ViewProfile($id)
    {
        $user = User::find($id);
        return view('profiledetail', ["user" => $user]);
    }
}
