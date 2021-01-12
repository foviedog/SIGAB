<?php

namespace App\Http\Controllers;

use App\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $array = ['estudiantesTotales'=> $this->estudiantesTotales(),
        'graduados'=> $this->graduados(),
        'graduacionesTotales'=> $this->graduacionesTotales(),
        'guiasAcademicasTotales'=> $this->guiasAcademicasTotales(),
        'personalTotal'=> $this->personalTotal(),
        'administrativos'=> $this->administrativos(),
        'academicos'=> $this->academicos()
    ];
        return view('home',$array);
    }
    private function estudiantesTotales(){
        return DB::table('estudiantes')->count();
    }

    private function graduados(){
        $total = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->groupBy('estudiantes.persona_id')->paginate(4)->total();
        return $total;
    }
    private function graduacionesTotales(){
        return DB::table('graduados')->count();
    }
    
    private function guiasAcademicasTotales(){
        return DB::table('guias_academicas')->count();
    }
    
    private function personalTotal(){
        return DB::table('personal')->count();
    }
    
    private function administrativos(){
        return DB::table('personal')->where('cargo', 'Administrativo')->count();
    }
    
    private function academicos(){
        return DB::table('personal')->where('cargo', 'Académico')->count();
    }
}
