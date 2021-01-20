<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Actividades;

class Actividades_interna extends Model
{
    protected $primaryKey = 'actividad_id';
    public $incrementing = false;

    public function actividades()
    {
        return $this->belongsTo('App\Actividades', 'id'); /* Revisar */
    }
}
