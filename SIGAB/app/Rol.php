<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $table = 'roles';

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    public function accesos()
    {
        return $this->belongsTo('App\Acceso');
    }
}
