<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $table = 'maps';

    public function mapsBombsite(){
        return $this->hasMany('App/mapsBombsite','idMap','id');
    }

    public function mapsSpawn(){
        return $this->hasMany('App/mapsSpawn','idMap','id');
    }
}
