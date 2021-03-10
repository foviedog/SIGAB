<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades;
use App\Actividades_interna;

class EvidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $lista = new ListaAsistencia();
            $lista->persona_id = request()->participante_id;
            $lista->actividad_id = request()->actividad_id;
            $lista->save();
            $mensaje = "success";
            return response()->json($mensaje, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response("No existe", 404);
        }
    }
    public function storeInvitado(Request $request)
    {
        try {
            $persona = new Persona();
            $persona = Persona::find($request->persona_id);   //Se busca en la BD si el participante ya se encontraba agregado anteriormente como persona

            if (!is_null($persona)) {
                return redirect()->route('lista-asistencia.show', $request->actividad_id)->with('mensaje', "error");
            } else {
                $persona = new Persona();
                $this->guardarPersona($persona, $request);
                $this->registrarParticipante($request->persona_id, $request->actividad_id);
            }

            return redirect()->route('lista-asistencia.show', $request->actividad_id)->with('mensaje', "success");
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('lista-asistencia.show', $request->actividad_id)->with('mensaje', "error");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function show($actividadId)
    {
        $paginaciones = [5, 10, 25, 50];
        $itemsPagina = request('itemsPagina', 5);
        $filtro = request('filtro', NULL);

        $mensaje = request('mensaje', NULL);
        //!AQUI VA LA LISTA DE DOCUMENTOS
        //$listaAsistencia = $this->obtenerLista($actividadId, $itemsPagina, $filtro);
        $actividad = Actividades::find($actividadId);

        //!Cambiar la ruta de lista de asistencia
        if (!is_null($mensaje)) {
            return redirect()->route('evidencias.show', $actividadId)->with('mensaje', $mensaje);
        }

        return view('control_actividades_internas.evidencias.detalle', [
            'actividad' => $actividad,
            'paginaciones' => $paginaciones,
            'itemsPagina' => $itemsPagina,
            'filtro' => $filtro,
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $particioanteId)
    {
        try {

            $lista = ListaAsistencia::where('persona_id', $particioanteId)
                ->where('actividad_id', $request->actividad_id);
            $lista->delete();
            return redirect()->route('lista-asistencia.show', $request->actividad_id)->with('eliminado', 'Participante eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('lista-asistencia.show', $request->actividad_id)->with('mensaje', 'error');
        }
    }

    public function obtenerLista($actividadId, $itemsPagina, $filtro)
    {
        $lista = NULL;
        if (is_null($filtro)) {
            $lista = Persona::join('lista_asistencias', 'personas.persona_id', '=', 'lista_asistencias.persona_id')
                ->where('lista_asistencias.actividad_id', $actividadId)->paginate($itemsPagina);
        } else {
            $lista = Persona::join('lista_asistencias', 'personas.persona_id', '=', 'lista_asistencias.persona_id')
                ->where('lista_asistencias.actividad_id', $actividadId)
                ->Where(function ($query) {
                    $query->orWhere('personas.persona_id', 'like', '%' .  request('filtro', '') . '%') // Filtro para buscar por nombre de persona
                        ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . request('filtro', '')  . "%'"); //Filtro para buscar por nombre completo
                })
                ->paginate($itemsPagina);
        }

        return $lista;
    }



    private function update_avatar($request, &$persona)
    {
        //En caso de que se haya subido alguna foto con el request se procede a guardarlo en el repositorio de imagenes de perfil
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar'); // Se obtiene el objeto que viene en el request y se guarda dentro de una variable
            $archivo = time() . '.' . $avatar->getClientOriginalExtension(); // Se toma la hora y la extensión del archivo que se subió (.jpg,png,etc..)
            Image::make($avatar)->resize(500, 640)->save(public_path('/img/fotos/' . $archivo)); // Se utiliza la herramienta de Image para que todas las imágenes se guarden en el mismo formato

            if ($persona->imagen_perfil != "default.jpg") // En caso de que *NO* se haya establecido una imagen por defecto
                File::delete(public_path('/img/fotos/' . $persona->imagen_perfil)); //Elimina la foto anterior para que no queden archivos "basura"

            $persona->imagen_perfil = $archivo; //Se le setea a la persona el nombre de la imagen de perfil con el formato especificado anteriormente (fecha.extension)
            $persona->save(); //Se guarda el atributo en la BD
        }
    }
}
