<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Actividades;

class ActividadesPromocion extends Model
{
    protected $primaryKey = 'actividad_id';
    public $table = 'actividades_promocion';
    public function actividades()
    {
        return $this->belongsTo('App\Actividades', 'id');
    }
}
