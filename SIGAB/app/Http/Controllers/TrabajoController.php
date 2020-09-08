<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Estudiante;
use App\Trabajo;

class TrabajoController extends Controller
{
    public function create($id_estudiante){
        $estudiante = Estudiante::findOrFail($id_estudiante);
        //dd($estudiante);
        return view('control_educativo.informacion_laboral.registrar', [
            'estudiante' => $estudiante,
        ]);
    }

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
        return Redirect::back()->with('mensaje', '¡El registro ha sido exitoso!');

    }

}
