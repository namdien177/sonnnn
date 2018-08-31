<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mapsBombsite extends Model
{
    protected $table = 'maps_bombsites';

    public function Map(){
        return $this->belongsTo('App\Map','idMap','id');
    }
}
