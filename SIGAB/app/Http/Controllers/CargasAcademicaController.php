<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helper\GlobalArrays;
use App\Exceptions\ControllerFailedException;
use App\Cargas_academica;
use App\Personal;
use App\Eliminado;

class CargasAcademicaController extends Controller
{
    public function index($id_personal)
    {
        try{

            // Personal al que se le quiere añadir una carga académica
            $personal = Personal::findOrFail($id_personal);

            // Cargas académicas por Personal
            $cargas_academicas = Cargas_academica::where('persona_id', $id_personal)->get();

            //Lista de cursos
            $cursos = GlobalArrays::CURSOS;

            //Se devuelve la vista
            return view('control_personal.carga_academica.listado', [
                'personal' => $personal, // Personal
                'cargas_academicas' => $cargas_academicas, // Cargas académicas
                'cursos' => $cursos, //Cursos
                'confirmarEliminar' => 'simple'
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
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

    public function destroy( $id_carga_academica)
    {
        try {
            
            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Carga académica';
            $eliminado->titulo = 'Se eliminó la carga académica' .$id_carga_academica.'.';
            $eliminado->save();

            $carga_academica = Cargas_academica::find($id_carga_academica); 
            $carga_academica->delete();
            return Redirect::back()
            ->with('mensaje-exito', '¡Se ha eliminado correctamente!');

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}
