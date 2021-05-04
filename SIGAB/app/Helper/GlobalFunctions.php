<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla
use Image;

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

    public static function actualizarFotoPerfil($avatar, $persona){
        $archivo = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->crop(300, 300)->save(public_path('/img/fotos/' . $archivo));

        if ($persona->imagen_perfil != "default.jpg")
            File::delete(public_path('/img/fotos/' . $persona->imagen_perfil)); //Elimina la foto anterior

        $persona->imagen_perfil = $archivo;
        $persona->save();
    }
}