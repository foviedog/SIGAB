<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividades;
use App\Actividades_internas;


class ActividadeController extends Controller
{
    public function create()
    {
        return view('control_actividades_internas.informacion_actividad.registrar');
    }
}