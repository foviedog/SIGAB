<?php

namespace App\Http\Controllers;

use App\Actividades;
use App\ActividadesPromocion;
use App\asistenciaPromocion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenciaPromocionController extends Controller
{
    

    public function show($actividadId)
    {
        $paginaciones = [5, 10, 25, 50];
        $itemsPagina = request('itemsPagina', 5);
        $filtro = request('filtro', NULL);

        $mensaje = request('mensaje', NULL);

        //$listaAsistencia = $this->obtenerLista($actividadId, $itemsPagina, $filtro);
        $actividad = Actividades::find($actividadId);

        if (!is_null($mensaje)) {
            return redirect()->route('lista-asistencia.show', $actividadId)->with('mensaje', $mensaje);
        }
        // dd($listaAsistencia);
        return view('control_actividades_promocion.lista_asistencia.detalle', [
            //'listaAsistencia' => $listaAsistencia,
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
            $lista = Persona::join('lista_asistencias', 'personas.persona_id', '=', 'lista_asistencias.persona_id')
                ->where('lista_asistencias.actividad_id', $actividadId)->paginate($itemsPagina);
        } else {
            $lista = Persona::join('lista_asistencias', 'personas.persona_id', '=', 'lista_asistencias.persona_id')
                ->where('lista_asistencias.actividad_id', $actividadId)
                ->Where(function ($query) {
                    $query->orWhere('personas.persona_id', 'like', '%' .  request('filtro', '') . '%') // Filtro para buscar por nombre de persona
                        ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . request('filtro', '')  . "%'"); //Filtro para buscar por nombre completo
                })
                ->paginate($itemsPagina);
        }

        return $lista;
    }


    public function store($actividadId)
    {
        dd(request());
        try {
            $lista = new asistenciaPromocion();
            $lista->actividad_id = request()->actividadId;
            $lista->cedula = request()->cedula;
            $lista->nombre = request()->nombre;
            $lista->apellidos = request()->apellidos;
            $lista->correo = request()->correo;
            $lista->numero_telefono = request()->telefono;
            $lista->procedencia = request()->procedencia;
            $lista->save();
            $mensaje = "success";
            return Redirect::back();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back();
        }
    }



}
