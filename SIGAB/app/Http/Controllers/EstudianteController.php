<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Persona;
use App\Estudiante;

class EstudianteController extends Controller
{

    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('control_educativo.listado', [
            'estudiantes' => $estudiantes,
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




    public function store(Request $request)
    {

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
        return Redirect::back()->with('mensaje', '¡El registro ha sido exitoso!');
    }


    public function show($id_estudiante){
        $estudiante = Estudiante::findOrFail($id_estudiante);
        return view('control_educativo.detalle', [
            'estudiante' => $estudiante,
        ]);
    }

}
