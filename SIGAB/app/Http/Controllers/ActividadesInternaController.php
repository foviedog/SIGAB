<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\GlobalArrays;
use App\Helper\Accesos;
use App\Events\EventActividades;
use App\Exceptions\ControllerFailedException;
use App\Actividades_interna;
use App\Actividades;
use App\Personal;

class ActividadesInternaController extends Controller
{
    //Devuelve el listado de las actividades internas.
    public function index()
    {
        try {

            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];

            //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 25 por página
            $itemsPagina = request('itemsPagina', 5);
            $tema_filtro = request('tema_filtro', NULL);
            $tipo_filtro = request('tipo_filtro', NULL);
            $proposito_filtro = request('proposito_filtro', NULL);
            $estado_filtro = request('estado_filtro', NULL);
            $rango_fechas = request('rango_fechas', NULL);
            $checkAvanzada = request('checkAvanzada', NULL);
            $fecha_inicio  = NULL;
            $fecha_final = NULL;

            //si se realiza una búsqueda sin seleccionar la fecha
            if (!is_null($checkAvanzada) && is_null($rango_fechas)) {
                $actividadesInternas = $this->filtroTemaTipoEstado($itemsPagina, $tema_filtro, $tipo_filtro, $proposito_filtro, $estado_filtro);
            } else if (!is_null($checkAvanzada) && !is_null($rango_fechas)) { //si se realiza una búsqueda y se coloca la fecha
                $actividadesInternas = $this->filtroAvanzada($itemsPagina, $estado_filtro, $tipo_filtro, $proposito_filtro, $rango_fechas, $tema_filtro);
            } else {
                $actividadesInternas = $this->filtroTema($itemsPagina, $tema_filtro); //si no uso busqueda avanzada solo puedo buscar por tema
            }

            //se devuelve la vista con los atributos de paginación de los estudiante
            return view('control_actividades_internas.listado', [
                'actividadesInternas' => $actividadesInternas, // Listado de actividades
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'tema_filtro' => $tema_filtro,
                'tipo_filtro' => $tipo_filtro,
                'estado_filtro' => $estado_filtro,
                'proposito_filtro' => $proposito_filtro,
                'rango_fechas' => $rango_fechas
            ]);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Retorna la vista de registrar actividades internas
    public function show($id_actividad)
    {
        try {
            $actividad = Actividades::findOrfail($id_actividad);
            //Las actividades se acceden si se cumple al menos uno de los siguientes parámetros:
            //1. Se tiene el acceso para autorizar la actividad
            //2. La actividad fue registrada por la persona que está en sesión
            //3. La actividad ya se encuentra autorizada
            if (Accesos::ACCESO_AUTORIZAR_ACTIVIDAD() || $actividad->creada_por == auth()->user()->persona_id || $actividad->autorizada == 1) {
                $personal = Personal::findOrFail($actividad->responsable_coordinar);
                return view('control_actividades_internas.detalle', ['actividad' => $actividad]);
            } else {
                return redirect('/home')->with('mensaje-advertencia', 'La actividad no se ha autorizado aún.');
            }
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Retorna la vista de registrar actividades internas
    public function create()
    {
        return view('control_actividades_internas.registrar');
    }

    //Método que inserta una actividad interna en la base de datos
    public function store(Request $request)
    {
        try {
            $actividad = new Actividades; //Se crea una nueva instacia de Actividad
            $actividad_interna = new Actividades_interna; //Se crea una nueva instacia de la actividad interna

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
            $actividad->creada_por = auth()->user()->persona_id;
            if (Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) //Si se tiene el acceso para autorizar, al registrar una actividad se autoriza automaticamente
                $actividad->autorizada = 1;
            $actividad->save(); //se guarda el objeto en la base de datos

            //se setean los atributos del objeto
            $actividad_interna->actividad_id = $actividad->id;
            $actividad_interna->tipo_actividad = $request->tipo_actividad;
            $actividad_interna->proposito = $request->proposito;
            $actividad_interna->agenda = $request->agenda;
            $actividad_interna->ambito = $request->ambito;
            $actividad_interna->certificacion_actividad = $request->certificacion_actividad;
            $actividad_interna->publico_dirigido = $request->publico_dirigido;
            $actividad_interna->recursos = $request->recursos;
            $actividad_interna->personal_facilitador = $request->facilitador_encontrado;

            if ($request->externo_check == "on") {
                $actividad_interna->facilitador_externo = $request->facilitador;
                $actividad_interna->personal_facilitador = NULL;
            }

            $actividad_interna->save(); //se guarda el objeto en la base de datos

            //Mensaje y notificación dependiendo del acceso
            if (Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) {
                $mensaje = "¡El registro ha sido exitoso!";
                event(new EventActividades($actividad, 1, 2));
            } else {
                $mensaje = "¡La actividad fue enviada para autorización correctamente! Puede verificar la actividad en el listado de Mis actividades que encontrará en el perfil personal";
                event(new EventActividades($actividad, 1, 1));
            }

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/actividad-interna/registrar")
                ->with('mensaje-exito', $mensaje) //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad)
                ->with('actividad_interna_insertada', $actividad_interna);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Método que inserta una actividad interna en la base de datos
    public function update($id_actividad, Request $request)
    {
        try {

            $actividad = Actividades::findOrFail($id_actividad);
            $actividad_interna = Actividades_interna::findOrFail($id_actividad);

            //se setean los atributos del objeto
            $actividad->tema = $request->tema;
            $actividad->lugar = $request->lugar;
            $actividad->estado = $request->estado;
            $actividad->fecha_inicio_actividad = $request->fecha_inicio_actividad;
            $actividad->fecha_final_actividad = $request->fecha_final_actividad;
            $actividad->descripcion = $request->descripcion;
            $actividad->evaluacion = $request->evaluacion;
            $actividad->objetivos = $request->objetivos;
            $actividad->responsable_coordinar = $request->responsable_coordinar;
            $actividad->duracion = $request->duracion;
            $actividad->save(); //se guarda el objeto en la base de datos

            //se setean los atributos del objeto
            $actividad_interna->actividad_id = $actividad->id;
            $actividad_interna->tipo_actividad = $request->tipo_actividad;
            $actividad_interna->proposito = $request->proposito;
            $actividad_interna->facilitador_actividad = $request->facilitador_actividad;
            $actividad_interna->agenda = $request->agenda;
            $actividad_interna->ambito = $request->ambito;
            $actividad_interna->certificacion_actividad = $request->certificacion_actividad;
            $actividad_interna->publico_dirigido = $request->publico_dirigido;
            $actividad_interna->recursos = $request->recursos;

            $actividad_interna->save(); //se guarda el objeto en la base de datos

            //Generar la notificacion
            event(new EventActividades($actividad, 1, 3));

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/detalle-actividad-interna/{$actividad->id}")
                ->with('mensaje-exito', '¡La actividad se ha actualizado correctamente!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad)
                ->with('actividad_interna_insertada', $actividad_interna);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    private function filtroAvanzada($itemsPagina, $estado_filtro, $tipo_filtro, $proposito_filtro, $rango_fechas, $tema_filtro)
    {
        $fechaIni = substr($rango_fechas, 0, 10);
        $fechaFin = substr($rango_fechas, -10);
        $fechaIni = date("Y-m-d", strtotime(str_replace('/', '-', $fechaIni)));
        $fechaFin = date("Y-m-d", strtotime(str_replace('/', '-', $fechaFin)));

        $actividades_internas = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id')
            ->where(function ($query) {
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if (!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) {
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->whereBetween('actividades.fecha_inicio_actividad', [$fechaIni, $fechaFin]) //Sentencia sql que filtra los resultados entre las fechas indicadas
            ->Where('actividades.tema', 'like', '%' .   $tema_filtro . '%')
            ->Where('actividades.estado', 'like', '%' .   $estado_filtro . '%')
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo_filtro . '%')
            ->Where('actividades_internas.proposito', 'like', '%' .   $proposito_filtro . '%')
            ->orderBy('actividades.fecha_inicio_actividad', 'desc') // Ordena por fecha de manera descendente
            ->paginate($itemsPagina); //Paginación de los resultados
        return $actividades_internas;
    }

    //
    private function filtroTemaTipoEstado($itemsPagina, $tema_filtro, $tipo_filtro, $proposito_filtro, $estado_filtro)
    {
        $actividadesInternas = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id') //revisar
            ->where(function ($query) {
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if (!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) {
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->Where('actividades.tema', 'like', '%' .   $tema_filtro . '%')
            ->Where('actividades.estado', 'like', '%' .   $estado_filtro . '%')
            ->Where('actividades_internas.tipo_actividad', 'like', '%' .   $tipo_filtro . '%')
            ->Where('actividades_internas.proposito', 'like', '%' .   $proposito_filtro . '%')
            ->orderBy('actividades.tema', 'asc') // Ordena por tema de manera ascendente
            ->paginate($itemsPagina); //Paginación de los resultados
        return $actividadesInternas;
    }

    private function filtroTema($itemsPagina, $tema_filtro)
    {
        $actividadesInternas = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id') //revisar
            ->where(function ($query) {
                //Si el usuario no cuenta con el permiso de autorizar, solo podra ver las actividades autorizadas
                if (!Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) {
                    $query->where('actividades.autorizada', '=', '1');
                }
            })
            ->Where('actividades.tema',  'like', '%' .   $tema_filtro . '%')
            ->orderBy('actividades.fecha_inicio_actividad', 'desc') // Ordena por tema de manera desc
            ->paginate($itemsPagina); //Paginación de los resultados

        return $actividadesInternas;
    }

    public function autorizar(Request $request)
    {
        try {

            $actividad = Actividades::findOrfail($request->id_actividad);
            $actividad->autorizada = 1;
            $actividad->save(); //se guarda el objeto en la base de datos

            //Generar la notificacion
            event(new EventActividades($actividad, 1, 2));

            //se redirecciona a la pagina del detalle de la actividad con un mensaje de exito
            return redirect("/detalle-actividad-interna/{$actividad->id}")
                ->with('mensaje-exito', '¡La actividad se ha autorizado correctamente!'); //Retorna mensaje de exito con el response a la vista despues de registrar el objeto

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }
}
