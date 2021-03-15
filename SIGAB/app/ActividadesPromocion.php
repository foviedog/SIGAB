<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadesPromocion extends Model
{
    public $table = 'actividades_promocion';
    public function actividades()
    {
        return $this->belongsTo('App\Actividades', 'id');
    }
}
