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

    {{-- Alerts --}}
    @include('layouts.messages.alerts')

    {{-- Mensaje de que muestra el objeto insertado
        (solo se muestra si ha sido exitoso el registro)  --}}
    @if(Session::has('guia_academica_insertada'))
    <div class="alert alert-dark" role="alert">

        {{-- Esto viene  del controller y trae el objeto recien creado en caso de haber hecho un registro exitoso --}}
        @php
        $guia = Session::get('guia_academica_insertada');
        @endphp

        Se registró la guía académica con lo siguientes datos: <br> <br>
        <div class="row">
            <div class="col-12">
                <b>Cédula:</b> {{ $guia->persona_id ?? "nope" }} <br>
                <b>Tipo:</b> {{ $guia->tipo }} <br>
                <b>Lugar de atención:</b> {{ $guia->lugar_atencion ?? "No se digitó" }} <br>
                <b>Fecha:</b> {{ $guia->fecha }} <br>
                <b>Ciclo lectivo:</b> {{ $guia->ciclo_lectivo ?? "No se digitó" }} <br>
                @if(Session::has('docente'))
                @php $docente = Session::get('docente'); @endphp
                <b>Solicitado por:</b> {{ $docente->persona->nombre." ".$docente->persona->apellido }} <br>
                @else
                <b>Solicitado por:</b> Estudiante <br>
                @endif
                <b>Situación:</b> {{ $guia->situacion ?? "No se digitó" }} <br>
                <b>Recomendaciones:</b> {{ $guia->recomendaciones ?? "No se digitó" }} <br>
                @if($guia->archivo_adjunto !== NULL)
                <b>Archivo adjunto:</b> <a href='{{ URL::asset('/estudiante/guia-academica/download/') }}/{{ $guia->archivo_adjunto }}' target='_blank'>{{ $guia->archivo_adjunto }}</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(Accesos::ACCESO_REGISTRAR_GUIAS_ACADEMICAS())
    {{-- Formulario para registrar informacion de la guia academica --}}
    <form autocomplete="off" action="{{ route('guia-academica.store') }}" method="POST" enctype="multipart/form-data" id="form-guia" onsubmit="activarLoader('Agregando guía');">
        @csrf
        @endif

        <div class="container">
            <div class="d-flex justify-content-center mb-2">
                <img class="rounded mb-3" width="160" height="160" id="imagen-modal" src="{{ asset('img/fotos/'.$estudiante->persona->imagen_perfil) }}" />
            </div>
            <div class=" d-flex justify-content-center align-items-center border-bottom">
                <div class=" text-center mb-3">
                    <strong>Cédula:</strong> &nbsp;&nbsp;<span id="cedula"> {{ $estudiante->persona->persona_id }}</span> <br>
                    <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"> {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</span> <br>
                    <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"> {{ $estudiante->persona->correo_personal }} </span> <br>
                </div>
            </div>

            <div class="form-group">
                <label for="motivo" class="col-form-label mt-3">Tipo &nbsp;<i class="text-danger">*</i></label>
                <select class="form-control mb-3" id="tipo" name="tipo" size="10" required>
                    @foreach($tipos as $tipo)
                    <option>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between w-100">
                    <label for="lugar" class="col-form-label">Lugar de atención &nbsp;<i class="text-danger">*</i> </label>
                    <span class="text-muted" id="mostrar_lugar"></span>
                </div>
                <input type="text" class="form-control" id="lugar" name="lugar" onkeyup="contarCaracteres(this,44)" required>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha &nbsp;<i class="text-danger">*</i></label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                </div>
                <div class="col mt-2">
                    <div class="form-group">
                        <label for="ciclo">Ciclo lectivo &nbsp;<i class="text-danger">*</i></label>
                        <select class="form-control" id="ciclo" name="ciclo" required>
                            <option value="Ciclo I">Ciclo I </option>
                            <option value="Ciclo II">Ciclo II </option>
                        </select>
                    </div>
                </div>
            </div>

            <label class="col-form-label">Solicitado por &nbsp;<i class="text-danger">*</i></label><br>
            <div class="row my-3 mx-1">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" value="est" checked>
                        <label class="form-check-label" for="radio">
                            Estudiante
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" value="docen">
                        <label class="form-check-label" for="radio">
                            Docente
                        </label>
                    </div>
                </div>
            </div>
            <div class="collapse mb-3" id="lista_docentes">
                @if(count($docentes) == 0)
                <span> No hay registros de personal todavía</span>
                <select class="form-control mb-3" size="10" id="docente" disabled>
                </select>
                @else
                Seleccione el docente
                <select class="form-control mb-3" size="10" id="docente">
                    @foreach($docentes as $docente)
                    <option>{{ $docente->persona->persona_id." - ".$docente->persona->nombre." ".$docente->persona->apellido }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            {{-- Input oculto que envia si es la guía es solicitada por un estudiante o por un educador --}}
            <input type="hidden" name="solicitud" id="solicitud">

            <div class="form-group">
                <label for="situacion" class="col-form-label">Situación &nbsp;<i class="text-danger">*</i></label>
                <textarea class="form-control" id="situacion" rows="2" cols="50" name="situacion" required></textarea>
            </div>
            <div class="form-group">
                <label class="col-form-label" for="recomendaciones">Recomendaciones </label>
                <textarea class="form-control" id="recomendaciones" rows="4" cols="50" name="recomendaciones"></textarea>
                <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
            </div>

            @if(Accesos::ACCESO_ADJUNTAR_EVIDENCIAS())
            <div class="form-group mb-5">
                <label class="col-form-label" for="adjuntar-archivo">Adjuntar archivo</label> <br>
                <input type="file" name="archivo" class="border" id="adjuntar-archivo">
                <br><span style="cursor: pointer" onclick="quitarArchivo()">Quitar archivo</span>
                <div class="text-danger">Los formatos permitidos son: <b>csv, txt, xlx, xls, pdf, docx, rar, zip, 7zip</b>.
                    <br>El archivo no debe pesar más de <b>30MB</b>.</div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            @endif

        </div>

        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        @if(Accesos::ACCESO_REGISTRAR_GUIAS_ACADEMICAS())
        <div class="d-flex justify-content-center pb-3">
            {{-- Boton para agregar informacion de la guia --}}
            <button type="submit" class="btn btn-rojo btn-lg">Agregar Guía</button>
        </div>
    </form>
    @endif

</div>

@endsection

@section('scripts')
<script>
    // Variables globales
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    let est = "{{$estudiante->persona->persona_id}}"

</script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/registrar.js') }}" defer></script>
@endsection
