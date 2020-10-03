@extends('layouts.app')

@section('titulo')
Registrar información del estudiante
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
        <h2>Registrar información de un personal</h2>
        <hr>

        {{-- Formulario para registrar informacion del estudiante --}}
        <form action="/estudiante" method="POST" enctype="multipart/form-data" id="estudiante">
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
            @if(Session::has('estudiante_insertado'))
            <div class="alert alert-dark" role="alert">

                @php
                $persona_insertado = Session::get('persona_insertado');
                $estudiante_insertado = Session::get('estudiante_insertado');
                $cedula = Session::get('cedula');
                @endphp

                Se insertó el estudiante con lo siguientes datos: <br> <br>
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
                        <b>Dirección lectivo:</b> {{ $estudiante_insertado->direccion_lectivo }} <br>
                        <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br>

                        {{-- Link directo al estudiante recien agregado --}}
                        <br>
                        <a clas="btn btn-rojo" href="/estudiante/detalle/{{ $cedula }}">
                            <input type="button" value="Editar" class="btn btn-rojo">
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
                            <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeyup="contarCarCed(this)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_ced"></span>
                        </div>
                    </div>

                    {{-- Campo: Nombre --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="nombre">Nombre/s: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCarNombre(this)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_nombre"></span>
                        </div>
                    </div>

                    {{-- Campo: Apellidos --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="apellido">Apellido/s: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="apellido" name="apellido" onkeyup="contarCarApellido(this)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_apellido"></span>
                        </div>
                    </div>

                    {{-- Campo: Fecha de nacimiento --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="fecha_nacimiento">Fecha de nacimiento: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='date' value="2020-08-15" class="form-control w-100" id="fecha_nacimiento" name="fecha_nacimiento" onkeyup="contarCarFechaNacimiento(this)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_fecha_nacimiento"></span>
                        </div>
                    </div>

                    {{-- Campo: Telefono fijo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_fijo">Teléfono fijo:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_fijo" name="telefono_fijo" onkeyup="contarCarTelefonoFijo(this)">
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_telefono_fijo"></span>
                        </div>
                    </div>

                    {{-- Campo: Telefono celular --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_celular">Teléfono celular:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_celular" name="telefono_celular" onkeyup="contarCarTelefonoCelular(this)">
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_telefono_celular"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo personal --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_personal">Correo personal:</label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_personal" name="correo_personal" onkeyup="contarCarCorreoPersonal(this)" multiple>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_correo_personal"></span>
                        </div>
                    </div>

                    {{-- Campo: Correo institucional --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="correo_institucional">Correo institucional: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_institucional" name="correo_institucional" onkeyup="contarCarCorreoInstitucional(this)" multiple required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_correo_institucional"></span>
                        </div>
                    </div>

                    {{-- Campo: Estado civil --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="estado_civil">Estado civil: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="estado_civil" name="estado_civil" form="estudiante" required>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                                <option value="Divorciado(a)">Divorciado(a)</option>
                                <option value="Unión libre">Unión libre</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Direccion de residencia --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="direccion_residencia">Dirección de residencia: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="direccion_residencia" name="direccion_residencia" onkeyup="contarCarDireccionResidencia(this)" required></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Dirección del domicilio en el que reside de manera regular"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_direccion_residencia"></span>
                        </div>
                    </div>

                    {{-- Campo: Genero --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="genero">Género: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="genero" name="genero" form="estudiante" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Grado académico --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="grado_academico">Grado académico: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="estado_civil" name="estado_civil" form="estudiante" required>
                                <option value="Bachillerato(a)">Bachillerato(a)</option>
                                <option value="Licenciado(a)">Licenciado(a)</option>
                                <option value="Master(a)">Master(a)</option>
                                <option value="Doctorado(a)">Doctorado(a)</option>
                                <option value="Posdoctorado(a)">Posdoctorado(a)</option>
                            </select>
                        </div>
                    </div>
                </div>


                {{-- Campos de la derecha --}}
                <div class="col">


                    {{-- Campo: tipo de nombramiento --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_nombramiento">Tipo de nombramiento: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_nombramiento" name="tipo_nombramiento" form="estudiante" required>
                                <option value="Tiempo Completo">Tiempo Completo</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Científico">A largo plazo</option>
                                <option value="Por incapacidad">Por incapacidad</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: tipo de puesto --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_puesto">Tipo de puesto: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_puesto" name="tipo_puesto" form="estudiante" required>
                                <option value="Tiempo Completo">Tiempo Completo</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Científico">A largo plazo</option>
                                <option value="Por incapacidad">Por incapacidad</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: tipo de puesto --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="jornada">Jornada: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="jornada" name="jornadar" form="estudiante" required>
                                <option value="Tiempo Completo">Tiempo Completo</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Científico">A largo plazo</option>
                                <option value="Por incapacidad">Por incapacidad</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Lugar de trabajo externo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="trabajo_externo">Lugar de trabajo externo: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="trabajo_externo" name="trabajo_externo" onkeyup="contarCarCarreraMatriculada1(this)" required>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nombre de la carrera principal"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_carrera_matriculada1"></span>
                        </div>
                    </div>
                    {{-- Campo: Año de propiedad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_propiedad">Año de propiedad: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='number' class="form-control w-100" id="anio_propiedad" name="anio_propiedad" onkeyup="contarCarAnioIngresoUna(this)" required>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Año en el que ingresó a la universidad"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_anio_ingreso_una"></span>
                        </div>
                    </div>
                    {{-- Campo: Area de esplización 1 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="carrera_matriculada_1">Area de esplización 1 : <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="carrera_matriculada_1" name="carrera_matriculada_1" onkeyup="contarCarCarreraMatriculada1(this)" required>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nombre de la carrera principal"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_carrera_matriculada1"></span>
                        </div>
                    </div>

                    {{-- Campo: Area de esplización 1  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="carrera_matriculada_2">Area de esplización 2:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="carrera_matriculada_2" name="carrera_matriculada_2" onkeyup="contarCarMateriaMatriculada2(this)">
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Nombre de la carrera secundaria"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_materia_matriculada_2"></span>
                        </div>
                    </div>

                    {{-- Campo: Experiencia profesional  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="experiencia_profesional"> Experiencia profesional:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="experiencia_profesional" name="experiencia_profesional" onkeyup="contarCarApoyoEducativo(this)"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_apoyo_educativo"></span>
                        </div>
                    </div>

                    {{-- Campo: Experiencia académica  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="experiencia_academica">Experiencia académica:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="experiencia_academica" name="experiencia_academica" onkeyup="contarCarApoyoEducativo(this)"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_cant_apoyo_educativo"></span>
                        </div>
                    </div>
                    {{-- Campo: Regimen administrativo  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="regimen_administrativo">Regimen administrativo:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="regimen_administrativo" name="regimen_administrativo" onkeyup="contarCarApoyoEducativo(this)"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="regimen_administrativo"></span>
                        </div>
                    </div>
                    {{-- Campo: Regimen docente  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="regimen_docente">Regimen docente:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="regimen_docente" name="regimen_docente" onkeyup="contarCarApoyoEducativo(this)"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>
                        <div class="col-1">
                            <span class="text-muted" id="regimen_docente"></span>
                        </div>
                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-center">
                {{-- Boton para agregar informacion del estudiante --}}
                <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
            </div>

        </form>
    </div>
</div>
@endsection

@section('pie')
Copyright
@endsection
