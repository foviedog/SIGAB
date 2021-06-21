<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\ControllerFailedException;
use App\Events\EventCursos; //Se añade el evento
use App\Curso;

class CursoController extends Controller
{
    public function index(){
        try{


            return view('control_cursos.listado', [
                //Variables que recibe la vista
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function show($codigo){
        try{
            $curso = Curso::findOrFail($codigo); //Obtener el curso desde la Base de datos
            return view('control_cursos.detalle', [ //Retornar a la vista destinada al curso
                'curso' => $curso // Enviar el curso en el response
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException(); // Validación de posibles errores 
        }
    }

    public function create(){
        try{
            return view('control_cursos.registrar', [
                //Variables que recibe la vista
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function store(Request $request){
        try{

            $curso = new Curso; // Creación de una nueva instacia Curso

            //Obtención de los valores que vienen en el request
            $curso->codigo = $request->codigo;
            $curso->nombre = $request->nombre;
            $curso->nrc = $request->nrc;

            //Almacenamiento del registro en la base de datos
            $curso->save();

            //Se acciona la notificación, se envía el curso y la acción
            event(new EventCursos($curso, 1));
            //IMPORTANTE: La notificación debe ser enviada DESPUÉS de registrar
            //el objeto en la base de datos

            return view('control_cursos.registrar') //Retorno de la vista 
            ->with('mensaje_exito', "¡El curso se ha registrado exitosamente!") //Mensaje de éxito
            ->with('curso_insertado', $curso); //Retorna el objeto que se insertó
        
        } catch (\Illuminate\Database\QueryException $ex) { 
            //Manejo de posibles errores 
            return view('control_cursos.registrar')
                ->with('mensaje_error', "Ha ocurrido un error con el registro del curso con el código " . "$request->codigo" . ". Es posible que el curso ya se encuentre agregado.");
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function update($codigo, Request $request){
        try{

            $curso = Curso::findOrFail($codigo); //Obtener el curso desde la Base de datos
            //Obtención de los valores que vienen en el request
            $curso->nombre = $request->nombre;
            $curso->nrc = $request->nrc;            
            //Almacenamiento del registro en la base de datos
            $curso->save();

            return view('control_cursos.detalle', [ //Retornar a la vista destinada al curso
                'curso' => $curso // Enviar el curso en el response
            ])->with('mensaje_exito', "¡El curso se ha actualizado exitosamente!"); //Mensaje de éxito
        } catch (\Exception $exception) {
            //Manejo de posibles errores 
            throw new ControllerFailedException();
        }
    }

    public function destroy($codigo_curso){
        try{
            

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function edit(){
        try{

            

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}


