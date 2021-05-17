<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalFunctions;
use App\Helper\GlobalArrays;
use App\Events\EventEstudiantes;
use App\Exceptions\ControllerFailedException;
use App\Estudiante;
use App\Persona;
use App\Guias_academica;
use App\Trabajo;
use App\Graduado;
use App\Personal;
use App\ListaAsistencia;
use App\User;
use App\Eliminado;

class EstudianteController extends Controller
{

    private $anios;

    public function __construct()
    {
        $this->anios = GlobalFunctions::obtenerAniosActual();
    }
    //Devuevle el listado de los estudiantes ordenados por su apellido.
    public function index()
    {
        try{

            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];

            //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 2 por página
            $itemsPagina = request('itemsPagina', 25);

            //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
            $filtro = request('filtro', NULL);


            //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
            if (!is_null($filtro)) {
                $estudiantes = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con personas
                    ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                    ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro . "%'") //Filtro para buscar por nombre completo
                    ->orderBy('personas.apellido', 'asc')
                    ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
            } else { //Si no se setea el filtro se devuelve un listado de los estudiantes
                $estudiantes = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con personas
                    ->orderBy('personas.apellido', 'asc') // Ordena por medio del apellido de manera ascendente
                    ->paginate($itemsPagina);; //Paginación de los resultados según el atributo seteado en el Request
            }
            //se devuelve la vista con los atributos de paginación de los estudiante
            return view('control_educativo.informacion_estudiantil.listado', [
                'estudiantes' => $estudiantes, // Listado estudiantel.
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'filtro' => $filtro, // Valor del filtro que se haya hecho para mantenerlo en la página
                'anios' => $this->anios
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Retorna la vista para crear un estudiante
    public function create()
    {
        return view('control_educativo.informacion_estudiantil.registrar');
    }

    //Método que inserta un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try {

            $persona = new Persona; //Se crea una nueva instacia de Persona
            $estudiante = new Estudiante; //Se crea una nueva instacia de estudiante

            //se setean los atributos del objeto
            $persona->persona_id = $request->cedula;
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

            //se setean los atributos del objeto
            $estudiante->persona_id = $request->cedula;
            $estudiante->direccion_lectivo = $request->direccion_lectivo;
            $estudiante->cant_hijos = $request->cantidad_hijos;
            $estudiante->tipo_colegio_procedencia = $request->tipo_colegio_procedencia;
            $estudiante->condicion_discapacidad = $request->condicion_discapacidad;
            $estudiante->anio_ingreso_ebdi = $request->anio_ingreso_ebdi;
            $estudiante->anio_ingreso_UNA = $request->anio_ingreso_una;
            $estudiante->carrera_matriculada_1 = $request->carrera_matriculada_1;
            $estudiante->carrera_matriculada_2 = $request->carrera_matriculada_2;
            $estudiante->anio_graduacion_estimado_1 = $request->anio_graduacion_estimado_1;
            $estudiante->anio_graduacion_estimado_2 = $request->anio_graduacion_estimado_2;
            $estudiante->anio_desercion = $request->anio_desercion;
            $estudiante->tipo_beca = $request->tipo_beca;
            $estudiante->nota_admision = $request->nota_admision;
            $estudiante->apoyo_educativo = $request->apoyo_educativo;
            $estudiante->residencias_UNA = $request->residencias;

            $persona->save(); //se guarda el objeto en la base de datos
            $estudiante->save(); //se guarda el objeto en la base de datos

             //Se envía la notificación
            event(new EventEstudiantes($estudiante, 1));

            //se redirecciona a la pagina de registro estudiante con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje-exito', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('persona_insertado', $persona) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('estudiante_insertado', $estudiante) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('cedula', $request->cedula); //Retorna un objeto en el response con la cedula, de otra manera no obtiene el dato de manera adecuada para imprimirlo en la vista

        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro estudiante
                ->with('mensaje-error', "Ha ocurrido un error con el registro del estudiante con la cédula  " . "$request->cedula" . ". Es posible que el estudiante ya se encuentre agregado.") //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
                ->with('persona_no_insertada', $persona) //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente
                ->with('estudiante_no_insertado', $estudiante); //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // Toma al estudiante por el id para mostrar su informacion detallada
    public function show($id_estudiante)
    {
        try{

            $estudiante = Estudiante::findOrFail($id_estudiante);
            return view('control_educativo.informacion_estudiantil.detalle', [
                'estudiante' => $estudiante,
                'confirmarEliminar' =>'estudiante'
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    //Metodo para actualizar los datos del estudiante
    public function update($id_estudiante, Request $request)
    {
        try{

            //Se obtiene la persona en base al ID
            $persona = Persona::find($id_estudiante);

            //Se obtiene el estudiante que contiene ese ID
            $estudiante = Estudiante::find($id_estudiante);

            // Datos asociados a la persona (no incluye la cédula ya que no debería ser posible editarla)
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

            //Se guardan los datos de la persona
            $persona->save();

            //Datos asociados al estudiante (no incluye el ID ya que no debería ser posible editarlo)
            $estudiante->direccion_lectivo = $request->direccion_lectivo;
            $estudiante->cant_hijos = $request->cantidad_hijos;
            $estudiante->tipo_colegio_procedencia = $request->tipo_colegio_procedencia;
            $estudiante->condicion_discapacidad = $request->condicion_discapacidad;
            $estudiante->anio_ingreso_ebdi = $request->anio_ingreso_ebdi;
            $estudiante->anio_ingreso_UNA = $request->anio_ingreso_una;
            $estudiante->carrera_matriculada_1 = $request->carrera_matriculada_1;
            $estudiante->carrera_matriculada_2 = $request->carrera_matriculada_2;
            $estudiante->anio_graduacion_estimado_1 = $request->anio_graduacion_estimado_1;
            $estudiante->anio_graduacion_estimado_2 = $request->anio_graduacion_estimado_2;
            $estudiante->anio_desercion = $request->anio_desercion;
            $estudiante->tipo_beca = $request->tipo_beca;
            $estudiante->nota_admision = $request->nota_admision;
            $estudiante->apoyo_educativo = $request->apoyo_educativo;
            $estudiante->residencias_UNA = $request->residencias;

            //Se guardan los datos del estudiante
            $estudiante->save();
            //Llamado al método que actualiza la foto de perfil
            $this->update_avatar($request, $estudiante);

             //Se envía la notificación
            event(new EventEstudiantes($estudiante, 2));

            //Se retorna el detalle del estudiante ya modificado
            return redirect("/estudiante/detalle/{$estudiante->persona_id}");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function update_avatar($request, $estudiante)
    {
        try{

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                GlobalFunctions::actualizarFotoPerfil($avatar, $estudiante->persona); //Se llama el metodo global que actualiza la imagen
            }

            return \Redirect::back();

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy($personaId){
        try{

            $esPersonal = Personal::where('persona_id', $personaId)->count() > 0;

            if($esPersonal){
                //Se guarda el registro en la tabla de eliminados
                $eliminado = new Eliminado;
                $eliminado->eliminado_por = auth()->user()->persona_id;
                $eliminado->elemento_eliminado = 'Estudiante';
                $eliminado->titulo = 'Se eliminó el estudiante '.$personaId.', sus guías académicas, sus trabajos, sus titulaciones y se eliminó de las listas de asistencia donde participaba';
                $eliminado->save();

                $guias = Guias_academica::where('persona_id', $personaId);
                $guias->delete();
                $trabajos = Trabajo::where('persona_id', $personaId);
                $trabajos->delete();
                $graduaciones = Graduado::where('persona_id', $personaId);
                $graduaciones->delete();
                $asistencia = ListaAsistencia::where('persona_id', $personaId);
                $asistencia->delete();
                $estudiante = Estudiante::where('persona_id', $personaId);
                $estudiante->delete();
            } else {
                //Se guarda el registro en la tabla de eliminados
                $eliminado = new Eliminado;
                $eliminado->eliminado_por = auth()->user()->persona_id;
                $eliminado->elemento_eliminado = 'Estudiante';
                $eliminado->titulo = 'Se eliminó el estudiante '.$personaId.', sus guías académicas, sus trabajos, sus titulaciones, se eliminó de las listas de asistencia donde participaba, su usuario (si tuviese) y la persona asociada';
                $eliminado->save();
                
                $usuario = User::where('persona_id', $personaId);
                $usuario->delete();
                $guias = Guias_academica::where('persona_id', $personaId);
                $guias->delete();
                $trabajos = Trabajo::where('persona_id', $personaId);
                $trabajos->delete();
                $graduaciones = Graduado::where('persona_id', $personaId);
                $graduaciones->delete();
                $asistencia = ListaAsistencia::where('persona_id', $personaId);
                $asistencia->delete();
                $estudiante = Estudiante::where('persona_id', $personaId);
                $estudiante->delete();
                $persona = Persona::where('persona_id', $personaId);
                $persona->delete();
            }

            return redirect(route('listado-estudiantil'))
                ->with('mensaje-exito', "El estudiante se ha eliminado correctamente.");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }

    }

}