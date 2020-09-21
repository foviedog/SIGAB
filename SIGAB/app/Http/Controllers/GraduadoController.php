<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Graduado;
use App\Estudiante;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GraduadoController extends Controller
{



    //Método que obtiene una cedula por medio del request, devuelve ese estudiante espefico junto con la vista para crear una guia academica
    public function create()
    {
        $id_estudiante = request('cedula', NULL); //Se obtiene el atributo de cédila que viene en el request y en caso de que no se encuentre seteado se pone en blanco
        $estudiante = Estudiante::findOrFail($id_estudiante);
        return view('control_educativo.informacion_estudiantil.informacion_graduados.registrar', [
            'estudiante' => $estudiante,
        ]);
    }


    //Método que inserta una guia academica de un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores
            //Se crea una nueva instacia de guías académicas.
            $graduado = new Graduado;

            //se setean los atributos del objeto
            $graduado->persona_id = $request->persona_id;
            $graduado->grado_academico = $request->grado_academico;
            $graduado->carrera_cursada = $request->carrera_cursada;
            $graduado->anio_graduacion = $request->anio_graduacion;
            //se guarda el objeto en la base de datos
            $graduado->save();

            //se redirecciona a la pagina de registro de guias academicas con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('graduado_insertada', $graduado); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }



    //Método iniciaal que devuelve el listado de guías con respecto a filtros
    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [10, 25, 50, 100];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 10 por página
        $itemsPagina = request('itemsPagina', 10);

        $graduados = $this->obtenerGraduados($itemsPagina);

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_estudiantil.informacion_graduados.listado', [
            'graduados' => $graduados, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
        ]);
    }

    /* ====================================================================================
                Métodos de búsquda de base de datos  utilizados en el index
    ==================================================================================== */

    //Función que retorna todas las guías presentes en la BD ordenadas con respecto a la última agregada en la BD.
    private function obtenerGraduados($itemsPagina)
    {

        $graduados = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->groupBy('estudiantes.persona_id')->paginate($itemsPagina);


        return $graduados; //Retorna el resultado de todas las guías
    }
}
