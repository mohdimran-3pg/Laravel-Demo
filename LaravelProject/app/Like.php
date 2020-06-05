<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function topic()
    {
        return $this->belongsTo('App\Topic', 'topic_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function solution()
    {
        return $this->belongsTo('App\Solution');
    }
}
