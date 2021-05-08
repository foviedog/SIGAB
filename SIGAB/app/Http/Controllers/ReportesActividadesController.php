<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Helper\GlobalArrays;
use App\Exceptions\ControllerFailedException;
use Carbon\Carbon;
use DateTime;
use PDF;
use App\Actividades;
use App\Actividades_interna;
use App\ActividadesPromocion;

class ReportesActividadesController extends Controller
{

    // ========================================================================================================================================
    // Función utilizada para procesar el request de mostrar la vista de reportes de actividades
    // ========================================================================================================================================
    public function show()
    {
        try{

            //Se obtienen los datos que sean necesarios para la generación de estadísticas
            //(A pesar de que no sean necesarios en un inicio es para evitar confictos con la recuperación de datos digitados en la elaboración de un request al servidor)
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
            $propositosDelAnio = $this->propositosActividad(); //Se obtiene el gráfico de cantidad de actividades según propósitos del año actual
            $estadosDelAnio = $this->estadosActividades(); //Se obtiene el gráfico de cantidad de actividades según estadis del año actual

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
                'propositosDelAnio' => json_encode($propositosDelAnio, JSON_UNESCAPED_SLASHES), //Se formatea el gráfico a JSON para utilizarlo en la API de JS
                'estadosDelAnio' => json_encode($estadosDelAnio, JSON_UNESCAPED_SLASHES) //Se formatea el gráfico a JSON para utilizarlo en la API de JS
            ]);
            
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    // ========================================================================================================================================
    // Función utilizada para procesar el request de generar un gráfico
    // ========================================================================================================================================
    public function resultado(Request $request)
    {
        try{

            //Se setean los tipos según la naturaleza de la actividad (Interna o promoción)
            $tip_act_int = $this->devolverTipos(0);
            $tip_act_prom = $this->devolverTipos(1);

            //Se obtienen los datos que se hayan digitado en el formulario de generación de estadísticas
            $chart = $request->tipo_grafico;
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
            //Se llama al algoritmo para la obtención de actividades realizadas según las fecahs
            $datos = $this->obtenerDatos($mesInicio, $mesFinal, $naturalezaAct, $tipoAct, $estadoActividad);
            $datosCuantitativos = $this->datosCuantitativosActividades(); //Se obtienen los datos cuantitativos que están ubicados encima de la página
            $propositosDelAnio = $this->propositosActividad(); //Se obtiene el gráfico de cantidad de actividades según propósitos del año actual
            $estadosDelAnio = $this->estadosActividades(); //Se obtiene el gráfico de cantidad de actividades según estadis del año actual

            //Se devuelve a la misma vista con los mismos datos de la búsqueda que haya realizado
            return view('reportes.actividades.detalle', [
                'chart' => $chart,
                'tip_act_int' => $tip_act_int,
                'tip_act_prom' => $tip_act_prom,
                'datos' => json_encode($datos, JSON_UNESCAPED_SLASHES), //Se formatea el gráfico a JSON para utilizarlo en la API de JS
                'datosCuantitativos' => $datosCuantitativos,
                'naturalezaAct' => $naturalezaAct,
                'tipoAct' => $tipoAct,
                'mesInicio' => $mesInicio,
                'mesFinal' => $mesFinal,
                'estadoActividad' => $estadoActividad,
                'propositosDelAnio' => json_encode($propositosDelAnio, JSON_UNESCAPED_SLASHES), //Se formatea el gráfico a JSON para utilizarlo en la API de JS
                'estadosDelAnio' => json_encode($estadosDelAnio, JSON_UNESCAPED_SLASHES) //Se formatea el gráfico a JSON para utilizarlo en la API de JS
            ]);
            
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    // ========================================================================================================================================
    // Algoritmo para la obtención de la cantidad de actividades según los siguientes datos:
    // naturaleza de la actividad, estado y tipo
    // Según cada uno de los meses que se encuentren en el rango de fechas seleccionado
    // ========================================================================================================================================
    public function obtenerDatos($mes_inicio, $mes_final, $naturalezaAct, $tipo, $estado)
    {
        $anio_ini = (int)substr($mes_inicio, 0, 4);
        $anio_fin = (int)substr($mes_final, 0, 4);
        $mes_ini = (int)substr($mes_inicio, 5, strlen($mes_final));
        $mes_fin = (int)substr($mes_final, 5, strlen($mes_final));

        $DA = $anio_fin - $anio_ini; //Difrencia que existe entre el rango de años
        $DM = $mes_fin - $mes_ini; //Diferencia existente entre el rango de meses
        $cont = 1; //Contador que incia en enero (1) en el caso de que haya más de 1 año de diferencia
        $datos = [];
        //Si el rango de meses se encuentra en el mismo año
        if ($DA == 0) {
            //Se realiza la consulta según el rango que existe entre el mes de inicio y el mes final
            for ($i = $mes_ini; $i <= $mes_fin; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio_ini, $estado, $tipo, $datos);
            }
        } //En caso de que la diferencia sea mayor a 1 año
        else if ($DA >= 1) {
            $anios_completos = $DA - 1; //Se obtiene la cantidad de años completos (12 meses) en los que se tiene que realizar la consulta
            $anio = $anio_ini; //Se inicializa un año axiliar para aumentarlo en el caso de que el rango de tiempo amerite iterar en más de 1 año en específico
            //? Primer extremo:
            // Se obtienen los datos del primer rango de meses, el cual no siempre empieza en Enero, por lo cual se debe obener
            // desde el mes de inico hasta Diciembre de ese mismo año
            for ($i = $mes_ini; $i <= 12; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
            }

            $anio++; //Se amuenta el año axiliar devido a que se terminó el primer rango de fechas
            //?Años intermedios:
            // Iteración de todos aquellos años que se encuentren en el rango de fechas y deba de contarse completos (12 meses)
            for ($i = 1; $i <= $anios_completos; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $this->agregarDatos($j, $naturalezaAct, $anio, $estado, $tipo, $datos);
                }
                $anio++;
            }

            //? Segundo extremo:
            //Se obtienen los datos que se encuentren en el segundo extremo del rango de fechas,
            //el cual va de enero del año final al mes final que se haya digitado
            for ($i = 1; $i <= $mes_fin; $i++) {
                $this->agregarDatos($i, $naturalezaAct, $anio, $estado, $tipo, $datos);
            }
        }

        return $datos; //Se retorna el conjunto de datos que contiene la cantidad de actividades según el mes
    }

    // ========================================================================================================================================
    // Función que obtiene los datos de la BD según la naturuleza de la actividad
    // ========================================================================================================================================
    private function agregarDatos($mes, $naturalezaAct, &$anio, $estado, $tipo, &$datos)
    {
        if ($naturalezaAct == "Actividad interna") {
            $actvidadesPorMes = $this->cantActividadInterPorMes($mes, $anio, $estado, $tipo);
        } else {
            $actvidadesPorMes = $this->cantActividadPromPorMes($mes, $anio, $estado, $tipo);
        }
        $datos[$anio . "-" . $mes] =  $actvidadesPorMes;
    }

    // ========================================================================================================================================
    // Función que devuelve utiliza una consulta de BD para obtener la cantidad de actividades internas generadas según 1 mes en específico
    // ========================================================================================================================================
    public function cantActividadInterPorMes($mes, $anio, $estado, $tipo)
    {
        //* Se considera un rango de meses de la siguiente forma:
        //* 2021-enero-01 al 2021-febrero-01 donde se excluyen la fecha final
        //* De esta manera se puede obtener todos los tatos que se encuentren en el mes de enero
        //** ESTO DIFIERE EN EL CASO DE QUE EL MES DE INICIO SEA DICIEMBRE
        $mesIni = (int)$mes; //Se parsea el mes entrante en tipo int para poder realizar operaciones matemáticas con él (suma)
        $mesFin = $mesIni + 1; //Se le suma 1 al mes entrante para poder obtener todos los datos que se encuentren en enero
        $mesStr = (string)$mes;
        $mesStrFin = (string)($mesFin);

        //En caso de que el mes sea menor a 9 se le agrega un 0 en la parte de adelante para que cumpla con el formato de la BD
        if ($mes < 9) {
            $mesStr = "0" . $mesStr;
            $mesStrFin = "0" . $mesFin;
        }
        //Se crean las fechas de inicio y de final según el formato presente en la BD
        $fecha_ini = $anio . "-" . $mesStr . "-01";
        $fecha_fin = $anio  . "-" . $mesStrFin . "-01";

        //En caso de que sea diciembre se le suma al año y no al mes
        if ($mes == 12) {
            $fecha_fin =  $anio + 1 . "-01" . "-01";
        }

        // Se realiza la consulta a la BD
        $cantAct = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->Where('actividades.estado', 'like', '%' .   $estado . '%')
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo . '%')
            ->where('actividades.fecha_inicio_actividad', '>=', $fecha_ini)
            ->where('actividades.fecha_inicio_actividad', '<', $fecha_fin)
            ->count();
        return $cantAct;
    }


    // ============================================================================================================================
    // Función que devuelve utiliza una consulta de BD para obtener la cantidad de actividades de promoción generadas según 1 mes en específico
    // ============================================================================================================================
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


    // ============================================================================================================================
    // Función que devuelve los tipos de actividad según el número que se digital
    // !considerar cambiar esto como una constante, como una tabla en la base detados XOR incluirlo como parte de una clase que contenga variables globales
    // ============================================================================================================================
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

    // ============================================================================================================================
    // Función que genera un array con los datos cuantitativos automáticos del dashboard de actividades
    // ============================================================================================================================
    private function datosCuantitativosActividades()
    {
        $cantPromocion = ActividadesPromocion::count(); //Obtiene la cantidad de acitvidades de promoción que se han realizado
        $cantInternas = Actividades_interna::count(); //Obtiene la cantidad de actividades internas que se han realizado
        $cantResponsables = Actividades::distinct('responsable_coordinar')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->count('responsable_coordinar'); //Obtiene la cantidad de responsables de actividades a lo largo del tiempo, únicamente
        return [$cantPromocion, $cantInternas, $cantResponsables];
    }


    // ============================================================================================================================
    // Función que genera un conjunto de datos utilizados para la generación autómatica
    // del gráfico de actividades del año actual según los el propósito
    // ============================================================================================================================
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

    // ============================================================================================================================
    // Función que genera un conjunto de datos utilizados para la generación autómatica
    // del gráfico de actividades del año actual según los estádos
    // ============================================================================================================================
    private function estadosActividades()
    {   //? Analizar la futura creación de una tabla en la BD que contenga todos los posibles estados
        $estados = ["En progreso", "Para ejecución", "Ejecutada", "Cancelada"]; //Se crea un array con todos los estados existentes
        $anioActual = (string) Carbon::now()->format('Y');
        $fechaIni = $anioActual . "-01-01"; //Se setea la fecha inicial para enero del año actual del servidor
        $fechaFin = $anioActual . "-12-31"; //Se setea la fecha final para diciembre del año actual del servidor
        $dataSet = []; //Se inicializa el conjunto de datos en vacío
        //Se recorre cada uno de los estados para realizar la búsqueda de cantidad de actividades según estados en el año actual
        foreach ($estados as &$estado) {
            //Se realiza la consulta a la base de datos
            $estadosActividades = Actividades::select("fecha_final_actividad as fecha_fin")
                ->Where('actividades.estado', 'like', '%' .   $estado . '%')
                ->whereBetween('fecha_final_actividad', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
                ->count(); //Obtiene la cantidad de actividades que cuentan con el estado en el que se está iterando
            $dataSet[$estado] = $estadosActividades; //Se asocia la consulta de la BD con el estado en el que se está iterando
        }

        return $dataSet;
    }

    // ==============================================================
    // Función utilizada para generar el reporte en una página aparte
    // ==============================================================
    public function obtReporte(Request $request)
    {
        //Se obtiene la imagen deL logo UNA y de la EBDI, en el formato "base64" para poderla renderizar directamente en la página del reporte
        $logoUNA = 'data:image/png;base64,' . base64_encode(File::get(public_path() . '/img/logo-UNA.png'));
        $logoEBDI = 'data:image/png;base64,' . base64_encode(File::get(public_path() . '/img/logoEBDI.png'));
        $annioActual = date("Y"); //Se obtiene el año actual del servidor
        date_default_timezone_set("America/Costa_Rica"); //Se obtiene la hora, minutos y segundos del servidor
        $consultado = 'Consultado el ' . date("d/m/Y") . ' a las ' . date('h:i:sa') . '.'; //Se crea la leyenda de "consultado en"
        //Se retorna la vista en la que se puede realizar la impresión o descarga del reporte
        return view('reportes.actividades.reporte', [
            'image' => $request->image, //Se obtiene la imagen (en formato base64) del gráfico que se generó por medio de la consulta
            'titulo' => $request->titulo, //Se ibtiene el título que la persona haya digitado en el modal
            'logoUNA' => $logoUNA,
            'logoEBDI' => $logoEBDI,
            'annioActual' => $annioActual,
            'consultado' => $consultado
        ]);
    }
}
