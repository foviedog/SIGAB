<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuiasAcademicaController extends Controller{

public function create(){
        return view('control_educativo.informacion_guias_academicas.registrar');
    }

    public function store(Request $request){

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
