<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $table = 'comments';

    public function News(){
        return $this->belongsTo('App\News','idNews','id');
    }
}
