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
$anios = GlobalFunctions::obtenerAniosActual();
$aniosFuturos = GlobalFunctions::obtenerAniosFuturos();
@endphp

@php
$persona_no_insertada = null;
$personal_no_insertado = null ;
$persona_no_insertada = Session::get('persona_no_insertada');
$estudiante_no_insertado = Session::get('estudiante_no_insertado');
@endphp

@section('contenido') <div class="card">
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
            <input type="hidden" name="persona_existe" @if(!is_null($persona_existe))) value="true" @else value="false" @endif>

            {{-- Alerts --}}
            @include('layouts.messages.alerts')

            {{-- Mensaje de que muestra el objeto insertado (solo se muestra si ha sido exitoso el registro)  --}}
            @if(isset($estudiante_insertado))
            <div class="alert alert-dark" role="alert">
                Se registró el estudiante con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>Cédula:</b> {{ $persona_insertada->persona_id }} <br>
                        <b>Nombre/s:</b> {{ $persona_insertada->nombre }} <br>
                        <b>Apellido/s:</b> {{ $persona_insertada->apellido }} <br>
                        <b>Fecha de nacimiento:</b> {{ $persona_insertada->fecha_nacimiento ?? "No se digitó" }} <br>
                        <b>Teléfono fijo:</b> {{ $persona_insertada->telefono_fijo ?? "No se digitó" }} <br>
                        <b>Teléfono celular:</b> {{ $persona_insertada->telefono_celular ?? "No se digitó" }} <br>
                        <b>Correo personal:</b> {{ $persona_insertada->correo_personal ?? "No se digitó" }} <br>
                        <b>Correo institucional:</b> {{ $persona_insertada->correo_institucional ?? "No se digitó" }} <br>
                        <b>Estado Civil:</b> {{ $persona_insertada->estado_civil ?? "No se digitó" }} <br>
                        <b>Dirección de residencia:</b> {{ $persona_insertada->direccion_residencia ?? "No se digitó" }} <br>
                        <b>Género:</b> {{ $persona_insertada->genero ?? "No se digitó" }} <br>
                        <b>Dirección lectivo:</b> {{ $estudiante_insertado->direccion_lectivo ?? "No se digitó" }} <br>
                        <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br>

                        {{-- Link directo al estudiante recien agregado --}}
                        <br>
                        <a clas="btn btn-rojo" href="{{ route('estudiante.show', $estudiante_insertado->persona_id) }}">
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
                            <label for="persona_id">Identificación: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6 ">
                            <input type='text' class="form-control w-100" id="persona_id" name="persona_id" onkeypress="contarCaracteres(this,15)" value="{{ (!is_null($persona_existe)) ? $persona_existe->persona_id : ($persona_no_insertada->persona_id ?? '' )}}" required @if(!is_null($persona_existe)) readonly @endif>
                        </div>
                        <div class="col-2 d-flex h-25">
                            <span data-toggle="tooltip" data-placement="top" title="Digitar número de cédula sin guiones, ni espacios (Acepta caracteres para cédulas extranjeras)"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                            <span class="text-muted" id="mostrar_persona_id"></span>
                        </div>
                    </div>

                    {{-- Campo: Nombre --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="nombre">Nombre/s: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeypress="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->nombre : ($persona_no_insertada->nombre ?? '' )}}" required @if(!is_null($persona_existe)) readonly @endif>
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
                            <input type='text' class="form-control w-100" id="apellido" name="apellido" onkeypress="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->apellido : ($persona_no_insertada->apellido ?? '') }}" required @if(!is_null($persona_existe)) readonly @endif>
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
                            <input type='date' class="form-control w-100" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ (!is_null($persona_existe)) ? $persona_existe->fecha_nacimiento : ($persona_no_insertada->fecha_nacimiento ?? null)  }}" required>
                        </div>
                    </div>

                    {{-- Campo: Telefono fijo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_fijo">Teléfono fijo:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_fijo" name="telefono_fijo" onkeypress="contarCaracteres(this,30)" value="{{ (!is_null($persona_existe)) ? $persona_existe->telefono_fijo : ($persona_no_insertada->telefono_fijo ?? '') }}">
                        </div>
                        <div class="col-2 d-flex h-25">
                            <span data-toggle="tooltip" data-placement="top" title="Digitar número sin guiones, ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                            <span class="text-muted" id="mostrar_telefono_fijo"></span>
                        </div>
                    </div>

                    {{-- Campo: Telefono celular --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_celular">Teléfono celular:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_celular" name="telefono_celular" onkeypress="contarCaracteres(this,30)" value="{{(!is_null($persona_existe)) ? $persona_existe->telefono_celular : ($persona_no_insertada->telefono_celular ?? '') }}">
                        </div>
                        <div class="col-2 d-flex h-25">
                            <span data-toggle="tooltip" data-placement="top" title="Digitar número sin guiones, ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                            <span class="text-muted" id="mostrar_telefono_celular"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo personal --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_personal">Correo personal:</label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_personal" name="correo_personal" onkeypress="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->correo_personal : ($persona_no_insertada->correo_personal ?? '') }}" multiple>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_correo_personal"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo institucional --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_institucional">Correo institucional:</label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_institucional" name="correo_institucional" onkeypress="contarCaracteres(this,100)" multiple value="{{ (!is_null($persona_existe)) ? $persona_existe->correo_institucional : ($persona_no_insertada->correo_institucional ?? '') }}">
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
                                <option value='{{ $estadoCivil }}' @if ((!is_null($persona_existe) && $persona_existe->estado_civil == $estadoCivil) || (!is_null($persona_no_insertada) && $estadoCivil==$persona_no_insertada->estado_civil)) selected @endif > {{ $estadoCivil }}</option>
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
                            <textarea class="form-control w-100" id="direccion_residencia" rows="4" name="direccion_residencia" onkeypress="contarCaracteres(this,250)" required>{{ (!is_null($persona_existe)) ? $persona_existe->direccion_residencia : ($persona_no_insertada->direccion_residencia ?? '')}}</textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="top" title="Dirección del domicilio en el que reside de manera regular"><i class="far fa-question-circle fa-lg"></i></span>
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
                                @foreach ($generos as $genero )
                                <option value="{{ $genero }}" @if ( (!is_null($persona_existe) && $persona_existe->genero == $genero) || !is_null($persona_no_insertada) && $persona_no_insertada->genero == $genero ) selected @endif>{{ $genero }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Direccion lectivo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="direccion_lectivo">Dirección en tiempo lectivo: </label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="direccion_lectivo" name="direccion_lectivo" onkeypress="contarCaracteres(this,250)"> {{ $estudiante_no_insertado->direccion_lectivo ?? '' }} </textarea>
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
                            <input type='number' min="0" max="99" class="form-control w-100" id="cantidad_hijos" name="cantidad_hijos" onkeypress="contarCaracteres(this,2)" value="{{ $estudiante_no_insertado->cant_hijos ?? '' }}" required>
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
                            <textarea class="form-control w-100" id="condicion_discapacidad" name="condicion_discapacidad" onkeypress="contarCaracteres(this,250)"> {{ $estudiante_no_insertado->condicion_discapacidad ?? '' }} </textarea>
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
                            <select id="anio_desercion" name="anio_desercion" class="form-control w-100" required>
                            <option value="">Sin seleccionar</option>
                                @foreach($anios as $anio)
                                <option value="{{ $anio }}" @if (!is_null($estudiante_no_insertado) && $anio==$estudiante_no_insertado->anio_desercion ) selected @endif>{{ $anio }}</option>
                                @endforeach
                            </select>
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
                            <input type='number' class="form-control w-100" min="0" max="999.99" step="0.01" id="nota_admision" name="nota_admision" onkeypress="contarCaracteres(this,6)" value="{{ $estudiante_no_insertado->nota_admision ?? '' }}">
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
                            <input type='text' class="form-control w-100" id="carrera_matriculada_1" name="carrera_matriculada_1" onkeypress="contarCaracteres(this,250)" value="{{ $estudiante_no_insertado->carrera_matriculada_1 ?? '' }}" required>
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
                            <input type='text' class="form-control w-100" id="carrera_matriculada_2" name="carrera_matriculada_2" onkeypress="contarCaracteres(this,45)" value="{{ $estudiante_no_insertado->carrera_matriculada_2 ?? '' }}">
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
                            <select id="anio_graduacion_estimado_1" name="anio_graduacion_estimado_1" class="form-control w-100" required>
                                <option value="">Sin seleccionar</option>
                                @foreach($aniosFuturos as $anio)
                                <option value="{{ $anio }}" @if (!is_null($estudiante_no_insertado) && $anio==$estudiante_no_insertado->anio_graduacion_estimado_1 ) selected @endif>{{ $anio }}</option>
                                @endforeach
                            </select>
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
                            <select id="anio_graduacion_estimado_2" name="anio_graduacion_estimado_2" class="form-control w-100" required>
                                <option value="">Sin seleccionar</option>
                                @foreach($aniosFuturos as $anio)
                                <option value="{{ $anio }}" @if (!is_null($estudiante_no_insertado) && $anio==$estudiante_no_insertado->anio_graduacion_estimado_2 ) selected @endif>{{ $anio }}</option>
                                @endforeach
                            </select>
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
                            <textarea class="form-control w-100" id="apoyo_educativo" name="apoyo_educativo" onkeypress="contarCaracteres(this,500)">{{ $estudiante_no_insertado->apoyo_educativo ?? '' }}</textarea>
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
<script src="{{ asset('js/global/inputs.js') }}" defer></script>
@endsection
