<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades;
use App\ActividadesPromocion;

class ActividadesPromocionController extends Controller
{

    public function index()
    {
         // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];

         //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
         //request se setea por defecto en 25 por página
        $itemsPagina = request('itemsPagina', 5);
        $tema_filtro = request('tema_filtro', NULL);
        $tipo_filtro = request('tipo_filtro', NULL);
        $estado_filtro = request('estado_filtro', NULL);
        $rango_fechas = request('rango_fechas', NULL);
        $fecha_inicio  = NULL;
        $fecha_final = NULL;
        if (!is_null($rango_fechas)) {
            $fecha_inicio = substr($rango_fechas, 0, 10);
            $fecha_final = substr($rango_fechas, -10);
        }
        $actividadesPromocion = ActividadesPromocion::join('actividades', 'actividades_promocion.actividad_id', '=', 'actividades.id')
             ->join('personal', 'actividades.responsable_coordinar', '=', 'personal.persona_id') //revisar
            ->Where('actividades.fecha_inicio_actividad', 'like', '%' .   $fecha_inicio . '%')
            ->Where('actividades.fecha_final_actividad', 'like', '%' .   $fecha_final . '%')
            ->Where('actividades.tema', 'like', '%' .   $tema_filtro . '%')
            ->Where('actividades.estado', 'like', '%' .   $estado_filtro . '%')
            ->Where('actividades_promocion.tipo_actividad', 'like', '%' .   $tipo_filtro . '%')
             ->orderBy('actividades.tema', 'asc') // Ordena por tema de manera ascendente
             ->paginate($itemsPagina); //Paginación de los resultados

         //se devuelve la vista con los atributos de paginación de actividades
        return view('control_actividades_promocion.listado', [
             'actividadesPromocion' => $actividadesPromocion, // Listado de actividades
             'paginaciones' => $paginaciones, // Listado de items de paginaciones.
             'itemsPagina' => $itemsPagina // Item que se desean por página.
        ]);
    }


    //Retorna la vista de registrar actividades promocion
    public function create()
    {
        return view('control_actividades_promocion.registrar');
    }

    //Método que inserta una actividad promocion en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores

            $actividad = new Actividades; //Se crea una nueva instacia de Actividad
            $actividad_promocion = new ActividadesPromocion; //Se crea una nueva instacia de la actividad promocion

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
            $actividad_promocion->actividad_id = $actividad->id;
            $actividad_promocion->tipo_actividad = $request->tipo_actividad;
            $actividad_promocion->instituciones_patrocinadoras = $request->instituciones_patrocinadoras;
            $actividad_promocion->recursos = $request->recursos;
            $actividad_promocion->save(); //se guarda el objeto en la base de datos

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/actividad-promocion/registrar")
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad)
                ->with('actividad_promocion_insertada', $actividad_promocion);
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return redirect("/actividad-promocion/registrar") //se redirecciona a la pagina de registro
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }


    //Retorna la vista de detalle actividades de promocion
    public function show($id_actividad)
    {
        $actividad = Actividades::findOrfail($id_actividad);
        //$personal = Personal::findOrFail($actividad->responsable_coordinar);

        return view('control_actividades_promocion.detalle', ['actividad' => $actividad]);
    }


    public function edit(ListaAsistencia $listaAsistencia)
    {
        //
    }


    public function update($id_actividad, Request $request)
    {
        try { //se utiliza un try-catch para control de errores

            $actividad = Actividades::findOrFail($id_actividad);
            $actividad_promocion = ActividadesPromocion::findOrFail($id_actividad);

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
            $actividad_promocion->actividad_id = $actividad->id;
            $actividad_promocion->tipo_actividad = $request->tipo_actividad;
            $actividad_promocion->instituciones_patrocinadoras = $request->instituciones_patrocinadoras;
            $actividad_promocion->recursos = $request->recursos;

            $actividad_promocion->save(); //se guarda el objeto en la base de datos

            //se redirecciona a la pagina de registro de actividad con un mensaje de exito
            return redirect("/detalle-actividad-promocion/{$actividad->id}")
                ->with('mensaje', '¡La actividad se ha actualizado correctamente!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('actividad_insertada', $actividad);
                //->with('actividad_promocion_insertada', $actividad_promocion);
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return redirect("/detalle-actividad-promocion/{$actividad->id}") //se redirecciona a la pagina de registro
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }


    public function destroy(Request $request, $particioanteId)
    {
        //
    }
}