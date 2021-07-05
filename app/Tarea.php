<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    public function accesos()
    {
        return $this->belongsToMany("App/Acceso");
    }
}
