<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public $incrementing=false;//todo after make id auto-increment delete this line

    protected $table='post';

    public function get_likes(){
        return $this->hasMany("App\Like");
    }
    public function comments(){
        return $this->hasMany('App\Comment','post_id', 'id');
    }
}
