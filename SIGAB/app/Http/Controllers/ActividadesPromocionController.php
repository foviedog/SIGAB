<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\GlobalArrays;
use App\Helper\Accesos;
use App\Events\EventActividades;
use App\Exceptions\ControllerFailedException;
use App\ActividadesPromocion;
use App\Actividades;

use App\Events\EventActividadParaAutorizar;

class ActividadesPromocionController extends Controller
{

    public function index()
    {
        try{

            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];
            //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 25 por página
            $itemsPagina = request('itemsPagina', 25);
            $tema_filtro = request('tema_filtro', NULL);
            $tipo_filtro = request('tipo_filtro', NULL);
            $estado_filtro = request('estado_filtro', NULL);
            $rango_fechas = request('rango_fechas', NULL);
            $checkAvanzada = request('checkAvanzada', NULL);
            $fechaIni = NULL;
            $fechaFin = NULL;
            //si se realiza una búsqueda sin seleccionar la fecha
            if (!is_null($checkAvanzada) && is_null($rango_fechas)) {
                $actividadesPromocion = $this->filtroTemaTipoEstado($itemsPagina, $tema_filtro, $tipo_filtro, $estado_filtro);
            } else if (!is_null($checkAvanzada) && !is_null($rango_fechas)) { //si se realiza una búsqueda y se coloca la fecha
                $actividadesPromocion = $this->filtroAvanzada($itemsPagina, $estado_filtro, $tipo_filtro, $rango_fechas, $tema_filtro);
            } else {
                $actividadesPromocion = $this->filtroTema($itemsPagina, $tema_filtro); //si no uso busqueda avanzada solo puedo buscar por tema
            }

            //se devuelve la vista con los atributos de paginación de actividades
            return view('control_actividades_promocion.listado', [
                'actividadesPromocion' => $actividadesPromocion, // Listado de actividades
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'tema_filtro' => $tema_filtro,
                'tipo_filtro' => $tipo_filtro,
                'estado_filtro' => $estado_filtro,
                'rango_fechas' => $rango_fechas
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    //Retorna la vista de registrar actividades promocion
    public function create()
    {
        return view('control_actividades_promocion.registrar');
    }

    //Método que inserta una actividad promocion en la base de datos
    public function store(Request $request)
    {
        try {

            $actividad = new Actividades; //Se crea una nueva instacia de Actividad
            $actividad_promocion = new ActividadesPromocion; //Se crea una nueva instacia de la actividad promocion
            //Obtene el rango de fechas del request y lo divide en fecha de inicio y fecha final
            $fechaIni = substr($request->rango_fechas, 0, 10);
            $fechaFin = substr($request->rango_fechas, -10);
            $fechaIni = date("Y-m-d", strtotime(str_replace('/', '-', $fechaIni)));
            $fechaFin = date("Y-m-d", strtotime(str_replace('/', '-', $fechaFin)));

            //se setean los atributos del objeto
            $actividad->tema = $request->tema;
            $actividad->lugar = $request->lugar;
            $actividad->estado = $request->estado;
            $actividad->descripcion = $request->descripcion;
            $actividad->evaluacion = $request->evaluacion;
            $actividad->objetivos = $request->objetivos;
            $actividad->fecha_inicio_actividad = $fechaIni; 
            $actividad->fecha_final_actividad = $fechaFin; 
            $actividad->responsable_coordinar = $request->responsable_encontrado;
            $actividad->creada_por = auth()->user()->persona_id;
            $actividad->duracion = $request->duracion;

            if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) //Si se tiene el acceso para autorizar, al registrar una actividad se autoriza automaticamente
                $actividad->autorizada = 1;
            $actividad->save(); //se guarda el objeto en la base de datos

            //se setean los atributos del objeto
            $actividad_promocion->actividad_id = $actividad->id;
            $actividad_promocion->tipo_actividad = $request->tipo_actividad;
            $actividad_promocion->instituciones_patrocinadoras = $request->instituciones_patrocinadoras;
            $actividad_promocion->recursos = $request->recursos;
            $actividad_promocion->save(); //se guarda el objeto en la base de datos

            //Mensaje dependiendo del acceso
            if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()){
                $mensaje = "¡El registro ha sido exitoso!";
                event(new EventActividades($actividad, 2, 2));
            } else {
                $mensaje = "¡La actividad fue enviada para autorización correctamente! Puede verificar la actividad en el listado de Mis actividades que encontrará en el perfil personal";
                event(new EventActividades($actividad, 2, 1));
            }

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/actividad-promocion/registrar")
                ->with('mensaje-exito', $mensaje) //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad)
                ->with('actividad_promocion_insertada', $actividad_promocion);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    //Retorna la vista de detalle actividades de promocion
    public function show($id_actividad)
    {
        try{
            $actividad = Actividades::findOrfail($id_actividad);
            //Las actividades se acceden si se cumple al menos uno de los siguientes parámetros:
            //1. Se tiene el acceso para autorizar la actividad
            //2. La actividad fue registrada por la persona que está en sesión
            //3. La actividad ya se encuentra autorizada
            //dd($actividad->creada_por." ".auth()->user()->persona_id);
            if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD() || $actividad->creada_por == auth()->user()->persona_id || $actividad->autorizada == 1){
                return view('control_actividades_promocion.detalle', ['actividad' => $actividad]);
            } else {
                return redirect('/home');
            }

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function edit(ListaAsistencia $listaAsistencia)
    {
        //
    }


    public function update($id_actividad, Request $request)
    {
        try {

            $actividad = Actividades::findOrFail($id_actividad);
            $actividad_promocion = ActividadesPromocion::findOrFail($id_actividad);
            //Obtene el rango de fechas del request y lo divide en fecha de inicio y fecha final
            $fechaIni = substr($request->rango_fechas, 0, 10);
            $fechaFin = substr($request->rango_fechas, -10);
            $fechaIni = date("Y-m-d", strtotime(str_replace('/', '-', $fechaIni)));
            $fechaFin = date("Y-m-d", strtotime(str_replace('/', '-', $fechaFin)));

            //se setean los atributos del objeto
            $actividad->tema = $request->tema;
            $actividad->lugar = $request->lugar;
            $actividad->estado = $request->estado;
            $actividad->fecha_inicio_actividad = $fechaIni; 
            $actividad->fecha_final_actividad = $fechaFin; 
            $actividad->descripcion = $request->descripcion;
            $actividad->evaluacion = $request->evaluacion;
            $actividad->objetivos = $request->objetivos;
            $actividad->responsable_coordinar = $request->responsable_encontrado;
            $actividad->duracion = $request->duracion;
            $actividad->save(); //se guarda el objeto en la base de datos

            //se setean los atributos del objeto
            $actividad_promocion->actividad_id = $actividad->id;
            $actividad_promocion->tipo_actividad = $request->tipo_actividad;
            $actividad_promocion->instituciones_patrocinadoras = $request->instituciones_patrocinadoras;
            $actividad_promocion->recursos = $request->recursos;

            $actividad_promocion->save(); //se guarda el objeto en la base de datos

            event(new EventActividades($actividad, 2, 3));

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/detalle-actividad-promocion/{$actividad->id}")
                ->with('mensaje-exito', '¡La actividad se ha actualizado correctamente!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad);
            //->with('actividad_promocion_insertada', $actividad_promocion);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    public function destroy(Request $request, $particioanteId)
    {
        //
    }
    
    //Filtro para hacer busquedas avanzadas, rangos de fecha de inicio, tema, tipo de actividad y estado
    private function filtroAvanzada($itemsPagina, $estado_filtro, $tipo_filtro, $rango_fechas, $tema_filtro)
    {
        $fechaIni = substr($rango_fechas, 0, 10);
        $fechaFin = substr($rango_fechas, -10);
        $fechaIni = date("Y-m-d", strtotime(str_replace('/', '-', $fechaIni)));
        $fechaFin = date("Y-m-d", strtotime(str_replace('/', '-', $fechaFin)));

        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->where(function($query){
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if(!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()){
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->whereBetween('actividades.fecha_inicio_actividad', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
            ->Where('actividades.tema', 'like', '%' .   $tema_filtro . '%')
            ->Where('actividades.estado', 'like', '%' .   $estado_filtro . '%')
            ->Where('actividades_promocion.tipo_actividad', 'like', '%' .   $tipo_filtro . '%')
            ->orderBy('actividades.fecha_inicio_actividad', 'desc') // Ordena por fecha de manera descendente
            ->paginate($itemsPagina); //Paginación de los resultados
        return $actividadesPromocion;
    }

    //Filtro de busqueda avanzada en caso de no necesitar fechas
    private function filtroTemaTipoEstado($itemsPagina, $tema_filtro, $tipo_filtro, $estado_filtro)
    {
        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->where(function($query){
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if(!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()){
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->Where('actividades.tema',  'like', '%' .   $tema_filtro . '%')
            ->Where('actividades_promocion.tipo_actividad',  'like', '%' . $tipo_filtro . '%')
            ->Where('actividades.estado', 'like', '%' .   $estado_filtro . '%')
            ->orderBy('actividades.fecha_inicio_actividad', 'desc') // Ordena por tema de manera desc
            ->paginate($itemsPagina); //Paginación de los resultados

        return $actividadesPromocion;
    }

    //Filtro solo por tema de actividad
    private function filtroTema($itemsPagina, $tema_filtro)
    {
        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->where(function($query){
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if(!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()){
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->Where('actividades.tema',  'like', '%' .   $tema_filtro . '%')
            ->orderBy('actividades.fecha_inicio_actividad', 'desc') // Ordena por tema de manera desc
            ->paginate($itemsPagina); //Paginación de los resultados
        return $actividadesPromocion;
    }

    public function autorizar(Request $request)
    {
        try {
            $actividad = Actividades::findOrfail($request->id_actividad);
            $actividad->autorizada = 1;
            $actividad->save(); //se guarda el objeto en la base de datos

            event(new EventActividades($actividad, 2, 2));

            //se redirecciona a la pagina del detalle de la actividad con un mensaje de exito
            return redirect("/detalle-actividad-promocion/{$actividad->id}")
                ->with('mensaje-exito', '¡La actividad se ha autorizado correctamente!'); //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
        
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy($actividadId){
        try{

            dd("llego hasta aqui");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }

    }

}
