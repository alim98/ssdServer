<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedPost extends Model
{
    //
    protected $table='savedposts';

    protected $primaryKey='saved_id';
}
