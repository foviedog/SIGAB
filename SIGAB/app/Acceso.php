<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    public function tareas()
    {
        return $this->hasMany("App/Tareas");
    }
    public function roles()
    {
        return $this->hasMany("App/Tareas");
    }
}
