<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
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

    /* Método que verifica si la contraseña cumple con los estándares */
    public static function verificarContrasenna($password) {

        /* La contraseña debe ser mayor a 6 carácteres */
        if ( strlen($password) < 6 ) {
            return false;
        }

        /* La contraseña debe tener algún número */
        if ( !preg_match("#[0-9]+#", $password) ) {
            return false;
        }

        /* La contraseña debe tener alguna minúscula */
        if ( !preg_match("#[a-z]+#", $password) ) {
            return false;
        }

        /* La contraseña debe tener alguna mayúscula */
        if ( !preg_match("#[A-Z]+#", $password) ) {
            return false;
        }

        /* La contraseña debe tener algún carácter especial */
        if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
            return false;
        }

        return true;
    }

    public static function hashPassword($password){
        return Hash::make($password);
    }

    public static function verificarContrasennaVieja($new_password, $old_passoword){
        return Hash::check($new_password, $old_passoword);
    }
}