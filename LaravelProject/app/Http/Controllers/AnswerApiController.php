<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Solution;
class AnswerApiController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solution = Solution::find($id);

        if ($solution != null) {
            if (Auth::id() == $solution->user->id) {
                $solution->likes()->delete();
                $solution->delete();
                return response()->json(["msg" => "Answer deleted successfully"], 200);
            } else {
                return response()->json(["error" => "You can not Delete other user answer"], 400);
            }
        } else {
            return response()->json(["msg" => "Answer does not exists"], 400);
        }
    }
}
