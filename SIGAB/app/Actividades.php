<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Actividades_interna;
use App\Personal;


class Actividades extends Model
{

    protected $table = 'actividades';

    public function responsableCoordinar()
    {
        return $this->belongsTo('App\Personal', 'responsable_coordinar'); /* Revisar */
    }

    public function actividadInterna()
    {
        return $this->hasOne('App\Actividades_interna', 'actividad_id');
    }
}
