<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guias_academica extends Model{

    public function estudiante(){
        return $this->belongsTo('App\Estudiante');
    }

}
