<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalFunctions;
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

        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }    
        catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }
    private function estudiantesTotales(){
        try{
        return DB::table('estudiantes')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }

    private function graduados(){
        try{
        $total = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->groupBy('estudiantes.persona_id')->paginate(4)->total();
        return $total;
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }
    private function graduacionesTotales(){
        try{
        return DB::table('graduados')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }
    
    private function guiasAcademicasTotales(){
        try{
        return DB::table('guias_academicas')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }
    
    private function personalTotal(){
        try{
        return DB::table('personal')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }
    
    private function administrativos(){
        try{
        return DB::table('personal')->where('cargo', 'Administrativo')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }
    
    private function academicos(){
        try{
        return DB::table('personal')->where('cargo', 'Académico')->count();
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }  
    }

    public function scriptGeneral(){
        $usuario_id = auth()->user()->id;
        $rutas = GlobalFunctions::rutas();
        return view('layouts.script',[
            'usuario_id' => $usuario_id,
            'rutas' => json_encode($rutas, JSON_UNESCAPED_SLASHES)
        ]);
    }

}
