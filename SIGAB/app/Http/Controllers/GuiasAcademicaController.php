<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Estudiante;
use App\Guias_academica;

class GuiasAcademicaController extends Controller
{

    //Método que obtiene una cedula por medio del request, devuelve ese estudiante espefico junto con la vista para crear una guia academica
    public function create($id_estudiante)
    {
        //Se obtiene el atributo de cédula que viene en el request y en caso de que no se encuentre seteado se pone en blanco
        $aceptado = request('aceptado', false);

        $estudiante = Estudiante::findOrFail($id_estudiante);

        if ($aceptado == 'true') {
            return view('control_educativo.informacion_guias_academicas.registrar', [
                'estudiante' => $estudiante,
            ]);
        }
        return response()->json($estudiante, 200);
    }

    //Método que inserta una guia academica de un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores
            //Se crea una nueva instacia de guías académicas.
            $guia = new Guias_academica;

            //se setean los atributos del objeto
            $guia->persona_id = $request->persona_id;
            $guia->motivo = $request->motivo;
            $guia->fecha = $request->fecha;
            $guia->ciclo_lectivo = $request->ciclo;
            $guia->situacion = $request->situacion;
            $guia->lugar_atencion = $request->lugar;
            $guia->recomendaciones = $request->recomendaciones;
            //se guarda el objeto en la base de datos
            $guia->save();

            //se redirecciona a la pagina de registro de guias academicas con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('gua_academica_insertada', $guia); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }


    //Método iniciaal que devuelve el listado de guías con respecto a filtros
    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [10, 25, 50, 100];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 10 por página
        $itemsPagina = request('itemsPagina', 10);

        $filtro = request('nombreFiltro', NULL); //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $fechaIni = request('fechaIni', NULL); //Se recibe del request con el valor final del rango de fechas, si dicho valor no está seteado se pone en NULL
        $fechaFin = request('fechaFin', NULL); //Se recibe del request con el valor final del rango de fechas, si dicho valor no está seteado se pone en NULL

        //En caso de que el filtro de intervalo de fechas se encuentre dentro del request entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($fechaIni) && !is_null($fechaFin)) {
            $guias = $this->filtroFechaNombre($fechaIni, $fechaFin, $filtro, $itemsPagina); //Retorna la lista de guías con respecto a las fechas especificadas
        } else if (!is_null($filtro)) { // En caso de que se busque únicamente el nombre,apellido o cédula de la persona se ejecuta la búsqueda por nombre
            $guias = $this->filtroNombre($filtro, $itemsPagina); //Búsqueda en la BD del por nombre, apellido o cédula
        } else { //Si no se adjunta ningún filtro de búsqueda se devuelve un listado de los estudiantes
            $guias = $this->obtenerGuias($itemsPagina);
        }

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_guias_academicas.listado', [
            'guias' => $guias, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro, // Valor del filtro que se haya hecho para mantenerlo en la página
            'fechaIni' => $fechaIni, // Valor del filtro que se haya hecho para mantenerlo en la página
            'fechaFin' => $fechaFin // Valor del filtro que se haya hecho para mantenerlo en la página
        ]);
    }

    // Método que muestra una guía específica de un estudiante.
    public function show($id_guia)
    {
        // Se realiza una búsqueda en la BD respecto a la guía específica del estudiante que se alla seleccionado.
        $guia = Guias_academica::join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de guias con personas
            ->join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con guías académicas
            ->where('guias_academicas.id', '=',  $id_guia) // Limita los resultados a la única guía que exista con el ID seleccionado
            ->first(); // Obtener únicamente a la guía a la que se ha consultado.

        return response()->json($guia, 200); // Retorna el resultado por medio de un atributo JSON en la respuesta al AJAX del documento js/control_educativo/información_guias_academicas/listado.js
    }

    public function update($id_graduacion, Request $request)
    {
        //Busca la graduación en la base de datos
        $graduacion = Guias_academica::find($id_graduacion);

        //Al la graduación encontrada se le actualizan los atributos
        $graduacion->motivo = $request->motivo;
        $graduacion->fecha = $request->fecha;
        $graduacion->ciclo_lectivo = $request->ciclo;
        $graduacion->lugar_atencion = $request->lugar;
        $graduacion->situacion = $request->situacion;
        $graduacion->recomendaciones = $request->recomendaciones;

        //Se guarda en la base de datos
        $graduacion->save();

        //Se reedirige a la página anterior con un mensaje de éxito
        return Redirect::back()
            ->with('exito', '¡Se ha actualizado correctamente!');
    }


    /* ====================================================================================
                Métodos de búsquda de base de datos  utilizados en el index
    ==================================================================================== */

    //Este método obtiene la fecha de inicio y la fecha final de la búsqueda y realiza un
    //Query de búsqueda con respecto a esas fechas. En caso de que en el request se incluya
    //el filtro de nombre se realiza una intersección entre los resultados de la fecha con
    //los resultados que coincidan con el nombre,apellido o cedula especificada, junto
    //con la paginación respectiva de los resultados
    private function filtroFechaNombre($fechaIni, $fechaFin, $filtro, $itemsPagina)
    {
        //Convierte el filtro de string a una fecha
        $fechaFin = date($fechaFin);
        //Convierte el filtro de string a una fecha
        $fechaIni = date($fechaIni);
        $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
            ->whereBetween('guias_academicas.fecha', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
            //Al agregar dentro de la sentencia [where] una función se logra crear una simulación de intersección entre los resultados anteriores con los que se encuentran dentro de la fucnión
            ->Where(function ($query) { //En caso de que se incluya un nombre,apellido o cédula en específico se agregan las sentencias de búsqueda pertinentes a cada una de ellas
                $query->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
                    ->orWhere('personas.persona_id', 'like', '%' . request('nombreFiltro', NULL) . '%') // Filtro para buscar por nombre de persona
                    ->orWhere('personas.apellido', 'like', '%' . request('nombreFiltro', NULL) . '%') // Filtro para buscar por apellido de persona
                    ->orWhere('personas.nombre', 'like', '%' . request('nombreFiltro', NULL) . '%'); // Filtro para buscar por cédula
            })
            ->orderBy('guias_academicas.id', 'desc') // Ordena con respecto al orden de  insercisión de guías académicas de manera descendente
            ->paginate($itemsPagina);  //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que realiza la búsqueda de guías académicas en la base de datos con respecto al nombre, apellido o cédula que se haya especificado
    private function filtroNombre($filtro, $itemsPagina)
    {
        $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
            ->orWhere('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
            ->orWhere('personas.apellido', 'like', '%' . $filtro . '%') // Filtro para buscar por apellido de persona
            ->orWhere('personas.nombre', 'like', '%' . $filtro . '%') // Filtro para buscar por cédula
            ->orderBy('personas.apellido', 'asc') // Ordena con respecto al orden de pellido de manera ascendentemente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que retorna todas las guías presentes en la BD ordenadas con respecto a la última agregada en la BD.
    private function obtenerGuias($itemsPagina)
    {
        $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
            ->orderBy('guias_academicas.id', 'desc') // Ordena con respecto al orden de  insercisión de guías académicas de manera descendente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías
    }
}
