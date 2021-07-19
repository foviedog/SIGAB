<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalFunctions;
use App\Helper\GlobalArrays;
use App\Events\EventPersonal;
use App\Exceptions\ControllerFailedException;
use App\Exports\PersonalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Personal;
use App\Persona;
use App\Idioma;
use App\ListaAsistencia;
use App\Actividades;
use App\Actividades_interna;
use App\ActividadesPromocion;
use App\Estudiante;
use App\User;
use App\Eliminado;

class PersonalController extends Controller
{

    //Devuevle el listado del personal ordenados por su apellido.
    public function index()
    {
        try{

            // Array que devuelve los items que se cargan por página
            $paginaciones = [5, 10, 25, 50];
            //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
            //request se setea por defecto en 25 por página
            $itemsPagina = request('itemsPagina', 25);
            //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
            $filtro = request('filtro', NULL);
            if (!is_null($filtro)) {
                $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                    ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                    ->orWhere('personal.cargo', 'like', '%' . $filtro . '%') // Filtro para buscar el cargo del personal
                    ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro . "%'") //Filtro para buscar por nombre completo
                    ->orderBy('personas.apellido', 'asc')
                    ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
            } else { //Si no se setea el filtro se devuelve un listado del personal
                $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                    ->orderBy('personas.apellido', 'asc') // Ordena por medio del apellido de manera ascendente
                    ->paginate($itemsPagina);; //Paginación de los resultados según el atributo seteado en el Request
            }

            //se devuelve la vista con los atributos de paginación del personal
            return view('control_personal.listado', [
                'personal' => $personal, // Listado de personal.
                'paginaciones' => $paginaciones, // Listado de items de paginaciones.
                'itemsPagina' => $itemsPagina, // Item que se desean por página.
                'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // ===========================================================================================
    // Método para redireccionar al usuario a la vista de registro de personal
    //============================================================================================
    public function create(Request $request)
    {
        try{
            if($request->cedula != null){
                $persona = Persona::find($request->cedula);
                $personal = Personal::find($request->cedula);

                if(!is_null($personal)){
                    return redirect()->back()
                    ->with('personalExisteError', "El personal ya se encuentra registrado");
                }

                return view('control_personal.registrar',[
                    'persona_existe' => $persona, // Listado de personal.
                ]);
            }else{
                throw new ControllerFailedException();
            }
        }catch (\Exception $exception) {
            throw new ControllerFailedException();
        }

    }


    // ===========================================================================================
    // Método que guarda un personal en la BD
    //============================================================================================
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para evitar el redireccionamiento a página default de error de Laravel
            $persona = new Persona(); //Se crea una nueva instacia de Persona
            $personal = new Personal(); //Se crea una nueva instacia de estudiante

            // Se le establece la cédula a cada uno de los objetos para que en el método generalizado realice un guardado del registro y no un actualizar.
            //SI NO SE PONE LA CÉDULA EL MÉTODO GENERAL LO TOMA COMO ACTUALIZACIÓN.
            $personal->persona_id = $request->persona_id;
            $persona->persona_id = $request->persona_id;
            if($request->persona_existe == "true"){
                $persona = Persona::find($request->persona_id);  //En caso de que la persona ya exista en la bd se busca al objeto para evitar conflictos de llave primaria duplicada
            }

            $this->guardarPersonal($persona, $personal, $request, 1);

            $this->guardarIdiomas($request); //Se llama al método genérico para guardar idiomas
            $persona_existe = null;
            return view('control_personal.registrar')
                    ->with('mensaje_exito', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                    ->with('persona_registrada', $persona) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                    ->with('personal_registrado', $personal) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                    ->with('persona_existe', null);

        } catch (\Illuminate\Database\QueryException $ex) {
            return view('control_personal.registrar') //se redirecciona a la pagina de registro personal
                    ->with('mensaje_error', "Ocurrió un error al insertar, puede que el registro ingresado con la cédula  " . "$request->cedula" . " ya exista")  //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
                    ->with('persona_no_insertada', $persona) //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente
                    ->with('personal_no_insertado', $personal) //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente
                    ->with('persona_existe', null);
        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    // ===========================================================================================
    // Método que muestra la información detallada de un personal
    //============================================================================================
    public function show($id_personal)
    {
        try{
            //Busca en la base de datos al personal con la cédula indicada
            $personal = Personal::findOrFail($id_personal);

            //Se optiene un arreglo con los idiomas específicos de la persona.
            $idiomas = Idioma::where('persona_id', '=', $id_personal)->get();

            $elementosBorrar = $this->delete($id_personal);

            return view('control_personal.detalle', [
                'personal' => $personal,
                'idiomas' => $idiomas,
                'confirmarEliminar' => 'personal',
                'elementosBorrar' => $elementosBorrar
            ]);

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    // ===========================================================================================
    // Método para actualizar los datos de un personal
    //============================================================================================
    public function update($id_personal, Request $request)
    {
        try{
            //Se crean instancias de persona y personal para crear inicializar los atributos de cada objeto
            $persona = new Persona();
            $personal = new Personal();
            // Se busca en la BD la persona que concuerde con el id que viene en el request
            $persona = Persona::find($id_personal);   //Se obtiene el personal que contiene ese ID

            $personal = Personal::find($id_personal);

            $this->guardarPersonal($persona, $personal, $request, 2); //Se llama al método genérico para guardar un personal

            Idioma::where('persona_id', $id_personal)->delete(); // Antes de guardar los idiommas de la persona, se eliminan todos los registros de idomas referentes a esa persona para que sea posible actualizarlo
            $this->guardarIdiomas($request); //Se llama al método genérico para guardar idiomas

            // Llamado al método que actualiza la foto de perfil
            $this->update_avatar($request, $personal);
            //Se retorna el detalle del personal ya modificado

            return redirect("/personal/detalle/{$personal->persona_id}")
            ->with('mensaje-exito', '¡El personal se ha actualizado correctamente!');

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }


    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~
    // Métodos privados de ÚNICO uso dentro del controller
    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~

    // ===========================================================================================
    // Métodos para actualizar la foto del perfil de un personal
    //============================================================================================
    private function update_avatar($request, $personal)
    {
        //En caso de que se haya subido alguna foto con el request se procede a guardarlo en el repositorio de imagenes de perfil
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar'); // Se obtiene el objeto que viene en el request y se guarda dentro de una variable

            GlobalFunctions::actualizarFotoPerfil($avatar, $personal->persona); //Se llama el metodo global que actualiza la imagen

        }
    }

    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~
    // MÉTODOS GENÉRICOS DE ACTUALIZAR Y GUARDAR
    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~

    //¡¡¡¡ NOTA IMPORTANTE !!!
    // Para que los métodos de guardado o actualizados genéricos funcionen, el request debe de mantener
    // siempre los mismos nombres que en la base de datos.



    // ===========================================================================================
    // Métodos genérico que toma los datos del request y *guarda* o *actualiza* un personal
    //============================================================================================
    private function guardarPersonal(&$persona, &$personal, $request, $accion)
    {
        //se setean los atributos del objeto
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

        //se setean los atributos del objeto tipo personal
        $personal->grado_academico = $request->grado_academico;
        $personal->cargo = $request->cargo;
        $personal->tipo_nombramiento = $request->tipo_nombramiento;
        $personal->tipo_puesto_1 = $request->tipo_puesto_1;
        $personal->tipo_puesto_2 = $request->tipo_puesto_2;
        $personal->jornada = $request->jornada;
        $personal->lugar_trabajo_externo = $request->trabajo_externo;
        $personal->anio_propiedad = $request->anio_propiedad;
        $personal->experiencia_profesional = $request->experiencia_profesional;
        $personal->experiencia_academica = $request->experiencia_academica;
        $personal->regimen_administrativo = $request->regimen_administrativo;
        $personal->regimen_docente = $request->regimen_docente;
        $personal->area_especializacion_1 = $request->area_especializacion_1;
        $personal->area_especializacion_2 = $request->area_especializacion_2;
        $personal->activo =  $request->activo;

        $personal->publicaciones =  $request->publicaciones;
        $personal->reconocimientos =  $request->reconocimientos;

        $persona->save(); //se guarda el objeto en la base de datos
        $personal->save();

        //Se envía la notificación
        event(new EventPersonal($personal, $accion));
    }


    // ==============================================================================================================
    // Métodos genérico que toma los datos del request y *guarda* o *actualiza* la lista de idiomas de un personal
    //===============================================================================================================
    private function guardarIdiomas($request)
    {
        if (!is_null($request->idiomasJSON)) {
            $idiomas =  json_decode($request->idiomasJSON); // Se toma el arreglo que viene en el array en formato JSON y se transforma a código PHP
            foreach ($idiomas as &$idoma) { // Por cada uno de los idiomas que esté en el arreglo se realizan las siguientes opciones:
                $idiomaP =  new Idioma(); // Se crea una nueva instancia del objeto idioma
                $idiomaP->persona_id =  $request->persona_id; // Se le esteblece la cédula de la persona al objeto idioma
                $idiomaP->nombre =  $idoma; // Se establece el nombre del idioma
                $idiomaP->save(); // Se guarda el idioma en la BD
            }
        }
    }


    // ==============================================================================================================
    // Método que busca el personal por su ID para probar si esta registrado
    //===============================================================================================================

    public function edit($id_personal)
    {
        try{
            $personal = Personal::find($id_personal); //se busca la persona con el id del personal requerido
            if ($personal == null) {
                return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
            } else {
                return response()->json($personal->persona, 200); //si hay un personal registrado con ese id lo retorna
            }

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    public function destroy($personaId){
        try{

            $esEstudiante = Estudiante::where('persona_id', $personaId)->count() > 0;

            if($esEstudiante){

                //Se guarda el registro en la tabla de eliminados
                $eliminado = new Eliminado;
                $eliminado->eliminado_por = auth()->user()->persona_id;
                $eliminado->elemento_eliminado = 'Personal';
                $eliminado->titulo = 'Se eliminó el personal '.$personaId.', sus cargas académicas y se eliminó de las listas de asistencia donde participaba';
                $eliminado->save();

                $personal = Personal::where('persona_id', $personaId);

                //Se envía la notificación
                event(new EventPersonal($personal->first(), 3));

                $idiomas = Idioma::where('persona_id', $personaId);
                $idiomas->delete();


                $personal->delete();
            } else {

                //Se guarda el registro en la tabla de eliminados
                $eliminado = new Eliminado;
                $eliminado->eliminado_por = auth()->user()->persona_id;
                $eliminado->elemento_eliminado = 'Personal';
                $eliminado->titulo = 'Se eliminó el personal '.$personaId.', sus cargas académicas y se eliminó de las listas de asistencia donde participaba';
                $eliminado->save();

                $personal = Personal::where('persona_id', $personaId);

                //Se envía la notificación
                event(new EventPersonal($personal->first(), 3));

                $usuario = User::where('persona_id', $personaId);
                $usuario->delete();
                $idiomas = Idioma::where('persona_id', $personaId);
                $idiomas->delete();


                $personal->delete();
                $persona = Persona::where('persona_id', $personaId);
                $persona->delete();
            }

            return redirect()->route('personal.listar')
                ->with('mensaje-exito', "El personal se ha eliminado correctamente.");

        } catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

    private function delete($personaId){
        $listasAsistencia = $this->obtenerConcurrenciasListas($personaId);
        $coordinacion = $this->obtenerConcurrenciaCoordinacion($personaId);
        $facilitador = $this->obtenerConcurrenciaFacilitador($personaId);

        $dataListas = [];
        $dataCoord = [];
        $dataFacili = [];

        foreach ($listasAsistencia as &$lista) {
            $dato = new \stdClass();
            $dato->url = route('lista-asistencia.show', $lista->id);
            $dato->tema = $lista->tema;
            array_push($dataListas, $dato);
        }

        foreach ($coordinacion as &$coord) {
            $dato = new \stdClass();
            $esInterna = Actividades_interna::where('actividades_internas.actividad_id', $coord->id)->count() > 0;
            if($esInterna)
                $dato->url = route('actividad-interna.show', $coord->id);
            else
                $dato->url = route('actividad-promocion.show', $coord->id);
            $dato->tema = $coord->tema;
            array_push($dataCoord, $dato);
        }

        foreach ($facilitador as &$facili) {
            $dato = new \stdClass();
            $dato->url = route('actividad-interna.show', $facili->id);
            $dato->tema = $facili->tema;
            array_push($dataFacili, $dato);
        }

        $resultado = [];

        array_push($resultado, $dataListas);
        array_push($resultado, $dataCoord);
        array_push($resultado, $dataFacili);

        return $resultado;
    }

    private function obtenerConcurrenciasListas($personaId){
        $concurrencias = ListaAsistencia::select('tema', 'actividades.id')
        ->join('actividades', 'actividades.id', '=', 'lista_asistencias.actividad_id')
        ->join('actividades_internas', 'actividades_internas.actividad_id', '=', 'actividades.id')
        ->where('persona_id', '=', $personaId)->get();
        return $concurrencias;
    }

    private function obtenerConcurrenciaCoordinacion($personaId){
        $concurrencias = Actividades::select('tema', 'actividades.id')
                        ->where('responsable_coordinar', '=', $personaId)->get();
        return $concurrencias;
    }

    private function obtenerConcurrenciaFacilitador($personaId){
        $concurrencias = Actividades::select('tema', 'actividades.id')
                        ->join('actividades_internas', 'actividades.id', '=', 'actividades_internas.actividad_id')
                        ->where('actividades_internas.personal_facilitador', '=', $personaId)->get();
        return $concurrencias;
    }

    public function exportar()
    {
        return Excel::download(new PersonalExport, 'personal.xlsx');
    }

}
