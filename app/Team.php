<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    public function player(){
        return $this->hasMany('App\Player','idTeam','id');
    }

    public function MatchTeam(){
        return $this->hasMany('App\MatchTeam','idTeam','id');
    }
}
