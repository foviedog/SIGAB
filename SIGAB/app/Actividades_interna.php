<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividades_interna extends Model
{
    protected $primaryKey = 'actividad_id';
    public $incrementing = false;

    public function actividad(){
        return $this->belongsTo('App\Actividad', 'id'); /* Revisar */
    }

}
