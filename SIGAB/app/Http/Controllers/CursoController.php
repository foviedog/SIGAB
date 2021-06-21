<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\ControllerFailedException;
use App\Events\EventCursos; //Se añade el evento
use App\Curso;
use App\Eliminado;

class CursoController extends Controller
{
    public function index(){
        try{

            //Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];

            //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 25 por página
            $itemsPagina = request('itemsPagina', 25);

            $filtro = request('filtro', NULL);

            if (!is_null($filtro) && $filtro != ' ') {
                $cursos = $this->filtroCursos($itemsPagina, $filtro); 
            }  else { 
                $cursos = $this->obtenerCursos($itemsPagina);
            }

            return view('control_cursos.listado', [
                'cursos' => $cursos, // Cursos
                'itemsPagina' => $itemsPagina, //Items por página
                'paginaciones' => $paginaciones, // Listado de items de paginaciones
                'filtro' => $filtro
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function show($codigo){
        try{
            $curso = Curso::findOrFail($codigo); //Obtener el curso desde la Base de datos
            return view('control_cursos.detalle', [ //Retornar a la vista destinada al curso
                'curso' => $curso, // Enviar el curso en el response
                'confirmarEliminar' => 'Curso' //Variable par el eliminado
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
                'curso' => $curso, // Enviar el curso en el response
                'confirmarEliminar' => 'Curso' //Variable par el eliminado
            ])->with('mensaje_exito', "¡El curso se ha actualizado exitosamente!"); //Mensaje de éxito
        } catch (\Exception $exception) {
            //Manejo de posibles errores 
            throw new ControllerFailedException();
        }
    }

    public function destroy($codigo){
        try{
            $curso = Curso::findOrFail($codigo); //Obtener el curso desde la Base de datos
            
            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Curso';
            $eliminado->titulo = 'Se eliminó el curso: '.$curso->codigo.' - '.$curso->nombre.' - '.$curso->nrc;
            $eliminado->save();

            //Se elimina de la base de datos
            $curso->delete();

            //Se reedireciona al listado
            return redirect(route('cursos.index'))
                ->with('mensaje-exito', "El curso se ha eliminado correctamente.");

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

    private function filtroCursos($itemsPagina, $filtro)
    {
        $cursos = Curso::orWhere('codigo', 'like', '%' . $filtro . '%')
            ->orWhere('cursos.nombre', 'like', '%' . $filtro . '%')
            ->orWhere('cursos.nrc', 'like', '%' . $filtro . '%')
            ->paginate($itemsPagina);

        return $cursos; 
    }

    private function obtenerCursos($itemsPagina)
    {
        $cursos = Curso::paginate($itemsPagina);

        return $cursos;
    }

}
