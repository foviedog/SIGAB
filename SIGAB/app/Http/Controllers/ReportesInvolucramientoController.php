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
                
            $anio = date('Y');
            $porcentajeActualParticipacion = $this->porcentajeParticipacion($this->cantActividadesXPersonal($anio));
            $porcentajeActualAmbito = $this->porcentajeParticipacionAmbito($this->cantActividadesXPersonalAmbito($anio));
            $datosCuantitativos = $this->datosCuntitativosPersonal();
            $datos = null;
            $personal = null;
            $nombre = null;
            $estadoActividad = request('estado_actividad', null);
            return view('reportes.involucramiento.detalle', [
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

    public function reporteAnual()
    {
        $anioInicio = request('anio_inicio', null);
        $anioFinal = request('anio_final', null);
        $actividadesXAnio  = null;
        $graficosInvolucramiento  = null;

        if (!is_null($anioInicio) && !is_null($anioFinal)) {
            $dataSet = $this->involucramientoAnual($anioInicio, $anioFinal);
            $actividadesXAnio = $dataSet[0];
            $graficosInvolucramiento = $dataSet[1];
        }

        $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id')->get()->keyBy('persona_id'); //Inner join de personal con personas
        return view('reportes.involucramiento.reporte_anual', [
            'graficosInvolucramiento' => json_encode($graficosInvolucramiento, JSON_UNESCAPED_SLASHES),
            'actividadesXAnio' => $actividadesXAnio,
            'personal' => $personal,
            'anioInicio' => $anioInicio,
            'anioFinal' => $anioFinal,
        ]);
    }
    public function involucramientoAnual($anioInicio, $anioFinal)
    {

        $actividadesAnio = []; //Colección para guarfar todas los conjuntos de datos referentes al id de la persona y las actividades en las que se ha involucrado
        $graficosInvolucramiento = []; //Colección para guardar los porcentajes de participación del año determinado

        //Se realiza la búsqueda según el rango de años que se haya digitado
        //Por efectos de tiempo de ejecución se decide devolver un array que contenga los dos tados (actividadesXPersonal y porcentajeParticipación)
        //De esta manera el método "cantActividadesXPersonal" solamente se ejecuta 1 vez.
        for ($anio = $anioInicio; $anio <= $anioFinal; $anio++) {
            $actividadesPersonal =  $this->cantActividadesXPersonal($anio); //Se obtien la cantidad de actividades por personal
            $actividadesAnio[$anio] = $actividadesPersonal; //Se almacena el dato según el año consultado
            $graficosInvolucramiento[$anio] = $this->porcentajeParticipacion($actividadesPersonal); //Se consulta sobre el porcentaje de todo el personal y se guarda en formato JSON según el año
        }
        return [$actividadesAnio, $graficosInvolucramiento];
    }
    public function tiposCargo()
    {
        $tiposCargo = ["Administrativo", "Académico"];
    }

    public function jornadaLaboral()
    {
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
        //!! Esto no está duplicado? NOOPE, una es de coordinacion y la otra de asistencia, rasta
        $actividadesCoorPorTipos = $this->actividadesCoorPorTipos($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesCoorPorFechas = $this->activadesCoorPorFechas($personal, $mesInicio, $mesFinal, $estadoActividad);
        $actividadesCoorPorAmbito = $this->activadesCoorPorAmbito($personal, $mesInicio, $mesFinal, $estadoActividad);
        array_push($dataSet, $actividadesCoorPorTipos);
        array_push($dataSet, $actividadesCoorPorFechas);
        array_push($dataSet, $actividadesCoorPorAmbito);

        $datosCuantitativos = $this->datosCuntitativosPersonal();

        $anio = date('Y');
        $porcentajeActualParticipacion = $this->porcentajeParticipacion($this->cantActividadesXPersonal($anio));
        $porcentajeActualAmbito = $this->porcentajeParticipacionAmbito($this->cantActividadesXPersonalAmbito($anio));

        return view('reportes.involucramiento.detalle', [
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
        $tipos = $this->devolverTiposActividades(0);

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
        $tipos = $this->devolverTiposActividades(0);

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

    public function devolverTiposActividades($act)
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
        $tipos = GlobalArrays::TIPOS_ACTIVIDAD_INTERNA;
        $porcentajesParticipacion = [];
        $cantPersonal = count($actividadesXPersonal);

        foreach ($actividadesXPersonal as &$personal) {
            foreach ($tipos as &$tipo) { //Se reccorre el array de los tipos de actividades internas
                if (!isset($porcentajesParticipacion[$tipo])) { //Se inicializa el porcentaje de parcipación según el tipo de actividad en 0
                    $porcentajesParticipacion[$tipo] = 0;
                }
                if ($personal[$tipo] > 0) { //En caso de que el personal haya tenido como mínimo 1 participación se suma dicho porcentaje
                    $porcentajesParticipacion[$tipo] = $porcentajesParticipacion[$tipo] +  (1 / $cantPersonal) * 100; //Se actualiza el array de porcentajes
                }
            }
        }
        // dd($porcentajesParticipacion);
        return $porcentajesParticipacion;
    }

    public function cantActividadesXPersonalAmbito($anio)
    {
        $ambitos = ["Nacional", "Internacional"];
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
        $cant = Actividades::join('lista_asistencias', 'lista_asistencias.actividad_id', '=', 'actividades.id')
            ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($persona_id) {
                $query->where("actividades.responsable_coordinar", "=", $persona_id)
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
        $ambitos = ["Nacional", "Internacional"];
        $porcentajesParticipacion = [];
        $cantPersonal = count($actividadesXPersonal);

        foreach ($actividadesXPersonal as &$personal) {

            foreach ($ambitos as &$ambito) { //Se reccorre el array de los tipos de actividades internas
                if (!isset($porcentajesParticipacion[$ambito])) { //Se inicializa el porcentaje de parcipación según el ambito de actividad en 0
                    $porcentajesParticipacion[$ambito] = 0;
                }
                if ($personal[$ambito] > 0) { //En caso de que el personal haya tenido como mínimo 1 participación se suma dicho porcentaje
                    $porcentajesParticipacion[$ambito] = $porcentajesParticipacion[$ambito] +  (1 / $cantPersonal) * 100; //Se actualiza el array de porcentajes
                }
            }
        }
        //dd($porcentajesParticipacion);
        return $porcentajesParticipacion;
    }
}
