<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public $isUserLiked;
    public $posted_by;

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
