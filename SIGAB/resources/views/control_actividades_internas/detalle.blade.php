@extends('layouts.app')

@section('titulo')
[[nombre de capacitacion]]
@endsection

@section('css')
{{-- No hay --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
@endsection

@section('contenido')

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estadosCiviles = ['Soltero(a)','Casado(a)','Viudo(a)','Divorciado(a)','Unión libre'];
$generos = ['Femenino','Masculino','Otro'];
$colegiosProcedencias = ['Público','Técnico','Científico','Bilingüe','Nocturno','Privado'];
$tiposBecas = ['No tiene','Beca por condición socioeconómica','Beca Omar Dengo (Residencia estudiantil)','Becas de posgrado',
'Beca por participación en actividades artísticas y deportivas','Beca por participación en movimiento estudiantil',
'Honor','Estudiante Asistente Académico y Paracadémico','Intercambio estudiantil','Préstamos estudiantiles','Giras'];
@endphp

{{-- Formulario general de estudiante --}}
{{-- <form action="{{ route('estudiante.update', ) }}" method="POST" role="form" enctype="multipart/form-data"> --}}
@csrf
{{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
@method('PATCH')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">

            <h3>[[ Nombre de la actividad ]]</h3>
            <div>
                <a href="{{ route('listado-actividad-interna' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
            </div>
        </div>
        <hr>

        {{-- Barra de navegación entre información genereal y bloques de texto  --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-gen-tab" data-toggle="tab" href="#info-gen" role="tab" aria-controls="info-gen" aria-selected="true">Información general</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="info-esp-tab" data-toggle="tab" href="#info-esp" role="tab" aria-controls="info-esp" aria-selected="false">Información específica</a>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="info-gen" role="tabpanel" aria-labelledby="info-gen-tab">


                <div class="card shadow-sm my-3 rounded pb-2">
                    <div class="card-header py-3">
                        <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Datos generales </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Campos de la izquierda --}}
                            <div class="col">
                                {{-- Campo: Tema --}}
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="tema">Tema <i class="text-danger">*</i></label>
                                                <span data-toggle="tooltip" data-placement="right" title="Tema o nombre de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <span class="text-muted " id="mostrar_tema"></span>
                                        </div>
                                        <div class="d-flex">
                                            <input type='text' class="form-control w-100" id="tema" name="tema" onkeyup="contarCaracteres(this,100)" required>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                {{-- Campo: Lugar --}}
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">

                                            <div>
                                                <label for="lugar">Lugar </label>
                                                <span data-toggle="tooltip" data-placement="right" title="Lugar a realizar la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            {{-- espacio donde se muestran los caracteres restantes  --}}
                                            <span class="text-muted" id="mostrar_lugar"></span>
                                        </div>
                                        <div class="d-flex">
                                            <input type='text' class="form-control w-100" id="lugar" name="lugar" onkeyup="contarCaracteres(this,60)">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Campo: Facilitador de actividad --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="facilitador_actividad">Facilitador de actividad<i class="text-danger">*</i>
                                                </label>
                                                <span data-toggle="tooltip" data-placement="right" title="Ingrese el nombre completo del facilitador de la actividad" class="mx-2"><i class="far fa-question-circle fa-lg"></i></span>
                                                {{-- espacio donde se muestran los caracteres restantes  --}}
                                            </div>
                                            <span class="text-muted" id="mostrar_facilitador_actividad"></span>

                                        </div>

                                        <div class="d-flex">
                                            <input type='text' class="form-control w-100" id="facilitador_actividad" name="facilitador_actividad" onkeyup="contarCaracteres(this,45)" required>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                {{-- Campo: Fecha de actividad--}}
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="fecha_actividad">Fecha de inicio<i class="text-danger">*</i>
                                                </label>
                                                <span data-toggle="tooltip" data-placement="right" title="Se selecciona la fecha de inicio de actividad, también se puede escribir siguiendo el formato determinado" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <input type='date' class="form-control w-100" id="fecha_inicio_actividad" name="fecha_inicio_actividad" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Campo: Fecha de actividad--}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="fecha_actividad">Fecha final<i class="text-danger">*</i>
                                                </label>
                                                <span data-toggle="tooltip" data-placement="right" title="Se selecciona la fecha a finalizar la actividad, también se puede escribir siguiendo el formato determinado" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>

                                        </div>
                                        <div class="d-flex">
                                            <input type='date' class="form-control w-100" id="fecha_final_actividad" name="fecha_final_actividad" required>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Campo: Duracion --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="duracion">Duración Total</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Se ingresa el número de horas totales de la duración de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-center">
                                            <div class="col d-flex justify-content-center">
                                                <div class="w-50  d-flex ">
                                                    <input type="number" value="0" min="0" step="1" name="duracion" id="duracion" />
                                                    <span class="d-flex align-items-center ml-2 font-weight-bold"> h</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        {{-- Campo: Proposito  --}}
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-75">
                                            <label for="proposito">Propósito<i class="text-danger">*</i></label>
                                        </div>
                                        <div class="d-flex">
                                            <select class="form-control w-100" id="proposito" name="proposito" required>
                                                <option value="">Seleccione</option>
                                                <option value="Inducción">Inducción</option>
                                                <option value="Capacitación">Capacitación</option>
                                                <option value="Actualización">Actualización</option>
                                                <option value="Involucramiento del personal">Involucramiento del personal</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Campo: Tipo de Actividad  --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-75">
                                            <label for="tipo_actividad">Tipo de actividad<i class="text-danger">*</i></label>
                                        </div>
                                        <div class="d-flex">
                                            <select class="form-control w-100" id="tipo_actividad" name="tipo_actividad" required>
                                                <option value="">Seleccione</option>
                                                <option value="Curso">Curso</option>
                                                <option value="Conferencia">Conferencia</option>
                                                <option value="Taller">Taller</option>
                                                <option value="Seminario">Seminario</option>
                                                <option value="Conversatorio">Conversatorio</option>
                                                <option value="Órgano colegiado">Órgano colegiado</option>
                                                <option value="Tutorías">Tutorías</option>
                                                <option value="Lectorías">Lectorías</option>
                                                <option value="Simposio">Simposio</option>
                                                <option value="Charla">Charla</option>
                                                <option value="Actividad cocurricular">Actividad co curricular</option>
                                                <option value="Tribunales de prueba de grado">Tribunales de prueba de grado</option>
                                                <option value="Tribunales de defensas públicas">Tribunales de defensas públicas</option>
                                                <option value="Comisiones de trabajo">Comisiones de trabajo</option>
                                                <option value="Externa">Externa</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Campo: Poblacion a la que va dirigida la actividad   --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-75">
                                            <label for="publico_dirigido">Dirigido a <i class="text-danger">*</i></label>
                                        </div>
                                        <div class="d-flex">
                                            <select class="form-control w-100" id="publico_dirigido" name="publico_dirigido" required>
                                                <option value="">Seleccione</option>
                                                <option value="Estudiantes de primer ingreso">Estudiantes de primer ingreso</option>
                                                <option value="Estudiantes regulares">Estudiantes regulares</option>
                                                <option value="Estudiantes graduados">Estudiantes graduados</option>
                                                <option value="Personal Docente">Personal Docente</option>
                                                <option value="Personal Administrativo">Personal Administrativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- Campo: Estado de actividad  --}}
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-75">
                                            <label for="estado">Estado <i class="text-danger">*</i></label>
                                        </div>
                                        <div class="d-flex">
                                            <select class="form-control w-100" id="estado" name="estado" required>
                                                <option value="">Seleccione</option>
                                                <option value="Para ejecución">Para ejecución</option>
                                                <option value="En progreso">En progreso</option>
                                                <option value="Ejecutada">Ejecutada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Campo: Certificación  --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <label for="certificacion">Certificación</label>
                                                <span data-toggle="tooltip" data-placement="right" title="En este espacio se ingresa si la actividad ofrece certificación o no, si se conoce el título de la certificación puede ingresarlo"><i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <span class="text-muted" id="mostrar_certificacion_actividad"></span>
                                        </div>
                                        <div class="d-flex">
                                            <input class="form-control w-100" type='text' name="certificacion_actividad" id="certificacion_actividad" onkeyup="contarCaracteres(this,100)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Campo: Ambito  --}}
                            <div class="col">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="w-75">
                                        <div class="d-flex justify-content-between w-75">
                                            <label for="ambito">Ámbito<i class="text-danger">*</i></label>
                                        </div>
                                        <div class="d-flex">
                                            <select class="form-control w-100" id="ambito" name="ambito" required>
                                                <option value="">Seleccione</option>
                                                <option value="Nacional">Nacional</option>
                                                <option value="Internacional">Internacional</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top">
                    <div class="row d-flex justify-content-center my-4">
                        {{-- Campo: Responsable de coordinar --}}
                        <div class="col-3 d-flex justify-content-end">
                            <label for="responsable_coordinar">
                                Responsable de coordinar<i class="text-danger">*</i>
                            </label>
                        </div>

                        <div class="col-6 ">
                            <div class="input-group w-50">
                                <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " required>
                                <div class="input-group-append">
                                    <button type="button" id="buscar" class="btn btn-contorno-rojo">Buscar</button>
                                    <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar" class="ml-2"> <i class="far fa-question-circle fa-lg mr-2"></i></span>
                                </div>
                            </div>
                        </div>
                        <input class="form-control" type='hidden' id="responsable-encontrado" name="responsable-encontrado" value="false">
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-danger w-50 text-center" role="alert" id="mensaje-alerta"></div>
                    </div>

                    <div class="row justify-content-center pb-3" id="targeta-responsable">
                        <div class="p-3 w-50 d-flex border-top border-secondary  justify-content-center">
                            <div class="col-3">
                                <div class="d-flex justify-content-center mb-2">
                                    <img class="rounded mb-3" width="160" height="160" id="imagen-responsable" />
                                </div>
                            </div>
                            <div class="col-5  d-flex justify-content-start align-items-center ">
                                <div class="d-flex justify-content-start align-items-center ">
                                    <div class="text-start mb-3">
                                        <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-responsable-card"> </span> <br>
                                        <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-responsable"> </span> <br>
                                        <strong>Correo institucional: </strong> &nbsp;&nbsp;<span id="correo-responsable"> </span> <br>
                                        <strong>Número de teléfono: </strong> &nbsp;&nbsp;<span id="num-telefono-responsable"></span> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="info-esp" role="tabpanel" aria-labelledby="info-esp-tab">
                <div class="mt-4">
                    <div class="row">

                        {{-- Campo: Objetivos --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="far fa-file-alt fa-2x"></i> &nbsp;&nbsp
                                                Objetivos de la actividad &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se describen los objetivos de la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="objetivos" name="objetivos" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo: Agenda --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="far fa-calendar fa-2x"></i> &nbsp;&nbsp
                                                Agenda &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se describen los puntos a tratar en la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea class="form-control w-100" id="agenda" name="agenda" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{-- Campo: Descripción --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">

                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="fas fa-receipt fa-2x"></i> &nbsp;&nbsp
                                                Descripcion &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Descripción y detalles de la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea class="form-control w-100" id="agenda" name="agenda" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Campo: Evaluacion --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="fas fa-user-edit fa-2x"></i> &nbsp;&nbsp
                                                Evaluación &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se ingresa una evaluación o comentario sobre la actividad">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="evaluacion" name="evaluacion" rows="4" onkeyup="contarCaracteres(this,500)"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Campo: Recursos --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="fas fa-pencil-ruler fa-2x"></i> &nbsp;&nbsp
                                                Recursos &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Recursos necesarios para desarrollar la actividad ">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="evaluacion" name="evaluacion" rows="4" onkeyup="contarCaracteres(this,500)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo: Instituciones patrocinadoras --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-100">
                                    <div class="card shadow-sm rounded pb-2">
                                        <div class="card-header py-3">
                                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                                <i class="far fa-building fa-2x"></i> &nbsp;&nbsp
                                                Instiuciones patrocinadoras &nbsp;&nbsp
                                                <span data-toggle="tooltip" data-placement="right" title="Se ingresa el nombre de las instituciones o entidades patrocinadoras de la actividad si existen">
                                                    <i class="far fa-question-circle fa-lg"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <textarea type='text' class="form-control w-100" id="instituciones_patrocinadoras" name="instituciones_patrocinadoras" rows="4" onkeyup="contarCaracteres(this,200)"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
{{-- </form> --}}
@endsection

@section('pie')
Copyright
@endsection
