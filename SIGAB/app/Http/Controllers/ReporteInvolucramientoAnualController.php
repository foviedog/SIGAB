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
use DB;


class ReporteInvolucramientoAnualController extends Controller
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
        try {
            $anioInicio = request('anio_inicio', null);
            $anioFinal = request('anio_final', null);
            $actividadesXAnio  = null;
            $graficosInvolucramiento  = null;
            $datosCuantitativos = $this->datosCuantitativosPersonal();

            if (!is_null($anioInicio) && !is_null($anioFinal)) {
                $dataSet = $this->involucramientoAnual($anioInicio, $anioFinal);
                $actividadesXAnio = $dataSet[0];
                $graficosInvolucramiento = $dataSet[1];
            }

            $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id')->get()->keyBy('persona_id'); //Inner join de personal con personas
            return view('reportes.involucramiento.anual.involucramiento_anual', [
                'graficosInvolucramiento' => json_encode($graficosInvolucramiento, JSON_UNESCAPED_SLASHES),
                'datosCuantitativos' => $datosCuantitativos,
                'actividadesXAnio' => $actividadesXAnio,
                'personal' => $personal,
                'anioInicio' => $anioInicio,
                'anioFinal' => $anioFinal,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        } catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    public function datosCuantitativosPersonal()
    {
        $interinos = Personal::where("tipo_nombramiento", "Interino")->count();
        $propietarios = Personal::where("tipo_nombramiento", "Propietario")->count();
        $fijo = Personal::where("tipo_nombramiento", "Plazo fijo")->count();
        $total = Personal::count();
        return [$interinos, $propietarios, $fijo, $total];
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

    // ==============================================================
    // Función utilizada para generar el reporte en una página aparte
    // ==============================================================
    public function reporte(Request $request)
    {
        date_default_timezone_set("America/Costa_Rica"); //Se obtiene la hora, minutos y segundos del servidor
        $consultado = 'Consultado el ' . date("d/m/Y") . ' a las ' . date('h:i:sa') . '.'; //Se crea la leyenda de "consultado en"
        //Se retorna la vista en la que se puede realizar la impresión o descarga del reporte
        $personal = json_decode($request->personal,true);
        $actividadesXAnio =  json_decode($request->actividadesXAnio,true);
        $graficosInvolucramiento = $request->graficosInvolucramiento;
        $anioInicio =  json_decode($request->anioInicio);
        $anioFinal =  json_decode($request->anioFinal);
        // dd($actividadesXAnio);
        return view('reportes.involucramiento.anual.reporte', [
            'graficosInvolucramiento' => $graficosInvolucramiento,
            'actividadesXAnio' => $actividadesXAnio,
            'personal' => $personal,
            'anioInicio' => $anioInicio,
            'anioFinal' => $anioFinal,
            'consultado' => $consultado
        ]);
    }
}
