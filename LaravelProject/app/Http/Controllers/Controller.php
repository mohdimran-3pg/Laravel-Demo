<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Auth;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isUserLikedTopic($likes)
    {

        $isUserLiked = false;
        $loggedInUser = Auth::user();
        

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
