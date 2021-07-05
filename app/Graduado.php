<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graduado extends Model
{
    public function estudiante()
    {
        return $this->belongsTo('App\Estudiante');
    }
}
