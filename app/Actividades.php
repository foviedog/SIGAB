<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Actividades_interna;
use App\Personal;
use App\ActividadesPromocion;


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
    public function actividadPromocion()
    {
        return $this->hasOne('App\ActividadesPromocion', 'actividad_id');
    }
}
