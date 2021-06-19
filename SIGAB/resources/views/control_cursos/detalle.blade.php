@extends('layouts.app')

@section('titulo')
Curso
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card-body">
    <div class="d-flex justify-content-between">
        <h2>Registrar información del estudiante</h2>
        <div>

            @if(Accesos::ACCESO_LISTAR_ESTUDIANTES())
            <div><a href="{{ route('listado-estudiantil') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a></div>
            @endif

        </div>
    </div>
    <hr>

    @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
    {{-- Formulario para registrar informacion del estudiante --}}
    <form action="{{ route('estudiante.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data" id="estudiante" onsubmit="activarLoader('Agregando Estudiante');">
        @csrf
    @endif

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Mensaje de que muestra el objeto insertado (solo se muestra si ha sido exitoso el registro)  --}}
        @if(isset($estudiante_insertado))
        <div class="alert alert-dark" role="alert">
            Se registró el estudiante con lo siguientes datos: <br> <br>
            <div class="row">
                <div class="col-6 text-justify">
                    {{-- <b>Cédula:</b> {{ $persona_insertada->persona_id }} <br>
                    <b>Nombre/s:</b> {{ $persona_insertada->nombre }} <br>
                    <b>Apellido/s:</b> {{ $persona_insertada->apellido }} <br>
                    <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br> --}}
                    {{-- Link directo al estudiante recien agregado --}}
                    {{-- <br>
                    <a clas="btn btn-rojo" href="{{ route('estudiante.show', $estudiante_insertado->persona_id) }}">
                        <input type="button" @if(Accesos::ACCESO_MODIFICAR_ESTUDIANTES()) value="Editar" @else value="Detalle" @endif class="btn btn-rojo">
                    </a>
                    <br> --}}
            </div>
        </div>
        <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo curso:</div>
        @endif
</div>
@endsection

@section('scripts')
{{-- Ningún script por el momento --}}
@endsection
