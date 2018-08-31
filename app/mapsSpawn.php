<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mapsSpawn extends Model
{

    protected $table = 'map_spawns';

    public function Map(){
        return $this->belongsTo('App/Map','idMap','id');
    }
}
