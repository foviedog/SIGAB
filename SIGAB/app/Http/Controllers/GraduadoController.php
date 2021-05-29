<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Events\EventTitulos;
use App\Exceptions\ControllerFailedException;
use App\Helper\GlobalFunctions;
use App\Graduado;
use App\Persona;
use App\Estudiante;
use App\Guias_academica;
use App\Eliminado;

class GraduadoController extends Controller
{

    //Método que obtiene una cedula por medio del request, devuelve ese estudiante espefico junto con la vista para crear una guia academica
    public function create($id_estudiante)
    {
        try{

            $estudiante = Estudiante::findOrFail($id_estudiante);

            return view('control_educativo.informacion_estudiantil.informacion_graduados.registrar', [
                'estudiante' => $estudiante,
            ]); 

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Método que inserta una guia academica de un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try {
            //Se crea una nueva instacia de graduado.
            $graduado = new Graduado;

            //se setean los atributos del objeto
            $graduado->persona_id = $request->persona_id;
            $graduado->grado_academico = $request->grado_academico;
            $graduado->carrera_cursada = $request->carrera_cursada;
            $graduado->anio_graduacion = $request->anio_graduacion;



            //se guarda el objeto en la base de datos
            $graduado->save();

             //Se envía la notificación
            event(new EventTitulos($graduado, 1));

            //se redirecciona a la pagina de registro de guias academicas con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje-exito', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('graduado_insertada', $graduado); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
        
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Método iniciaal que devuelve el listado de guías con respecto a filtros
    public function index()
    {
        try{
        // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 2 por página
        $itemsPagina = request('itemsPagina', 25);

        //Se recibe del request  el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('nombreFiltro', NULL);

        //Se recibe del request el valor de anio, y se le asigna a la variable ciclo par realizar el filtro. Si dicho valor no está seteado se pone en NULL
        $anio = request('anio', NULL);

        //En caso de que el filtro de ciclo lectivo se encuentre dentro del request entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($anio) && $anio != ' ') {
            $graduados = $this->filtroAnio($anio, $filtro, $itemsPagina); //Retorna la lista de guías con respecto a las fechas especificadas
        } else if (!is_null($filtro)) { // En caso de que se busque únicamente el nombre,apellido o cédula de la persona se ejecuta la búsqueda por nombre
            $graduados = $this->filtroNombre($filtro, $itemsPagina); //Búsqueda en la BD del por nombre, apellido o cédula
        } else { //Si no se adjunta ningún filtro de búsqueda se devuelve un listado de los estudiantes
            $graduados = $this->obtenerGraduados($itemsPagina);
        }

        //dd($anio);

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_educativo.informacion_estudiantil.informacion_graduados.listado', [
            'graduados' => $graduados, // Listado estudiantel.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro, // Valor del filtro que se haya hecho para mantenerlo en la página,
            'anio' => $anio, // Valor del filtro de año de graduación
        ]);
    } catch (\Illuminate\Database\QueryException $ex) {  
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }    
    catch (ModelNotFoundException $ex) {  
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    public function show($id_estudiante)
    {
        try{
        // Estudiante al que se le quiere añadir una graduación
        $estudiante = Estudiante::findOrFail($id_estudiante);

        // Graduaciones por estudiante
        $graduaciones = Graduado::where('persona_id', $id_estudiante)->get();

        //Se devuelve la vista
        return view('control_educativo.informacion_estudiantil.informacion_graduados.show', [
            'estudiante' => $estudiante,       // Estudiante
            'graduaciones' => $graduaciones,   // Graduaciones
            'confirmarEliminar' => 'simple'
        ]);
        } catch (ModelNotFoundException $ex) {  
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    // Método que muestra una graduación específica
    public function edit($id_graduacion)
    {
        try{
        //Busca la graduación en la base de datos
        $graduacion = Graduado::find($id_graduacion);

        //Retorna la graduación en formato JSON y con un código de éxito de 200
        return response()->json($graduacion, 200);
        }    catch (ModelNotFoundException $ex) {  
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }

    // Método que actualiza la información de la graduación
    public function update($id_graduacion, Request $request)
    {
        try{
        //Busca la graduación en la base de datos
        $graduacion = Graduado::find($id_graduacion);

        //Al la graduación encontrada se le actualizan los atributos
        $graduacion->grado_academico = $request->grado_academico;
        $graduacion->carrera_cursada = $request->carrera_cursada;
        $graduacion->anio_graduacion = $request->anio_graduacion;

        //Se guarda en la base de datos
        $graduacion->save();

         //Se envía la notificación
        event(new EventTitulos($graduacion, 2));

        //Se reedirige a la página anterior con un mensaje de éxito
        return Redirect::back()
            ->with('mensaje-exito', '¡Se ha actualizado correctamente!');
        } catch (\Illuminate\Database\QueryException $ex) {  
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }    
        catch (ModelNotFoundException $ex) {  
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    /* ====================================================================================
                Métodos de búsquda de base de datos  utilizados en el index
    ==================================================================================== */

    //Función que realiza la búsqueda de guías académicas en la base de datos con respecto al nombre, apellido o cédula que se haya especificado
    private function filtroAnio($anio, $filtro, $itemsPagina)
    {
        $guias = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->where('graduados.anio_graduacion', '=', $anio)
            ->orderBy('personas.apellido', 'asc')
            ->groupBy('estudiantes.persona_id') // Ordena con respecto al orden de pellido de manera ascendentemente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }


    //Función que realiza la búsqueda de guías académicas en la base de datos con respecto al nombre, apellido o cédula que se haya especificado
    private function filtroNombre($filtro, $itemsPagina)
    {
        $guias =  $graduados = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->orWhere('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
            ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro . "%'") //Filtro para buscar por nombre completo
            ->orderBy('personas.apellido', 'asc')
            ->groupBy('estudiantes.persona_id') // Ordena con respecto al orden de pellido de manera ascendentemente
            ->paginate($itemsPagina); //Paginación de los resultados según el atributo de cantidad de itemps por página seteado en el Request

        return $guias; //Retorna el resultado de todas las guías que cumplan con los filtros especificados
    }

    //Función que retorna todas las guías presentes en la BD ordenadas con respecto a la última agregada en la BD.
    private function obtenerGraduados($itemsPagina)
    {

        $graduados = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de guias con personas
            ->join('graduados', 'estudiantes.persona_id', '=', 'graduados.persona_id')
            ->groupBy('estudiantes.persona_id')->paginate($itemsPagina);

        return $graduados; //Retorna el resultado de todas las guías
    }

    public function destroy($id_graduacion)
    {
        try {
            
            $graduacion = Graduado::find($id_graduacion); 

             //Se envía la notificación
            event(new EventTitulos($graduacion, 3));

            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Titulación';
            $eliminado->titulo = $graduacion->grado_academico.' '.$graduacion->carrera_cursada.' '.$graduacion->anio_graduacion;
            $eliminado->save();

            $graduacion->delete();
            
            return Redirect::back()
            ->with('exito', '¡Se ha eliminado correctamente!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()
            ->with('mensaje-error', 'ha ocurrido un error');
        } catch (ModelNotFoundException $ex) {  
            return Redirect::back()//se redirecciona a la pagina anteriror
                ->with('mensaje-error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
        
    }

}
