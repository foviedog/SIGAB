<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalFunctions;
use App\Helper\GlobalArrays;
use App\Exceptions\ControllerFailedException;
use App\Persona;
use App\Actividades_interna;
use App\ActividadesPromocion;

class PersonaController extends Controller
{
    // Método que muestra una guía específica de un estudiante.
    public function show()
    {
        try{
        
            $persona_id = auth()->user()->persona_id;
            
            if ($persona_id != session('persona')->persona_id) {
                return  abort(404);
            }
            // Se realiza una búsqueda en la BD respecto a la persona específica.
            $persona = Persona::findOrFail($persona_id);
            // dd($persona->personal);
            return view('control_perfil.detalle', [
                'persona' => $persona,
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // Método que muestra una guía específica de un estudiante.
    public function update($persona_id, Request $request)
    {
        try{

            // Se accesede al objeto persona almacenado en la sesión.
            $persona = session('persona');;

            // Datos asociados a la persona (no incluye la cédula ya que no debería ser posible editarla)
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->fecha_nacimiento = $request->fecha_nacimiento;
            $persona->telefono_fijo = $request->telefono_fijo;
            $persona->telefono_celular = $request->telefono_celular;
            $persona->correo_personal = $request->correo_personal;
            $persona->correo_institucional = $request->correo_institucional;
            $persona->estado_civil = $request->estado_civil;
            $persona->direccion_residencia = $request->direccion_residencia;
            $persona->genero = $request->genero;

            //Se guardan los datos de la persona
            $persona->save();

            //Llamado al método que actualiza la foto de perfil
            $this->update_avatar($request, $persona);

            //Se retorna el detalle del estudiante ya modificado
            return redirect("/perfil");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    private function update_avatar($request, $persona)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            GlobalFunctions::actualizarFotoPerfil($avatar, $persona);
        }

        return \Redirect::back();
    }

    //Metodo que reedireciona a la vista de notificaciones
    public function notifications()
    {
        $notificacionesNoLeidas = auth()->user()->unreadNotifications()->paginate(2);
        $notificacionesLeidas = auth()->user()->readNotifications;
        dd($notificacionesNoLeidas);
        return view('control_perfil.notificaciones', [
            'notificacionesNoLeidas'=> $notificacionesNoLeidas,
            'notificacionesLeidas'=> $notificacionesLeidas
        ]);
    }

    public function obtenerNotificaciones(){
        $notificaciones = auth()->user()->unreadNotifications()->limit(5)->get();
        $cantidad = auth()->user()->unreadNotifications()->groupBy('notifiable_type')->count();
        $resultado = new \stdClass();
        $resultado->notificaciones = $notificaciones;
        $resultado->cantidad = $cantidad;
        return response()->json($resultado);
    }

    public function misActividades(){
        $actividadesInternas =  Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
        ->where('actividades.creada_por', '=', auth()->user()->persona_id)->get();
        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
        ->where('actividades.creada_por', '=', auth()->user()->persona_id)->get();
        
        return view('control_perfil.actividades', [
            'actividadesInternas' => $actividadesInternas,
            'actividadesPromocion' => $actividadesPromocion
        ]);
    }

    public function cambiarContrasenna(){
        return view('control_perfil.contrasenna', [
        ]);
    }

    public function actualizarContrasenna(Request $request){
        try{

            /* Verifica que la contraseña antigua sea igual a la registrada */
            if(GlobalFunctions::verificarContrasennaVieja($request->old_password, auth()->user()->password)){
                /* Verifica que la contraseña contenga los requisitos mínimos de seguridad */
                if(GlobalFunctions::verificarContrasenna($request->new_password)){

                    /* Si la contraseña cumple con los estándares, se procede a actualizarla
                        en la base de datos encriptada.  */
                    $persona_id = auth()->user()->persona_id;
                    DB::table('users')
                        ->where('persona_id', $persona_id)
                            ->update(['password' => GlobalFunctions::hashPassword($request->new_password)]);

                    /* Devuelve la página con un mensaje de éxito. */
                    return Redirect::back()
                            ->with('mensaje-exito', 'La contraseña se actualizó exitosamente.');

                } else {

                    /* Si la contraseña no cumple con los estándares acordados, se reedirige
                    con un mensaje de error. */
                    return Redirect::back()
                            ->with('mensaje-error', 'La contraseña no cumple con los estándares mínimos de seguridad.');
                }
            } else {
                return Redirect::back()
                            ->with('mensaje-error', 'La contraseña antigua no coincide con nuestros registros.');
            }
            
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
}
