<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla
use Illuminate\Http\Request;
use App\Persona;
use Image;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Helper\GlobalArrays;

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
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
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
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    private function update_avatar($request, $persona)
    {
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');
            $archivo = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(500, 640)->save(public_path('/img/fotos/' . $archivo));

            if ($persona->imagen_perfil != "default.jpg")
                File::delete(public_path('/img/fotos/' . $persona->imagen_perfil)); //Elimina la foto anterior

            $persona->imagen_perfil = $archivo;
            $persona->save();
        }

        return \Redirect::back();
    }

    //Metodo que reedireciona a la vista de notificaciones
    public function notifications()
    {
        $notificacionesNoLeidas = auth()->user()->unreadNotifications;
        $notificacionesLeidas = auth()->user()->readNotifications;

        return view('control_perfil.notificaciones', [
            'notificacionesNoLeidas'=> $notificacionesNoLeidas,
            'notificacionesLeidas'=> $notificacionesLeidas
        ]);
    }

    public function obtenerNotificaciones(){
        return auth()->user()->unreadNotifications;
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
}
