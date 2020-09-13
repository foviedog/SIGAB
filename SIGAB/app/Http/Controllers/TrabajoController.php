<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Estudiante;
use App\Trabajo;

class TrabajoController extends Controller
{

    /* Devuevle el listado de los estudiantes ordenados por su apellido */
    public function index($id_estudiante)
    {
        /* Estudiante al que se le quiere añadir un trabajo */
        $estudiante = Estudiante::findOrFail($id_estudiante);

        /* Trabajos por estudiante */
        $trabajos = Trabajo::where('persona_id', $id_estudiante);

        /* Array que devuelve los items que se cargan por página */
        $paginaciones = [2, 4, 25, 50, 100];

        /*Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            request se setea por defecto en 2 por página */
        $itemsPagina = request('itemsPagina', 2);

        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);

        //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($filtro)) {
            $trabajos = Trabajo::where('persona_id', $id_estudiante)
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        } else {
            $trabajos = Trabajo::where('persona_id', $id_estudiante)
                ->orderBy('nombre_organizacion', 'asc') // Ordena por medio del nombre organizacion de manera ascendente
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        }

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_laboral.listado', [
            'estudiante' => $estudiante, // estudiante
            'trabajos' => $trabajos,
            'paginaciones' => $paginaciones, // listado de items de paginaciones
            'itemsPagina' => $itemsPagina, // items que se desean por página
        ]);
    }

    /* Devuelve la página para registrar un trabajo de un estudiante en específico */
    public function create($id_estudiante){
        $estudiante = Estudiante::findOrFail($id_estudiante);
        //dd($estudiante);
        return view('control_educativo.informacion_laboral.registrar', [
            'estudiante' => $estudiante,
        ]);
    }

    /* Recoge los datos desde el request e inserta en la base de datos, al
        final devuelve a la página anterior */
    public function store(Request $request){
        $trabajo = new Trabajo;
        $trabajo->persona_id = $request->persona_id;
        $trabajo->nombre_organizacion = $request->nombre_organizacion;
        $trabajo->tipo_organizacion = $request->tipo_organizacion;
        $trabajo->tiempo_desempleado = $request->tiempo_desempleado;
        $trabajo->cargo_actual = $request->cargo_actual;
        $trabajo->jefe_inmediato = $request->jefe_inmediato;
        $trabajo->telefono_trabajo = $request->telefono_trabajo;
        $trabajo->jornada_laboral = $request->jornada_laboral;
        $trabajo->correo_trabajo = $request->correo_trabajo;
        $trabajo->interes_capacitacion = $request->interes_capacitacion;
        $trabajo->otros_estudios = $request->otros_estudios;
        //dd($trabajo);
        $trabajo->save();
        return Redirect::back()
            ->with('mensaje', '¡El registro ha sido exitoso!')
                ->with('trabajo_insertado', $trabajo);

    }

}
