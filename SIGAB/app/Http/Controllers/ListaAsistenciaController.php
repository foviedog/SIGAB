<?php

namespace App\Http\Controllers;

use App\Actividades;
use App\Actividades_interna;
use App\ListaAsistencia;
use App\Persona;
use Illuminate\Http\Request;

class ListaAsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $lista = new ListaAsistencia();
            $lista->persona_id = request()->participante_id;
            $lista->actividad_id = request()->actividad_id;
            $lista->save();
            $paginaciones = [5, 10, 25, 50];
            $filtro = request('filtro', NULL);

            $itemsPagina = 5;
            $actividad = Actividades::find(request()->actividad_id);

            $listaAsistencia = $this->obtenerLista($lista->actividad_id, $itemsPagina, $filtro);
            $tabla = view('control_actividades_internas.lista_asistencia.load',  [
                'listaAsistencia' => $listaAsistencia,
                'actividad' => $actividad,
                'paginaciones' => $paginaciones,
                'itemsPagina' => $itemsPagina,
                'filtro' => $filtro,
            ])->render();

            return response()->json($tabla, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response("No existe", 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
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
        return view('control_actividades_internas.lista_asistencia.detalle', [
            'listaAsistencia' => $listaAsistencia,
            'actividad' => $actividad,
            'paginaciones' => $paginaciones,
            'itemsPagina' => $itemsPagina,
            'filtro' => $filtro,
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaAsistencia $listaAsistencia)
    {
        //
    }
    //Método que busca la cédula del participante que se desea agregar en
    //la lista de asistencia y lo retorna por medio de un response como respuesta
    //a un método AJAX.
    public function obtenerParticipante($idParticipante)
    {
        $participante = Persona::find($idParticipante); //Busca al participante en la base de datos de personas
        if (is_null($participante)) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        }
        return response()->json($participante, 200);
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
}
