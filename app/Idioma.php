<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    public function personal()
    {
        return $this->belongsTo('App\Personal', 'persona_id');
    }
}
