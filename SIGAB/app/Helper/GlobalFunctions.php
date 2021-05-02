<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;

class GlobalFunctions
{
    public static function verificarAcceso($tareaConsulta){
        $tareas = Session::get('accesos_usuario');
        foreach ($tareas as $tarea){
            if($tarea->tarea_id == $tareaConsulta)
                return true;
        }
        return false;
    }
}