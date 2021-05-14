@extends('layouts.app')

@section('titulo')
{{ $actividad->tema }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$tiposActividad = GlobalArrays::TIPOS_ACTIVIDAD_PROMOCION;
$estados = GlobalArrays::ESTADOS_ACTIVIDAD;
// Formato de fechas para que se pueda utilizar en el rango de fechas del api: daterangePicker()
$fechaIni = date("d/m/Y", strtotime(str_replace('/', '-', $actividad->fecha_inicio_actividad)));
$fechaFin = date("d/m/Y", strtotime(str_replace('/', '-', $actividad->fecha_final_actividad)));

$rangoFechas = $fechaIni . " - " . $fechaFin
@endphp

@section('contenido')

<div class="card">
    <div class="card-body">

        {{-- Mensajes FIXED --}}
        <div class="mensaje-container" id="mensaje-alerta" style="display:none;">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; ">  </div>
        </div>
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>{{ $actividad->tema }}</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>

                @if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD()) {{-- Se verifica si tiene el privilegio para autorizar una actividad --}}
                @if($actividad->autorizada == 0) {{-- Se verifica si la actividad aún no ha sido autorizada --}}
                {{-- Botón para autorizar actividad --}}
                <form action="{{ route('actividad-promocion.autorizar') }}" method="POST" enctype="multipart/form-data" id="form-guardar">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" value="{{ Request::route('id_actividad') }}" name="id_actividad">
                    <button type="submit" class="btn btn-info ml-4"><i class="fas fa-check-double"></i> &nbsp; Autorizar actividad </button>
                </form>
                @else {{-- Si la actividad ya fue autorizada, solo se muestra un botón desactivado que lo recalca --}}
                <button class="btn btn-success ml-4" disabled><i class="fas fa-check-double"></i> &nbsp; Actividad autorizada </button>
                @endif
                @endif

            </div>
            {{-- Botones superiores --}}
            <div>
                @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
                {{-- Botón para regresar al listado de actividades --}}
                <a href="{{ route('actividad-promocion.listado') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
                @endif

                @if(Accesos::ACCESO_MODIFICAR_ACTIVIDADES())
                {{-- Boton que habilita opcion de editar --}}
                <button type="button" id="editar-actividad" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                {{-- Boton de cancelar edicion --}}
                <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                @endif
            </div>
        </div>
        <hr>


        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Barra de navegación entre información genereal y bloques de texto  --}}
        <ul class="nav nav-tabs" id="opciones_tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-gen-tab" href="#">Información general</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="info-esp-tab" href="#">Información específica</a>
            </li>
        </ul>

        @if(Accesos::ACCESO_MODIFICAR_ACTIVIDADES())
        {{-- Formulario general de actualización de datos de actividad --}}
        <form autocomplete="off" action="{{ route('actividad-promocion.update', $actividad->id) }}" method="POST" role="form" enctype="multipart/form-data" id="actividad-form" onsubmit="activarLoader('Agregando cambios');">
            {{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
            @method('PATCH')
            {{-- Seguridad de envío de datos --}}
            @csrf
            @endif

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="info-gen" role="tabpanel" aria-labelledby="info-gen-tab" role="tabpanel">

                    <div class="row d-flex justify-content-end mt-4 px-3">
                        <div>
                            @if(Accesos::ACCESO_VISUALIZAR_EVIDENCIAS())
                            <a href="{{ route('evidencias.show', $actividad->id) }}" id="evidencias" class="btn btn-azul-una btn-sombreado-azul font-weight-light mr-3"><i class="fas fa-file-upload"></i> &nbsp; Evidencias </a>
                            @endif
                            @if(Accesos::ACCESO_VISUALIZAR_LISTA_PARTICIPACION())
                            <a href="{{ route('asistencia-promocion.show', $actividad->id) }}" id="lista-asistencia" class="btn btn-azul-una btn-sombreado-azul"> <i class="far fa-address-book"></i> &nbsp; Lista de asistencia </a>
                            @endif
                        </div>
                    </div>

                    {{-- Campos iniciales --}}
                    <div class="row py-3 mt-2 border-bottom">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Datos generales </p>
                                </div>

                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    {{-- Campo: Tema --}}
                                    <div class="w-90">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-dark">Tema: <i class="text-danger">*</i></span>
                                            </div>
                                            <input type='text' class="form-control " id="tema" name="tema" onkeyup="contarCaracteres(this,100)" value="{{ $actividad->tema }}" required disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Tema o nombre de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center w-5">
                                                <span id="mostrar_tema"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Campo: LUGAR --}}
                                    <div class="w-90">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-dark">Lugar: <i class="text-danger">*</i></span>
                                            </div>
                                            <input type='text' class="form-control" id="lugar" name="lugar" value="{{ $actividad->lugar }}" onkeyup=" contarCaracteres(this,60)" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Lugar a realizar la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center w-5">
                                                <span id="mostrar_lugar"></span>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Campo: TIPO DE ACTIVIDAD--}}
                                    <div class="w-90">
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-dark">Tipo de actividad: <i class="text-danger">*</i></span>
                                            </div>
                                            <select class="form-control" id="tipo_actividad" name="tipo_actividad" required disabled>
                                                @foreach($tiposActividad as $tipoActividad)
                                                <option value="{{ $tipoActividad }}" @if($tipoActividad==$actividad->actividadPromocion->tipo_actividad) selected @endif> {{ $tipoActividad }} </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Tipo de actividad de actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <div class=" w-5">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card pb-5">
                                <div class="card-header">
                                    <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Características de la actividad </p>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-center align-items-center pb-4">

                                    {{-- DURACIÓN --}}
                                    <div class="w-90 d-flex justify-content-between">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-dark">Duración Total: </span>
                                            </div>
                                            <div class="w-50 mx-2">
                                                <input type="number" value="0" min="0" step="1" name="duracion" id="duracion" value="{{ $actividad->duracion }}" disabled />
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text font-weight-bold font-italic"> h</span>
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Se ingresa el número de horas totales de la duración de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <div class="w-5">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Campo: RANGO DE FECHAS --}}
                                    <div class="w-90">
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-dark">Fechas: <i class="text-danger">*</i></span>
                                            </div>
                                            <input type="text" class="form-control datetimepicker" name="rango_fechas" id="rango_fechas" placeholder="DD/MM/YYYY - DD/MM/YYYY" value="{{ $rangoFechas ?? null }}" disabled required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-contorno-rojo" data-toggle="tooltip" data-placement="top" title="Vaciar el campo de fecha" onclick="eliminarFechas(this);" disabled><i class="fas fa-calendar-times fa-lg"></i></button>
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Fecha de inicio y fecha final en el que se ejecuta la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                            </div>
                                            <div class=" w-5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-90">
                                        {{-- ESTADO --}}
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-dark">Estado: <i class="text-danger">*</i></span>
                                            </div>
                                            <select class="form-control" id="estado" name="estado" required disabled>
                                                @foreach($estados as $estado)
                                                <option value="{{ $estado }}" @if($estado==$actividad->estado) selected @endif> {{ $estado }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Facilitador y coordinador --}}
                    <div class="row my-4 px-3">
                        <div class="card w-100">
                            <div class="card-header">
                                <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Personal responsable </p>
                            </div>
                            <div class="card-body row d-flex justify-content-center">
                                {{-- RESPONSABLE DE ACTIVIDAD --}}
                                <div class="col-5">
                                    {{-- INPUT PARA REALIZAR LA BÚSQUEDA DEL RESPONSABLE --}}
                                    <div class="row d-flex justify-content-center my-4">
                                        <div class="input-group w-90">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text textd-dark font-weight-bold"> Responsable de coordinar: <i class="text-danger">*</i> </span>
                                            </div>
                                            <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " value="{{ $actividad->responsableCoordinar->persona_id }}" required disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar"> <i class="far fa-question-circle fa-lg "></i></span>
                                                <button type="button" id="buscarCoordinador" class="btn btn-contorno-azul-una" disabled>Buscar</button>
                                            </div>
                                        </div>
                                        <input class="form-control" type='hidden' id="responsable-encontrado" name="responsable_encontrado" value="{{ $actividad->responsableCoordinar->persona_id }}">
                                    </div>

                                    {{-- MENSAJE DE ALERTA PARA MANEJO DE ERRORES --}}
                                    <div class="row d-flex justify-content-center">
                                        <div class="alert alert-danger w-50 text-center" role="alert" id="alerta-responsable" style="display: none;"></div>
                                    </div>
                                    {{-- TARJETA CON LA INFORMACIÓN DEL RESPONSABLE --}}
                                    <div class="row justify-content-center pb-3" id="responsable-info">
                                        <div class="w-75 p-3 d-flex border-top justify-content-center">
                                            <div class="col-3 p-0">
                                                <div class="d-flex justify-content-center mb-2">
                                                    <div class="overflow-hidden rounded " style="max-width: 160px; max-height: 160px; ">
                                                        <img class="rounded mb-3" id="imagen-responsable" src="{{ URL::asset('img/fotos/') }}/{{ $actividad->responsableCoordinar->persona->imagen_perfil }}" style="max-width: 100%; max-height:  100%; " />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9  d-flex justify-content-start align-items-center ">
                                                <div class="d-flex justify-content-start align-items-center w-100">
                                                    <div class="text-start mb-3">
                                                        <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-responsable-card"> {{ $actividad->responsableCoordinar->persona_id }}</span> <br>
                                                        <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-responsable">{{ $actividad->responsableCoordinar->persona->nombre." " . $actividad->responsableCoordinar->persona->apellido}} </span> <br>
                                                        <strong>Correo institucional: </strong> &nbsp;&nbsp;<span id="correo-responsable"> {!! $actividad->responsableCoordinar->persona->correo_institucional ?? '<i class="font-weight-light"> No registrado</i>' !!}</span> <br>
                                                        <strong>Número de teléfono: </strong> &nbsp;&nbsp;<span id="num-telefono-responsable"> {!! $actividad->responsableCoordinar->persona->telefono_celular ?? '<i class="font-weight-light"> No registrado</i>' !!} </span> <br>
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
                                                    <textarea type='text' class="form-control w-100" id="objetivos" name="objetivos" rows="4" disabled>{{ $actividad->objetivos }} </textarea>
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
                                                    <textarea class="form-control w-100" id="descripcion" name="descripcion" rows="4" disabled>{{ $actividad->descripcion }}</textarea>
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
                                                <div class=" d-flex justify-content-between align-items-center">
                                                    <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">

                                                        <i class="fas fa-user-edit fa-2x"></i> &nbsp;&nbsp
                                                        Evaluación &nbsp;&nbsp

                                                        <span data-toggle="tooltip" data-placement="right" title="Se ingresa una evaluación o comentario sobre la actividad">
                                                            <i class="far fa-question-circle fa-lg"></i>
                                                        </span>
                                                    </p>

                                                    <span class="text-muted" id="mostrar_evaluacion"></span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <textarea type='text' class="form-control w-100" id="evaluacion" name="evaluacion" rows="4" onkeyup="contarCaracteres(this,500)" disabled> {{ $actividad->evaluacion }} </textarea>
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
                                                    <textarea type='text' class="form-control w-100" id="recursos" name="recursos" rows="4" onkeyup="contarCaracteres(this,500)" disabled> {{ $actividad->actividadPromocion->recursos }} </textarea>
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
                                                    <textarea type='text' class="form-control w-100" id="instituciones_patrocinadoras" name="instituciones_patrocinadoras" rows="4" onkeyup="contarCaracteres(this,200)" disabled>{{ $actividad->actividadPromocion->instituciones_patrocinadoras}} </textarea>
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
            @if(Accesos::ACCESO_MODIFICAR_ACTIVIDADES())
            <div class="row d-flex justify-content-center mt-3">
                {{-- Boton para enviar los cambios --}}
                <button type="submit" id="guardar-cambios" class="btn btn-rojo">Guardar cambios</button>
            </div>
        </form>
        @endif

    </div>
</div>

@endsection

@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_promocion/detalle_editar.js') }}" defer></script>
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script>
    $("input[type='number']").inputSpinner();

</script>
@endsection
