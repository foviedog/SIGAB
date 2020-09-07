<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{

    public function persona(){
        return $this->hasOne('App\Persona');
    }

    public function guias_academicas(){
        return $this->hasMany('App\Guias_academica');
    }

    public function trabajo(){
        return $this->hasMany('App\Trabajo');
    }

    public function graduado(){
        return $this->hasMany('App\Graduado'); /* Revisar relacion */
    }

}
