<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Events\EventListaAsistencia;
use App\Exceptions\ControllerFailedException;
use App\ActividadesPromocion;
use App\Actividades;
use App\asistenciaPromocion;
use App\Eliminado;

class AsistenciaPromocionController extends Controller
{

    public function show($actividadId)
    {
        try{

            $paginaciones = [5, 10, 25, 50];
            $itemsPagina = request('itemsPagina', 5);
            $filtro = request('filtro', NULL);
            $mensaje = request('mensaje',NULL);
            $error = request('error',NULL);

            $listaAsistencia = $this->obtenerLista($actividadId, $itemsPagina, $filtro);
            $actividad = Actividades::find($actividadId);
            return view('control_actividades_promocion.lista_asistencia.detalle', [
                'listaAsistencia' => $listaAsistencia,
                'actividad' => $actividad,
                'paginaciones' => $paginaciones,
                'itemsPagina' => $itemsPagina,
                'filtro' => $filtro,
                'mensaje' => $mensaje,
                'error' => $error,
                'confirmarEliminar' => 'simple'
            ]);
    
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function obtenerLista($actividadId, $itemsPagina, $filtro)
    {
        $lista = NULL;
        if (is_null($filtro)) {
            $lista = asistenciaPromocion::where('asistencia_promocion.actividad_id', $actividadId)->paginate($itemsPagina);
        } else {
            $lista = asistenciaPromocion::where('asistencia_promocion.actividad_id', $actividadId)
                ->Where(function ($query) {
                    $query->orWhere('asistencia_promocion.actividad_id', 'like', '%' .  request('filtro', '') . '%') // Filtro para buscar por nombre de persona
                        ->orWhereRaw("concat(nombre, ' ', apellidos) like '%" . request('filtro', '')  . "%'") //Filtro para buscar por nombre completo
                        ->orWhereRaw("cedula like '%" . request('filtro', '')  . "%'") //Filtro para buscar por cedula
                        ->orWhereRaw("correo like '%" . request('filtro', '')  . "%'"); //Filtro para buscar por cedula
                })
                ->paginate($itemsPagina);
        }
        return $lista;
    }

    public function store()
    {
        try {
            
            $lista = new asistenciaPromocion();
            $lista->actividad_id = request()->acitividad_id;
            $lista->cedula = request()->cedula;
            $lista->nombre = request()->nombre;
            $lista->apellidos = request()->apellidos;
            $lista->correo = request()->correo;
            $lista->numero_telefono = request()->telefono;
            $lista->procedencia = request()->procedencia;
            $lista->save();
            return redirect()->route('asistencia-promocion.show', [request()->acitividad_id,"mensaje"=> "Participante agregado correctamente"]);
        
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy(Request $request, $particioanteId)
    {
        try {
            $lista = asistenciaPromocion::where('cedula', $particioanteId)
                ->where('actividad_id', $request->actividad_id);

             //Se envía la notificación
            //event(new EventListaAsistencia($particioanteId, $request->actividad_id, 2, 1));

            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Participante en actividad de promoción';
            $eliminado->titulo = "Participante: ".$particioanteId.' de la actividad: '.$request->actividad_id;
            $eliminado->save();

            $lista->delete();
            return redirect()->route('asistencia-promocion.show', [$request->actividad_id, "mensaje"=>"Participante eliminado correctamente"]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function obtenerParticipanteLista($idActividad, $cedula)
    {

    }

    //Método que busca la cédula del participante que se desea agregar en
    //la lista de asistencia y lo retorna por medio de un response como respuesta
    //a un método AJAX.
    public function obtenerParticipante($idParticipante,Request $request)
    {
        $participante = asistenciaPromocion::where("cedula",$idParticipante)
        ->where("actividad_id",$request->actividadId)->first(); //Busca al participante en la base de datos de personas
        if (is_null($participante)) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        }
        return response()->json($participante, 200);
    }

}