<?php

namespace App;

use App\Feeds;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    public function post(){
        return $this->belongsTo(Feeds::class);
    }
}
