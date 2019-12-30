<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    public $incrementing=false;
    protected $table='tags';
    protected $primaryKey='tag_id';
    public $timestamps=false;
}
