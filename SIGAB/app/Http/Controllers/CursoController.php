<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function show(){
        try{

            
            return view('control_cursos.detalle', [
                //Variables que recibe la vista
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

    public function store(){
        try{

            

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


