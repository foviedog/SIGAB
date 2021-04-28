<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;

class GlobalFunctions
{
    public static function verificarAcceso($tarea){
        return isset(Session::get('accesos_usuario')[$tarea]);
    }
}