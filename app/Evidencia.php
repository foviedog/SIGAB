<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{

    public function actividad()
    {
        return $this->hasOne('App\Avitividades_interna', 'actividad_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y (H:i:s)', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y (H:i:s)', strtotime($value));
    }
}
