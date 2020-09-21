@extends('layouts.app')

@section('titulo')
Registrar información Graduados
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
{{-- Link al script de registro de registro de estudiantes --}}
<script src="{{ asset('js/control_educativo/informacion_estudiante/registrar.js') }}" defer></script>
@endsection

@section('contenido')

<div class="card">
    <div class="card-body">
        <h2>Registrar información del graduado</h2>
        <hr>

        {{-- Formulario para registrar informacion del estudiante --}}
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

                Se insertó el estudiante con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 ">
                        <b>Cédula:</b> {{ $graduado->persona_id ?? "nope" }} <br>
                        <b>Motivo:</b> {{ $graduado->grado_academico }} <br>
                        <b>Fecha:</b> {{ $graduado->carrera_cursada }} <br>
                        <b>Ciclo lectivo:</b> {{ $graduado->anio_graduacion ?? "No se digitó" }} <br>
                    </div>
                </div>
            </div>

            {{-- <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div> --}}
            @endif

    </div>

</div>
</div>

<div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div>
@endif

<div class="container w-75 ">
    <div class="d-flex justify-content-center flex-column ">
        {{-- Campo: Motivo --}}
        <div class="mb-3">
            <label for="grado_academico">Grado academico: <i class="text-danger">*</i></label>
            <input type='text' class="form-control w-100" id="grado_academico" name="grado_academico" onkeyup="contarCargrado_academico(this)" required>
            <span class="text-muted" id="mostrar_cant_grado_academico"></span>
        </div>

        {{-- Campo:  Lugar atencion--}}
        <div class=" mb-3">
            <label for="carrera_cursada">Carrera cursada: <i class="text-danger">*</i></label>
            <input type='text' class="form-control w-100" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCarLugarAtencion(this)" required>
            <span class="text-muted" id="mostrar_cant_carrera_cursada"></span>
        </div>

        {{-- Campo:  Lugar atencion--}}
        <div class=" mb-3">
            <label for="anio_graduacion">año de graduacion: <i class="text-danger">*</i></label>
            <input type='number' class="form-control w-100" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCarLugarAtencion(this)" required>
            <span class="text-muted" id="mostrar_cant_anio_graduacion"></span>
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

@section('pie')
Copyright
@endsection
