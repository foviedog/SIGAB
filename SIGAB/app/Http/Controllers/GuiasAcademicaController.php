<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Estudiante;
use App\Guias_academica;

class GuiasAcademicaController extends Controller
{

    public function create()
    {
        $id_estudiante = request('cedula', '');
        $estudiante = Estudiante::findOrFail($id_estudiante);
        return view('control_educativo.informacion_guias_academicas.registrar', [
            'estudiante' => $estudiante,
        ]);
    }

    public function store(Request $request)
    {

        $guia = new Guias_academica;

        $guia->persona_id = $request->persona_id;
        $guia->motivo = $request->motivo;
        $guia->fecha = $request->fecha;
        $guia->ciclo_lectivo = $request->ciclo_lectivo;
        $guia->situacion = $request->situacion;
        $guia->lugar_atencion = $request->lugar_atencion;
        $guia->recomendaciones = $request->recomendaciones;
        $guia->save();

        return Redirect::back()
            ->with('mensaje', '¡El registro ha sido exitoso!')
            ->with('gua_academica_insertada', $guia);
    }



    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [10, 25, 50, 100];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 10 por página
        $itemsPagina = request('itemsPagina', 10);

        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);

        //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($filtro)) {
            $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
                ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
                ->orderBy('guias_academicas.id', 'desc') // Ordena por medio del apellido de manera ascendente
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        } else { //Si no se setea el filtro se devuelve un listado de los estudiantes
            $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
                ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
                ->orderBy('guias_academicas.id', 'desc') // Ordena por medio del apellido de manera ascendente
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        }
        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_guias_academicas.listado', [
            'guias' => $guias, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
        ]);
    }

    public function show($id_guia)
    {
        $guia = Guias_academica::join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de guias con personas
            ->join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con guías académicas
            ->where('guias_academicas.id', '=',  $id_guia)
            ->first(); // Obtener únicamente a la guía a la que se ha consultado.

        return response()->json($guia, 200);
    }
}
