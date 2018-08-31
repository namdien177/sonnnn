<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    public function user(){
        return $this->belongsTo('App\User','idUser', 'id');
    }

    public function NewsContent(){
        return $this->hasMany('App\NewsContent','idNews','id');
    }

    public function comment(){
        return $this->hasMany('App/comments','idNews','id');
    }
}
