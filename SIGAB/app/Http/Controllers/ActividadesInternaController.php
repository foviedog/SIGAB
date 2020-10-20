<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividades;
use App\Actividades_interna;

class ActividadesInternaController extends Controller
{

    //Devuevle el listado de las actividades internas.
    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 25 por página
        $itemsPagina = request('itemsPagina', 5);

        //Inner join de actividades internas con actividades
        $actividadesInternas = Actividades_interna::join('actividades', 'actividades_internas.actividad_id', '=', 'actividades.id')
            ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id') //revisar
            ->orderBy('actividades.tema', 'asc') // Ordena por tema de manera ascendente
            ->paginate($itemsPagina); //Paginación de los resultados

        //se devuelve la vista con los atributos de paginación de los estudiante
        return view('control_actividades_internas.informacion_actividad.listado', [
            'actividadesInternas' => $actividadesInternas, // Listado de actividades
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina // Item que se desean por página.
        ]);
    }

    //Retorna la vista de registrar actividades internas
    public function create()
    {
        return view('control_actividades_internas.registrar');
    }

    //Método que inserta una actividad interna en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores

            $actividad = new Actividades; //Se crea una nueva instacia de Actividad
            $actividad_interna = new Actividades_interna; //Se crea una nueva instacia de la actividad interna

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
            $actividad_interna->instituciones_patrocinadoras = $request->instituciones_patrocinadoras;
            $actividad_interna->recursos = $request->recursos;

            $actividad_interna->save(); //se guarda el objeto en la base de datos

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/actividad-interna/registrar")
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad)
                ->with('actividad_interna_insertada', $actividad_interna);
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return redirect("/actividad-interna/registrar") //se redirecciona a la pagina de registro
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }
}
