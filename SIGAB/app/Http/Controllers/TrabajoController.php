<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Events\EventTrabajos;
use App\Exceptions\ControllerFailedException;
use App\Trabajo;
use App\Estudiante;
use App\Eliminado;

class TrabajoController extends Controller
{

    /* Devuevle el listado de los estudiantes ordenados por su apellido */
    public function index($id_estudiante)
    {
        try{

            // Estudiante al que se le quiere añadir un trabajo
            $estudiante = Estudiante::findOrFail($id_estudiante);

            // Trabajos por estudiante
            $trabajos = Trabajo::where('persona_id', $id_estudiante);

            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];

            ///Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //     request se setea por defecto en 2 por página
            $itemsPagina = request('itemsPagina', 5);

            //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
            $filtro = request('filtro', NULL);

            //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
            if (!is_null($filtro)) {
                $trabajos = Trabajo::where('persona_id', $id_estudiante)
                    ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
            } else {
                $trabajos = Trabajo::where('persona_id', $id_estudiante)
                    ->orderBy('nombre_organizacion', 'asc') // Ordena por medio del nombre organizacion de manera ascendente
                    ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
            }

            //Se devuelve la vista con los atributos de paginación de los estudiante
            return view('control_educativo.informacion_laboral.listado', [
                'estudiante' => $estudiante,       // Estudiante
                'trabajos' => $trabajos,           // Trabajos
                'paginaciones' => $paginaciones,  // Listado de items de paginaciones
                'itemsPagina' => $itemsPagina,   // Items que se desean por página
                'confirmarEliminar' => 'simple'
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    /* Devuelve la página para registrar un trabajo de un estudiante en específico */
    public function create($id_estudiante)
    {
        try{

            $estudiante = Estudiante::findOrFail($id_estudiante);
            return view('control_educativo.informacion_laboral.registrar', [
                'estudiante' => $estudiante,
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    /* Recoge los datos desde el request e inserta en la base de datos, al
        final devuelve a la página anterior */
    public function store(Request $request)
    {
        try{
            //Se crea un nuevo trabajo
            $trabajo = new Trabajo;

            //Se van añadiendo los atributos del request al nuevo trabajo
            $trabajo->persona_id = $request->persona_id;
            $trabajo->nombre_organizacion = $request->nombre_organizacion;
            $trabajo->tipo_organizacion = $request->tipo_organizacion;
            $trabajo->tiempo_desempleado = $request->tiempo_desempleado;
            $trabajo->cargo_actual = $request->cargo_actual;
            $trabajo->jefe_inmediato = $request->jefe_inmediato;
            $trabajo->telefono_trabajo = $request->telefono_trabajo;
            $trabajo->jornada_laboral = $request->jornada_laboral;
            $trabajo->correo_trabajo = $request->correo_trabajo;
            $trabajo->interes_capacitacion = $request->interes_capacitacion;
            $trabajo->otros_estudios = $request->otros_estudios;

            //Descomentar la siguiente línea en el caso de que se desee ver la información del trabajo
            //dd($trabajo);

            //Se guarda en la base de datos
            $trabajo->save();

             //Se envía la notificación
            //event(new EventTrabajos($trabajo, 1));

            //Se reedirige a la página anterior con la información digitada un mensaje de éxito
            return Redirect::back()
                ->with('mensaje-exito', '¡El registro ha sido exitoso!')
                ->with('trabajo_insertado', $trabajo);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // Método que muestra un trabajo específico
    public function edit($id_trabajo)
    {
        //Busca el trabajo en la base de datos
        $trabajo = Trabajo::find($id_trabajo);

        //Retorna el trabajo en formato JSON y con un código de éxito de 200
        return response()->json($trabajo, 200);
    }

    // Método que actualiza la información laboral
    public function update(Request $request)
    {
        try{

            //Busca el trabajo en la base de datos
            $trabajo = Trabajo::find($request->id_trabajo);

            //Al trabajo encontrado se le actualizan los atributos
            $trabajo->nombre_organizacion = $request->nombre_organizacion;
            $trabajo->tipo_organizacion = $request->tipo_organizacion;
            $trabajo->tiempo_desempleado = $request->tiempo_desempleado;
            $trabajo->cargo_actual = $request->cargo_actual;
            $trabajo->jefe_inmediato = $request->jefe_inmediato;
            $trabajo->telefono_trabajo = $request->telefono_trabajo;
            $trabajo->jornada_laboral = $request->jornada_laboral;
            $trabajo->correo_trabajo = $request->correo_trabajo;
            $trabajo->interes_capacitacion = $request->interes_capacitacion;
            $trabajo->otros_estudios = $request->otros_estudios;

            //Se guarda en la base de datos
            $trabajo->save();

             //Se envía la notificación
            //event(new EventTrabajos($trabajo, 2));

            //Se reedirige a la página anterior con un mensaje de éxito
            return Redirect::back()
                ->with('mensaje-exito', '¡Se ha actualizado correctamente!');
                
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy($id_trabajo)
    {
        try {
            
            $trabajo = Trabajo::find($id_trabajo);
            
             //Se envía la notificación
            //event(new EventTrabajos($trabajo, 3));

            //Se guarda el registro en la tabla de eliminados
            $eliminado = new Eliminado;
            $eliminado->eliminado_por = auth()->user()->persona_id;
            $eliminado->elemento_eliminado = 'Trabajo';
            $eliminado->titulo = $trabajo->nombre_organizacion;
            $eliminado->save();

            $trabajo->delete();

            return Redirect::back()
            ->with('mensaje-exito', '¡Se ha eliminado correctamente!');

        } catch (\Illuminate\Database\QueryException $ex) {
            return Redirect::back()
            ->with('mensaje-error', 'Ha ocurrido un error al eliminar.');
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}
