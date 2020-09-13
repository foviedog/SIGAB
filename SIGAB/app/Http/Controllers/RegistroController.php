<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Persona;
use App\User;

class RegistroController extends Controller
{

    public function index(){
        $personas = Persona::all();
        return view('auth.register', [
            'personas' => $personas,
        ]);
    }

    public function show(Request $request){

        $persona_id = explode(' ', $request->persona)[0];

        $persona_existe = User::where('persona_id', $persona_id)->count();

        if($persona_existe == 0){
            $persona = Persona::find($persona_id);
            //dd($persona);
            return Redirect::back()
                ->with('persona', $persona);
        } else {
            return Redirect::back()
                ->with('error', 'La persona ya está registrada en el sistema.');
        }

    }

    public function register(Request $request){

        if($this->verificarContrasenna($request->password)){

            DB::table('users')
                ->insert(['persona_id'=>$request->persona_id,
                            'rol'=> $request->rol,
                                'password'=>Hash::make($request->password)]);

            return Redirect::back()
                    ->with('exito', 'Se registró exitosamente al usuario.');

        } else {
            return Redirect::back()
                    ->with('error', 'La contraseña no cumple con los estándares mínimos de seguridad.');
        }

    }

    private function verificarContrasenna($password) {
        if ( strlen($password) < 6 ) {
            return false;
        } if ( !preg_match("#[0-9]+#", $password) ) {
            return false;
        } if ( !preg_match("#[a-z]+#", $password) ) {
            return false;
        } if ( !preg_match("#[A-Z]+#", $password) ) {
            return false;
        } if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
            return false;
        }
        return true;
    }

}
