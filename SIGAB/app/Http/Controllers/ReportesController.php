<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\ActividadesPromocion;

class ReportesController extends Controller
{
    public function show()
    {
        $chart = "bar";
        $tip_act_int = $this->devolverTipos(0);
        $tip_act_prom = $this->devolverTipos(1);

        return view('reportes.detalle', [
            'chart' => $chart,
            'tip_act_int' => $tip_act_int,
            'tip_act_prom' => $tip_act_prom
        ]);
    }



    public function resultado(Request $request)
    {
        $chart = $request->tipo_grafico;
        $tip_act_int = $this->devolverTipos(0);
        $tip_act_prom = $this->devolverTipos(1);


        $naturalezaAct = $request->actividad_naturaleza;
        $estado_actividad = $request->estado_actividad;
        $mes_inicio = $request->mes_inicio;
        $mes_final = $request->mes_final;
        $chart = $request->tipo_grafico;
        $tipoAct = null;
        if ($naturalezaAct == "Actividad interna") {
            $tipoAct = $request->tipo_actividad_int;
        } else {
            $tipoAct = $request->tipo_actividad_prom;
        }
        $datos = $this->obtenerDatos($mes_inicio, $mes_final, $naturalezaAct, $tipoAct, $estado_actividad);

        return view('reportes.detalle', [
            'chart' => $chart,
            'tip_act_int' => $tip_act_int,
            'tip_act_prom' => $tip_act_prom,
            'datos' => $datos
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
                for ($j = 1; $j <= 12; $i++) {
                    $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
                }
                $anio++;
            }

            //? Segundo extremo
            for ($i = 1; $i <= $mes_fin; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
            }
        }
        dd($datos);
        return $datos;
    }

    private function agregarDatos($mes, $naturalezaAct, $anio, $estado, $tipo, &$datos)
    {
        if ($naturalezaAct == "Actividad interna") {
            $actvidadesPorMes = $this->cantActividadInterPorMes($mes, $anio, $estado, $tipo);
        } else {
            $actvidadesPorMes = $this->cantActividadPromPorMes($mes, $anio, $estado, $tipo);
        }
        array_push($datos, $anio . "-" . $mes, $actvidadesPorMes);
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
            $mesStrFin = "01";
            $fecha_fin =  $anio + 1 . "-01" . "-01";
        }

        $cantAct = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->Where('actividades.estado', 'like', '%' .   $estado . '%')
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();
        return $cantAct;
    }
    //!ARREGLAR ESTO
    public function cantActividadPromPorMes($mes, $anio, $estado, $tipo)
    {
        $fecha_ini = $anio . "-0" . $mes . "-01";
        $fecha_fin = $anio . "-0" . $mes . 1 . "-01";

        $$cantAct = ActividadesPromocion::join('actividades', 'activiades_promocion.actividad_id', '=', 'actividades.id')
            ->Where('actividades.estado', 'like', '%' .   $estado . '%')
            ->Where('activiades_promocion.tipo_actividad', 'like', '%' .   $tipo . '%')
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
}
