<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistenciaPromocion extends Model
{
    public $table = 'asistencia_promocion';
    public function actividad()
    {
        return $this->hasOne('App\ActividadesPromocion', 'actividad_id');
    }
}
