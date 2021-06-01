@extends('layouts.app')

@section('titulo')
Registrar información laboral de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="container bg-white py-4 px-3 mb-5 sombra w-75">
    <div class="d-flex justify-content-between">
        <h3 class="text-center texto-gris-oscuro font-weight-bold">Registrar información laboral</h3>

        @if(Accesos::ACCESO_LISTAR_TRABAJOS())
        <div><a href="{{ route('trabajo.listar', $estudiante->persona->persona_id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left"></i> &nbsp; Regresar</a></div>
        @endif

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

    @if(Accesos::ACCESO_REGISTRAR_TRABAJOS())
    {{-- Formulario para registrar informacion laboral --}}
    <form autocomplete="off" action="{{ route('trabajo.store') }}" method="POST" role="form" enctype="multipart/form-data" onsubmit="activarLoader('Agregando trabajo');">
        @csrf
        @method('PATCH')
        @endif

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Mensaje de que muestra el objeto insertado
            (solo se muestra si ha sido exitoso el registro)  --}}
        @if(Session::has('trabajo_insertado'))
        <div class="alert alert-dark" role="alert">

            @php
            $trabajo_insertado = Session::get('trabajo_insertado');
            @endphp

            Se registró el trabajo con lo siguientes datos: <br> <br>
            <b>Cédula de la persona:</b> {{ $trabajo_insertado->persona_id }} <br> <br>
            <div class="row">
                <div class="col-6 text-justify">
                    <b>Nombre de la organización:</b> {{ $trabajo_insertado->nombre_organizacion }} <br>
                    <b>Jornada laboral:</b> {{ $trabajo_insertado->jornada_laboral }} <br>
                    <b>Jefe inmediato:</b> {{ $trabajo_insertado->jefe_inmediato ?? "No se digitó" }} <br>
                    <b>Tiempo desempleado:</b> {{ $trabajo_insertado->tiempo_desempleado ?? "No se digitó" }} <br>
                    <b>Capacitaciones de interés:</b> {{ $trabajo_insertado->interes_capacitacion ?? "No se digitó" }} <br>
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

        <div class="row mt-4">

            {{-- Campos de la izquierda --}}

            <div class="col">
                {{-- Campo: Nombre de la organizacion --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="nombre_organizacion">Nombre de la organización: <i class="text-danger">*</i></label>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="nombre_organizacion" name="nombre_organizacion" onkeyup="contarCaracteres(this,100)" required>
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_nombre_organizacion"></span>
                    </div>
                </div>

                {{-- Campo: Tipo de organizacion --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="tipo_organizacion">Tipo de organización</label> <i class="text-danger">*</i>
                    </div>
                    <div class="col-6">
                        <select name="tipo_organizacion" class="form-control">
                            <option value="Instituciones públicas">Instituciones públicas</option>
                            <option value="Instituciones privadas">Instituciones privadas</option>
                            <option value="Instituciones autónomas">Instituciones autónomas</option>
                            <option value="Instituciones semiautónomas">Instituciones semiautónomas</option>
                            <option value="Organismos internacionales (ONGs)">Organismos internacionales (ONGs)</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_cant_tip_org"></span>
                    </div>
                </div>

                {{-- Campo: Jornada laboral --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="jornada_laboral">Jornada laboral: </label>
                        <span class="ml-1" data-toggle="tooltip" data-placement="bottom" title="Ingrese la jornada, seguido de la cantidad de horas entre paréntesis. Ej. Tiempo completo (40 horas)."><i class="far fa-question-circle fa-lg"></i> </span>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="jornada_laboral" name="jornada_laboral" onkeyup="contarCaracteres(this,45)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_jornada_laboral"></span>
                    </div>
                </div>

                {{-- Campo: Cargo actual --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="cargo_actual">Cargo actual: </label>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="cargo_actual" name="cargo_actual" onkeyup="contarCaracteres(this,200)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_cargo_actual"></span>
                    </div>
                </div>

                {{-- Campo: Intereses Capacitacion --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="interes_capacitacion">Capacitaciones de interés:</label>
                        <span data-toggle="tooltip" data-placement="bottom" title="Digitar los temas de interés de la persona en recibir capacitación y/o actualización."><i class="far fa-question-circle fa-lg"></i> </span>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control w-100" id="interes_capacitacion" name="interes_capacitacion"></textarea>
                    </div>
                </div>
            </div>


            {{-- Campos de la derecha --}}

            <div class="col">
                {{-- Campo: Jefe inmediato --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="jefe_inmediato">Jefe inmediato: </label>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="jefe_inmediato" name="jefe_inmediato" onkeyup="contarCaracteres(this,45)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_jefe_inmediato"></span>
                    </div>
                </div>
                {{-- Campo: Tiempo desempleado --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="tiempo_desempleado">Tiempo desempleado: </label>
                        <span data-toggle="tooltip" data-placement="bottom" title="Ingrese la información como se muestra en el ejemplo: Ej. 3 años y 4 meses."><i class="far fa-question-circle fa-lg"></i> </span>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="tiempo_desempleado" name="tiempo_desempleado" onkeyup="contarCaracteres(this,45)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_tiempo_desempleado"></span>
                    </div>
                </div>

                {{-- Campo: Telefono trabajo --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="telefono_trabajo">Teléfono trabajo: </label>
                    </div>
                    <div class="col-6">
                        <input type='text' class="form-control w-100" id="telefono_trabajo" name="telefono_trabajo" onkeyup="contarCaracteres(this,45)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_telefono_trabajo"></span>
                    </div>
                </div>

                {{-- Campo: Correo trabajo --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="correo_trabajo">Correo trabajo: </label>
                    </div>
                    <div class="col-6">
                        <input type="email" class="form-control w-100" id="correo_trabajo" name="correo_trabajo" onkeyup="contarCaracteres(this,80)">
                    </div>
                    <div class="col-1">
                        <span class="text-muted" id="mostrar_correo_trabajo"></span>
                    </div>
                </div>

                {{-- Campo: Otros estudios --}}
                <div class="d-flex justify-content-start mb-4">
                    <div class="col-5">
                        <label for="otros_estudios">Otros estudios: </label>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control w-100" id="otros_estudios" name="otros_estudios"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center ">

            {{-- Input oculto que envia el id del estudiante --}}
            <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}">

            {{-- Boton para agregar informacion laboral --}}
            @if(Accesos::ACCESO_REGISTRAR_TRABAJOS())
            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg mb-3">
            @endif
        </div>

        @if(Accesos::ACCESO_REGISTRAR_TRABAJOS())
    </form>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection
