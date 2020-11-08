<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\Cargas_academica;
use Illuminate\Support\Facades\Redirect;

class CargasAcademicaController extends Controller
{
    public function index($id_personal)
    {
        // Personal al que se le quiere añadir una carga académica
        $personal = Personal::findOrFail($id_personal);

        // Cargas académicas por Personal
        $cargas_academicas = Cargas_academica::where('persona_id', $id_personal)->get();

        //Lista de cursos
        $cursos = [
            'BGC400 - Introducción a la Bibliotecología y Gestión de la Información',
            'BGC401 - Metodología de la investigación I',
            'BGC402 - Aplicaciones informáticas a la Bibliotecología',
            'BGC403 - Metodología de la Investigación II',
            'BGC404 - Organización de la información I',
            'BGC405 - Fundamentos pedagógicos aplicados a la Bibliotecología',
            'BGC406 - Usuarios de la información',
            'BGC407 - Diseño de Interfaces Gráficas',
            'BGC408 - Organización de la Información II',
            'BGC409 - Diseño de servicios de información',
            'BGC410 - Análisis de Sistemas Integrados de Información',
            'BGC411 - Gestión de Colecciones',
            'BGC412 - Taller de recursos y materiales didácticos',
            'BGC413 - Organización de recursos de información especiales',
            'BGC414 - Organización administrativa',
            'BGC415 - Alfabetización Informacional',
            'BGC416 - Indización y clasificación',
            'BGC417 - Dirección de unidades de información',
            'BGC418 - Evaluación de procesos administrativos',
            'BGC419 - Taller Gestión de Proyectos',
            'BGC420 - Gestión de la información y el conocimiento en las organizaciones',
            'BGC421 - Estudios Métricos de la Información',
            'BGC422 - Gestión de Documentos y Archivos',
            'BGC423 - Práctica Profesional Supervisada',
            'BGC424 - Seminario Realidad Nacional',
            'BGC425 - Auditoría de la información',
            'BGC500 - Taller de Investigación I',
            'BGC501 - Patrimonio documental y su preservación',
            'BGC502 - Arquitectura de la Información',
            'BGC503 - Mediación Cultural',
            'BGC504 - Taller de investigación II',
            'BGC505 - Implementación de Sistemas Integrados de Información',
            'BGC506 - Debates epistemológicos de la Bibliotecología',
            'BGC530O - Producción editorial en la era digital',
            'BGE210 - Organización de archivos',
            'BGE211 - Almacenamiento y recuperación de la información III',
            'BGE212 - Aplicación de los multimedios',
            'BGE205 - Documentación',
            'BGE214 - Metodología de la investigación',
            'BGE215 - Desarrollo de colecciones',
            'BGE216 - Procesamiento de materiales especiales',
            'BGE201 - Ética profesional',
            'BGE402 - Estudios métricos',
            'BGE219 - Práctica profesional',
            'BGE400 - Gestión para el conocimiento',
            'BGE401 - Indización y resúmenes en Documentación',
            'BGE218 - Control Documental nacional e internacional',
            'BGE403 - Gestión de Proyectos',
            'BGE404 - Gerencia de servicios de información',
            'BGE405 - Comportamiento organizacional',
            'BGE406 - Liderazgo y recursos humanos',
            'BGE407 - Planificación y evaluación de sistemas de información',
            'BGE408 - Auditoría de la información',
            'BGE409 - Evaluación de servicios y formación de usuarios',
            'BG508 - Investigación II'
        ];

        //Se devuelve la vista
        return view('control_personal.carga_academica.listado', [
            'personal' => $personal, // Personal
            'cargas_academicas' => $cargas_academicas, // Cargas académicas
            'cursos' => $cursos //Cursos
        ]);
    }

    //Método que obtiene una cedula por medio del request, devuelve ese Personal espefico junto con la vista para crear una guia academica
    public function create($id_personal)
    {

        $personal = Personal::findOrFail($id_personal);

        //Lista de cursos
        $cursos = [
            'BGC400 - Introducción a la Bibliotecología y Gestión de la Información',
            'BGC401 - Metodología de la investigación I',
            'BGC402 - Aplicaciones informáticas a la Bibliotecología',
            'BGC403 - Metodología de la Investigación II',
            'BGC404 - Organización de la información I',
            'BGC405 - Fundamentos pedagógicos aplicados a la Bibliotecología',
            'BGC406 - Usuarios de la información',
            'BGC407 - Diseño de Interfaces Gráficas',
            'BGC408 - Organización de la Información II',
            'BGC409 - Diseño de servicios de información',
            'BGC410 - Análisis de Sistemas Integrados de Información',
            'BGC411 - Gestión de Colecciones',
            'BGC412 - Taller de recursos y materiales didácticos',
            'BGC413 - Organización de recursos de información especiales',
            'BGC414 - Organización administrativa',
            'BGC415 - Alfabetización Informacional',
            'BGC416 - Indización y clasificación',
            'BGC417 - Dirección de unidades de información',
            'BGC418 - Evaluación de procesos administrativos',
            'BGC419 - Taller Gestión de Proyectos',
            'BGC420 - Gestión de la información y el conocimiento en las organizaciones',
            'BGC421 - Estudios Métricos de la Información',
            'BGC422 - Gestión de Documentos y Archivos',
            'BGC423 - Práctica Profesional Supervisada',
            'BGC424 - Seminario Realidad Nacional',
            'BGC425 - Auditoría de la información',
            'BGC500 - Taller de Investigación I',
            'BGC501 - Patrimonio documental y su preservación',
            'BGC502 - Arquitectura de la Información',
            'BGC503 - Mediación Cultural',
            'BGC504 - Taller de investigación II',
            'BGC505 - Implementación de Sistemas Integrados de Información',
            'BGC506 - Debates epistemológicos de la Bibliotecología',
            'BGC530O - Producción editorial en la era digital',
            'BGE210 - Organización de archivos',
            'BGE211 - Almacenamiento y recuperación de la información III',
            'BGE212 - Aplicación de los multimedios',
            'BGE205 - Documentación',
            'BGE214 - Metodología de la investigación',
            'BGE215 - Desarrollo de colecciones',
            'BGE216 - Procesamiento de materiales especiales',
            'BGE201 - Ética profesional',
            'BGE402 - Estudios métricos',
            'BGE219 - Práctica profesional',
            'BGE400 - Gestión para el conocimiento',
            'BGE401 - Indización y resúmenes en Documentación',
            'BGE218 - Control Documental nacional e internacional',
            'BGE403 - Gestión de Proyectos',
            'BGE404 - Gerencia de servicios de información',
            'BGE405 - Comportamiento organizacional',
            'BGE406 - Liderazgo y recursos humanos',
            'BGE407 - Planificación y evaluación de sistemas de información',
            'BGE408 - Auditoría de la información',
            'BGE409 - Evaluación de servicios y formación de usuarios',
            'BG508 - Investigación II'
        ];

        return view('control_personal.carga_academica.registrar', [
            'personal' => $personal,
            'cursos' => $cursos //Cursos
        ]);
    }

    //Método que inserta una carga academica para un personal especifico en la base de datos
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para control de errores

            //Se crea una nueva instacia de carga académica.
            $carga_academica = new Cargas_academica;

            //se setean los atributos del objeto
            $carga_academica->persona_id = $request->persona_id;
            $carga_academica->ciclo_lectivo = $request->ciclo_lectivo;
            $carga_academica->anio  = $request->anio;
            $carga_academica->nombre_curso = $request->nombre_curso;
            $carga_academica->nrc = $request->nrc;

            //se guarda el objeto en la base de datos
            $carga_academica->save();

            //se redirecciona a la pagina de registro de cargas academicas con un mensaje de exito y los datos específicos del objeto insertado
            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('carga_academica_insertada', $carga_academica); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro cargas academicas
                ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
        }
    }

    // Método que muestra una carga académica específica
    public function edit($id_carga_academica)
    {
        //Busca la carga académica en la base de datos
        $carga_academica = Cargas_academica::find($id_carga_academica);

        //Retorna la carga académica en formato JSON y con un código de éxito de 200
        return response()->json($carga_academica, 200);
    }

    // Método que actualiza la información de la carga académica
    public function update($id_carga_academica, Request $request)
    {
        //Busca la carga académica en la base de datos
        $carga_academica = Cargas_academica::find($id_carga_academica);

        //Al la carga académica encontrada se le actualizan los atributos
        $carga_academica->ciclo_lectivo = $request->ciclo_lectivo;
        $carga_academica->anio  = $request->anio;
        $carga_academica->nombre_curso = $request->nombre_curso;
        $carga_academica->nrc = $request->nrc;

        //Se guarda en la base de datos
        $carga_academica->save();

        //Se reedirige a la página anterior con un mensaje de éxito
        return Redirect::back()
            ->with('exito', '¡Se ha actualizado correctamente!');
    }
}
