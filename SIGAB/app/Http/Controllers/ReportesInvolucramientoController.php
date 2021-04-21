<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Actividades;
use Carbon\Carbon;
use App\Personal;

class ReportesInvolucramientoController extends Controller
{

    public function show()
    {
        $datosCuantitativos = $this->datosCuntitativosPersonal();
        return view('reportes.involucramiento.detalle', [
            'datosCuantitativos' => $datosCuantitativos
        ]);
    }

    public function datosCuntitativosPersonal(){
        $interinos = Personal::where("tipo_nombramiento", "Interino")->count();
        $propietarios = Personal::where("tipo_nombramiento", "Propietario")->count();
        $fijo = Personal::where("tipo_nombramiento", "Plazo fijo")->count();
        $total = Personal::count();
        return [$interinos, $propietarios, $fijo, $total];
    }

    public function tiposCargo(){
        $tiposCargo = ["Administrativo", "Académico"];
        
    }

    public function jornadaLaboral(){
    
    }

}
