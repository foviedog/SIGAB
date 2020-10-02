@extends('layouts.app')

@section('titulo')
Registrar guía académica
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="container bg-white py-4 px-3 mb-5 sombra w-75">
    <div class="d-flex justify-content-between">
        <h3 class="text-center texto-gris-oscuro font-weight-bold"> Registrar Guía Académica </h3>
        <div><a href="{{ route('guia-academica.listar' ) }}" class="btn btn-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Regresar</a></div>
    </div>
    <hr>

    {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {!! \Session::get('mensaje') !!}
    </div>
    @endif

    {{-- Mensaje de error (solo se muestra si ha sido ocurrio algun error en la insercion) --}}
    @php
    $error = Session::get('error');
    @endphp

    @if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ "¡Oops! Algo ocurrió. ".$error }}
    </div>
    @endif

    {{-- Mensaje de que muestra el objeto insertado
        (solo se muestra si ha sido exitoso el registro)  --}}
    @if(Session::has('gua_academica_insertada'))
    <div class="alert alert-dark" role="alert">

        {{-- Esto viene  del controller y trae el objeto recien creado en caso de haber hecho un registro exitoso --}}
        @php
        $guia = Session::get('gua_academica_insertada');
        @endphp

        Se insertó el estudiante con lo siguientes datos: <br> <br>
        <div class="row">
            <div class="col-6 ">
                <b>Cédula:</b> {{ $guia->persona_id ?? "nope" }} <br>
                <b>Motivo:</b> {{ $guia->motivo }} <br>
                <b>Fecha:</b> {{ $guia->fecha }} <br>
                <b>Ciclo lectivo:</b> {{ $guia->ciclo_lectivo ?? "No se digitó" }} <br>
                <b>Situación:</b> {{ $guia->situacion ?? "No se digitó" }} <br>
                <b>Lugar de atención:</b> {{ $guia->lugar_atencion ?? "No se digitó" }} <br>
                <b>Recomendaciones:</b> {{ $guia->recomendaciones ?? "No se digitó" }} <br>
            </div>
        </div>
    </div>

    @endif

    {{-- Formulario para registrar informacion de la guia academica --}}
    <form action="/estudiante/guia-academica" method="POST" enctype="multipart/form-data" id="estudiante">
        @csrf
        <div class="container">
            <div class="d-flex justify-content-center mb-2">
                <img class="rounded mb-3" width="160" height="160" id="imagen-modal" src="{{ asset('img/fotos/'.$estudiante->persona->imagen_perfil) }}" />
            </div>
            <div class=" d-flex justify-content-center align-items-center border-bottom">
                <div class=" text-center mb-3">
                    <strong> Cédula:</strong> &nbsp;&nbsp;<span id="cedula"> {{ $estudiante->persona->persona_id }}</span> <br>
                    <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"> {{ $estudiante->persona->nombre }} &nbsp; {{ $estudiante->persona->apellido }}</span> <br>
                    <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"> {{ $estudiante->persona->correo_personal }} </span> <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="motivo" class="col-form-label">Motivo &nbsp;<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="motivo" name="motivo" required>
                        <span class="text-muted" id="mostrar_cant_motivo"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha &nbsp;<i class="text-danger">*</i></label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="ciclo">Ciclo lectivo <i class="text-danger">*</i></label>
                        <select class="form-control " id="ciclo" name="ciclo" form="estudiante" required>
                            <option value="Ciclo I">Ciclo I </option>
                            <option value="Ciclo II">Ciclo II </option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="lugar" class="col-form-label">Lugar de atención &nbsp;<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="lugar" name="lugar" required>
                        <span class="text-muted" id="mostrar_cant_lugar_atencion"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="situacion" class="col-form-label">Situación &nbsp;<i class="text-danger">*</i></label>
                <textarea class="form-control" id="situacion" rows="2" cols="50" name="situacion" required></textarea>
                <span class="text-muted" id="mostrar_cant_situacion"></span>
            </div>
            <div class="form-group">
                <label class="col-form-label" for="recomendaciones">Recomendaciones </label>
                <textarea class="form-control" id="recomendaciones" rows="4" cols="50" name="recomendaciones" ></textarea>
                <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
            </div>
        </div>



        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion del estudiante --}}
            <button type="submit" class="btn btn-rojo btn-lg">Agregar Guía</button>
        </div>
    </form>
</div>

@endsection
{{-- Link al script de registro de registro guias academicas de estudiantes --}}
@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/registrar.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
