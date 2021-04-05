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


        $naturalezaAct = $request->actividad;
        $tipoAct = $request->tipo_actividad;

        $chart = $request->tipo_grafico;
        return view('reportes.detalle', [
            'chart' => $chart,
            'tip_act_int' => $tip_act_int,
            'tip_act_prom' => $tip_act_prom
        ]);
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
