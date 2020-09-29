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
<div class="container bg-white py-4 px-3 mb-5 sombra w-75">
    <div class="d-flex justify-content-between">
        <h3 class="text-center texto-gris-oscuro font-weight-bold">Registrar información laboral</h3>
        <div><a href="/estudiante/trabajo/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"><i class="fas fa-chevron-left"></i> &nbsp; Regresar</a></div>
    </div>
    <hr>

        {{-- Información del estudiante --}}
        <div class="d-flex justify-content-center mb-2">
            <img class="rounded mb-3" width="160" height="160" id="imagen-modal" src="{{ asset('img/fotos/'.$estudiante->persona->imagen_perfil) }}" />
        </div>
        <div class="d-flex justify-content-center align-items-center border-bottom mb-2 pb-3">
            <div class=" text-center">
                <strong>Cédula:</strong> &nbsp;&nbsp;<span id="cedula"> {{ $estudiante->persona->persona_id }}</span> <br>
                <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"> {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }} </span> <br>
                <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"> {{ $estudiante->persona->correo_personal }} </span> <br>
            </div>
        </div>

        {{-- Formulario para registrar informacion laboral --}}
        <form action="/estudiante/trabajo/registrar" method="POST" role="form" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Mensaje de exito
            (solo se muestra si ha sido exitoso el registro) --}}
            @if(Session::has('mensaje'))
            <div class="alert alert-success" role="alert" id="mensaje-exito">
                {!! \Session::get('mensaje') !!}
            </div>
            @endif

        {{-- Mensaje de que muestra el objeto insertado
            (solo se muestra si ha sido exitoso el registro)  --}}
            @if(Session::has('trabajo_insertado'))
            <div class="alert alert-dark" role="alert">

                @php
                $trabajo_insertado = Session::get('trabajo_insertado');
                @endphp

                Se insertó el trabajo con lo siguientes datos: <br> <br>
                <b>Cédula de la persona:</b> {{ $trabajo_insertado->persona_id }} <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>Nombre de la organización:</b> {{ $trabajo_insertado->nombre_organizacion }} <br>
                        <b>Jornada laboral:</b> {{ $trabajo_insertado->jornada_laboral }} <br>
                        <b>Jefe inmediato:</b> {{ $trabajo_insertado->jefe_inmediato ?? "No se digitó" }} <br>
                        <b>Tiempo desempleado:</b> {{ $trabajo_insertado->tiempo_desempleado ?? "No se digitó" }} <br>
                        <b>Intereses capacitación:</b> {{ $trabajo_insertado->interes_capacitacion ?? "No se digitó" }} <br>
                    </div>
                    <div class="col-6 text-justify">
                        <b>Tipo de organización:</b> {{ $trabajo_insertado->tipo_organizacion }} <br>
                        <b>Cargo actual:</b> {{ $trabajo_insertado->cargo_actual }} <br>
                        <b>Teléfono trabajo:</b> {{ $trabajo_insertado->telefono_trabajo ?? "No se digitó" }} <br>
                        <b>Correo trabajo:</b> {{ $trabajo_insertado->correo_trabajo ?? "No se digitó" }} <br>
                        <b>Otros estudios:</b> {{ $trabajo_insertado->otros_estudios ?? "No se digitó" }} <br>
                    </div>
                </div>
            </div>

            {{-- Mensaje "Agregar un nuevo trabajo"
                (solo se muestra si ha sido exitoso el registro)  --}}

            <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo trabajo:</div>
            @endif

            <div class="container w-75">

                {{-- Campo: Nombre de la organizacion --}}
                <div class="d-flex justify-content-center flex-column mt-3">
                    <div class="mb-3">
                        <label for="nombre_organizacion">Nombre de la organización</label> <i class="text-danger">*</i> <span class="text-muted" id="mostrar_cant_nom_org"></span>
                        <input type='text' class="form-control w-100" id="nombre_organizacion" name="nombre_organizacion" onkeyup="contarCarNomOrg(this)" required>
                    </div>
                </div>

                {{-- Campo: Tipo de organizacion --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="tipo_organizacion">Tipo de organización</label> <i class="text-danger">*</i> <span class="text-muted" id="mostrar_cant_tip_org"></span>
                        {{-- <input type='text' class="form-control w-100" id="tipo_organizacion" name="tipo_organizacion" onkeyup="contarCarTipOrg(this)" required> --}}
                        <select name="tipo_organizacion" class="form-control w-100">
                            <option value="Instituciones públicas">Instituciones públicas</option>
                            <option value="Instituciones privadas">Instituciones privadas</option>
                            <option value="Instituciones autónomas">Instituciones autónomas</option>
                            <option value="Instituciones semiautónomas">Instituciones semiautónomas</option>
                            <option value="Organismos internacionales (ONGs)">Organismos internacionales (ONGs)</option>
                        </select>
                    </div>
                </div>

                {{-- Campo: Jornada laboral --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="jornada_laboral">Jornada laboral</label><span class="text-muted" id="mostrar_cant_jorn_lab"></span>
                        <input type='text' class="form-control w-100" id="jornada_laboral" name="jornada_laboral" onkeyup="contarCarJornLab(this)">
                    </div>
                </div>

                {{-- Campo: Cargo actual --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="cargo_actual">Cargo actual:</label> <span class="text-muted" id="mostrar_cant_carg_act"></span>
                        <input type='text' class="form-control w-100" id="cargo_actual" name="cargo_actual" onkeyup="contarCarCargAct(this)">
                    </div>
                </div>

                {{-- Campo: Jefe inmediato --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="jefe_inmediato">Jefe inmediato</label> <span class="text-muted" id="mostrar_cant_jef_inme"></span>
                        <input type='text' class="form-control w-100" id="jefe_inmediato" name="jefe_inmediato" onkeyup="contarCarJefInme(this)">
                    </div>
                </div>

                {{-- Campo: Tiempo desempleado --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="tiempo_desempleado">Tiempo desempleado</label> <span class="text-muted" id="mostrar_cant_tiemp_desmp"></span>
                        <input type='text' class="form-control w-100" id="tiempo_desempleado" name="tiempo_desempleado" onkeyup="contarCarTiempDesempl(this)">
                    </div>
                </div>

                {{-- Campo: Telefono trabajo --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="telefono_trabajo">Teléfono trabajo</label> <span class="text-muted" id="mostrar_cant_tel_trbj"></span>
                        <input type='text' class="form-control w-100" id="telefono_trabajo" name="telefono_trabajo" onkeyup="contarCarTelfTrbj(this)">
                    </div>
                </div>

                {{-- Campo: Correo trabajo --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="correo_trabajo">Correo trabajo</label> <span class="text-muted" id="mostrar_cant_corr_trbj"></span>
                        <input type='text' class="form-control w-100" id="correo_trabajo" name="correo_trabajo" onkeyup="contarCarCorrTrbj(this)">
                    </div>
                </div>

                {{-- Campo: Intereses Capacitacion --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="interes_capacitacion">Intereses capacitación</label>
                        <textarea class="form-control w-100" id="interes_capacitacion" name="interes_capacitacion"></textarea>
                    </div>
                </div>

                {{-- Campo: Otros estudios --}}
                <div class="d-flex justify-content-center flex-column ">
                    <div class="mb-3">
                        <label for="otros_estudios">Otros estudios</label>
                        <textarea class="form-control w-100" id="otros_estudios" name="otros_estudios"></textarea>
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
    </div>
</div>
@endsection

@section('pie')
Copyright
@endsection
