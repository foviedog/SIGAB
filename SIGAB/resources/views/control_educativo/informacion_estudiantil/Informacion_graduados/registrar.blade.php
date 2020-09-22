@extends('layouts.app')

@section('titulo')
Registrar información de graduaciones para {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
{{-- Link al script de registro de registro de estudiantes --}}
<script src="{{ asset('js/control_educativo/informacion_graduaciones/registrar.js') }}" defer></script>
@endsection

@section('contenido')

<div class="container bg-white py-4 px-3 mb-5 sombra w-75">


    <h3 class="texto-gris-oscuro font-weight-bold">Registrar información de graduación para {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h3>
    <hr class="pb-2">

    <div class="d-flex flex-row-reverse mb-4">
        {{-- Botón para regresar al listado de graduaciones del estudiante --}}
        <a href="/estudiante/graduacion/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"><i class="fas fa-chevron-left"></i> &nbsp; Regresar</a>
    </div>

    {{-- Formulario para registrar informacion de la graduación --}}
    <form action="/estudiante/graduacion" method="POST" enctype="multipart/form-data" id="estudiante">
        @csrf

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
        @if(Session::has('graduado_insertada'))
            <div class="alert alert-dark" role="alert">

                {{-- Esto viene  del controller y trae el objeto recien creado en caso de haber hecho un registro exitoso --}}
                @php
                    $graduado = Session::get('graduado_insertada');
                @endphp

                Se insertó la graduación con los siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 ">
                        <b>Cédula:</b> {{ $graduado->persona_id ?? "Error" }} <br>
                        <b>Motivo:</b> {{ $graduado->grado_academico }} <br>
                        <b>Fecha:</b> {{ $graduado->carrera_cursada }} <br>
                        <b>Ciclo lectivo:</b> {{ $graduado->anio_graduacion ?? "No se digitó" }} <br>
                    </div>
                </div>
            </div>

            <div class="h3 mb-5 mt-4 mx-3">Agregar nueva graduación:</div>
        @endif

        <div class="container w-75 ">

            <div class="d-flex justify-content-center flex-column ">
                {{-- Campo: Grado académico --}}
                <div class="mb-3">
                    <label for="grado_academico">Grado académico <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_grado_academico"></span></label>
                    <input type='text' class="form-control" id="grado_academico" name="grado_academico" onkeyup="contarCarGradoAcademico(this)" required>
                </div>

                {{-- Campo: Carrera cursada--}}
                <div class=" mb-3">
                    <label for="carrera_cursada">Carrera cursada <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_carrera_cursada"></span></label>
                    <input type='text' class="form-control" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCarCarrCursada(this)" required>
                </div>

                {{-- Campo: Año de graduación --}}
                <div class=" mb-3">
                    <label for="anio_graduacion">Año de graduación <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_anio_graduacion"></span></label>
                    <input type='number' class="form-control" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCarAnioGraduacion(this)" required>
                </div>
            </div>

        </div>
        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion de la graduación --}}
            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
        </div>
    </form>
</div>
@endsection

@section('pie')
Copyright
@endsection
