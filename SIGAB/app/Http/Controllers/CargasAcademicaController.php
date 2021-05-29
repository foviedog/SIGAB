<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalArrays;
use App\Helper\GlobalFunctions;
use App\Exceptions\ControllerFailedException;
use App\Cargas_academica;
use App\Personal;
use App\Eliminado;

class CargasAcademicaController extends Controller
{
    public function index($id_personal)
    {
       // try{
            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];
            // Personal al que se le quiere añadir una carga académica

                    //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 2 por página
            $itemsPagina = request('itemsPagina', 25);

            //Se recibe del request el valor de anio, y se le asigna a la variable ciclo par realizar el filtro. Si dicho valor no está seteado se pone en NULL
            $anio = request('anioFiltro', NULL);

            $personal = Personal::findOrFail($id_personal);

            //Lista de cursos
            $cursos = GlobalArrays::CURSOS;

        //En caso de que el filtro de ciclo lectivo se encuentre dentro del request entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($anio) && $anio != ' ') {
            $cargas_academicas = $this->filtroAnio($anio, $id_personal, $itemsPagina); //Retorna la lista de Cargas académicas  con respecto a las fechas especificadas
        }  else { //Si no se adjunta ningún filtro de búsqueda se devuelve un listado de Cargas académicas por Personal
            $cargas_academicas = $this->obtenerCargas($itemsPagina, $id_personal);  //Retorna la lista de Cargas académicas segun ese personal      
        }

            //Se devuelve la vista
            return view('control_personal.carga_academica.listado', [
                'personal' => $personal, // Personal
                'cargas_academicas' => $cargas_academicas, // Cargas académicas
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'anio' => $anio, // Valor del filtro de año de graduación
                'cursos' => $cursos, //Cursos
                'confirmarEliminar' => 'simple'
            ]);

       // } catch (\Exception $exception) {
        //    throw new ControllerFailedException();
       // }
    }





    //Función que realiza la búsqueda de guías académicas en la base de datos con respecto al nombre, apellido o cédula que se haya especificado
    private function filtroAnio($anio, $id_personal, $itemsPagina)
    {
        $cargas_academicas = Cargas_academica::where('persona_id', $id_personal) //Inner join de guias con personas
            ->where('cargas_academicas.anio', '=', $anio)
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $cargas_academicas; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que retorna todas las guías presentes en la BD ordenadas con respecto a la última agregada en la BD.
    private function obtenerCargas($itemsPagina, $id_personal)
    {
        $cargas_academicas = Cargas_academica::where('persona_id', $id_personal)
        ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request
        return $cargas_academicas; //Retorna el resultado de todas las guías
    }


    //Método que obtiene una cedula por medio del request, devuelve ese Personal espefico junto con la vista para crear una guia academica
    public function create($id_personal)
    {
        try{

            $personal = Personal::findOrFail($id_personal);

            //Lista de cursos
            $cursos = GlobalArrays::CURSOS;

            return view('control_personal.carga_academica.registrar', [
                'personal' => $personal,
                'cursos' => $cursos //Cursos
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Método que inserta una carga academica para un personal especifico en la base de datos
    public function store(Request $request)
    {
        try {

            //Se crea una nueva instacia de carga académica.
            $carga_academica = new Cargas_academica;

            //se setean los atributos del objeto
            $carga_academica->persona_id = $request->persona_id;
            $carga_academica->ciclo_lectivo = $request->ciclo_lectivo;
            $carga_academica->anio  = $request->anio;
            $carga_academica->nombre_curso = $request->nombre_curso;
            $carga_academica->nrc = $request->nrc;

            //se guarda el objeto en la base de datos
            $carga_academica->save();

            //se redirecciona a la pagina de registro de cargas academicas con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje-exito', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('carga_academica_insertada', $carga_academica); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
        
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // Método que muestra una carga académica específica
    public function edit($id_carga_academica)
    {
        //Busca la carga académica en la base de datos
        $carga_academica = Cargas_academica::find($id_carga_academica);

        //Retorna la carga académica en formato JSON y con un código de éxito de 200
        return response()->json($carga_academica, 200);
    }

    // Método que actualiza la información de la carga académica
    public function update($id_carga_academica, Request $request)
    {
        try{

            //Busca la carga académica en la base de datos
            $carga_academica = Cargas_academica::find($id_carga_academica);

            //Al la carga académica encontrada se le actualizan los atributos
            $carga_academica->ciclo_lectivo = $request->ciclo_lectivo;
            $carga_academica->anio  = $request->anio;
            $carga_academica->nombre_curso = $request->nombre_curso;
            $carga_academica->nrc = $request->nrc;

            //Se guarda en la base de datos
            $carga_academica->save();

            //Se reedirige a la página anterior con un mensaje de éxito
            return Redirect::back()
                ->with('mensaje-exito', '¡Se ha actualizado correctamente!');

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy($id_carga_academica)
    {
        try {

            $carga_academica = Cargas_academica::find($id_carga_academica); 
            
            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Carga académica';
            $eliminado->titulo = 'Se eliminó la carga académica ' .$carga_academica->nombre_curso.' '.$carga_academica->nrc.' del personal '.$carga_academica->persona_id.'.';
            $eliminado->save();
            
            $carga_academica->delete();
            return Redirect::back()
            ->with('mensaje-exito', '¡Se ha eliminado correctamente!');

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}
