<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model{

    protected $primaryKey = 'persona_id';

    public function persona(){
        return $this->belongsTo('App\Persona', 'persona_id');
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
