@extends('layouts.app')

@section('titulo')
Registrar información laboral de
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection


@section('contenido')
<h2> Registrar información de la guia academica del estudiante </h2>
<hr>

{{-- Formulario para registrar informacion de la guia academica --}}
<form action="/estudiante/guia-academica" method="POST" enctype="multipart/form-data" id="estudiante">
    @csrf

    {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
    @if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {!! \Session::get('mensaje') !!}
    </div>
    @endif

    {{-- Mensaje de que muestra el objeto insertado
        (solo se muestra si ha sido exitoso el registro)  --}}
    @if(Session::has('gua_academica_insertada'))
    <div class="alert alert-dark" role="alert">

        @php
        $guia = Session::get('gua_academica_insertada');
        @endphp

        Se insertó el estudiante con lo siguientes datos: <br> <br>
        <div class="row">
            <div class="col-6 text-justify">
                <b>Cedula:</b> {{ $guia->persona_id ?? "nope" }} <br>
                <b>Motivo:</b> {{ $guia->motivo }} <br>
                <b>Fecha:</b> {{ $guia->fecha }} <br>
                <b>Ciclo lectivo:</b> {{ $guia->ciclo_lectivo ?? "No se digitó" }} <br>
                <b>Situacion:</b> {{ $guia->situacion ?? "No se digitó" }} <br>
                <b>Lugar de atencion:</b> {{ $guia->lugar_atencion ?? "No se digitó" }} <br>
                <b>Recomendaciones:</b> {{ $guia->recomendaciones ?? "No se digitó" }} <br>
            </div>
        </div>
    </div>

    <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div>
    @endif
    <div class="row">
        {{-- Campos de la izquierda --}}
        <div class="col">


            {{-- Campo: Carrera matriculada 2 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="motivo">Motivo:</label>
                </div>
                <div class="col-6">
                    <input type='text' class="form-control w-100" id="motivo" name="motivo" onkeyup="contarCarMotivo(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_motivo"></span>
                </div>
            </div>

            {{-- Campo: Año de ingreso a la UNA --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="fecha">Fecha:</label>
                </div>
                <div class="col-6">
                    <input type='date' value="2020-08-15" class="form-control w-100" id="fecha" name="fecha" onkeyup="contarCarFecha(this)" required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_fecha"></span>
                </div>
            </div>

            {{-- Campo: Carrera matriculada 2 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="ciclo_lectivo">Ciclo lectivo:</label>
                </div>
                <div class="col-6">
                    <input type='text' class="form-control w-100" id="ciclo_lectivo" name="ciclo_lectivo" onkeyup="contarCarCicloLectivo(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_ciclo_lectivo"></span>
                </div>
            </div>

            {{-- Campo: Apoyo educativo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="situacion">Situacion:</label>
                </div>
                <div class="col-6">
                    <textarea class="form-control w-100" id="situacion" name="situacion" onkeyup="contarCarSituacion(this)"></textarea>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_situacion"></span>
                </div>
            </div>

            {{-- Campo: Carrera matriculada 2 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="lugar_atencion">Lugar atencion:</label>
                </div>
                <div class="col-6">
                    <input type='text' class="form-control w-100" id="lugar_atencion" name="lugar_atencion" onkeyup="contarCarLugarAtencion(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_lugar_atencion"></span>
                </div>
            </div>

            {{-- Campo: Apoyo educativo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="recomendaciones">Recomendaciones:</label>
                </div>
                <div class="col-6">
                    <textarea class="form-control w-100" id="recomendaciones" name="recomendaciones" onkeyup="contarCarRecomendaciones(this)"></textarea>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Input oculto que envia el id del estudiante --}}
    <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">



    <div class="d-flex justify-content-center">
        {{-- Boton para agregar informacion del estudiante --}}
        <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
    </div>


</form>
@endsection
{{-- Link al script de registro de registro guias academicas de estudiantes --}}
@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/registrar.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
