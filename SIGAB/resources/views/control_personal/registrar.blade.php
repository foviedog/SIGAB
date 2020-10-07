@extends('layouts.app')

@section('titulo')
Registrar información del estudiante
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection


@section('contenido')


<!-- Modal de idiomas -->
<div class="modal fade" id="idomasModal" tabindex="-1" aria-labelledby="idomasModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title font-weight-light d-flex  justify-content-center" id="idomasModalLabel">Agregar idiomas de un personal</h5>

            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="alert alert-danger text-center font-weight-bold" role="alert" id="alert-idiomas">
                        Complete todos los campos.
                    </div>
                    <div class="form-group">
                        <form name="agregar-nombre" id="agregar-nombre">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="lista-idiomas">
                                    <tr>
                                        <td><input type="text" name="name[]" placeholder="Nombre del idioma" class="form-control idioma" /></td>
                                        <td><button type="button" name="agregar-btn" id="agregar-btn" class="btn btn-contorno-rojo"> <i class="fas fa-plus-circle"></i> Agregar otro idioma</button></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex  justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-idiomas"> Borrar todo y cancelar </button>
                <button type="button" class="btn btn-rojo" id="aceptar-idiomas"> Aceptar </button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2>Registrar información de un personal</h2>
        <hr>



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
                </div>


                <div class="col-6 ">
                    <b>Tipo de cargo:</b> {{ $personal_registrado->cargo?? "No se digitó" }} <br>
                    <b>Tipo de nombramiento:</b> {{ $personal_registrado->tipo_nombramiento ?? "No se digitó" }} <br>
                    <b>Tipo de puesto:</b> {{ $personal_registrado->tipo_puesto ?? "No se digitó" }} <br>
                    <b>Jornada laboral:</b> {{ $personal_registrado->jornada ?? "No se digitó" }} <br>
                    <b>Lugar de trabajo externo:</b> {{ $personal_registrado->lugar_trabajo_externo ?? "No se digitó" }} <br>
                    <b>Experiencia profesional:</b> {{ $personal_registrado->experiencia_profesional ?? "No se digitó" }} <br>
                    <b>Experiencia academica:</b> {{ $personal_registrado->experiencia_academica ?? "No se digitó" }} <br>
                    <b>Regimen administrativo:</b> {{ $personal_registrado->regimen_administrativo ?? "No se digitó" }} <br>
                    <b>Regimen docente:</b> {{ $personal_registrado->regimen_docente ?? "No se digitó" }} <br>
                    <b>Area de especialización 1:</b> {{ $personal_registrado->area_especializacion_1 ?? "No se digitó" }} <br>
                    <b>Area de especialización 2:</b> {{ $personal_registrado->area_especializacion_2 ?? "No se digitó" }} <br>
                </div>

            </div>
            <div class="row d-flex justify-content-start py-3">
                {{-- Link directo al estudiante recien agregado --}}
                <a clas="btn btn-lg btn-rojo my-3" href="/personal/detalle/{{ $persona_insertado->persona_id }}">
                    <input type="button" value="Editar" class="btn btn-rojo">
                </a>
            </div>
        </div>

        <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div>
        @endif
        {{-- Formulario para registrar informacion del personal --}}
        <form action="/personal" method="POST" enctype="multipart/form-data" id="personal">
            @csrf
            <input type="hidden" name="idiomasForm" id="idiomasForm">
            <div class="row">

                {{-- Campos de la izquierda --}}
                <div class="col">
                    {{-- Campo: Cedula --}}
                    <div class="d-flex justify-content-start mb-4">
                        <div class="col-4">
                            <label for="cedula">Cédula: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeyup="contarCaracteres(this,15)" required>
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
                            <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCaracteres(this,50)" required>
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
                            <input type='text' class="form-control w-100" id="apellido" name="apellido" onkeyup="contarCaracteres(this,50)" required>
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
                            <input type='date' value="2020-08-15" class="form-control w-100" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                    </div>

                    {{-- Campo: Telefono fijo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="telefono_fijo">Teléfono fijo:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="telefono_fijo" name="telefono_fijo" onkeyup="contarCaracteres(this,30)">
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
                            <input type='text' class="form-control w-100" id="telefono_celular" name="telefono_celular" onkeyup="contarCaracteres(this,30)">
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
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_personal" name="correo_personal" onkeyup="contarCaracteres(this,45)" multiple>
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
                            <input type='email' minlength="3" maxlength="45" class="form-control w-100" id="correo_institucional" name="correo_institucional" onkeyup="contarCaracteres(this,45)" multiple required>
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
                            <select class="form-control w-100" id="estado_civil" name="estado_civil" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Soltero(a)"> Soltero(a)</option>
                                <option value="Casado(a)"> Casado(a) </option>
                                <option value="Viudo(a)"> Viudo(a) </option>
                                <option value="Divorciado(a)"> Divorciado(a) </option>
                                <option value="Unión libre"> Unión libre </option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Direccion de residencia --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="direccion_residencia">Dirección de residencia: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="direccion_residencia" rows="4" name="direccion_residencia" onkeyup="contarCaracteres(this,250)" required></textarea>
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
                            <select class="form-control w-100" id="genero" name="genero" form="personal" required>
                                <option value="" selected>Seleccione</option>
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
                            <select class="form-control w-100" id="grado_academico" name="grado_academico" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Bachillerato(a)">Bachillerato(a)</option>
                                <option value="Licenciado(a)">Licenciado(a)</option>
                                <option value="Master(a)">Master(a)</option>
                                <option value="Doctorado(a)">Doctorado(a)</option>
                                <option value="Posdoctorado(a)">Posdoctorado(a)</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: tipo de nombramiento --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_nombramiento">Tipo de nombramiento: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_nombramiento" name="tipo_nombramiento" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Interino">Interino</option>
                                <option value="Propietario">Propietario</option>
                                <option value="Plazo fijo">Plazo fijo</option>
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
                            <select class="form-control w-100" id="cargo" name="cargo" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Académico">Académico</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: tipo de puesto --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_puesto">Tipo de puesto: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_puesto" name="tipo_puesto" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Secretaría">Secretaría</option>
                                <option value="Dirección">Dirección</option>
                                <option value="Subdirección">Subdirección</option>
                                <option value="Docente">Docente</option>
                                <option value="Profesional Ejecutivo">Profesional Ejecutivo</option>
                                <option value="Participante de PPAA">Participante de PPAA</option>
                                <option value="Responsable PPAA">Responsable PPAA</option>
                                <option value="Técnico Auxiliar">Técnico Auxiliar</option>
                                <option value="Biblioteca infantil">Biblioteca infantil</option>
                                <option value="Asistente administrativo(a)">Asistente administrativo(a)</option>
                                <option value="Profesional Asistencial en Desarrollo Tecnológico">Profesional Asistencial en Desarrollo Tecnológico</option>
                                <option value="Profesional Ejecutivo en Desarrollo Documental">Profesional Ejecutivo en Desarrollo Documental</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Regimen administrativo  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="regimen_administrativo">Regimen administrativo:</label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="regimen_administrativo" name="regimen_administrativo" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Categoría 21 (Técnico Auxiliar)">Categoría 21 (Técnico Auxiliar)</option>
                                <option value="Categoría 23 (Técnico General 1-2-3)">Categoría 23 (Técnico General 1-2-3)</option>
                                <option value="Categoría 24 (Técnico Analista 1-2-3)">Categoría 24 (Técnico Analista 1-2-3)</option>
                                <option value="Categoría 32 (Profesional Asistencial 1-2-3-4-5)">Categoría 32 (Profesional Asistencial 1-2-3-4-5)</option>
                                <option value="Categoría 34 (Profesional Ejecutivo 1-2-3-4)">Categoría 34 (Profesional Ejecutivo 1-2-3-4)</option>
                                <option value="Categoría 35 (Profesional Analista 1-2-3)">Categoría 35 (Profesional Analista 1-2-3)</option>
                                <option value="Categoría 36 (Profesional Especialista)">Categoría 36 (Profesional Especialista)</option>
                                <option value="Categoría 37 (Profesional Asesor de Procesos 1-2)">Categoría 37 (Profesional Asesor de Procesos 1-2)</option>
                                <option value="Categoría 38 (Profesional Asesor General)">Categoría 38 (Profesional Asesor General)</option>
                                <option value="Categoría 42 (Director Ejecutivo)">Categoría 42 (Director Ejecutivo)</option>
                                <option value="Categoría 43 (Director Especialista)">Categoría 43 (Director Especialista)</option>
                                <option value="Categoría 44 (Director Asesor)">Categoría 44 (Director Asesor)</option>
                            </select>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>

                    </div>

                    {{-- Campo: Regimen docente  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="regimen_docente">Regimen docente:</label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="regimen_docente" name="regimen_docente" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Categoría 87 (Profesor Instructor Bachiller)">Categoría 87 (Profesor Instructor Bachiller)</option>
                                <option value="Categoría 88 (Profesor Instructor Licenciado)">Categoría 88 (Profesor Instructor Licenciado)</option>
                                <option value="Categoría 89 (Profesor I)">Categoría 89 (Profesor I)</option>
                                <option value="Categoría 90 (Profesor II)">Categoría 90 (Profesor II) </option>
                                <option value="Categoría 91 (Catedrático)">Categoría 91 (Catedrático)</option>
                            </select>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>

                    </div>

                    {{-- Campo: Jornada --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="jornada">Jornada laboral: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="jornada" name="jornada" form="personal" required>
                                <option value="" selected>Seleccione</option>
                                <option value="Por horas">Por horas</option>
                                <option value="Ciclo lectivo">Ciclo lectivo</option>
                                <option value="Año">Año</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Lugar de trabajo externo --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="trabajo_externo">Lugar de trabajo externo: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="trabajo_externo" name="trabajo_externo" onkeyup="contarCaracteres(this,60)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_trabajo_externo"></span>
                        </div>
                    </div>
                    {{-- Campo: Año de propiedad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="anio_propiedad">Año de propiedad: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='number' class="form-control w-100" id="anio_propiedad" name="anio_propiedad" onkeyup="contarCaracteres(this,4)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_anio_propiedad"></span>
                        </div>
                    </div>
                    {{-- Campo: Area de especialización 1 --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="area_especializacion_1">Area de especialización 1 : <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="area_especializacion_1" name="area_especializacion_1" onkeyup="contarCaracteres(this,100)" required>
                        </div>
                        <div class="col-1">
                            <span class="text-muted" id="mostrar_area_especializacion_1"></span>
                        </div>
                    </div>

                    {{-- Campo: Area de especialización 2  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="area_especializacion_2">Area de esplización 2:</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="area_especializacion_2" name="area_especializacion_2" onkeyup="contarCaracteres(this,100)">
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
                            <textarea class="form-control w-100" id="experiencia_profesional" name="experiencia_profesional" rows="3"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>

                    </div>

                    {{-- Campo: Experiencia académica  --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="experiencia_academica">Experiencia académica:</label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="experiencia_academica" name="experiencia_academica" rows="3"></textarea>
                        </div>
                        <span data-toggle="tooltip" data-placement="bottom" title="Tipo de apoyo educativo establecido por el Departamento de Orientación y Psicología"><i class="far fa-question-circle fa-lg"></i></span>

                    </div>
                    {{-- Campo: carga_academica --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="carga_academica">Carga académica: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="carga_academica" name="carga_academica" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                        </div>
                        <span class="text-muted" id="mostrar_carga_academica"></span>

                    </div>


                </div>
            </div>
            <div class="row pb-4">
                <div class="col pt-5">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="residencias">Participaciones: <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="EscogePparticipaciones" id="noParticipacion" value="0" checked>
                                <label class="form-check-label pr-5" for="participaciones1"> No </label>

                                <input class="form-check-input" type="radio" name="EscogePparticipaciones" id="siParticipacion" value="1">
                                <label class="form-check-label" for="participaciones2"> Sí </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="d-flex justify-content-center  pt-5">
                        {{-- Boton para agregar informacion del estudiante --}}
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-rojo" data-toggle="modal" data-target="#idomasModal">
                            Agragar idiomas
                        </button>
                    </div>
                </div>
            </div>
            <div id="participaciones">
                <div class="row pt-4 border-top border-gray">
                    <div class="col">
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="capacitacion_didactica">Capacitación didactica: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="capacitacion_didactica" name="capacitacion_didactica" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_capacitacion_didactica"></span>

                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="publicaciones">Publicaciones: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="publicaciones" name="publicaciones" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_publicaciones"></span>

                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="cursos_impartidos">Cursos impartidos: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="cursos_impartidos" name="cursos_impartidos" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_cursos_impartidos"></span>
                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="evaluacion_interna_ppaa">Evaluación interna PPAA: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="evaluacion_interna_ppaa" name="evaluacion_interna_ppaa" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_evaluacion_interna_ppaa"></span>

                        </div>

                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="miembro_comisiones">Miembro comisiones: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="miembro_comisiones" name="miembro_comisiones" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_miembro_comisiones"></span>

                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="miembro_prueba_grado">Miembro prueba de grado: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="miembro_prueba_grado" name="miembro_prueba_grado" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_miembro_prueba_grado"></span>

                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="evaluador_defensa_publica">Evaluador defensa pública: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="evaluador_defensa_publica" name="evaluador_defensa_publica" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_evaluador_defensa_publica"></span>
                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <div class="col-4">
                                <label for="evaluacion_externa_ppaa">Evaluación externa PPAA: </label>
                            </div>
                            <div class="col-6">
                                <textarea class="form-control w-100" id="evaluacion_externa_ppaa" name="evaluacion_externa_ppaa" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                            </div>
                            <span class="text-muted" id="mostrar_evaluacion_externa_ppaa"></span>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-center">
                    <div class="col-6">
                        <label for="reconocimientos">Reconocimientos: </label>
                        <textarea class="form-control w-100" id="reconocimientos" name="reconocimientos" rows="3" form="personal" onkeyup="contarCaracteres(this,250)"></textarea>
                    </div>
                    <span class="text-muted" id="mostrar_reconocimientos"></span>
                </div>
            </div>

            <div class="d-flex justify-content-center  pt-5">
                {{-- Boton para agregar informacion del estudiante --}}
                <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
            </div>

        </form>
    </div>
</div>
@endsection
@section('scripts')
{{-- Link al script de registro de registro de estudiantes --}}
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_personal/mostrarParticipaciones.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
