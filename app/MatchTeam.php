<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where()
 */
class MatchTeam extends Model
{
    protected $table ='match_teams';

    public function team(){
        return $this->belongsTo('App\Team','idTeam','id');
    }

    public function match(){
        return $this->belongsTo('App\Match','idMatch','id');
    }
}
