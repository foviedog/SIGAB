@extends('layouts.app')

@section('titulo')
Registrar información del estudiante
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection


@php
$estadosCiviles = GlobalArrays::ESTADOS_CIVILES;
$generos = GlobalArrays::GENEROS;
$colegiosProcedencias = GlobalArrays::COLEGIOS_PROCEDENCIA;
$tiposBecas = GlobalArrays::TIPOS_BECA;
@endphp

@php
$persona_no_insertada = null;
$personal_no_insertado = null ;
$persona_no_insertada = Session::get('persona_no_insertada');
$estudiante_no_insertado = Session::get('estudiante_no_insertado');
@endphp

@php
$anios = array();
for ($anio = 2000; $anio <= date("Y"); $anio++) { array_push($anios, $anio); } @endphp @section('contenido') <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h2>Registrar información del estudiante</h2>
            <div>

                @if(Accesos::ACCESO_LISTAR_ESTUDIANTES())
                <div><a href="{{ route('listado-estudiantil') }}" class="btn btn-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Regresar</a></div>
                @endif

            </div>
        </div>
        <hr>

        @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
        {{-- Formulario para registrar informacion del estudiante --}}
        <form action="{{ route('estudiante.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data" id="estudiante">
            @csrf
            @endif

            {{-- Alerts --}}
            @include('layouts.messages.alerts')

            {{-- Mensaje de que muestra el objeto insertado (solo se muestra si ha sido exitoso el registro)  --}}
            @if(Session::has('estudiante_insertado'))
            <div class="alert alert-dark" role="alert">

                @php
                $persona_insertado = Session::get('persona_insertado');
                $estudiante_insertado = Session::get('estudiante_insertado');
                $cedula = Session::get('cedula');
                @endphp

                Se registró el estudiante con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>Cédula:</b> {{ $cedula }} <br>
                        <b>Nombre/s:</b> {{ $persona_insertado->nombre }} <br>
                        <b>Apellido/s:</b> {{ $persona_insertado->apellido }} <br>
                        <b>Fecha de nacimiento:</b> {{ $persona_insertado->fecha_nacimiento ?? "No se digitó" }} <br>
                        <b>Teléfono fijo:</b> {{ $persona_insertado->telefono_fijo ?? "No se digitó" }} <br>
                        <b>Teléfono celular:</b> {{ $persona_insertado->telefono_celular ?? "No se digitó" }} <br>
                        <b>Correo personal:</b> {{ $persona_insertado->correo_personal ?? "No se digitó" }} <br>
                        <b>Correo institucional:</b> {{ $persona_insertado->correo_institucional ?? "No se digitó" }} <br>
                        <b>Estado Civil:</b> {{ $persona_insertado->estado_civil ?? "No se digitó" }} <br>
                        <b>Dirección de residencia:</b> {{ $persona_insertado->direccion_residencia ?? "No se digitó" }} <br>
                        <b>Género:</b> {{ $persona_insertado->genero ?? "No se digitó" }} <br>
                        <b>Dirección lectivo:</b> {{ $estudiante_insertado->direccion_lectivo ?? "No se digitó" }} <br>
                        <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br>

                        {{-- Link directo al estudiante recien agregado --}}
                        <br>
                        <a clas="btn btn-rojo" href="{{ route('estudiante.show', $cedula) }}">
                            <input type="button" @if(Accesos::ACCESO_MODIFICAR_ESTUDIANTES()) value="Editar" @else value="Detalle" @endif class="btn btn-rojo">
                        </a>
                        <br>

                    </div>
                    <div class="col-6 text-justify">
                        <b>Tipo de colegio de procedencia:</b> {{ $estudiante_insertado->tipo_colegio_procedencia ?? "No se digitó" }} <br>
                        <b>Condición de discapacidad:</b> {{ $estudiante_insertado->condicion_discapacidad ?? "No se digitó" }} <br>
                        <b>Año de ingreso a la EBDI:</b> {{ $estudiante_insertado->anio_ingreso_ebdi ?? "No se digitó" }} <br>
                        <b>Año de ingreso a la UNA:</b> {{ $estudiante_insertado->anio_ingreso_UNA ?? "No se digitó" }} <br>
                        <b>Carrera matriculada 1:</b> {{ $estudiante_insertado->carrera_matriculada_1 ?? "No se digitó" }} <br>
                        <b>Carrera matriculada 2:</b> {{ $estudiante_insertado->carrera_matriculada_2 ?? "No se digitó" }} <br>
                        <b>Año de graduación estimado 1:</b> {{ $estudiante_insertado->anio_graduacion_estimado_1 ?? "No se digitó" }} <br>
                        <b>Año de graduación estimado 2:</b> {{ $estudiante_insertado->anio_graduacion_estimado_2 ?? "No se digitó" }} <br>
                        <b>Año de deserción:</b> {{ $estudiante_insertado->anio_desercion ?? "No se digitó" }} <br>
                        <b>Tipo de beca:</b> {{ $estudiante_insertado->tipo_beca ?? "No se digitó" }} <br>
                        <b>Nota de admisión:</b> {{ $estudiante_insertado->nota_admision ?? "No se digitó" }} <br>
                        <b>Apoyo educativo:</b> {{ $estudiante_insertado->apoyo_educativo ?? "No se digitó" }} <br>

                        @if($estudiante_insertado->residencias_UNA == 0)
                        <b>Residencias:</b> {{ "No" ?? "No se digitó" }} <br>
                        @else
                        <b>Residencias:</b> {{ "Sí" ?? "No se digitó" }} <br>
                        @endif

                    </div>

                </div>
            </div>

            <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div>
            @endif

            <div class="row">

                {{-- Campos de la izquierda --}}
                <div class="col">

                    {{-- Campo: Cedula --}}
                    <div class="d-flex justify-content-start mb-4">
                        <div class="col-4">
                            <label for="cedula">Cédula: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeyup="contarCaracteres(this,15)" value="{{ $persona_no_insertada->persona_id ?? '' }}" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cedula"></span>
                        </div>
                    </div>

                    {{-- Campo: Nombre --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="nombre">Nombre/s: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCaracteres(this,50)" value="{{ $persona_no_insertada->nombre ?? '' }}" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_nombre"></span>
                        </div>
                    </div>

                    {{-- Campo: Apellidos --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="apellido">Apellido/s: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="apellido" name="apellido" onkeyup="contarCaracteres(this,50)" value="{{ $persona_no_insertada->apellido ?? '' }}" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_apellido"></span>
                        </div>
                    </div>

                    {{-- Campo: Fecha de nacimiento --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="fecha_nacimiento">Fecha de nacimiento: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='date' class="form-control w-100" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $persona_no_insertada->fecha_nacimiento ?? null  }}" required>
                        </div>

                    </div>

                    {{-- Campo: Telefono fijo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_fijo">Teléfono fijo:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_fijo" name="telefono_fijo" onkeyup="contarCaracteres(this,30)" value="{{ $persona_no_insertada->telefono_fijo ?? '' }}">
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_telefono_fijo"></span>
                        </div>
                    </div>

                    {{-- Campo: Telefono celular --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_celular">Teléfono celular:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_celular" name="telefono_celular" onkeyup="contarCaracteres(this,30)" value="{{ $persona_no_insertada->telefono_celular ?? '' }}">
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_telefono_celular"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo personal --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_personal">Correo personal:</label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_personal" name="correo_personal" onkeyup="contarCaracteres(this,45)" value="{{ $persona_no_insertada->correo_personal ?? '' }}" multiple>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_correo_personal"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo institucional --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_institucional">Correo institucional: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_institucional" name="correo_institucional" onkeyup="contarCaracteres(this,45)" multiple value="{{ $persona_no_insertada->correo_institucional ?? '' }}" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_correo_institucional"></span>
                        </div>
                    </div>

                    {{-- Campo: Estado civil --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="estado_civil">Estado civil: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="estado_civil" name="estado_civil" class="form-control" required>
                                <option value="" selected>Sin seleccionar</option>
                                @foreach($estadosCiviles as $estadoCivil)
                                <option value='{{ $estadoCivil }}' @if ( $persona_no_insertada !=null) @if ( $estadoCivil==$persona_no_insertada->estado_civil) selected @endif @endif > {{ $estadoCivil }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Direccion de residencia --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="direccion_residencia">Dirección de residencia: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="direccion_residencia" name="direccion_residencia" onkeyup="contarCaracteres(this,250)" required>{{$persona_no_insertada->direccion_residencia ?? ''}}</textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Dirección del domicilio en el que reside de manera regular"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_direccion_residencia"></span>
                        </div>
                    </div>

                    {{-- Campo: Genero --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="genero">Género: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="genero" name="genero" class="form-control w-100" required>
                                <option value="" selected>Sin seleccionar</option>
                                <option value="M" @if ( $persona_no_insertada !=null) @if ( $persona_no_insertada->genero == "M") selected @endif @endif>Masculino</option>
                                <option value="F" @if ( $persona_no_insertada !=null) @if ( $persona_no_insertada->genero == "F") selected @endif @endif>Femenino</option>
                                <option value="Otro" @if ( $persona_no_insertada !=null) @if ( $persona_no_insertada->genero == "Otro") selected @endif @endif )>Otro</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Direccion lectivo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="direccion_lectivo">Dirección en tiempo lectivo: </label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="direccion_lectivo" name="direccion_lectivo" onkeyup="contarCaracteres(this,250)"> {{ $estudiante_no_insertado->direccion_lectivo ?? '' }} </textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Dirección del domicilio o apartamento en el que reside durante los ciclos lectivos"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_direccion_lectivo"></span>
                        </div>
                    </div>

                    {{-- Campo: Cantidad de hijos --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="cantidad_hijos">Cantidad hijos: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='number' min="0" max="99" class="form-control w-100" id="cantidad_hijos" name="cantidad_hijos" onkeyup="contarCaracteres(this,2)" value="{{ $estudiante_no_insertado->cant_hijos ?? '' }}" required>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="En caso de no tener hijos se debe ingresar un 0"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cantidad_hijos"></span>
                        </div>
                    </div>
                </div>

                {{-- Campos de la derecha --}}
                <div class="col">

                    {{-- Campo: Tipo de colegio de procedencia --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_colegio_procedencia">Tipo colegio de procedencia: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="tipo_colegio_procedencia" name="tipo_colegio_procedencia" class="form-control" required>
                                @foreach($colegiosProcedencias as $colegioProcedencia)
                                <option value="{{ $colegioProcedencia }}" @if ( $estudiante_no_insertado !=null) @if ( $colegioProcedencia==$estudiante_no_insertado->tipo_colegio_procedencia) selected @endif @endif > {{ $colegioProcedencia }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Condicion de discapacidad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="condicion_discapacidad">Condición de discapacidad:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="condicion_discapacidad" name="condicion_discapacidad" onkeyup="contarCaracteres(this,250)"> {{ $estudiante_no_insertado->condicion_discapacidad ?? '' }} </textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Se debe especificar la condición que posee, o de no tener, se debe dejar vacío"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_condicion_discapacidad"></span>
                        </div>
                    </div>

                    {{-- Campo: Año de ingreso a la EBDI --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_ingreso_ebdi">Año de ingreso a la EBDI: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="anio_ingreso_ebdi" name="anio_ingreso_ebdi" class="form-control w-100" required>
                                @foreach($anios as $anio)
                                <option value="{{ $anio }}" @if ( !is_null($estudiante_no_insertado) && $anio==$estudiante_no_insertado->anio_ingreso_ebdi ) selected @endif>{{ $anio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que ingresó a la escuela"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_ingreso_ebdi"></span>
                        </div>
                    </div>

                    {{-- Campo: Año de ingreso a la UNA --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_ingreso_una">Año de ingreso a la UNA: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="anio_ingreso_una" name="anio_ingreso_una" class="form-control w-100" required>
                                @foreach($anios as $anio)
                                <option value="{{ $anio }}" @if (!is_null($estudiante_no_insertado) && $anio==$estudiante_no_insertado->anio_ingreso_UNA ) selected @endif>{{ $anio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que ingresó a la universidad"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_ingreso_una"></span>
                        </div>
                    </div>

                    {{-- Campo: Año de desercion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_desercion">Año de deserción:</label>
                        </div>
                        <div class="col-6">
                            <input type='number' min="0" max="9999" class="form-control w-100" id="anio_desercion" name="anio_desercion" onkeyup="contarCaracteres(this,10)" value="{{ $estudiante_no_insertado->anio_desercion ?? '' }}">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que desertó de la carrera, si no lo ha hecho, se debe dejar el espacio vacío"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_desercion"></span>
                        </div>
                    </div>

                    {{-- Campo: Tipo de beca --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_beca">Tipo de beca: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select id="tipo_beca" name="tipo_beca" class="form-control" required>
                                @foreach($tiposBecas as $tipoBeca)
                                <option value="{{ $tipoBeca }}" @if ( $estudiante_no_insertado !=null) @if ( $tipoBeca==$estudiante_no_insertado->tipo_beca) selected @endif @endif > {{ $tipoBeca }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Nota de admision --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="nota_admision">Nota de admisión: </label>
                        </div>
                        <div class="col-6">
                            <input type='number' class="form-control w-100" min="0" max="999.99" step="0.01" id="nota_admision" name="nota_admision" onkeyup="contarCaracteres(this,6)" value="{{ $estudiante_no_insertado->nota_admision ?? '' }}">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nota de admisión especifíco para la Universidad Nacional"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_nota_admision"></span>
                        </div>
                    </div>

                    {{-- Campo: Carrera matriculada 1 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="carrera_matriculada_1">Carrera matriculada 1: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="carrera_matriculada_1" name="carrera_matriculada_1" onkeyup="contarCaracteres(this,45)" value="{{ $estudiante_no_insertado->carrera_matriculada_1 ?? '' }}" required>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nombre de la carrera principal"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_carrera_matriculada_1"></span>
                        </div>
                    </div>

                    {{-- Campo: Carrera matriculada 2 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="carrera_matriculada_2">Carrera matriculada 2:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="carrera_matriculada_2" name="carrera_matriculada_2" onkeyup="contarCaracteres(this,45)" value="{{ $estudiante_no_insertado->carrera_matriculada_2 ?? '' }}">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nombre de la carrera secundaria"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_carrera_matriculada_2"></span>
                        </div>
                    </div>

                    {{-- Campo: Año de graduacion estimado 1 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_graduacion_estimado_1">Año de graduación estimado 1: </label>
                        </div>
                        <div class="col-6">
                            <input type='number' min="1975" max="9999" class="form-control w-100" id="anio_graduacion_estimado_1" name="anio_graduacion_estimado_1" onkeyup="contarCaracteres(this,10)" value="{{ $estudiante_no_insertado->anio_graduacion_estimado_1 ?? '' }}">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que se estima que concluya la carrera matriculada 1"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_graduacion_estimado_1"></span>
                        </div>
                    </div>

                    {{-- Campo: Año estimado de graduacion 2 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_graduacion_estimado_2">Año de graduación estimado 2:</label>
                        </div>
                        <div class="col-6">
                            <input type='number' min="1975" max="9999" class="form-control w-100" id="anio_graduacion_estimado_2" name="anio_graduacion_estimado_2" onkeyup="contarCaracteres(this,10)" value="{{ $estudiante_no_insertado->anio_graduacion_estimado_2 ?? '' }}">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que se estima que concluya la carrera matriculada 2"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_graduacion_estimado_2"></span>
                        </div>
                    </div>

                    {{-- Campo: Apoyo educativo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="apoyo_educativo">Apoyo educativo:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="apoyo_educativo" name="apoyo_educativo" onkeyup="contarCaracteres(this,500)">{{ $estudiante_no_insertado->apoyo_educativo ?? '' }}</textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_apoyo_educativo"></span>
                        </div>
                    </div>

                    {{-- Campo: Residencias --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="residencias">Residencias:</label>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="residencias" id="residencias1" value="0" checked>
                                <label class="form-check-label pr-5" for="residencias1"> No </label>

                                <input class="form-check-input" type="radio" name="residencias" id="residencias2" value="1">
                                <label class="form-check-label" for="residencias2"> Sí </label>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
            <div class="d-flex justify-content-center">
                {{-- Boton para agregar informacion del estudiante --}}
                <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
            </div>
        </form>
        @endif

    </div>
    </div>
    @endsection

    @section('scripts')
    <script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
    @endsection
