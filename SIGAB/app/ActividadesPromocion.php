<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadesPromocion extends Model
{
    public function actividades()
    {
        return $this->belongsTo('App\Actividades', 'id');
    }
}
