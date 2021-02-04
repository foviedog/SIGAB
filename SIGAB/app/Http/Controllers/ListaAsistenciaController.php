<?php

namespace App\Http\Controllers;

use Image;
use App\Actividades;
use App\Actividades_interna;
use App\ListaAsistencia;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla


class ListaAsistenciaController extends Controller
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

            return response("success", 200);
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

        $listaAsistencia = $this->obtenerLista($actividadId, $itemsPagina, $filtro);
        $actividad = Actividades::find($actividadId);

        if (!is_null($mensaje)) {
            return redirect()->route('lista-asistencia.show', $actividadId)->with('mensaje', $mensaje);
        }
        // dd($listaAsistencia);
        return view('control_actividades_internas.lista_asistencia.detalle', [
            'listaAsistencia' => $listaAsistencia,
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
    public function destroy(ListaAsistencia $listaAsistencia)
    {
        //
    }
    //Método que busca la cédula del participante que se desea agregar en
    //la lista de asistencia y lo retorna por medio de un response como respuesta
    //a un método AJAX.
    public function obtenerParticipante($idParticipante)
    {
        $participante = Persona::find($idParticipante); //Busca al participante en la base de datos de personas
        if (is_null($participante)) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        }
        return response()->json($participante, 200);
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

    private function guardarPersona(&$persona, $request)
    {
        //se setean los atributos del objeto
        $persona->persona_id = $request->persona_id;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->telefono_fijo = $request->telefono_fijo;
        $persona->telefono_celular = $request->telefono_celular;
        $persona->correo_personal = $request->correo_personal;
        $persona->correo_institucional = $request->correo_institucional;
        $persona->estado_civil = $request->estado_civil;
        $persona->direccion_residencia = $request->direccion_residencia;
        $persona->genero = $request->genero;
        $persona->save(); //se guarda el objeto en la base de datos
        $this->update_avatar($request, $persona);
    }
    private function registrarParticipante($participante_id, $actividad_id)
    {
        $lista = new ListaAsistencia();
        $lista->persona_id = $participante_id;
        $lista->actividad_id = $actividad_id;
        $lista->save();
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
