<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
