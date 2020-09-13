<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Estudiante;
use App\Guias_academica;

class EstudianteController extends Controller
{

    //Devuevle el listado de los estudiantes ordenados por su apellido.
    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [2, 4, 25, 50, 100];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 2 por página
        $itemsPagina = request('itemsPagina', 2);

        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);

        //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($filtro)) {
            $estudiantes = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con personas
                ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                ->orWhere('personas.apellido', 'like', '%' . $filtro . '%') // Filtro para buscar por apellido de persona
                ->orWhere('personas.nombre', 'like', '%' . $filtro . '%') // Filtro para buscar por cédula
                ->orderBy('personas.apellido', 'asc')
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        } else { //Si no se setea el filtro se devuelve un listado de los estudiantes
            $estudiantes = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con personas
                ->orderBy('personas.apellido', 'asc') // Ordena por medio del apellido de manera ascendente
                ->paginate($itemsPagina);; //Paginación de los resultados según el atributo seteado en el Request
        }
        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.listado', [
            'estudiantes' => $estudiantes, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
        ]);
    }

    public function create()
    {
        //$estudiante = Estudiante::findOrFail($id_estudiante);
        //dd($estudiante);
        return view('control_educativo.informacion_estudiantil.registrar', [
            //'estudiante' => $estudiante,
        ]);
    }

    public function store(Request $request){

        $persona = new Persona;
        $estudiante = new Estudiante;

        $persona->persona_id = $request->cedula;
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
        $persona->save();

        $estudiante->persona_id = $request->cedula;
        $estudiante->direccion_lectivo = $request->direccion_lectivo;
        $estudiante->cant_hijos = $request->cantidad_hijos;
        $estudiante->tipo_colegio_procedencia = $request->tipo_colegio_procedencia;
        $estudiante->condicion_discapacidad = $request->condicion_discapacidad;
        $estudiante->anio_ingreso_ebdi = $request->anio_ingreso_ebdi;
        $estudiante->anio_ingreso_UNA = $request->anio_ingreso_una;
        $estudiante->carrera_matriculada_1 = $request->carrera_matriculada_1;
        $estudiante->carrera_matriculada_2 = $request->carrera_matriculada_2;
        $estudiante->anio_graduacion_estimado_1 = $request->anio_gradacion_estimado_1;
        $estudiante->anio_graduacion_estimado_2 = $request->anio_graduacion_estimado_2;
        $estudiante->anio_desercion = $request->anio_desercion;
        $estudiante->tipo_beca = $request->tipo_beca;
        $estudiante->nota_admision = $request->nota_admision;
        $estudiante->apoyo_educativo = $request->apoyo_educativo;
        $estudiante->residencias_UNA = $request->residencias;
        $estudiante->save();

        return Redirect::back()
        ->with('mensaje', '¡El registro ha sido exitoso!')
        ->with('persona_insertado', $persona)
        ->with('estudiante_insertado', $estudiante)
        ->with('cedula', $request->cedula);
    }

// Toma al estudiante por el id para mostrar su informacion detallada
    public function show($id_estudiante)
    {
        $estudiante = Estudiante::findOrFail($id_estudiante);
        return view('control_educativo.detalle', [
            'estudiante' => $estudiante,
        ]);
    }




public function guia_create(){
        return view('control_educativo.informacion_estudiantil.guia_academica_registrar');
    }

    public function guia_store(Request $request){

        $guia = new Guias_academica;

        $guia->persona_id = 116250948;
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





}
