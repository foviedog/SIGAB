@extends('layouts.app')

@section('titulo')
{{ $actividad->tema }}
@endsection

@section('css')
{{-- No hay --}}
@endsection


@section('contenido')



{{-- Arreglos de opciones de los select utilizados --}}
@php


$tiposActividad = ['Curso','Conferencia','Taller','Seminario','Seminario','Conversatorio','Órgano colegiado',
'Tutorías','Lectorías','Simposio','Charla','Actividad cocurricular','Tribunales de prueba de grado','Tribunales de defensas públicas',
'Comisiones de trabajo','Externa','Otro'];

$estados = ['Para ejecución','En progreso','Ejecutada','Cancelada'];


@endphp

{{-- Formulario general de actualización de datos de actividad --}}
<form action="{{ route('actividad-promocion.update', $actividad->id) }}" method="POST" role="form" enctype="multipart/form-data" id="actividad-form">
    {{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
    @method('PATCH')
    {{-- Seguridad de envío de datos --}}
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                {{-- Título  --}}
                <div class=" d-flex justify-content-start align-items-center">
                    <h3>{{ $actividad->tema }}</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>
                </div>
                {{-- Botones superiores --}}
                <div>
                    {{-- Botón para regresar al listado de actividades --}}
                    <a href="{{ route('actividad-promocion.listado' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
                    {{-- Boton que habilita opcion de editar --}}
                    <button type="button" id="editar-actividad" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                    {{-- Boton de cancelar edicion --}}
                    <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                </div>
            </div>
            <hr>
            {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
            @if(Session::has('mensaje'))
            <div class="alert alert-success text-center font-weight-bold" role="alert" id="mensaje_exito">
                {!! \Session::get('mensaje') !!}
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger text-center font-weight-bold" role="alert">
                {{ "¡Oops! Algo ocurrió mal"  }}
            </div>
            @endif
            {{-- Barra de navegación entre información genereal y bloques de texto  --}}
            <ul class="nav nav-tabs" id="opciones_tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="info-gen-tab" href="#info-gen">Información general</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="info-esp-tab" href="#">Información específica</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="info-gen" role="tabpanel" aria-labelledby="info-gen-tab">


                    <div class="card shadow-sm my-3 rounded pb-2">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Datos generales </p>
                                </div>
                                <div>
                                    <a href="{{ route('evidencias.show', $actividad->id) }}" id="evidencias" class="btn btn-rojo font-weight-light"><i class="fas fa-file-upload"></i> &nbsp; Evidencias </a>

                                    <a href="{{ route('lista-asistencia.show', $actividad->id) }}" id="lista-asistencia" class="btn btn-rojo"> <i class="far fa-address-book"></i> &nbsp; Lista de asistencia </a>
                                </div>
                            </div>
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
                                                <input type='text' class="form-control w-100" id="tema" name="tema" onkeyup="contarCaracteres(this,100)" value="{{ $actividad->tema }}" required disabled>
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
                                                <input type='text' class="form-control w-100" id="lugar" name="lugar" onkeyup="contarCaracteres(this,60)" value='{{ $actividad->lugar }}' placeholder="No especificado" disabled>

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
                                                <select id="propositos" name="tipo_actividad" class="form-control" required disabled>
                                                    @foreach($tiposActividad as $tipoActividad)
                                                    <option value="{{ $tipoActividad }}" @if($tipoActividad==$actividad->actividadPromocion->tipo_actividad) selected @endif> {{ $tipoActividad }} </option>
                                                    @endforeach
                                                </select>
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
                                                <input type='date' class="form-control w-100" id="fecha_inicio_actividad" name="fecha_inicio_actividad" value='{{ $actividad->fecha_inicio_actividad ?? "No especificado " }}' required disabled>
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
                                                <input type='date' class="form-control w-100" id="fecha_final_actividad" name="fecha_final_actividad" value='{{ $actividad->fecha_final_actividad ?? "No especificado " }}' required disabled>

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
                                                        <input type="number" min="0" step="1" name="duracion" id="duracion" value="{{ $actividad->duracion }}" disabled />
                                                        <span class=" d-flex align-items-center ml-2 font-weight-bold"> h</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="row d-felx justify-content-center">

                                <div class="col-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-75">
                                                <label for="estado">Estado <i class="text-danger">*</i></label>
                                            </div>
                                            <div class="d-flex">
                                                <select id="propositos" name="estado" class="form-control" required disabled>
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
                    </div>

                    <div class="border-top">

                        <div class="row d-flex justify-content-center">
                            <div class="col-6">
                                <div class="card shadow-sm rounded pb-2 mt-2">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">
                                            Responsable de coordinar la actividad
                                        </p>
                                    </div>
                                    <div class="card-body ">
                                        <div class="row d-flex justify-content-center mb-2" id="campo-buscar">
                                            {{-- Campo: Responsable de coordinar --}}
                                            <div class="col-6 ">
                                                <div class="input-group w-80">
                                                    <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " value='{{ $actividad->responsableCoordinar->persona_id }}' required>
                                                    <div class="input-group-append">
                                                        <button type="button" id="buscar" class="btn btn-contorno-rojo">Buscar</button>
                                                        <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar" class="ml-2 mt-2"> <i class="far fa-question-circle fa-lg "></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type='hidden' id="responsable-encontrado" name="responsable-encontrado" value="true">
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="alert alert-danger w-75 text-center" role="alert" id="mensaje-alerta"></div>
                                        </div>

                                        <div class="row justify-content-center pb-3" id="tarjeta-responsable">
                                            <div class="p-3 w-100 d-flex border-top justify-content-center" id="info-responsable">
                                                <div class="col-3">
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <div class="overflow-hidden rounded " style="max-width: 160px; max-height: 160px; ">
                                                            <img class="rounded mb-3" id="imagen-responsable" src="{{ URL::asset('img/fotos/') }}/{{ $actividad->responsableCoordinar->persona->imagen_perfil }}" style="max-width: 100%; max-height:  100%; " />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-5  d-flex justify-content-start align-items-center ">
                                                    <div class="d-flex justify-content-start align-items-center ">
                                                        <div class="text-start mb-3">
                                                            <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-responsable-card"> {{ $actividad->responsableCoordinar->persona_id }}</span> <br>
                                                            <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-responsable"> {{ $actividad->responsableCoordinar->persona->nombre }} </span> <br>
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
            <div class="row d-flex justify-content-center mt-3">
                {{-- Boton para enviar los cambios --}}
                <button type="submit" id="guardar-cambios" class="btn btn-rojo">Guardar cambios</button>
            </div>

        </div>
    </div>

</form>


@endsection


@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_promocion/detalle_editar.js') }}" defer></script>
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script>
    $("input[type='number']").inputSpinner();

</script>
@endsection



@section('pie')
Copyright
@endsection
