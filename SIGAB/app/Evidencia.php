<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{

    public function actividad()
    {
        return $this->hasOne('App\Avitividades_interna', 'actividad_id');
    }
}
