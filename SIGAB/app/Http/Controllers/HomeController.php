<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalFunctions;
use App\Exceptions\ControllerFailedException;
use App\Persona;
use App\Estudiante;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try{
            
            $array = ['estudiantesTotales'=> $this->estudiantesTotales(),
            'graduados'=> $this->graduados(),
            'graduacionesTotales'=> $this->graduacionesTotales(),
            'guiasAcademicasTotales'=> $this->guiasAcademicasTotales(),
            'personalTotal'=> $this->personalTotal(),
            'administrativos'=> $this->administrativos(),
            'academicos'=> $this->academicos(),
            'persona' => Persona::findOrFail(auth()->user()->persona_id)
            ];

            return view('home',$array);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    private function estudiantesTotales(){
        try{

            return DB::table('estudiantes')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        } 
    }

    private function graduados(){
        try{

            $total = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
                ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
                ->groupBy('estudiantes.persona_id')->paginate(4)->total();
            return $total;

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    private function graduacionesTotales(){
        try{

            return DB::table('graduados')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
    
    private function guiasAcademicasTotales(){
        try{

            return DB::table('guias_academicas')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
    
    private function personalTotal(){
        try{

            return DB::table('personal')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
    
    private function administrativos(){
        try{
        
            return DB::table('personal')->where('cargo', 'Administrativo')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
    
    private function academicos(){
        try{

            return DB::table('personal')->where('cargo', 'Académico')->count();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function scriptGeneral(){
        try{
            $usuario_id = auth()->user()->id;
            $persona_id = auth()->user()->persona_id;
            $rutas = GlobalFunctions::rutas();
            return view('layouts.script',[
                'usuario_id' => $usuario_id,
                'persona_id' => $persona_id,
                'rutas' => json_encode($rutas, JSON_UNESCAPED_SLASHES)
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}
