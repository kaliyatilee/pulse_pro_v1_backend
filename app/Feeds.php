<?php

namespace App;

//use App\Comment;
//use App\User;
use App\Like;

use Illuminate\Database\Eloquent\Model;

class Feeds extends Model
{

    protected $table = 'newsfeeds';
    public function user(){
        return $this->belongsTo(User::class);
    }
//
//    public function comments(){
//        return $this->hasMany(Comment::class);
//    }

    public function likes(){
        return $this->hasMany(Like::class);
    }
}
