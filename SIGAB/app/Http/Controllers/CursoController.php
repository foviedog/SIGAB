<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\ControllerFailedException;
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

            $curso = Curso::findOrFail($codigo);

            return view('control_cursos.detalle', [
                'curso' => $curso
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
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

            $curso = new Curso;

            $curso->codigo = $request->codigo;
            $curso->nombre = $request->nombre;
            $curso->nrc = $request->nrc;
            $curso->save();

            return view('control_cursos.registrar')
            ->with('mensaje_exito', "¡El curso se ha registado exitosamente!")
            ->with('curso_insertado', $curso);
        
        } catch (\Illuminate\Database\QueryException $ex) { 
            return view('control_cursos.registrar')
                ->with('mensaje_error', "Ha ocurrido un error con el registro del curso con el código " . "$request->codigo" . ". Es posible que el curso ya se encuentre agregado.");
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function update(){
        try{

            

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy(){
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


