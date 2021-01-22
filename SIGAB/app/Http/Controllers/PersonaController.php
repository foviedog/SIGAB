<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class PersonaController extends Controller
{
    // Método que muestra una guía específica de un estudiante.
    public function show($persona_id)
    {

        // Se realiza una búsqueda en la BD respecto a la persona específica.
        $persona = Persona::findOrFail($persona_id);
        // dd($persona->personal);
        return view('control_perfil.detalle', [
            'persona' => $persona,
        ]);
    }
}
