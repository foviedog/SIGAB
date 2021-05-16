@extends('layouts.app')

@section('titulo')
Registrar información del personal
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estadosCiviles = GlobalArrays::ESTADOS_CIVILES;
$generos = GlobalArrays::GENEROS;
$cargos = GlobalArrays::CARGOS_PERSONAL;
$grados_academicos = GlobalArrays::GRADOS_ACADEMICOS;
$jornadas = GlobalArrays::JORNADAS_PERSONAL;
$tipos_nombramientos = GlobalArrays::TIPOS_NOMBRAMIENTO_PERSONAL;
$tipos_puestos = GlobalArrays::TIPOS_PUESTOS_PERSONAL;
$regimenes_administrativos = GlobalArrays::REGIMENES_ADMINISTRATIVOS_PERSONAL;
$regimenes_docentes = GlobalArrays::REGIMENES_DOCENTES_PERSONAL;
@endphp

@php
$persona_no_insertada = null;
$personal_no_insertado = null ;
$persona_no_insertada = Session::get('persona_no_insertada');
$personal_no_insertado = Session::get('personal_no_insertado');
@endphp

@section('contenido')



<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h2>Registrar información de un personal</h2>
            <div>

                @if(Accesos::ACCESO_LISTAR_PERSONAL())
                <a href="{{ route('personal.listar') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de personal </a>
                @endif

            </div>
        </div>
        <hr>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Mensaje de que muestra el objeto insertado
            (solo se muestra si ha sido exitoso el registro)  --}}
        @if(Session::has('personal_registrado'))
        <div class="alert alert-dark" role="alert">

            @php
            $persona_insertado = Session::get('persona_registrada');
            $personal_registrado = Session::get('personal_registrado');
            @endphp

            <span class="my-3 font-weight-bolder">Se registró el personal exitosamente con lo siguientes datos:</span>
            <div class="row ">
                <div class="col-6 ">
                    <b>Cédula:</b> {{ $persona_insertado->persona_id }} <br>
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
                    <b>Grado academico:</b> {{ $personal_registrado->grado_academico ?? "No se digitó" }} <br>
                    {{-- Link para modificiar al personal recien agregado --}}
                    <br>
                    <a class="btn btn-rojo" href="{{ route('personal.show',$personal_registrado->persona_id ) }}">
                        @if(Accesos::ACCESO_MODIFICAR_PERSONAL())
                        Editar
                        @else
                        Detalle
                        @endif
                    </a>
                    <br>
                </div>
                <div class="col-6 ">
                    <b>Tipo de cargo:</b> {{ $personal_registrado->cargo?? "No se digitó" }} <br>
                    <b>Tipo de nombramiento:</b> {{ $personal_registrado->tipo_nombramiento ?? "No se digitó" }} <br>
                    <b>Tipo de puesto:</b> {{ $personal_registrado->tipo_puesto ?? "No se digitó" }} <br>
                    <b>Jornada laboral:</b> {{ $personal_registrado->jornada ?? "No se digitó" }} <br>
                    <b>Lugar de trabajo externo:</b> {{ $personal_registrado->lugar_trabajo_externo ?? "No se digitó" }} <br>
                    <b>Experiencia profesional:</b> {{ $personal_registrado->experiencia_profesional ?? "No se digitó" }} <br>
                    <b>Experiencia academica:</b> {{ $personal_registrado->experiencia_academica ?? "No se digitó" }} <br>
                    <b>Régimen administrativo:</b> {{ $personal_registrado->regimen_administrativo ?? "No se digitó" }} <br>
                    <b>Régimen docente:</b> {{ $personal_registrado->regimen_docente ?? "No se digitó" }} <br>
                    <b>Área de especialización 1:</b> {{ $personal_registrado->area_especializacion_1 ?? "No se digitó" }} <br>
                    <b>Área de especialización 2:</b> {{ $personal_registrado->area_especializacion_2 ?? "No se digitó" }} <br>
                </div>

            </div>

        </div>

        <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo personal:</div>
        @endif

        @if(Accesos::ACCESO_REGISTRAR_PERSONAL())
        {{-- Formulario para registrar informacion del personal --}}
        <form autocomplete="off" action="{{ route('personal.store') }}" method="POST" enctype="multipart/form-data" id="personal-form" onsubmit="activarLoader('Agregando Personal');">
            @csrf
            @endif
            <input type="hidden" name="persona_existe" @if(!is_null($persona_existe))) value="true" @else value="false" @endif>
            <input type="hidden" name="idiomasJSON" id="idiomasJSON">
            <div class="tab-content ">
                <div class="tab-pane pt-4 active" id="general">
                    <div class="row">
                        {{-- Campos de la izquierda --}}
                        <div class="col">
                            {{-- Campo: Cedula --}}
                            <div class="d-flex justify-content-start mb-4">
                                <div class="col-4">
                                    <label for="persona_id">Identificación: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6 ">
                                    <input type='text' class="form-control w-100" id="persona_id" name="persona_id" onkeyup="contarCaracteres(this,15)" value="{{ (!is_null($persona_existe)) ? $persona_existe->persona_id : ($persona_no_insertada->persona_id ?? '' )}}" required @if(!is_null($persona_existe)) readonly @endif>
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
                                    <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->nombre : ($persona_no_insertada->nombre ?? '' )}}" required @if(!is_null($persona_existe)) readonly @endif>
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
                                    <input type='text' class="form-control w-100" id="apellido" name="apellido" onkeyup="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->apellido : ($persona_no_insertada->apellido ?? '') }}" required @if(!is_null($persona_existe)) readonly @endif>
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
                                    <input type='text' class="form-control w-100" id="telefono_fijo" name="telefono_fijo" onkeyup="contarCaracteres(this,30)" value="{{ (!is_null($persona_existe)) ? $persona_existe->telefono_fijo : ($persona_no_insertada->telefono_fijo ?? '') }}">
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
                                    <input type='text' class="form-control w-100" id="telefono_celular" name="telefono_celular" onkeyup="contarCaracteres(this,30)" value="{{(!is_null($persona_existe)) ? $persona_existe->telefono_celular : ($persona_no_insertada->telefono_celular ?? '') }}">
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
                                    <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_personal" name="correo_personal" onkeyup="contarCaracteres(this,50)" value="{{ (!is_null($persona_existe)) ? $persona_existe->correo_personal : ($persona_no_insertada->correo_personal ?? '') }}" multiple>
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
                                    <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_institucional" name="correo_institucional" onkeyup="contarCaracteres(this,100)" multiple value="{{ (!is_null($persona_existe)) ? $persona_existe->correo_institucional : ($persona_no_insertada->correo_institucional ?? '') }}" required>
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
                                    <textarea class="form-control w-100" id="direccion_residencia" rows="4" name="direccion_residencia" onkeyup="contarCaracteres(this,250)" required>{{ (!is_null($persona_existe)) ? $persona_existe->direccion_residencia : ($persona_no_insertada->direccion_residencia ?? '')}}</textarea>
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
                                        <option value="{{ $genero }}" @if ( (!is_null($persona_existe) && $persona_existe->genero == $genero) || !is_null($persona_no_insertada) &&  $persona_no_insertada->genero == $genero ) selected  @endif>{{ $genero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Campo: Grado académico --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="grado_academico">Grado académico: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6">
                                    <select id="grado_academico" name="grado_academico" class="form-control" required>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($grados_academicos as $grado_academico)
                                        <option value="{{ $grado_academico }}" @if ( $personal_no_insertado !=null) @if ( $grado_academico==$personal_no_insertado->grado_academico) selected @endif @endif> {{ $grado_academico }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Campo: tipo de nombramiento --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="tipo_nombramiento">Tipo de nombramiento: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6">
                                    <select id="tipo_nombramiento" name="tipo_nombramiento" class="form-control" required>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($tipos_nombramientos as $tipo_nombramiento)
                                        <option value="{{ $tipo_nombramiento }}" @if ( $personal_no_insertado !=null) @if ( $tipo_nombramiento==$personal_no_insertado->tipo_nombramiento) selected @endif @endif> {{ $tipo_nombramiento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        {{-- Campos de la derecha --}}
                        <div class="col">

                            {{-- Campo: tipo de cargo --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="cargo">Tipo de cargo: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6">
                                    <select id="cargo" name="cargo" class="form-control" required>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($cargos as $cargo)
                                        <option value="{{ $cargo }}" @if ( $personal_no_insertado !=null) @if ( $cargo==$personal_no_insertado->cargo) selected @endif @endif> {{ $cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Campo: tipo de puesto 1--}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="tipo_puesto_1">Tipo de puesto 1: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6">
                                    <select id="tipo_puesto_1" name="tipo_puesto_1" class="form-control" required>
                                        @foreach($tipos_puestos as $tipo_puesto)
                                        <option value="{{ $tipo_puesto }}" @if ( $personal_no_insertado !=null) @if ( $tipo_puesto==$personal_no_insertado->tipo_puesto_1) selected @endif @endif> {{ $tipo_puesto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span data-toggle="tooltip" data-placement="top" title="Tipo de puesto PRINCIPAL que desempeña en la EBDI"><i class="far fa-question-circle fa-lg "></i></span>
                            </div>
                            {{-- Campo: tipo de puesto 2--}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="tipo_puesto_2">Tipo de puesto 2: </label>
                                </div>
                                <div class="col-6">
                                    <select id="tipo_puesto_2" name="tipo_puesto_2" class="form-control">
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($tipos_puestos as $tipo_puesto)
                                        <option value="{{ $tipo_puesto }}" @if ( $personal_no_insertado !=null) @if ( $tipo_puesto==$personal_no_insertado->tipo_puesto_2) selected @endif @endif> {{ $tipo_puesto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span data-toggle="tooltip" data-placement="top" title="Tipo de puesto SECUNDARIO que desempeña en la EBDI"><i class="far fa-question-circle fa-lg "></i></span>

                            </div>
                            {{-- Campo: Jornada --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="jornada">Jornada laboral: <i class="text-danger">*</i></label>
                                </div>
                                <div class="col-6">
                                    <select id="jornada" name="jornada" class="form-control" required>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($jornadas as $jornada)
                                        <option value="{{ $jornada }}" @if ( $personal_no_insertado !=null) @if ( $jornada==$personal_no_insertado->jornada) selected @endif @endif> {{ $jornada }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Campo: Regimen administrativo  --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="regimen_administrativo">Régimen administrativo:</label>
                                </div>
                                <div class="col-6">
                                    <select id="regimen_administrativo" name="regimen_administrativo" class="form-control">
                                        <option value="" selected>No aplica para docentes</option>
                                        @foreach($regimenes_administrativos as $regimen_administrativo)
                                        <option value="{{ $regimen_administrativo }}" @if ( $personal_no_insertado !=null) @if ( $regimen_administrativo==$personal_no_insertado->regimen_administrativo) selected @endif @endif> {{ $regimen_administrativo }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            {{-- Campo: Regimen docente  --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="regimen_docente">Régimen docente:</label>
                                </div>
                                <div class="col-6">
                                    <select id="regimen_docente" name="regimen_docente" class="form-control">
                                        <option value="" selected>No aplica para administrativos</option>
                                        @foreach($regimenes_docentes as $regimen_docente)
                                        <option value="{{ $regimen_docente }}" @if ( $personal_no_insertado !=null) @if ( $regimen_docente==$personal_no_insertado->regimen_docente) selected @endif @endif> {{ $regimen_docente }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            {{-- Campo: Lugar de trabajo externo --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="trabajo_externo">Lugar de trabajo externo: </label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="trabajo_externo" name="trabajo_externo" onkeyup="contarCaracteres(this,60)" value="{{ $personal_no_insertado->lugar_trabajo_externo ?? '' }}">
                                </div>
                                <div class="col-2 d-flex h-25">
                                    <span data-toggle="tooltip" data-placement="top" title="Aplica para personal docente interino"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_trabajo_externo"></span>
                                </div>

                            </div>
                            {{-- Campo: Año de propiedad --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="anio_propiedad">Año de propiedad:</label>
                                </div>
                                <div class="col-6">
                                    <input type='number' class="form-control w-100" id="anio_propiedad" name="anio_propiedad" onkeyup="contarCaracteres(this,4)" value="{{ $personal_no_insertado->anio_propiedad ?? '' }}" min="1990" max="{{ date("Y") }}" />
                                </div>
                                <div class=" col-2">
                                    <span data-toggle="tooltip" data-placement="top" title="Año en el que obtuvo la propiedad en la UNA (Aplica para profesores propietarios) (Rango: 1990 - Año actual)"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_anio_propiedad"></span>
                                </div>
                            </div>
                            {{-- Campo: Area de especialización 1 --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="area_especializacion_1">Área de especialización 1 :</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="area_especializacion_1" name="area_especializacion_1" onkeyup="contarCaracteres(this,100)" value="{{ $personal_no_insertado->area_especializacion_1 ?? '' }}">
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_area_especializacion_1"></span>
                                </div>
                            </div>

                            {{-- Campo: Area de especialización 2  --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="area_especializacion_2">Área de especialización 2:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="area_especializacion_2" name="area_especializacion_2" onkeyup="contarCaracteres(this,100)" value="{{ $personal_no_insertado->area_especializacion_2 ?? '' }}">
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_area_especializacion_2"></span>
                                </div>
                            </div>

                            {{-- Campo: Experiencia profesional  --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="experiencia_profesional"> Experiencia profesional:</label>
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control w-100" id="experiencia_profesional" name="experiencia_profesional" rows="3">{{ $personal_no_insertado->experiencia_profesional ?? '' }}</textarea>
                                </div>
                                <div class="col-2 d-flex h-25">
                                    <span data-toggle="tooltip" data-placement="top" title="Digite la experiencia profesional que se obtuvo en otras entidades externas a la UNA."><i class=" far fa-question-circle fa-lg"></i></span>

                                </div>
                            </div>

                            {{-- Campo: Experiencia académica  --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="experiencia_academica">Experiencia académica:</label>
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control w-100" id="experiencia_academica" name="experiencia_academica" rows="3">{{ $personal_no_insertado->experiencia_academica ?? '' }}</textarea>
                                </div>
                                <div class="col-2 d-flex h-25">
                                    <span data-toggle="tooltip" data-placement="top" title="Experiencia académica en la UNA y en otras instituciones."><i class="far fa-question-circle fa-lg"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row pb-4">

                        <div class="col mt-2">
                            <div class="bg-light py-3 w-100">
                                <p class="ml-3 font-weight-bold ">Lista de idiomas: </p>
                            </div>
                            <div class="alert alert-danger text-center font-weight-bold w-100" role="alert" id="alert-idiomas">
                                Complete todos los campos.
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="lista-idiomas">
                                    <tr>
                                        <td><input type="text" name="name[]" placeholder="Nombre del idioma" class="form-control idioma" /></td>
                                        <td><button type="button" name="agregar-btn" id="agregar-btn" class="btn btn-contorno-rojo"> <i class="fas fa-plus-circle"></i> Agregar otro idioma</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col pt-5 d-flex justify-content-center  align-items-center">
                            <div class="mb-3">
                                <a class="btn btn-contorno-rojo " id="participaciones-ref" data-toggle="tooltip" data-placement="top" title="Esta sección es opcional y se puede editar luego de que se haya registrado el personal">
                                    Participaciones adicionales &nbsp;<i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="infoParticipaciones">
                    <div id="participaciones">
                        <div class="row d-flex justify-content-between border-bottom pb-2">
                            <div class="col">
                                <h4 class="font-weight-bold">Participaciones adicionales</h4>
                            </div>

                        </div>
                        <div class="row pt-4 ">
                            <div class="col">
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="capacitacion_didactica" class="d-flex justify-content-between">Capacitación didactica:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span>
                                        </label>
                                        <textarea class="form-control w-100" id="capacitacion_didactica" name="capacitacion_didactica" rows="3" form="personal-form"></textarea>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="publicaciones" class="d-flex justify-content-between">Publicaciones:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span> </label>
                                        <textarea class="form-control w-100" id="publicaciones" name="publicaciones" rows="3" form="personal-form"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="cursos_impartidos" class="d-flex justify-content-between">Cursos impartidos:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span>
                                        </label>
                                        <textarea class="form-control w-100" id="cursos_impartidos" name="cursos_impartidos" rows="3" form="personal-form"></textarea>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="evaluacion_interna_ppaa" class="d-flex justify-content-between">Evaluación interna PPAA: <span data-toggle="tooltip" data-placement="top" title="separar cada uno con punto y coma (;))">
                                                {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span>
                                        </label>
                                        <textarea class="form-control w-100" id="evaluacion_interna_ppaa" name="evaluacion_interna_ppaa" rows="3" form="personal-form"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="miembro_comisiones" class="d-flex justify-content-between">Miembro comisiones:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span></label>
                                        <textarea class="form-control w-100" id="miembro_comisiones" name="miembro_comisiones" rows="3" form="personal-form"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="miembro_prueba_grado" class="d-flex justify-content-between">Miembro prueba de grado:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span></label>
                                        <textarea class="form-control w-100" id="miembro_prueba_grado" name="miembro_prueba_grado" rows="3" form="personal-form"></textarea>
                                    </div>


                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="evaluador_defensa_publica" class="d-flex justify-content-between">Evaluador defensa pública:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span></label>
                                        <textarea class="form-control w-100" id="evaluador_defensa_publica" name="evaluador_defensa_publica" rows="3" form="personal-form"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="col">
                                        <label for="evaluacion_externa_ppaa" class="d-flex justify-content-between">Evaluación externa PPAA:
                                            {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span></label>
                                        <textarea class="form-control w-100" id="evaluacion_externa_ppaa" name="evaluacion_externa_ppaa" rows="3" form="personal-form"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="col-6">
                                <label for="reconocimientos" class="d-flex justify-content-between">Reconocimientos: <span data-toggle="tooltip" data-placement="top" title="separar cada uno con punto y coma (;))">
                                        {{-- <i class="far fa-question-circle fa-lg"></i> --}}</span></label>
                                <textarea class="form-control w-100" id="reconocimientos" name="reconocimientos" rows="3" form="personal-form"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col d-flex justify-content-center mt-5">
                        <a class="btn btn-contorno-rojo" href="#general" id="info-general" data-toggle="tab"><i class="fas fa-chevron-left"></i> &nbsp; Información general </a>
                    </div>
                </div>

            </div>
            @if(Accesos::ACCESO_REGISTRAR_PERSONAL())
            <div class="d-flex justify-content-center  pt-4">
                {{-- Boton para registrar informacion del personal --}}
                <button type="submit" id="registrar-btn" class="btn btn-rojo btn-lg">Registrar</button>
            </div>
        </form>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_personal/registrar.js') }}" defer></script>
@endsection
