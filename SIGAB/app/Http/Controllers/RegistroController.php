<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Persona;
use App\User;

/*  Esta clase se creó con el fin de registrar nuevos usuarios
    desde una interfaz interna en el sistema sin la necesidad
    de usar tinker. Se recomienda no modificar este archivo
    a menos que sea totalmente necesario.
    Se pretende que esta interfaz sólo pueda ser accedida por
    los usuarios con los permisos correspondientes. */

class RegistroController extends Controller
{

    /* Método que devuelve la página con la información
       de todas las personas ingresadas en el sistema */
    public function index(){
        try{
        $personas = Persona::all();
        return view('auth.register', [
            'personas' => $personas,
        ]);
    }   
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    /* Método que devuelve la persona que se desea
       registrar como usuario/a del sistema */
    public function show(Request $request){
try{
        /*  Extrae el id del request (recordar que se
            está recuperando de un value que tiene el
            siguiente formato: 'XXX - YYYY YYYY', donde X representa
            la cédula y Y representa el nombre completo de la persona).
            Es necesario sólo extraer la cédula, por lo tanto
            se utiliza un método de php que separa un string al
            encontrar un espacio y los devuelve en un array. Por eso
            se extrae la posición 0 del mismo, ya que este representa
            la cédula del usuario. */
        $persona_id = explode(' ', $request->persona)[0];

        /*  Verifica si ya existe un usuario registro en el sistema
            con esa misma cédula.
            Un count mayor a 0 represanta una persona con un usuario
            previamente registrado. */
        $persona_existe = User::where('persona_id', $persona_id)->count();

        /*  Se pregunta si la persona existe. En el caso de que 'persona_existe' sea
            un número mayor a 0, significa que sí existe. */
        if($persona_existe == 0){

            //Si no existe el usuario, se recupera la persona
            //con la cédula correspondiente.
            $persona = Persona::find($persona_id);

            //Descomentar la siguiente línea si se desea revisar los datos de la persona
            //dd($persona);

            //Se regresa la página pero con la persona que se desea agregar
            //como una variable a la vista
            return Redirect::back()
                ->with('persona', $persona);

        } else {

            //Si la persona ya tiene un usuario, se devuelve la página
            //con un mensaje de error
            return Redirect::back()
                ->with('error', 'La persona ya está registrada en el sistema.');
        }
    }   
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    /* Método que registra un nuevo usuario */
    public function register(Request $request){
try{
        /* Verifica que la contraseña contenga los requisitos mínimos de seguridad */
        if($this->verificarContrasenna($request->password)){

            /* Si la contraseña cumple con los estándares, se procede a registrar
               el usuario en la base de datos con la contraseña encriptada.  */
            DB::table('users')
                ->insert(['persona_id'=>$request->persona_id,
                            'rol'=> $request->rol,
                                'password'=>Hash::make($request->password)]);

            /* Devuelve la página con un mensaje de éxito. */
            return Redirect::back()
                    ->with('exito', 'Se registró exitosamente al usuario.');

        } else {

            /* Si la contraseña no cumple con los estándares acordados, se reedirige
               con un mensaje de error. */
            return Redirect::back()
                    ->with('error', 'La contraseña no cumple con los estándares mínimos de seguridad.');
        }
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    /* Método que verifica si la contraseña cumple con los estándares */
    private function verificarContrasenna($password) {

        /* La contraseña debe ser mayor a 6 carácteres */
        /*if ( strlen($password) < 6 ) {
            return false;
        }*/

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

}
