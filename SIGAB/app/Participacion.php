<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    protected $table = 'participaciones';
    public $incrementing = false;

    public function personal()
    {
        return $this->belongsTo('App\Personal', 'persona_id');
    }
}
