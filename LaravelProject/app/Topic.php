<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Category;

class Topic extends Model {

    protected $fillable = ['title', 'description', "category_id"];
    public $isUserLiked = false;
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function solutions()
    {
        return $this->hasMany('App\Solution');
    }

    public function getTopics()
    {
        return Topic::paginate(5);
    }

    public function addTopic($title, $desc, $category_id)
    {
        $category = Category::find($category_id);
        $this->title = $title;
        $this->description = $desc;
        $this->category_id = $category_id;
        $user = Auth::user();
        $user->topics()->save($this);
        // $this->save();
        return $this->id;
    }

    public function findTopic($id)
    {
        return Topic::find($id);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}


?>