<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    protected $table = 'actividades';

    public function personal(){
        return $this->hasOne('App\Personal', 'persona_id'); /* Revisar */
    }

    public function actividadInterna(){
        return $this->hasOne('App\Actividades_interna', 'actividad_id'); /* Revisar */
    }
}
