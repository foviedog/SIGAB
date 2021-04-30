<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Estudiante;
use App\Guias_academica;
use App\Personal;
use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla
use Illuminate\Support\Facades\Validator;
use App\Helper\GlobalArrays;

class GuiasAcademicaController extends Controller
{

    //Método que obtiene una cedula por medio del request, devuelve ese estudiante espefico junto con la vista para crear una guia academica
    public function create($id_estudiante)
    {
        try{
        //Se obtiene el atributo de cédula que viene en el request y en caso de que no se encuentre seteado se pone en blanco
        $aceptado = request('aceptado', false);

        $estudiante = Estudiante::findOrFail($id_estudiante);

        //Tipos de guías académicas
        $tipos = GlobalArrays::TIPOS_GUIA_ACADEMICA;

        //Docentes
        $docentes = Personal::where('cargo', 'Académico')->get();

        if ($aceptado == 'true') {
            return view('control_educativo.informacion_guias_academicas.registrar', [
                'estudiante' => $estudiante,
                'tipos' => $tipos,
                'docentes' => $docentes
            ]);
        }
        return response()->json($estudiante, 200);
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    //Método que inserta una guia academica de un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores

            //Se crea una nueva instacia de guías académicas.
            $guia = new Guias_academica;

            //se setean los atributos del objeto
            $guia->persona_id = $request->persona_id;
            $guia->tipo = $request->tipo;
            $guia->solicitud = $request->solicitud;
            $guia->fecha = $request->fecha;
            $guia->ciclo_lectivo = $request->ciclo;
            $guia->situacion = $request->situacion;
            $guia->lugar_atencion = $request->lugar;
            $guia->recomendaciones = $request->recomendaciones;

            //Verifica el archivo adjunto y lo sube
            if ($request->archivo !== NULL) {


                $validacion = Validator::make($request->all(), [
                    'archivo' => 'mimes:csv,txt,xlx,xls,pdf,docx,pptx|max:30000'
                ]);

                if ($validacion->fails()) {
                    return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                        ->with('error', "El archivo no cumple con las especificaciones establecidas: " . $validacion->errors()->first()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
                }

                $archivo = new File;

                if ($request->file()) {
                    $nombreArchivo = time() . '_' . $request->archivo->getClientOriginalName();
                    $rutaArchivo = $request->file('archivo')->storeAs('guias_archivos', $nombreArchivo, 'public');
                    $guia->archivo_adjunto = $nombreArchivo;
                }
            }

            //se guarda el objeto en la base de datos
            $guia->save();

            //Revisa si la guia fue solicitada por un docente
            if ($request->solicitud != $request->persona_id) {

                //Busca el docente en la base de datos
                $docente = Personal::where('persona_id', $request->solicitud)->first();

                //se redirecciona a la pagina de registro de guias academicas con un mensaje de exito y los datos específicos del objeto insertado
                return Redirect::back()
                    ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                    ->with('gua_academica_insertada', $guia) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                    ->with('docente', $docente); //devuelve la información del docente
            } else {
                return Redirect::back()
                    ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                    ->with('gua_academica_insertada', $guia); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
            }
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    //Método inicial que devuelve el listado de guías con respecto a filtros
    public function index()
    {
        try{
        //Tipos de guías académicas
        $tipos = GlobalArrays::TIPOS_GUIA_ACADEMICA;

        // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 10 por página
        $itemsPagina = request('itemsPagina', 10);

        $filtro = request('nombreFiltro', NULL); //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $fechaIni = request('fechaIni', NULL); //Se recibe del request con el valor final del rango de fechas, si dicho valor no está seteado se pone en NULL
        $fechaFin = request('fechaFin', NULL); //Se recibe del request con el valor final del rango de fechas, si dicho valor no está seteado se pone en NULL

        //En caso de que el filtro de intervalo de fechas se encuentre dentro del request entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($fechaIni) && !is_null($fechaFin)) {
            $guias =  $this->filtroFechaNombre($fechaIni, $fechaFin, $filtro, $itemsPagina); //Retorna la lista de guías con respecto a las fechas especificadas
        } else if (!is_null($filtro)) { // En caso de que se busque únicamente el nombre,apellido o cédula de la persona se ejecuta la búsqueda por nombre
            $guias = $this->filtroNombre($filtro, $itemsPagina); //Búsqueda en la BD del por nombre, apellido o cédula
        } else { //Si no se adjunta ningún filtro de búsqueda se devuelve un listado de los estudiantes
            $guias = $this->obtenerGuias($itemsPagina);
        }

        //Docentes
        $docentes = Personal::where('cargo', 'Académico')->get();

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_guias_academicas.listado', [
            'guias' => $guias, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro, // Valor del filtro que se haya hecho para mantenerlo en la página
            'fechaIni' => $fechaIni, // Valor del filtro que se haya hecho para mantenerlo en la página
            'fechaFin' => $fechaFin, // Valor del filtro que se haya hecho para mantenerlo en la página
            'tipos' => $tipos,
            'docentes' => $docentes
        ]);
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    // Método que muestra una guía específica de un estudiante.
    public function show($id_guia)
    {
        try{
        // Se realiza una búsqueda en la BD respecto a la guía específica del estudiante que se alla seleccionado.
        $guia = Guias_academica::join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de guias con personas
            ->join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con guías académicas
            ->where('guias_academicas.id', '=',  $id_guia) // Limita los resultados a la única guía que exista con el ID seleccionado
            ->first(); // Obtener únicamente a la guía a la que se ha consultado.

        return response()->json($guia, 200); // Retorna el resultado por medio de un atributo JSON en la respuesta al AJAX del documento js/control_educativo/información_guias_academicas/listado.js
    }    
     catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    public function update($id_guia, Request $request)
    {
        try{
        //Busca la graduación en la base de datos
        $guia = Guias_academica::find($id_guia);

        //Al la graduación encontrada se le actualizan los atributos
        $guia->tipo = $request->tipo;
        $guia->solicitud = $request->solicitud;
        $guia->fecha = $request->fecha;
        $guia->ciclo_lectivo = $request->ciclo;
        $guia->lugar_atencion = $request->lugar;
        $guia->situacion = $request->situacion;
        $guia->recomendaciones = $request->recomendaciones;


        //Verifica el archivo adjunto y lo sube
        if ($request->archivo !== NULL) {

            $validacion = Validator::make($request->all(), [
                'archivo' => 'mimes:csv,txt,xlx,xls,pdf,docx,rar,zip,7zip|max:30000'
            ]);

            if ($validacion->fails()) {
                return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                    ->with('error', "El archivo no cumple con las especificaciones establecidas: " . $validacion->errors()->first()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
            }

            if ($guia->archivo_adjunto != NULL) {
                File::delete(public_path('/storage/guias_archivos/' . $guia->archivo_adjunto));
            }

            $archivo = new File;

            if ($request->file()) {
                $nombreArchivo = time() . '_' . $request->archivo->getClientOriginalName();
                $rutaArchivo = $request->file('archivo')->storeAs('guias_archivos', $nombreArchivo, 'public');
                $guia->archivo_adjunto = $nombreArchivo;
            }
        }

        //Se guarda en la base de datos
        $guia->save();

        //Se reedirige a la página anterior con un mensaje de éxito
        return Redirect::back()
            ->with('exito', '¡Se ha actualizado correctamente!');
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }    
         catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    //Método que elimina un archivo
    public function deleteFile($id_guia)
    {
        try{
        //Busca la graduación en la base de datos
        $guia = Guias_academica::find($id_guia);

        if ($guia->archivo_adjunto != NULL) {
            File::delete(public_path('/storage/guias_archivos/' . $guia->archivo_adjunto));
            $guia->archivo_adjunto = NULL;
        } else {
            return Redirect::back() //se redirecciona a la pagina de registro guias academicas
                ->with('error', "El archivo no exite");
        }

        $guia->save();

        return Redirect::back()
            ->with('exito', '¡El archivo se ha borrado exitosamente!');
        }    
         catch (ModelNotFoundException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }
    //Método que descarga un archivo
    public function download($nombre_archivo)
    {
        return response()->download(storage_path("/app/public/guias_archivos/$nombre_archivo"));
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
            //Al ser una función anónima no se puede acceder a los parámetros aceptados en la función por lo que se tiene que acceder directamente al request.
            ->Where(function ($query) { //En caso de que se incluya un nombre,apellido o cédula en específico se agregan las sentencias de búsqueda pertinentes a cada una de ellas
                $query->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
                    ->orWhere('personas.persona_id', 'like', '%' .  request('nombreFiltro', '') . '%') // Filtro para buscar por nombre de persona
                    ->orWhereRaw("concat(nombre, ' ', apellido) like '%" .  request('nombreFiltro', '')  . "%'"); //Filtro para buscar por nombre completo
            })
            ->orderBy('guias_academicas.fecha', 'desc') // Ordena con respecto al orden de  insercisión de guías académicas de manera descendente
            ->paginate($itemsPagina);  //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que realiza la búsqueda de guías académicas en la base de datos con respecto al nombre, apellido o cédula que se haya especificado
    private function filtroNombre($filtro, $itemsPagina)
    {
        $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
            ->orWhere('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
            ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro  . "%'") //Filtro para buscar por nombre completo
            ->orderBy('guias_academicas.fecha', 'desc') // Ordena con respecto al orden de pellido de manera ascendentemente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que retorna todas las guías presentes en la BD ordenadas con respecto a la última agregada en la BD.
    private function obtenerGuias($itemsPagina)
    {
        $guias = Guias_academica::join('personas', 'guias_academicas.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('estudiantes', 'guias_academicas.persona_id', '=', 'estudiantes.persona_id') //Inner join de estudiantes con guías académicas
            ->orderBy('guias_academicas.fecha', 'desc') // Ordena con respecto al orden de  insercisión de guías académicas de manera descendente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías
    }


    public function destroy( $id_guia)
    {
        try {
            
            $guia = Guias_academica::find($id_guia); 
            $guia->delete();
            return Redirect::back()
            ->with('exito', '¡Se ha eliminado correctamente!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()
            ->with('error', 'ha ocurrido un error');
        }
    }



}
