<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;

class GlobalFunctions
{
    public static function verificarAcceso($tarea){
        return in_array($tarea, array_column(Session::get('accesos_usuario')->toArray(), 'tarea_id'));
    }
}