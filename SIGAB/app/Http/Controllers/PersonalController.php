<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Persona;
use App\Personal;

class PersonalController extends Controller
{



        //Devuevle el listado del personal ordenados por su apellido.
        public function index(){

        // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];
        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 25 por página
        $itemsPagina = request('itemsPagina', 25);
        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);
        if (!is_null($filtro)) {
            $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro . "%'") //Filtro para buscar por nombre completo
                ->orderBy('personas.apellido', 'asc')
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        } else { //Si no se setea el filtro se devuelve un listado del personal
            $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                ->orderBy('personas.apellido', 'asc') // Ordena por medio del apellido de manera ascendente
                ->paginate($itemsPagina);; //Paginación de los resultados según el atributo seteado en el Request
        }
        //se devuelve la vista con los atributos de paginación del personal
            return view('control_personal.listado', [
                'personal' => $personal, // Listado de personal.
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
            ]);
        }





    public function create()
    {
        return view('control_personal.registrar');
    }





}

