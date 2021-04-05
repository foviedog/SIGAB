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
        return view('reportes.detalle', [
            'chart' => $chart,
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


    public function resultado(Request $request)
    {
        $naturalezaAct = $request->actividad;
        $tipoAct = $request->tipo_actividad;

        $chart = $request->tipo_grafico;

        return view('reportes.detalle', [
            'chart' => $chart,
        ]);
    }
}
