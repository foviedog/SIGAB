@extends('layouts.app')

@section('titulo')
Registrar información de graduaciones para {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')

<div class="container bg-white py-4 px-3 mb-5 sombra w-75">
    <div class="d-flex justify-content-between">
        <h3 class="text-center texto-gris-oscuro font-weight-bold">Registrar graduación</h3>
        <div><a href="/estudiante/graduacion/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"><i class="fas fa-chevron-left"></i> &nbsp; Regresar</a></div>
    </div>
    <hr>

    {{-- Información del estudiante --}}
    <div class="d-flex justify-content-center mb-2">
        <img class="rounded mb-3" width="160" height="160" id="imagen-modal" src="{{ asset('img/fotos/' . $estudiante->persona->imagen_perfil) }}" />
    </div>
    <div class="d-flex justify-content-center align-items-center border-bottom mb-2 pb-3">
        <div class=" text-center">
            <strong>Cédula:</strong> &nbsp;&nbsp;<span id="cedula"> {{ $estudiante->persona->persona_id }}</span> <br>
            <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre">
                {{ $estudiante->persona->nombre . ' ' . $estudiante->persona->apellido }} </span> <br>
            <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo">
                {{ $estudiante->persona->correo_personal }} </span> <br>
        </div>
    </div>

    {{-- Formulario para registrar informacion de la graduación
        --}}
    <form action="/estudiante/graduacion" method="POST" enctype="multipart/form-data" id="estudiante">
        @csrf
        @method('PATCH')

        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro)
            --}}
        @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert" id="mensaje-exito">
            {!! \Session::get('mensaje') !!}
        </div>
        @endif

        {{-- Mensaje de error (solo se muestra si ha sido ocurrio algun error en la
            insercion) --}}
        @php
        $error = Session::get('error');
        @endphp

        @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ '¡Oops! Algo ocurrió. ' . $error }}
        </div>
        @endif
        {{-- Mensaje de que muestra el objeto insertado
            (solo se muestra si ha sido exitoso el registro) --}}
        @if (Session::has('graduado_insertada'))
        <div class="alert alert-dark" role="alert">

            {{-- Esto viene del controller y trae el objeto recien creado en caso de
                    haber hecho un registro exitoso --}}
            @php
            $graduado = Session::get('graduado_insertada');
            @endphp

            Se registró la graduación con los siguientes datos: <br> <br>
            <div class="row">
                <div class="col-6 ">
                    <b>Cédula:</b> {{ $graduado->persona_id ?? 'Error' }} <br>
                    <b>Grado académico:</b> {{ $graduado->grado_academico }} <br>
                    <b>Carrera cursada:</b> {{ $graduado->carrera_cursada }} <br>
                    <b>Año de graduación:</b> {{ $graduado->anio_graduacion ?? 'No se digitó' }} <br>
                </div>
            </div>
        </div>

        <div class="h3 mb-5 mt-4 mx-3">Agregar nueva graduación:</div>
        @endif

        <div class="container w-75 ">

            <div class="d-flex justify-content-center flex-column mt-3">
                {{-- Campo: Grado académico --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="grado_academico">Grado académico <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_grado_academico"></span>
                    </div>
                    <select class="form-control w-100" id="grado_academico" name="grado_academico" form="personal-form" required>
                        <option value="" selected>Seleccione</option>
                        <option value="Diplomado"> Diplomado</option>
                        <option value="Bachillerato"> Bachillerato </option>
                        <option value="Licenciatura"> Licenciatura </option>
                        <option value="Maestría"> Maestría </option>
                        <option value="Doctorado"> Doctorado </option>
                    </select>
                </div>

                {{-- Campo: Carrera cursada--}}
                <div class=" mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="carrera_cursada">Carrera cursada <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_carrera_cursada"></span>
                    </div>
                    <input type='text' class="form-control" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCaracteres(this,80)" required>
                </div>

                {{-- Campo: Año de graduación --}}
                <div class=" mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="anio_graduacion">Año de graduación <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_anio_graduacion"></span>
                    </div>
                    <input type='number' class="form-control" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCaracteres(this,4)" min="1975" required>
                </div>
            </div>

        </div>
        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion de la graduación
                --}}
            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
        </div>
    </form>
</div>
@endsection

@section('scripts')
{{-- Link al script de registro de registro de estudiantes --}}
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
