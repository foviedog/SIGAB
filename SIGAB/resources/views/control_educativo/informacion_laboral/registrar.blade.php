@extends('layouts.app')

@section('titulo')
Registrar información laboral de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_laboral/registrar.js') }}" defer></script>
@endsection

@section('contenido')
<h2>Registrar información laboral para {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
<hr>

{{-- Formulario para registrar informacion laboral --}}
<form action="/trabajo" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {!! \Session::get('mensaje') !!}
        </div>
    @endif

    <div class="row">

        {{-- Campos de la izquierda --}}
        <div class="col">

            {{-- Campo: Nombre de la organizacion --}}
            <div class="form-inline mb-4">
                <div class="col-4">
                    <label for="nombre_organizacion">Nombre de la organización:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="nombre_organizacion"
                    name="nombre_organizacion"
                    onkeyup="contarCarNomOrg(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_nom_org"></span>
                </div>
            </div>

            {{-- Campo: Jornada laboral --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="jornada_laboral">Jornada laboral:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="jornada_laboral"
                    name="jornada_laboral"
                    onkeyup="contarCarJornLab(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_jorn_lab"></span>
                </div>
            </div>

            {{-- Campo: Jefe inmediato --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="jefe_inmediato">Jefe inmediato:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="jefe_inmediato"
                    name="jefe_inmediato"
                    onkeyup="contarCarJefInme(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_jef_inme"></span>
                </div>
            </div>

                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tiempo_desempleado">Tiempo desempleado:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="tiempo_desempleado"
                    name="tiempo_desempleado"
                    onkeyup="contarCarTiempDesempl(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tiemp_desmp"></span>
                </div>
            </div>

            {{-- Campo: Intereses Capacitacion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="interes_capacitacion">Intereses capacitación:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="interes_capacitacion"
                    name="interes_capacitacion"></textarea>
                </div>
            </div>

        </div>

        {{-- Campos de la derecha --}}
        <div class="col">

            {{-- Campo: Tipo de organizacion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tipo_organizacion">Tipo de organización:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="tipo_organizacion"
                    name="tipo_organizacion"
                    onkeyup="contarCarTipOrg(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tip_org"></span>
                </div>
            </div>

            {{-- Campo: Cargo actual --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="cargo_actual">Cargo actual:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="cargo_actual"
                    name="cargo_actual"
                    onkeyup="contarCarCargAct(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_carg_act"></span>
                </div>
            </div>

            {{-- Campo: Telefono trabajo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="telefono_trabajo">Teléfono trabajo:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="telefono_trabajo"
                    name="telefono_trabajo"
                    onkeyup="contarCarTelfTrbj(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tel_trbj"></span>
                </div>
            </div>

            {{-- Campo: Correo trabajo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="correo_trabajo">Correo trabajo:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="correo_trabajo"
                    name="correo_trabajo"
                    onkeyup="contarCarCorrTrbj(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_corr_trbj"></span>
                </div>
            </div>

            {{-- Campo: Otros estudios --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="otros_estudios">Otros estudios:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="otros_estudios"
                    name="otros_estudios"></textarea>
                </div>
            </div>

        </div>

    </div>

    <div class="d-flex justify-content-center">

        {{-- Input oculto que envia el id del estudiante --}}
        <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

        {{-- Boton para agregar informacion laboral --}}
        <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">

    </div>

</form>
@endsection

@section('pie')
Copyright
@endsection
