<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Actividades;
use App\ListaAsistencia;
use Carbon\Carbon;
use App\Personal;
use Illuminate\Support\Facades\DB;

class ReportesInvolucramientoController extends Controller
{
    const TIPOS_ACT_INTERNAS = [
        "Curso", "Conferencia", "Taller", "Seminario", "Conversatorio",
        "Órgano colegiado", "Tutorías", "Lectorías", "Simposio", "Charla", "Actividad cocurricular",
        "Tribunales de prueba de grado", "Tribunales de defensas públicas",
        "Comisiones de trabajo", "Externa", "Otro"
    ];

    public function show()
    {
        $datosCuantitativos = $this->datosCuntitativosPersonal();
        return view('reportes.involucramiento.detalle', [
            'datosCuantitativos' => $datosCuantitativos
        ]);
    }

    public function datosCuntitativosPersonal()
    {
        $interinos = Personal::where("tipo_nombramiento", "Interino")->count();
        $propietarios = Personal::where("tipo_nombramiento", "Propietario")->count();
        $fijo = Personal::where("tipo_nombramiento", "Plazo fijo")->count();
        $total = Personal::count();
        return [$interinos, $propietarios, $fijo, $total];
    }

    public function tiposCargo()
    {
        $tiposCargo = ["Administrativo", "Académico"];
    }

    public function jornadaLaboral()
    {
    }

    public function cantActividadesXPersonal()
    {
        $tipos = ReportesInvolucramientoController::TIPOS_ACT_INTERNAS;
        $personal = DB::table('personal')
            ->select('persona_id')->get();
        $dataSet = [];
        foreach ($personal as &$persona) {
            $personaTipos = [];
            foreach ($tipos as &$tipo) {
                $cant = $this->cantActividadesInternasXTipo($persona->persona_id, $tipo, '2021');
                $personaTipos[$tipo] =  $cant;
            }
            $dataSet[$persona->persona_id] = $personaTipos;
        }
        // dd($dataSet);
        $this->porcentajeParticipacion($dataSet);

        return $dataSet;
    }

    public function cantActividadesInternasXTipo($persona_id, $tipo, $anio)
    {
        $cant = Actividades::join('lista_asistencias', 'lista_asistencias.actividad_id', '=', 'actividades.id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($persona_id) {
                $query->where("actividades.responsable_coordinar", "=", $persona_id)
                    ->orwhere("lista_asistencias.persona_id", "=", $persona_id);
            })
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
            ->where(function ($query) {
                $query->where('actividades.estado', '=', 'Ejecutada')
                    ->orWhere('actividades.estado', '=', 'En progreso');
            })
            // ->where(function ($query) use ($anio) {
            //     $query->whereYear('actividades.fecha_final_actividad', $anio)
            //         ->orwhereYear('actividades.fecha_inicio_actividad', $anio);
            // })
            ->whereYear('actividades.fecha_inicio_actividad', $anio)
            ->distinct()
            ->count('actividades.id');
        return $cant;
    }
    public function porcentajeParticipacion($actividadesXPersonal)
    {
        $tipos = ReportesInvolucramientoController::TIPOS_ACT_INTERNAS;
        $porcentajesParticipacion = [];
        $cantPersonal = count($actividadesXPersonal);

        foreach ($actividadesXPersonal as &$personal) {

            foreach ($tipos as &$tipo) { //Se reccorre el array de los tipos de actividades internas
                if (!isset($porcentajesParticipacion[$tipo])) { //Se inicializa el porcentaje de parcipación según el tipo de actividad en 0
                    $porcentajesParticipacion[$tipo] = 0;
                }
                if ($personal[$tipo] > 0) { //En caso de que el personal haya tenido como mínimo 1 participación se suma dicho porcentaje
                    $porcentajesParticipacion[$tipo] = $porcentajesParticipacion[$tipo] +  (1 / $cantPersonal); //Se actualiza el array de porcentajes
                }
            }
        }
        // dd($porcentajesParticipacion);
        return $porcentajesParticipacion;
    }
}
