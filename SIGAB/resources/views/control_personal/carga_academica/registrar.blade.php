@extends('layouts.app')

@section('titulo')
Registrar información de cargas académicas para {{ $personal->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')

<div class="container bg-white py-4 px-3 mb-5 sombra w-75">
    <div class="d-flex justify-content-between">
        <h3 class="text-center texto-gris-oscuro font-weight-bold">Registrar carga académica</h3>
        <div><a href="/personal/carga-academica/{{ $personal->persona->persona_id }}" class="btn btn-rojo"><i class="fas fa-chevron-left"></i> &nbsp; Regresar</a></div>
    </div>
    <hr>

    {{-- Información del personal --}}
    <div class="d-flex justify-content-center mb-2">
        <img class="rounded mb-3" width="160" height="160" id="imagen-modal" src="{{ asset('img/fotos/'.$personal->persona->imagen_perfil) }}" />
    </div>
    <div class="d-flex justify-content-center align-items-center border-bottom mb-2 pb-3">
        <div class=" text-center">
            <strong>Cédula:</strong> &nbsp;&nbsp;<span id="cedula"> {{ $personal->persona->persona_id }}</span> <br>
            <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"> {{ $personal->persona->nombre." ".$personal->persona->apellido }} </span> <br>
            <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"> {{ $personal->persona->correo_personal }} </span> <br>
        </div>
    </div>

    {{-- Formulario para registrar informacion de la carga academica --}}
    <form action="/personal/carga-academica" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
        @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert" id="mensaje-exito">
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
        @if(Session::has('carga_academica_insertada'))
        <div class="alert alert-dark" role="alert">

            {{-- Esto viene  del controller y trae el objeto recien creado en caso de haber hecho un registro exitoso --}}
            @php
            $carga_academica = Session::get('carga_academica_insertada');
            @endphp

            Se registró la carga académica con los siguientes datos: <br> <br>
            <div class="row">
                <div class="col-12">
                    <b>Ciclo lectivo:</b> {{ $carga_academica->ciclo_lectivo }} <br>
                    <b>Año:</b> {{ $carga_academica->anio }} <br>
                    <b>Nombre del curso:</b> {{ $carga_academica->nombre_curso }} <br>
                    <b>NRC:</b> {{ $carga_academica->nrc ?? "No se digitó" }} <br>
                </div>
            </div>
        </div>

        <div class="h3 mb-5 mt-4 mx-3">Agregar otra carga académica:</div>
        @endif

        <div class="container w-75 ">

            <div class="d-flex justify-content-center flex-column mt-3">

                {{-- Campo: Ciclo lectivo --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="ciclo_lectivo">Ciclo lectivo <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_ciclo_lectivo"></span>
                    </div>
                    <select class="form-control" name="ciclo_lectivo" id="ciclo_lectivo">
                        <option>I Ciclo</option>
                        <option>II Ciclo</option>
                    </select>
                </div>

                {{-- Campo: Año de graduación --}}
                <div class=" mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="anio">Año <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_anio"></span>
                    </div>
                    <input type='number' class="form-control" id="anio" name="anio" onkeyup="contarCaracteres(this,4)" min="1975" required>
                </div>

                {{-- Campo: Nombre del curso--}}
                <label for="nombre_curso">Nombre del curso <i class="text-danger">*</i></label>
                <select class="form-control mb-3" id="nombre_curso" name="nombre_curso" size="10" required>
                    @foreach($cursos as $curso)
                        <option>{{ $curso }}</option>
                    @endforeach
                </select>

                {{-- Campo: NRC--}}
                <div class=" mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label for="nrc">NRC <i class="text-danger">*</i></label>
                        <span class="text-muted ml-2" id="mostrar_nrc"></span>
                    </div>
                    <input type='number' class="form-control" id="nrc" name="nrc" onkeyup="contarCaracteres(this,7)" min="0" required>
                </div>

            </div>

        </div>
        {{-- Input oculto que envia el id del personal --}}
        <input type="hidden" name="persona_id" value="{{ $personal->persona->persona_id }}">

        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion de la carga academica --}}
            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
        </div>
    </form>
</div>
@endsection

@section('scripts')
{{-- Link al script de registro de personal --}}
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
