<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsContent extends Model
{
    protected $table = 'news_contents';

    public function news(){
        return $this->belongsTo('App\News','idNews','id');
    }
}
