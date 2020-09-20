@extends('layouts.app')

@section('titulo')
Registrar información laboral de
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection


@section('contenido')

<div class="container bg-white py-4 px-3 mb-5 sombra w-75">


    <h3 class="text-center texto-gris-oscuro font-weight-bold "> Registrar información de la guia academica de {{ $estudiante->persona_id }} </h3>
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
                <div class="col-6 ">
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
        @endif

        <div class="container w-75 ">
            <div class="d-flex justify-content-center flex-column ">
                {{-- Campo: Motivo --}}
                <div class="mb-3">
                    <label for="motivo">Motivo:</label>
                    <input type='text' class="form-control w-100" id="motivo" name="motivo" onkeyup="contarCarMotivo(this)">
                    <span class="text-muted" id="mostrar_cant_motivo"></span>
                </div>

                {{-- Campo: Fecha --}}
                <div class=" mb-3">
                    <label for="fecha">Fecha:</label>
                    <input type='date' value="2020-08-15" class="form-control w-100" id="fecha" name="fecha" onkeyup="contarCarFecha(this)" required>
                    <span class="text-muted" id="mostrar_cant_fecha"></span>
                </div>

                {{-- Campo: Ciclo lectivo--}}
                <div class=" mb-3">
                    <label for="ciclo_lectivo">Ciclo lectivo:</label>
                    <input type='text' class="form-control w-100" id="ciclo_lectivo" name="ciclo_lectivo" onkeyup="contarCarCicloLectivo(this)">
                    <span class="text-muted" id="mostrar_cant_ciclo_lectivo"></span>
                </div>

                {{-- Campo:  Lugar atencion--}}
                <div class=" mb-3">
                    <label for="lugar_atencion">Lugar atencion:</label>
                    <input type='text' class="form-control w-100" id="lugar_atencion" name="lugar_atencion" onkeyup="contarCarLugarAtencion(this)">
                    <span class="text-muted" id="mostrar_cant_lugar_atencion"></span>
                </div>

                {{-- Campo: Situacion --}}
                <div class=" mb-3">
                    <label for="situacion">Situacion:</label>
                    <textarea class="form-control w-100" id="situacion" name="situacion" onkeyup="contarCarSituacion(this)" rows="4" cols="50"></textarea>
                    <span class="text-muted" id="mostrar_cant_situacion"></span>
                </div>

                {{-- Campo:  Recomendaciones --}}
                <div class=" mb-3">
                    <label for="recomendaciones">Recomendaciones:</label>
                    <textarea class="form-control w-100" id="recomendaciones" name="recomendaciones" onkeyup="contarCarRecomendaciones(this)" rows="4" cols="50"></textarea>
                    <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
                </div>

            </div>
        </div>
        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion del estudiante --}}
            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
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
