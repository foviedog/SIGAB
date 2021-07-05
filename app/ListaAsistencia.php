<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaAsistencia extends Model
{
    public function personas()
    {
        return $this->hasMany('App\Persona', 'persona_id');
    }
    public function actividad()
    {
        return $this->hasOne('App\Avitividades_interna', 'actividad_id');
    }
}
