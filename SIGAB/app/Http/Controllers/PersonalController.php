<?php

namespace App\Http\Controllers;

use App\Idioma;
use App\Participacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Persona;
use App\Personal;

class PersonalController extends Controller
{



    //Devuevle el listado del personal ordenados por su apellido.
    public function index()
    {

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
                ->orWhere('personal.tipo_puesto', 'like', '%' . $filtro . '%') // Filtro para buscar tipo de puesto del personal
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
    }

    public function create()
    {
        return view('control_personal.registrar');
    }
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para evitar el redireccionamiento a página default de error de Laravel

            $persona = new Persona; //Se crea una nueva instacia de Persona
            $personal = new Personal; //Se crea una nueva instacia de estudiante
            $participacion = new Participacion(); //Se crea una nueva instacia de estudiante

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

            //se setean los atributos del objeto tipo personal
            $personal->persona_id = $request->cedula;
            $personal->carga_academica = $request->carga_academica;
            $personal->grado_academico = $request->grado_academico;
            $personal->cargo = $request->cargo;
            $personal->tipo_nombramiento = $request->tipo_nombramiento;
            $personal->tipo_puesto = $request->tipo_puesto;
            $personal->jornada = $request->jornada;
            $personal->lugar_trabajo_externo = $request->trabajo_externo;
            $personal->anio_propiedad = $request->anio_propiedad;
            $personal->experiencia_profesional = $request->experiencia_profesional;
            $personal->experiencia_academica = $request->experiencia_academica;
            $personal->regimen_administrativo = $request->regimen_administrativo;
            $personal->regimen_docente = $request->regimen_docente;
            $personal->area_especializacion_1 = $request->area_especializacion_1;
            $personal->area_especializacion_2 = $request->area_especializacion_2;

            $personal->save(); //se guarda el objeto en la base de datos
            //se redirecciona a la pagina de registro estudiante con un mensaje de exito y los datos específicos del objeto insertado

            $participacion->persona_id =  $request->cedula;
            $participacion->capacitacion_didactica =  $request->capacitacion_didactica;
            $participacion->publicaciones =  $request->publicaciones;
            $participacion->cursos_impartidos =  $request->cursos_impartidos;
            $participacion->miembro_comisiones =  $request->miembro_comisiones;
            $participacion->miembro_prueba_grado =  $request->miembro_prueba_grado;
            $participacion->evaluador_defensa_publica =  $request->evaluador_defensa_publica;
            $participacion->evaluacion_interna_ppaa =  $request->evaluacion_interna_ppaa;
            $participacion->evaluacion_externa_ppaa =  $request->evaluacion_externa_ppaa;
            $participacion->reconocimientos =  $request->reconocimientos;
            $participacion->save();

            if (!is_null($request->idiomasForm)) {
                $idiomas =  json_decode($request->idiomasForm);
                foreach ($idiomas as &$idoma) {
                    $idiomaP =  new Idioma();
                    $idiomaP->persona_id =  $request->cedula;
                    $idiomaP->nombre =  $idoma;
                    $idiomaP->save();
                }
            }

            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('persona_registrada', $persona) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('personal_registrado', $personal); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos


        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro estudiante
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    public function show($id_personal)
    {
        $personal = Personal::join('participaciones', 'personal.persona_id', '=', 'participaciones.persona_id')
            ->where('personal.persona_id', '=', $id_personal)
            ->first();
        $idiomas = Idioma::where('persona_id', '=', $id_personal)
            ->get();
        return view('control_personal.detalle', [
            'personal' => $personal,
            'idiomas' => $idiomas
        ]);
    }


    //Metodo para actualizar los datos del personal
    public function update($id_personal, Request $request)
    {
        //Se obtiene la persona en base al ID
        $persona = Persona::find($id_personal);

        //Se obtiene el personal que contiene ese ID
        $personal = Personal::find($id_personal);

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

        //Datos asociados al personal (no incluye el ID ya que no debería ser posible editarlo)
        $personal->carga_academica = $request->carga_academica;
        $personal->grado_academico = $request->grado_academico;
        $personal->tipo_nombramiento = $request->tipo_nombramiento;
        $personal->tipo_puesto = $request->tipo_puesto;
        $personal->jornada = $request->jornada;
        $personal->lugar_trabajo_externo = $request->trabajo_externo;
        $personal->anio_propiedad = $request->anio_propiedad;
        $personal->experiencia_profesional = $request->experiencia_profesional;
        $personal->experiencia_academica = $request->experiencia_academica;
        $personal->regimen_administrativo = $request->regimen_administrativo;
        $personal->regimen_docente = $request->regimen_docente;
        $personal->area_especializacion_1 = $request->area_especializacion_1;
        $personal->area_especializacion_2 = $request->area_especializacion_2;

        //Se guardan los datos del personal
        $personal->save();
        //Llamado al método que actualiza la foto de perfil
        $this->update_avatar($request, $personal);

        //Se retorna el detalle del personal ya modificado
        return redirect("/personal/detalle/{$personal->persona_id}");
    }


    public function edit($id_personal)
    {
        $personal = Persona::find($id_personal);
        if($personal===null){
            return response("No existe",404);
        }
        else{
        return response()->json($personal,200);
        }
    }


    public function update_avatar($request, $personal)
    {
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');
            $archivo = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/img/fotos/' . $archivo));

            if ($personal->persona->imagen_perfil != "default.jpg")
                File::delete(public_path('/img/fotos/' . $personal->persona->imagen_perfil)); //Elimina la foto anterior

            $personal->persona->imagen_perfil = $archivo;
            $personal->persona->save();
        }

        return \Redirect::back();
    }
}