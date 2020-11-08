<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    protected $table = 'participaciones';
    protected $primaryKey = 'persona_id';
    public $incrementing = false;

    public function personal()
    {
        return $this->belongsTo('App\Personal', 'persona_id');
    }
}
