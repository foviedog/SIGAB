<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Estudiante;
use Image;
use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla
use App\Guias_academica;

class EstudianteController extends Controller
{

    //Devuevle el listado de los estudiantes ordenados por su apellido.
    public function index()
    {
        // Array que devuelve los items que se cargan por página
        $paginaciones = [2, 4, 25, 50, 100];

        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 2 por página
        $itemsPagina = request('itemsPagina', 2);

        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);

        //En caso de que el filtro esté seteado entonces se realiza un búsqueda en la base de datos con dichos datos.
        if (!is_null($filtro)) {
            $estudiantes = Estudiante::join('personas', 'estudiantes.persona_id', '=', 'personas.persona_id') //Inner join de estudiantes con personas
                ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                ->orWhere('personas.apellido', 'like', '%' . $filtro . '%') // Filtro para buscar por apellido de persona
                ->orWhere('personas.nombre', 'like', '%' . $filtro . '%') // Filtro para buscar por cédula
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
            'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
        ]);
    }

    //Retorna la vista para crear un estudiante
    public function create()
    {
        return view('control_educativo.informacion_estudiantil.registrar');
    }

    //Método que inserta un estudiante especifico en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores

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
            $persona->save(); //se guarda el objeto en la base de datos

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
            $estudiante->anio_graduacion_estimado_1 = $request->anio_gradacion_estimado_1;
            $estudiante->anio_graduacion_estimado_2 = $request->anio_graduacion_estimado_2;
            $estudiante->anio_desercion = $request->anio_desercion;
            $estudiante->tipo_beca = $request->tipo_beca;
            $estudiante->nota_admision = $request->nota_admision;
            $estudiante->apoyo_educativo = $request->apoyo_educativo;
            $estudiante->residencias_UNA = $request->residencias;
            $estudiante->save(); //se guarda el objeto en la base de datos

            //se redirecciona a la pagina de registro estudiante con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('persona_insertado', $persona) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('estudiante_insertado', $estudiante) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('cedula', $request->cedula); //Retorna un objeto en el response con la cedula, de otra manera no obtiene el dato de manera adecuada para imprimirlo en la vista
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro estudiante
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    // Toma al estudiante por el id para mostrar su informacion detallada
    public function show($id_estudiante)
    {
        $estudiante = Estudiante::findOrFail($id_estudiante);
        return view('control_educativo.informacion_estudiantil.detalle', [
            'estudiante' => $estudiante,
        ]);
    }


    //Metodo para actualizar los datos del estudiante
    public function update($id_estudiante, Request $request)
    {
        $persona = Persona::find($id_estudiante);

        $estudiante = Estudiante::find($id_estudiante);

        //Datos asociados a la persona
        //$persona->persona_id = $request->cedula;
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

        $persona->save();
        //Datos asociados al estudiante
        //$estudiante->persona_id = $request->cedula;
        $estudiante->direccion_lectivo = $request->direccion_lectivo;
        $estudiante->cant_hijos = $request->cantidad_hijos;
        $estudiante->tipo_colegio_procedencia = $request->tipo_colegio_procedencia;
        $estudiante->condicion_discapacidad = $request->condicion_discapacidad;
        $estudiante->anio_ingreso_ebdi = $request->anio_ingreso_ebdi;
        $estudiante->anio_ingreso_UNA = $request->anio_ingreso_una;
        $estudiante->carrera_matriculada_1 = $request->carrera_matriculada_1;
        $estudiante->carrera_matriculada_2 = $request->carrera_matriculada_2;
        $estudiante->anio_graduacion_estimado_1 = $request->anio_gradacion_estimado_1;
        $estudiante->anio_graduacion_estimado_2 = $request->anio_graduacion_estimado_2;
        $estudiante->anio_desercion = $request->anio_desercion;
        $estudiante->tipo_beca = $request->tipo_beca;
        $estudiante->nota_admision = $request->nota_admision;
        $estudiante->apoyo_educativo = $request->apoyo_educativo;
        $estudiante->residencias_UNA = $request->residencias;

        $this->update_avatar($request, $estudiante);

        return redirect("/estudiante/detalle/{$estudiante->persona_id}");
    }

    public function update_avatar($request, $estudiante)
    {
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');
            $archivo = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/img/fotos/' . $archivo));

            if ($estudiante->persona->imagen_perfil != "default.jpg")
                File::delete(public_path('/img/fotos/' . $estudiante->persona->imagen_perfil)); //Elimina la foto anterior

            $estudiante->persona->imagen_perfil = $archivo;
            $estudiante->persona->save();
        }

        return \Redirect::back();
    }
}
