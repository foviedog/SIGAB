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
            $persona = session('persona');

            // Datos asociados a la persona (no incluye la cédula ya que no debería ser posible editarla)
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

            //Se retorna el detalle del estudiante ya modificado
            return redirect("/perfil");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Metodo que reedireciona a la vista de notificaciones
    public function notifications()
    {
        $notificacionesNoLeidas = auth()->user()->unreadNotifications()->paginate(8);
        return view('control_perfil.notificaciones', [
            'notificacionesNoLeidas'=> $notificacionesNoLeidas,
        ]);
    }
    //Metodo que reedireciona a la vista de notificaciones leídas
    public function notificacionesLeidas()
    {
        $notificacionesLeidas = auth()->user()->readNotifications()->paginate(8);
        return view('control_perfil.notificaciones_leidas', [
            'notificacionesLeidas'=> $notificacionesLeidas
        ]);
    }

    public function marcarLeido($idNotificacion){

        $notificacion = auth()->user()->unreadNotifications
        ->where('id', '=',$idNotificacion)->first();
        $notificacion->markAsRead();

        return \Redirect::back();
    }

    public function marcarTodasLeido(){
        $notificacion = auth()->user()->unreadNotifications->markAsRead();
        return \Redirect::back();
    }

    public function eliminarNotificacion($idNotificacion){

        $notificacion = auth()->user()->readNotifications
        ->where('id', '=',$idNotificacion)->first();
        $notificacion->delete();

        return \Redirect::back();
    }

    public function eliminarTodasNotificaciones(){

        $notificaciones = auth()->user()->readNotifications;

        foreach($notificaciones as $notificacion){
            $notificacion->delete();
        }

        return \Redirect::back();
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
        ->where('actividades.creada_por', '=', auth()->user()->persona_id)->paginate(8);
        
        return view('control_perfil.actividades', [
            'actividadesInternas' => $actividadesInternas,
        ]);
    }
    public function misActividadesPromocion(){
        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
        ->where('actividades.creada_por', '=', auth()->user()->persona_id)->paginate(8);
        
        return view('control_perfil.actividades_promocion', [
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
