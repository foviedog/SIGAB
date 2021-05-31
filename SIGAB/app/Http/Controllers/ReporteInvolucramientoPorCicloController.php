<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Actividades;
use App\Personal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DateTime;
use PDF;
use App\Helper\GlobalArrays;
use App\Helper\GlobalFunctions;

class ReporteInvolucramientoPorCicloController extends Controller
{
    private $anios;

    public function __construct()
    {
        $this->anios = GlobalFunctions::obtenerAniosActual();
    }

    // ========================================================================================================================================
    // Función utilizada para procesar el request de mostrar la vista de reportes de actividades
    // ========================================================================================================================================
    public function show()
    {
        //Las siguientes dos líneas de código arreglan el bug de las versiones de php > 7.1 con números flotantes
        ini_set('precision', 10);
        ini_set('serialize_precision', 10);
        try {
            $anio = request('anio', null);
            $personal = null;
            $actividadesCiclo = [];
            $datosCuantitativos = $this->datosCuntitativosPersonal();
            $actividadesPrimerCiclo = null;
            $actividadesSegundoCiclo = null;
            
            if (!is_null($anio)) {
                $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id')->get()->keyBy('persona_id'); //Inner join de personal con personas
                $actividadesCiclo = $this->actividadesPorCiclo($personal, $anio);
                $actividadesPrimerCiclo = $actividadesCiclo[0];
                $actividadesSegundoCiclo = $actividadesCiclo[1];
            }

            return view('reportes.involucramiento.por_ciclo.involucramiento_ciclo', [
                'datosCuantitativos' => $datosCuantitativos,
                'personal' => $personal,
                'anioReporte' => $anio,
                'actividadesPrimerCiclo' =>  $actividadesPrimerCiclo,
                'actividadesSegundoCiclo' =>   $actividadesSegundoCiclo,
                'anios' => $this->anios
            ]);
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        } catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    public function datosCuntitativosPersonal()
    {
        $interinos = Personal::where("tipo_nombramiento", "Interino")->count();
        $propietarios = Personal::where("tipo_nombramiento", "Propietario")->count();
        $fijo = Personal::where("tipo_nombramiento", "Plazo fijo")->count();
        $total = Personal::count();
        return [$interinos, $propietarios, $fijo, $total];
    }

    public function actividadesPorCiclo($personal, $anio)
    {
        $primerCiclo = [];
        $segundoCiclo = [];
        foreach ($personal as $persona) {
            $actividadesPersonalPrimerCiclo =  $this->consultaActividadesXCiclo($persona->persona_id, $anio, 1); //Actividades por personal del primer ciclo
            $actividadesPersonalSegundoCiclo =  $this->consultaActividadesXCiclo($persona->persona_id, $anio, 2); //Actividades por personal del segundo ciclo
            //Almacenamiento del resultado de las consultas
            $primerCiclo[$persona->persona_id] = $actividadesPersonalPrimerCiclo;
            $segundoCiclo[$persona->persona_id] = $actividadesPersonalSegundoCiclo;
        }
        return [$primerCiclo, $segundoCiclo];
    }

    public function consultaActividadesXCiclo($persona_id, $anio, $ciclo)
    {
        if ($ciclo == 1) {
            $fechaIni = $anio . "-01-01";
            $fechaFin = $anio . "-07-01";
        } else {
            $fechaIni = $anio . "-07-01";
            $fechaFin = $anio . "-12-31";
        }

        $actividadesCiclo = Actividades::select("actividades.id",  "actividades_internas.tipo_actividad", "actividades.tema", "actividades.fecha_inicio_actividad", "actividades.fecha_final_actividad")
            ->leftJoin('lista_asistencias', 'lista_asistencias.actividad_id', '=', 'actividades.id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($persona_id) {
                $query->where("actividades.responsable_coordinar", "=", $persona_id)
                    ->orwhere("actividades_internas.personal_facilitador", "=", $persona_id)
                    ->orwhere("lista_asistencias.persona_id", "=", $persona_id);
            })
            ->where(function ($query) {
                $query->where('actividades.estado', '=', 'Ejecutada')
                    ->orWhere('actividades.estado', '=', 'En progreso');
            })
            ->whereBetween('actividades.fecha_final_actividad', [$fechaIni, $fechaFin])
            ->distinct()->get();

        return $actividadesCiclo;
    }

    // ==============================================================
    // Función utilizada para generar el reporte en una página aparte
    // ==============================================================
    public function reporte(Request $request)
    {
        $annioActual = date("Y"); //Se obtiene el año actual del servidor
        date_default_timezone_set("America/Costa_Rica"); //Se obtiene la hora, minutos y segundos del servidor
        $consultado = 'Consultado el ' . date("d/m/Y") . ' a las ' . date('h:i:sa') . '.'; //Se crea la leyenda de "consultado en"
        //Se retorna la vista en la que se puede realizar la impresión o descarga del reporte
        $personal = json_decode($request->personal);
        $anioReporte =  json_decode($request->anio);
        $actividadesPrimerCiclo = json_decode($request->actividadesPrimerCiclo,true);
        $actividadesSegundoCiclo =  json_decode($request->actividadesSegundoCiclo, true);
        // dd($actividadesPrimerCiclo);
        return view('reportes.involucramiento.por_ciclo.reporte', [
            'personal' => $personal,
            'anioReporte' => $anioReporte,
            'actividadesPrimerCiclo' => $actividadesPrimerCiclo,
            'actividadesSegundoCiclo' => $actividadesSegundoCiclo,
            'consultado' => $consultado
        ]);
    }
}
