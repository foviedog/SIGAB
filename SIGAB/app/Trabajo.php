<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model{

    public function estudiante(){
        return $this->belongsTo('App\Estudiante', 'persona_id');
    }
}
