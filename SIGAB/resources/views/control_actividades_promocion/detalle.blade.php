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
<form action="{{ route('actividad-interna.update', $actividad->id) }}" method="POST" role="form" enctype="multipart/form-data" id="actividad-form">
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
                    <a href="{{ route('actividad-interna.listado' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
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
                {{ "¡Oops! Algo ocurrió mal. ".$error }}
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
                        </div>
                    </div>

                    <div class="border-top">
                    </div>

                </div>

                <div class="tab-pane fade" id="info-esp" role="tabpanel" aria-labelledby="info-esp-tab">
                    <div class="mt-4">
                        
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

@section('pie')
Copyright
@endsection
