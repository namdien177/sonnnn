<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mapsSpawn extends Model
{

    protected $table = 'maps_spawns';

    public function Map(){
        return $this->belongsTo('App\Map','idMap','id');
    }
}
