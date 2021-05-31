<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades_interna;
use App\Helper\GlobalArrays;
use App\Exceptions\ControllerFailedException;
use App\ActividadesPromocion;
use Carbon\Carbon;
use DB;
use App\Personal;
use App\ListaAsistencia;
use App\Persona;
use App\Actividades;

class ReportesInvolucramientoController extends Controller
{

    public function show()
    {
        try{
            //Las siguientes dos líneas de código arreglan el bug de las versiones de php > 7.1 con números flotantes
            ini_set('precision', 10);
            ini_set('serialize_precision', 10);
            $anio = date('Y');
            $porcentajeActualParticipacion = $this->porcentajeParticipacion($this->cantActividadesXPersonal($anio));
            $porcentajeActualAmbito = $this->porcentajeParticipacionAmbito($this->cantActividadesXPersonalAmbito($anio));
            $datosCuantitativos = $this->datosCuntitativosPersonal();
            $datos = null;
            $personal = null;
            $nombre = null;
            $estadoActividad = request('estado_actividad', null);
            return view('reportes.involucramiento.general', [
                'porcentajeActualParticipacion' => json_encode($porcentajeActualParticipacion, JSON_UNESCAPED_SLASHES),
                'porcentajeActualAmbito' => json_encode($porcentajeActualAmbito, JSON_UNESCAPED_SLASHES),
                'datosCuantitativos' => $datosCuantitativos,
                'datos' => $datos,
                'personal' => $personal,
                'estadoActividad' => $estadoActividad,
                'nombre' => $nombre
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
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


    public function tiposCargo()
    {
        $tiposCargo = ["Administrativo", "Académico"];
    }

    public function cantActividadesXPersonal($anio)
    {
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;
        $personal = DB::table("personal")->select("persona_id")->get(); //Inner join de personal con personas
        $dataSet = [];
        foreach ($personal as &$persona) {
            $personaTipos = [];
            foreach ($tipos as &$tipo) {
                $cant = $this->cantActividadesInternasXTipo($persona->persona_id, $tipo, $anio);
                $personaTipos[$tipo] =  $cant;
            }
            $dataSet[$persona->persona_id] = $personaTipos;
        }

        return $dataSet;
    }

    public function resultado(Request $request)
    {
        //Las siguientes dos líneas de código arreglan el bug de las versiones de php > 7.1 con números flotantes
        ini_set('precision', 10);
        ini_set('serialize_precision', 10);
        $personal = Personal::find($request->personal_encontrado);
        $persona = Persona::find($request->personal_encontrado);
        $nombre = $persona->nombre . " " . $persona->apellido;
        $mesInicio = $request->mes_inicio;
        $mesFinal = $request->mes_final;
        $estadoActividad = $request->estado_actividad;
        $dataSet = array();

        $actividadesPorTipos = $this->activadesPorTipos($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesPorFechas = $this->activadesPorFechas($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesPorAmbito = $this->activadesPorAmbito($personal, $mesInicio, $mesFinal, $estadoActividad);
        array_push($dataSet, $actividadesPorTipos);
        array_push($dataSet, $actividadesPorFechas);
        array_push($dataSet, $actividadesPorAmbito);

        $actividadesCoorPorTipos = $this->actividadesCoorPorTipos($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesCoorPorFechas = $this->activadesCoorPorFechas($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesCoorPorAmbito = $this->activadesCoorPorAmbito($personal, $mesInicio, $mesFinal, $estadoActividad);
        array_push($dataSet, $actividadesCoorPorTipos);
        array_push($dataSet, $actividadesCoorPorFechas);
        array_push($dataSet, $actividadesCoorPorAmbito);

        $actividadesFaciliPorTipos = $this->actividadesFaciliPorTipos($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesFaciliPorFechas = $this->actividadesFaciliPorFechas($personal, $mesInicio, $mesFinal, $estadoActividad);
        array_push($dataSet, $actividadesFaciliPorTipos);
        array_push($dataSet, $actividadesFaciliPorFechas);

        $datosCuantitativos = $this->datosCuntitativosPersonal();

        $anio = date('Y');
        $porcentajeActualParticipacion = $this->porcentajeParticipacion($this->cantActividadesXPersonal($anio));
        $porcentajeActualAmbito = $this->porcentajeParticipacionAmbito($this->cantActividadesXPersonalAmbito($anio));

        return view('reportes.involucramiento.general', [
            'porcentajeActualParticipacion' => json_encode($porcentajeActualParticipacion, JSON_UNESCAPED_SLASHES),
            'porcentajeActualAmbito' => json_encode($porcentajeActualAmbito, JSON_UNESCAPED_SLASHES),
            'datos' => json_encode($dataSet, JSON_UNESCAPED_SLASHES),
            'datosCuantitativos' => $datosCuantitativos,
            'personal' => $request->personal_encontrado,
            'nombre' => $nombre,
            'estadoActividad' => $estadoActividad,
            'mesInicio' => $mesInicio,
            'mesFinal' => $mesFinal
        ]);
    }

    public function activadesPorTipos($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = array();
        $fecha_ini = $mesInicio . "-01";
        $fecha_fin = $mesFinal . "-01";
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;

        foreach ($tipos as &$tipo) {
            $count = ListaAsistencia::join('actividades', 'actividades.id', '=', 'lista_asistencias.actividad_id')
                ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->where('persona_id', '=', $personal->persona_id)
                ->where('actividades.estado', 'like', '%' .   $estado . '%')
                ->where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
                ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
                ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
                ->count();
            array_push($dataSet, $count);
        }

        return array_combine($tipos, $dataSet);
    }

    public function actividadesCoorPorTipos($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = array();

        $fecha_ini = $mesInicio . "-01";
        $fecha_fin = $mesFinal . "-01";
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;

        foreach ($tipos as &$tipo) {
            $count = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->where('actividades.responsable_coordinar', '=', $personal->persona_id)
                ->where('actividades.estado', 'like', '%' .   $estado . '%')
                ->where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
                ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
                ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
                ->count();
            array_push($dataSet, $count);
        }

        return array_combine($tipos, $dataSet);
    }

    public function activadesPorFechas($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = [];

        $anio_ini = (int)substr($mesInicio, 0, 4);
        $anio_fin = (int)substr($mesFinal, 0, 4);
        $mes_ini = (int)substr($mesInicio, 5, strlen($mesFinal));
        $mes_fin = (int)substr($mesFinal, 5, strlen($mesFinal));

        $DA = $anio_fin - $anio_ini;
        $DM = $mes_fin - $mes_ini;
        $cont = 1;

        if ($DA == 0) {
            for ($i = $mes_ini; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActAsisPorMes($i, $personal, $anio_ini, $estado, $dataSet);
                $dataSet[$anio_ini . "-" . $i] =  $actvidadesPorMes;
            }
        } else if ($DA >= 1) {
            $anios_completos = $DA - 1;
            $anio = $anio_ini;
            //? Primer extremo
            for ($i = $mes_ini; $i <= 12; $i++) {
                $actvidadesPorMes = $this->cantActAsisPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }

            $anio++; //?Se amuenta el año
            //?Años intermedios que se deben contar COMPLETOS (Todos los 12 meses del año)
            for ($i = 1; $i <= $anios_completos; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $actvidadesPorMes = $this->cantActAsisPorMes($j, $personal, $anio, $estado, $dataSet);
                    $dataSet[$anio . "-" . $j] =  $actvidadesPorMes;
                }
                $anio++;
            }

            //? Segundo extremo
            for ($i = 1; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActAsisPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }
        }

        return $dataSet;
    }

    public function cantActAsisPorMes($mes, $personal, $anio, $estado, &$dataSet)
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

        $cantAct = ListaAsistencia::join('actividades', 'actividades.id', '=', 'lista_asistencias.actividad_id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where('persona_id', '=', $personal->persona_id)
            ->where('actividades.estado', 'like', '%' .   $estado . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();

        return $cantAct;
    }

    public function activadesCoorPorFechas($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = [];

        $anio_ini = (int)substr($mesInicio, 0, 4);
        $anio_fin = (int)substr($mesFinal, 0, 4);
        $mes_ini = (int)substr($mesInicio, 5, strlen($mesFinal));
        $mes_fin = (int)substr($mesFinal, 5, strlen($mesFinal));

        $DA = $anio_fin - $anio_ini;
        $DM = $mes_fin - $mes_ini;
        $cont = 1;

        if ($DA == 0) {
            for ($i = $mes_ini; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActCoorPorMes($i, $personal, $anio_ini, $estado, $dataSet);
                $dataSet[$anio_ini . "-" . $i] =  $actvidadesPorMes;
            }
        } else if ($DA >= 1) {
            $anios_completos = $DA - 1;
            $anio = $anio_ini;
            //? Primer extremo
            for ($i = $mes_ini; $i <= 12; $i++) {
                $actvidadesPorMes = $this->cantActCoorPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }

            $anio++; //?Se amuenta el año
            //?Años intermedios que se deben contar COMPLETOS (Todos los 12 meses del año)
            for ($i = 1; $i <= $anios_completos; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $actvidadesPorMes = $this->cantActCoorPorMes($j, $personal, $anio, $estado, $dataSet);
                    $dataSet[$anio . "-" . $j] =  $actvidadesPorMes;
                }
                $anio++;
            }

            //? Segundo extremo
            for ($i = 1; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActCoorPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }
        }

        return $dataSet;
    }

    public function cantActCoorPorMes($mes, $personal, $anio, $estado, &$dataSet)
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
            ->where('actividades.responsable_coordinar', '=', $personal->persona_id)
            ->where('actividades.estado', 'like', '%' .   $estado . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();

        return $cantAct;
    }

    public function activadesPorAmbito($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = array();

        $ambitos =  GlobalArrays::AMBITOS_ACTIVIDAD;
        $fecha_ini = $mesInicio . "-01";
        $fecha_fin = $mesFinal . "-01";

        foreach ($ambitos as &$ambito) {
            $count = ListaAsistencia::join('actividades', 'actividades.id', '=', 'lista_asistencias.actividad_id')
                ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->where('persona_id', '=', $personal->persona_id)
                ->where('actividades.estado', 'like', '%' .   $estado . '%')
                ->where('actividades_internas.ambito', '=', $ambito)
                ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
                ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
                ->count();
            array_push($dataSet, $count);
        }

        return array_combine($ambitos, $dataSet);
    }

    public function activadesCoorPorAmbito($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = array();

        $ambitos =  GlobalArrays::AMBITOS_ACTIVIDAD;
        $fecha_ini = $mesInicio . "-01";
        $fecha_fin = $mesFinal . "-01";

        foreach ($ambitos as &$ambito) {
            $count = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->where('actividades.responsable_coordinar', '=', $personal->persona_id)
                ->where('actividades.estado', 'like', '%' .   $estado . '%')
                ->where('actividades_internas.ambito', '=', $ambito)
                ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
                ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
                ->count();
            array_push($dataSet, $count);
        }

        return array_combine($ambitos, $dataSet);
    }

    public function obtenerPersonal($idPersonal)
    {
        $datos = array();

        $persona = Persona::find($idPersonal); //Busca a la persona en la base de datos de personas
        if (is_null($persona)) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        }

        $personal = Personal::find($idPersonal); //Busca al personal en la base de datos de personas
        if (is_null($personal)) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        }


        array_push($datos, $persona);
        array_push($datos, $personal);

        return response()->json($datos, 200);
    }

    public function cantActividadesInternasXTipo($persona_id, $tipo, $anio)
    {
        $cant = Actividades::leftJoin('lista_asistencias', 'lista_asistencias.actividad_id', '=', 'actividades.id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($persona_id) {
                $query->where("actividades.responsable_coordinar", "=", $persona_id)
                    ->orwhere("actividades_internas.personal_facilitador", "=", $persona_id)
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
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;
        $porcentajesParticipacion = [];
        $cantPersonal = count($actividadesXPersonal);
        foreach ($actividadesXPersonal as $personal) {
            foreach ($tipos as $tipo) { //Se reccorre el array de los tipos de actividades internas
                if (!isset($porcentajesParticipacion[$tipo])) { //Se inicializa el porcentaje de parcipación según el tipo de actividad en 0
                    $porcentajesParticipacion[$tipo] = 0;
                }
                if ($personal[$tipo] > 0) { //En caso de que el personal haya tenido como mínimo 1 participación se suma dicho porcentaje
                    $porcentajesParticipacion[$tipo] +=  round(((1 / $cantPersonal) * 100), 1); //Se actualiza el array de porcentajes
                }
            }
        }
        return $porcentajesParticipacion;
    }

    public function cantActividadesXPersonalAmbito($anio)
    {
        $ambitos =  GlobalArrays::AMBITOS_ACTIVIDAD;
        $personal = \DB::table('personal')
            ->select('persona_id')->get();
        $dataSet = [];

        foreach ($personal as &$persona) {
            $personaAmbito = [];
            foreach ($ambitos as &$ambito) {
                $cant = $this->cantActividadesInternasXAmbito($persona->persona_id, $ambito, $anio);
                $personaAmbito[$ambito] =  $cant;
            }
            $dataSet[$persona->persona_id] = $personaAmbito;
        }
        // dd($dataSet);
        $this->porcentajeParticipacionAmbito($dataSet);

        return $dataSet;
    }

    public function cantActividadesInternasXAmbito($persona_id, $ambito, $anio)
    {
        $cant = Actividades::leftJoin('lista_asistencias', 'lista_asistencias.actividad_id', '=', 'actividades.id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($persona_id) {
                $query->where("actividades.responsable_coordinar", "=", $persona_id)
                    ->orwhere("actividades_internas.personal_facilitador", "=", $persona_id)
                    ->orwhere("lista_asistencias.persona_id", "=", $persona_id);
            })
            ->Where('actividades_internas.ambito', 'like', '%' .   $ambito . '%')
            ->where(function ($query) {
                $query->where('actividades.estado', '=', 'Ejecutada')
                    ->orWhere('actividades.estado', '=', 'En progreso');
            })
            ->whereYear('actividades.fecha_inicio_actividad', $anio)
            ->distinct()
            ->count('actividades.id');
        return $cant;
    }

    public function porcentajeParticipacionAmbito($actividadesXPersonal)
    {
        $ambitos =  GlobalArrays::AMBITOS_ACTIVIDAD;
        $porcentajesParticipacion = [];
        $cantPersonal = count($actividadesXPersonal);

        foreach ($actividadesXPersonal as &$personal) {

            foreach ($ambitos as &$ambito) { //Se reccorre el array de los tipos de actividades internas
                if (!isset($porcentajesParticipacion[$ambito])) { //Se inicializa el porcentaje de parcipación según el ambito de actividad en 0
                    $porcentajesParticipacion[$ambito] = 0;
                }
                if ($personal[$ambito] > 0) { //En caso de que el personal haya tenido como mínimo 1 participación se suma dicho porcentaje
                    $porcentajesParticipacion[$ambito] = round($porcentajesParticipacion[$ambito] + (1 / $cantPersonal) * 100, 2); //Se actualiza el array de porcentajes
                }
            }
        }
        //dd($porcentajesParticipacion);
        return $porcentajesParticipacion;
    }

    public function actividadesFaciliPorTipos($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = array();

        $fecha_ini = $mesInicio . "-01";
        $fecha_fin = $mesFinal . "-01";
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;

        foreach ($tipos as &$tipo) {
            $count = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
                ->where('actividades_internas.personal_facilitador', '=', $personal->persona_id)
                ->where('actividades.estado', 'like', '%' .   $estado . '%')
                ->where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
                ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
                ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
                ->count();
            array_push($dataSet, $count);
        }

        return array_combine($tipos, $dataSet);
    }

    public function actividadesFaciliPorFechas($personal, $mesInicio, $mesFinal, $estado)
    {
        $dataSet = [];

        $anio_ini = (int)substr($mesInicio, 0, 4);
        $anio_fin = (int)substr($mesFinal, 0, 4);
        $mes_ini = (int)substr($mesInicio, 5, strlen($mesFinal));
        $mes_fin = (int)substr($mesFinal, 5, strlen($mesFinal));

        $DA = $anio_fin - $anio_ini;
        $DM = $mes_fin - $mes_ini;
        $cont = 1;

        if ($DA == 0) {
            for ($i = $mes_ini; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActFaciliPorMes($i, $personal, $anio_ini, $estado, $dataSet);
                $dataSet[$anio_ini . "-" . $i] =  $actvidadesPorMes;
            }
        } else if ($DA >= 1) {
            $anios_completos = $DA - 1;
            $anio = $anio_ini;
            //? Primer extremo
            for ($i = $mes_ini; $i <= 12; $i++) {
                $actvidadesPorMes = $this->cantActFaciliPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }

            $anio++; //?Se amuenta el año
            //?Años intermedios que se deben contar COMPLETOS (Todos los 12 meses del año)
            for ($i = 1; $i <= $anios_completos; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $actvidadesPorMes = $this->cantActFaciliPorMes($j, $personal, $anio, $estado, $dataSet);
                    $dataSet[$anio . "-" . $j] =  $actvidadesPorMes;
                }
                $anio++;
            }

            //? Segundo extremo
            for ($i = 1; $i <= $mes_fin; $i++) {
                $actvidadesPorMes = $this->cantActFaciliPorMes($i, $personal, $anio, $estado, $dataSet);
                $dataSet[$anio . "-" . $i] =  $actvidadesPorMes;
            }
        }

        return $dataSet;
    }

    public function cantActFaciliPorMes($mes, $personal, $anio, $estado, &$dataSet)
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
            ->where('actividades_internas.personal_facilitador', '=', $personal->persona_id)
            ->where('actividades.estado', 'like', '%' .   $estado . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();

        return $cantAct;
    }
}
