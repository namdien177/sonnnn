<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    public function matchteam(){
        return $this->hasMany('App\MatchTeam','id','idTeam');
    }
}
