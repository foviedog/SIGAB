<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Actividades;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DateTime;
use PDF;

class ReportesActividadesController extends Controller
{

    public function show()
    {
        $chart = "bar";
        $tip_act_int = $this->devolverTipos(0);
        $tip_act_prom = $this->devolverTipos(1);
        $datos = null;
        $datosCuantitativos = $this->datosCuantitativosActividades();
        $naturalezaAct = request('actividad_naturaleza', null);
        $estadoActividad = request('estado_actividad', null);
        $mesInicio = request('mes_inicio', null);
        $mesFinal = request('mes_final', null);
        $chart = request('tipo_grafico', null);
        $tipoAct = request('tipo_actividad_int', null);
        $propositosDelAnio = $this->propositosActividad();
        $estadosDelAnio = $this->estadosActividades();

        return view('reportes.actividades.detalle', [
            'chart' => $chart,
            'tip_act_int' => $tip_act_int,
            'tip_act_prom' => $tip_act_prom,
            'datos' => $datos,
            'datosCuantitativos' => $datosCuantitativos,
            'naturalezaAct' => $naturalezaAct,
            'tipoAct' => $tipoAct,
            'mesInicio' => $mesInicio,
            'mesFinal' => $mesFinal,
            'estadoActividad' => $estadoActividad,
            'propositosDelAnio' => json_encode($propositosDelAnio, JSON_UNESCAPED_SLASHES),
            'estadosDelAnio' => json_encode($estadosDelAnio, JSON_UNESCAPED_SLASHES),
        ]);
    }



    public function resultado(Request $request)
    {
        $chart = $request->tipo_grafico;
        $tip_act_int = $this->devolverTipos(0);
        $tip_act_prom = $this->devolverTipos(1);

        $naturalezaAct = $request->actividad_naturaleza;
        $estadoActividad = $request->estado_actividad;
        $mesInicio = $request->mes_inicio;
        $mesFinal = $request->mes_final;
        $chart = $request->tipo_grafico;
        if ($naturalezaAct == "Actividad interna") {
            $tipoAct = $request->tipo_actividad_int;
        } else {
            $tipoAct = $request->tipo_actividad_prom;
        }
        $datos = $this->obtenerDatos($mesInicio, $mesFinal, $naturalezaAct, $tipoAct, $estadoActividad);
        $datosCuantitativos = $this->datosCuantitativosActividades();
        $propositosDelAnio = $this->propositosActividad();
        $estadosDelAnio = $this->estadosActividades();

        $this->generarTextoReporte(
            $request->actividad_naturaleza, 
            $tipoAct, 
            $request->estado_actividad, 
            $mesInicio, 
            $mesFinal
        );

        return view('reportes.actividades.detalle', [
            'chart' => $chart,
            'tip_act_int' => $tip_act_int,
            'tip_act_prom' => $tip_act_prom,
            'datos' => json_encode($datos, JSON_UNESCAPED_SLASHES),
            'datosCuantitativos' => $datosCuantitativos,
            'naturalezaAct' => $naturalezaAct,
            'tipoAct' => $tipoAct,
            'mesInicio' => $mesInicio,
            'mesFinal' => $mesFinal,
            'estadoActividad' => $estadoActividad,
            'propositosDelAnio' => json_encode($propositosDelAnio, JSON_UNESCAPED_SLASHES),
            'estadosDelAnio' => json_encode($estadosDelAnio, JSON_UNESCAPED_SLASHES),
            'chart' => $chart,
        ]);
    }

    public function obtenerDatos($mes_inicio, $mes_final, $naturalezaAct, $tipo, $estado)
    {
        $anio_ini = (int)substr($mes_inicio, 0, 4);
        $anio_fin = (int)substr($mes_final, 0, 4);
        $mes_ini = (int)substr($mes_inicio, 5, strlen($mes_final));
        $mes_fin = (int)substr($mes_final, 5, strlen($mes_final));

        $DA = $anio_fin - $anio_ini;
        $DM = $mes_fin - $mes_ini;
        $cont = 1;
        $datos = [];
        if ($DA == 0) {
            for ($i = $mes_ini; $i <= $mes_fin; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio_ini, $estado, $tipo, $datos);
            }
        } else if ($DA >= 1) {
            $anios_completos = $DA - 1;
            $anio = $anio_ini;
            //? Primer extremo
            for ($i = $mes_ini; $i <= 12; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
            }

            $anio++; //?Se amuenta el año
            //?Años intermedios que se deben contar COMPLETOS (Todos los 12 meses del año)
            for ($i = 1; $i <= $anios_completos; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $this->agregarDatos($j, $naturalezaAct, $anio, $estado, $tipo, $datos);
                }
                $anio++;
            }

            //? Segundo extremo
            for ($i = 1; $i <= $mes_fin; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
            }
        }

        return $datos;
    }

    private function agregarDatos($mes, $naturalezaAct, &$anio, $estado, $tipo, &$datos)
    {
        if ($naturalezaAct == "Actividad interna") {
            $actvidadesPorMes = $this->cantActividadInterPorMes($mes, $anio, $estado, $tipo);
        } else {
            $actvidadesPorMes = $this->cantActividadPromPorMes($mes, $anio, $estado, $tipo);
        }
        $datos[$anio . "-" . $mes] =  $actvidadesPorMes;
    }


    public function cantActividadInterPorMes($mes, $anio, $estado, $tipo)
    {
        $mesIni = (int)$mes;
        $mesFin = $mesIni + 1;
        $mesStr = (string)$mes;
        $mesStrFin = (string)($mesFin);

        if ($mes < 9) {
            $mesStr = "0" . $mesStr;
            $mesStrFin = "0" . $mesFin;
        }
        $fecha_ini = $anio . "-" . $mesStr . "-01";
        $fecha_fin = $anio  . "-" . $mesStrFin . "-01";

        if ($mes == 12) {
            $fecha_fin =  $anio . "-12" . "-31";
        }
        $cantAct = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->Where('actividades.estado', 'like', '%' .   $estado . '%')
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();
        return $cantAct;
    }

    public function cantActividadPromPorMes($mes, $anio, $estado, $tipo)
    {
        $mesIni = (int)$mes;
        $mesFin = $mesIni + 1;
        $mesStr = (string)$mes;
        $mesStrFin = (string)($mesFin);

        if ($mes < 9) {
            $mesStr = "0" . $mesStr;
            $mesStrFin = "0" . $mesFin;
        }
        $fecha_ini = $anio . "-" . $mesStr . "-01";
        $fecha_fin = $anio  . "-" . $mesStrFin . "-01";

        if ($mes == 12) {
            $fecha_fin =  $anio . "-12" . "-31";
        }
        $cantAct = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
            ->Where('actividades.estado', 'like', '%' .   $estado . '%')
            ->Where('actividades_promocion.tipo_actividad', 'like', '%' .   $tipo . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();

        return  $cantAct;
    }



    public function devolverTipos($act)
    {
        switch ($act) {
            case 0:
                return [
                    "Curso", "Conferencia", "Taller", "Seminario", "Conversatorio",
                    "Órgano colegiado", "Tutorías", "Lectorías", "Simposio", "Charla", "Actividad cocurricular",
                    "Tribunales de prueba de grado", "Tribunales de defensas públicas",
                    "Comisiones de trabajo", "Externa", "Otro"
                ];
            case 1:
                return [
                    "Ferias", "Participación en congresos nacionales e internacionales", "Puertas abiertas",
                    "Promoción por redes sociales", "Visitas a comunidades", "Visitas a colegios",
                    "Envío de paquetes promocionales por correo electrónico", "Charlas", "Otro"
                ];
        }
    }

    private function datosCuantitativosActividades()
    {
        $cantPromocion = ActividadesPromocion::count(); //Obtiene la cantidad de acitvidades de promoción que se han realizado
        $cantInternas = Actividades_interna::count(); //Obtiene la cantidad de actividades internas que se han realizado
        $cantResponsables = Actividades::distinct('responsable_coordinar')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->count('responsable_coordinar'); //Obtiene la cantidad de responsables de actividades a lo largo del tiempo, únicamente
        return [$cantPromocion, $cantInternas, $cantResponsables];
    }

    private function propositosActividad()
    {
        $propositos = ["Capacitación", "Indución", "Actualización", "Involucramiento del personal", "Otro"];
        $anioActual = (string) Carbon::now()->format('Y');
        $fechaIni = $anioActual . "-01-01";
        $fechaFin = $anioActual . "-12-31";
        $dataSet = [];
        $cont = 0;

        foreach ($propositos as &$proposito) {
            $propositosActividades = Actividades_interna::select("fecha_final_actividad as fecha_fin")
                ->join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->Where('actividades_internas.proposito', 'like', '%' .   $proposito . '%')
                ->whereBetween('fecha_final_actividad', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
                ->count(); //Obtiene la cantidad de actividades internas que se realizan o se van a realzar en el 2021
            $dataSet[$proposito] = $propositosActividades;
        }
        return $dataSet;
    }
    private function estadosActividades()
    {
        $estados = ["En progreso", "Para ejecución", "Ejecutada", "Cancelada"];
        $anioActual = (string) Carbon::now()->format('Y');
        $fechaIni = $anioActual . "-01-01";
        $fechaFin = $anioActual . "-12-31";
        $dataSet = [];
        $cont = 0;

        foreach ($estados as &$estado) {
            $estadosActividades = Actividades::select("fecha_final_actividad as fecha_fin")
                ->Where('actividades.estado', 'like', '%' .   $estado . '%')
                ->whereBetween('fecha_final_actividad', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
                ->count(); //Obtiene la cantidad de actividades que cuentan con el estado en el que se está iterando
            $dataSet[$estado] = $estadosActividades;
        }
        return $dataSet;
    }

    public function generarTextoReporte($naturaleza, $tipo, $estado, $mesInicio, $mesFinal){
        
        if ($naturaleza == "Actividad interna") {
            $naturaleza = 'Actividades Internas';
        } else {
            $naturaleza = 'Actividades de Promoción';
        }

        if(!$tipo) 
            $tipo = 'Todos los tipos';

        if(!$estado) 
            $estado = 'Todos los estados';

        $tempMI = new \DateTime($mesInicio);
        $tempFN = new \DateTime($mesFinal);

        $mInicio = $tempMI->format('m/Y');
        $mFinal = $tempFN->format('m/Y');

        $reporteTexto = 'Reporte estadístico de '. $naturaleza. ' del tipo de «'.$tipo.'» con el estado «'.$estado.'» desde el mes de '.$mInicio.' hasta el mes de '.$mFinal.'.';
        
        Session::put("reporteTexto", $reporteTexto);
    }

    public function obtReporte(){

        $logoUNA = 'data:image/png;base64,' . base64_encode(File::get(public_path(). '/img/logo-UNA.png'));
        $logoEBDI = 'data:image/png;base64,' . base64_encode(File::get(public_path(). '/img/logoEBDI.png'));
        $annioActual = date("Y");
        date_default_timezone_set("America/Costa_Rica");
        $consultado = 'Consultado el '.date("d/m/Y"). ' a las '.date('h:i:sa').'.';

        /*return view('reportes.actividades.reporte', [
            'imgUri' => Session::get("imgUri"),
            'reporteTexto' => Session::get("reporteTexto"),
            'logoUNA' => $logoUNA,
            'logoEBDI' => $logoEBDI,
            'annioActual' => $annioActual,
            'consultado' => $consultado
        ]);*/

        $pdf = PDF::loadView('reportes.actividades.reporte', [
            'imgUri' => Session::get("imgUri"),
            'reporteTexto' => Session::get("reporteTexto"),
            'logoUNA' => $logoUNA,
            'logoEBDI' => $logoEBDI,
            'annioActual' => $annioActual,
            'consultado' => $consultado
        ]);
        //Session::forget("reporteTexto");
        Session::forget('imgUri');
        return $pdf->download('reporte_'.date("d/m/Y").'_'.date('h:i').'.pdf');
    }

    public function genReporte(Request $request){
        Session::put("imgUri", $request->imgURI);
    }
}
