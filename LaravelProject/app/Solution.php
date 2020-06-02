<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
