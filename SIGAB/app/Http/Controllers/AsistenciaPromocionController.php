<?php

namespace App\Http\Controllers;

use App\Actividades;
use App\ActividadesPromocion;
use App\asistenciaPromocion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AsistenciaPromocionController extends Controller
{
    

    public function show($actividadId)
    {

        $paginaciones = [5, 10, 25, 50];
        $itemsPagina = request('itemsPagina', 5);
        $filtro = request('filtro', NULL);

        $mensaje = request('mensaje', NULL);

        $listaAsistencia = $this->obtenerLista($actividadId, $itemsPagina, $filtro);
        $actividad = Actividades::find($actividadId);

        if (!is_null($mensaje)) {
            return redirect()->route('lista-asistencia.show', $actividadId)->with('mensaje', $mensaje);
        }
        // dd($listaAsistencia);
        return view('control_actividades_promocion.lista_asistencia.detalle', [
            'listaAsistencia' => $listaAsistencia,
            'actividad' => $actividad,
            'paginaciones' => $paginaciones,
            'itemsPagina' => $itemsPagina,
            'filtro' => $filtro,
            'mensaje' => $mensaje,
        ]);
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
       // dd(\request()->cedula);
        try {
            $lista = new asistenciaPromocion();
            
            //$lista->id=1;
            $lista->actividad_id = request()->acitividad_id;
            $lista->cedula = request()->cedula;
            $lista->nombre = request()->nombre;
            $lista->apellidos = request()->apellidos;
            $lista->correo = request()->correo;
            $lista->numero_telefono = request()->telefono;
            $lista->procedencia = request()->procedencia;
            $lista->save();
            
            $mensaje = "success";
            return response()->json($mensaje, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response("No existe", 404);
        }
    }



}