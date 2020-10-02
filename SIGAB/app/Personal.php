<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'persona_id';
    public $incrementing = false;

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function participacion()
    {
        return $this->hasOne('App\Participacion', 'persona_id');
    }

    public function idiomas()
    {
        return $this->hasOne('App\Idioma', 'persona_id');
    }

    public function actividad()
    {
        return $this->belongsTo('App\Actividad', 'id'); /* Revisar */
    }

}
