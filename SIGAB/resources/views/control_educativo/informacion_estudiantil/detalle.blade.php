@extends('layouts.app')

@section('titulo')
Detalle del estudiante {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- No hay --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
@endsection

@section('contenido')

@php
$estadosCiviles = ['Soltero','Casado','Viudo','Divorciado','Unión libre'];
$generos = ['Femenino','Masculino','Otro'];
$colegiosProcedencias = ['Científico','Técnico','Bilingüe','Privado','Liceo','Nocturno'];
$tiposBecas = ['No tiene','Beca por condición socioeconómica','Beca Omar Dengo (Residencia estudiantil)','Becas de posgrado',
'Beca por participación en actividades artísticas y deportivas','Beca por participación en movimiento estudiantil',
'Honor','Estudiante Asistente Académico y Paracadémico','Intercambio estudiantil','Préstamos estudiantiles','Giras'];
@endphp

<div class="card">
    <div class="card-body">
                {{-- Formulario general de estudiante --}}
                <form action="/estudiante/detalle/{estudiante}" method="POST" role="form" enctype="multipart/form-data" >
                    @csrf
        <div class="container-fluid">
            <div class=" d-flex justify-content-between">
                <div>
                    <h3 class="texto-gris mb-4">{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}
                </div>
                <div>
                    <a href="/listado-estudiantil" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a>
                    <button type="button" class="btn btn-rojo" id="editar-estudiante"><i class="fas fa-edit "></i> Editar </button>
                    <button type="button" class="btn btn-rojo" id="cancelar-edi"><i class="fas fa-close "></i> Cancelar </button>
                </div>
            </div>
            </h3>

            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body text-center shadow-sm rounded pb-5">
                            {{-- Foto del estudiante --}}
                            <img class="rounded-circle mb-3 mt-4" src="{{ asset('img/fotos/'.$estudiante->persona->imagen_perfil) }}" width="160" height="160" />
                            <div class="mb-3"><i class="fa fa-id-card mr-3 texto-rojo"></i><small class="texto-negro" style="font-size: 17px;"><strong>{{ $estudiante->persona_id }}</strong></small></div>
                            <div class="mb-3"><button id="cambiar-foto" class="btn btn-rojo btn-sm" type="button" data-toggle="modal" data-target="#modalCambiarFoto">Cambiar Foto</button></div>
                            {{-- Modal para modificar foto --}}
                            <div class="modal fade" id="modalCambiarFoto" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cambiar foto de perfil</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{--Form para cambiar la foto de perfil--}}
                                            <form enctype="multipart/form-data" action="/estudiante/imagen/cambiar" method="POST">
                                                <input type="file" name="avatar">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id_estudiante" value="{{ $estudiante->persona->persona_id }}"><br>
                                                <hr>
                                                <input type="submit" class="pull-right btn btn-rojo" value="Subir">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Tarjeta de información académica del estudiante --}}
                    <div class="card shadow-sm mb-4 rounded">
                        <div class="card-header py-3">
                            <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Información académica</h6>
                        </div>
                        <div class="card-body pb-5">
                            <form>
                                {{-- Campo: Nota admision --}}
                                <div class="form-group">
                                    <label for="nota"><strong>Nota de admisión *</strong><br /></label><input id="nota_admision" class="form-control" type="number" placeholder="Nota Admision" name="nota_admision" value="{{  $estudiante->nota_admision }}" disabled />
                                </div>
                                {{-- Campo: Ingreso a la UNA --}}
                                <div class="form-group">
                                    <label for="anioUNA"><strong>Año de ingreso a la UNA</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la UNA" name="anio_ingreso_una" value="{{ $estudiante->anio_ingreso_UNA }}" disabled />
                                </div>
                                {{-- Campo: Ingreso a la EBDI --}}
                                <div class="form-group">
                                    <label for="anioEBDI"><strong>Año de ingreso a la EBDI *</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la EBDI" name="anio_ingreso_ebdi" value="{{ $estudiante->anio_ingreso_ebdi }}" disabled />
                                </div>
                                {{-- Campo: Primera Carrera --}}
                                <div class="form-group">
                                    <label for="carrera1"><strong>Primera Carrera *</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Carrera 1" name="carrera_matriculada_1" value="{{ $estudiante->carrera_matriculada_1 }}" disabled /> </input>
                                </div>
                                {{-- Campo: Segunda Carrera --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Sólo en caso de que existe segunda carrera" for="carrera2"><strong>Segunda Carrera</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Carrera 2" name="carrera_matriculada_2" value=" {{ $estudiante->carrera_matriculada_2 ?? "No se registra ninguna" }}" disabled /> </input>
                                </div>
                                {{-- Campo: Colegio Procedencia --}}
                                <div class="form-group">
                                    <label for="colegio"><strong>Tipo de colegio de procedencia</strong><br /></label>
                                    <select class="form-control" id="tipo_colegio_procedencia" name="tipo_colegio_procedencia" form="estudiante" disabled>
                                        @foreach($colegiosProcedencias as $colegioProcedencia)
                                        <option value="{{ $colegioProcedencia }}" @if ($colegioProcedencia==$estudiante->tipo_colegio_procedencia) selected @endif> {{ $colegioProcedencia }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Campo: Estimado Graduacion --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Año estimado de graduación de la primera carrera" for="anio_graduacion_estimado_1"><strong>Año Estimado Graduación 1 *</strong><br /></label><input class="form-control" type="number" placeholder="Estimado Graduación" name="anio_graduacion_estimado_1" value="{{ $estudiante->anio_graduacion_estimado_1 ?? 0 }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Año estimado de graduación de la segunda carrera (Si el estudiante tiene)" for="anio_graduacion_estimado_2"><strong>Año Estimado Graduación 2</strong><br /></label><input class="form-control" type="number" placeholder="Estimado Graduación" name="anio_graduacion_estimado_2" value="{{ $estudiante->anio_graduacion_estimado_2 ?? 0 }}" disabled />
                                </div>
                                {{-- Campo: Desercion --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Se ingresa año de deserción si existe" for="anio_desercion"><strong>Año Deserción</strong><br /></label><input class="form-control" type="number" placeholder="Deserción" name="anio_desercion" value="{{ $estudiante->anio_desercion ?? 0 }}"  disabled />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">

                    <div class="row">
                        <div class="col">
                            {{-- Tarjeta de Informacion de contacto del estudiante --}}
                            <div class="card shadow-sm mb-3 rounded pb-2">
                                <div class="card-header py-3">
                                    <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Contacto</p>
                                </div>
                                <div class="card-body">
                                    <form>

                                        <div class="form-row">
                                            {{-- Campo: Nombre estudiante --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nombre"><strong>Nombre *</strong></label><input id="nombre" class="form-control" type="text" id="nombre" placeholder="Nombre Estudiante" name="nombre" value="{{ $estudiante->persona->nombre }}" disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Apellidos --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="apellido"><strong>Apellidos *</strong></label>
                                                    <input type="text" class="form-control " name="apellido" placeholder="Apellido" value="{{ $estudiante->persona->apellido }}" disabled/> </input>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" form-row">
                                            {{-- Campos: Correo electronico --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label><input class="form-control" placeholder="Correo personal" type="email" name="correo_personal" value="{{ $estudiante->persona->correo_personal}}" disabled />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_institucional"><strong>Correo Institucional *</strong><br /></label><input class="form-control" type="email" name="correo_institucional" placeholder="Correo Institucional" value="{{ $estudiante->persona->correo_institucional}}" disabled />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Campos: Telefonos --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label><input class="form-control" type="text" name="telefono_celular" placeholder="Telefono Celular" value="{{ $estudiante->persona->telefono_celular ?? "No se registra ninguno" }}" required disabled />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label><input class="form-control" type="text" placeholder="Telefono" name="telefono_fijo" placeholder="Telefono Fijo" value="{{ $estudiante->persona->telefono_fijo ?? "No se registra ninguno" }}" required disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- Tarjeta de informacion adicional del estudiante --}}
                            <div class="card shadow-sm pb-5">
                                <div class="card-header py-3">
                                    <p class="texto-rojo-medio m-0 font-weight-bold ">Información Adicional</p>
                                </div>
                                <div class="card-body pb-5">
                                    <form>
                                        {{-- Campo: Direccion Residencia --}}
                                        <div class="form-group">
                                            <label data-toggle="tooltip" data-placement="left" title="Lugar de residencia del estudiante fuera del tiempo lectivo" for="DireccionResidencia"><strong>Dirección Residencia *</strong><br /></label>
                                            <textarea  class="form-control" type="text" placeholder="Direccion" name="direccion_residencia" disabled />{{ $estudiante->persona->direccion_residencia }} </textarea>
                                        </div>

                                        {{-- Campo: Direccion tiempo lectivo --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Lugar de residencia del estudiante durante el tiempo lectivo"  for="DireccionLectivo"><strong>Dirección Tiempo Lectivo *</strong><br /></label>
                                                    <textarea class="form-control" type="text" placeholder="Direccion" name="direccion_lectivo" disabled /> {{ $estudiante->direccion_lectivo }} </textarea>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Campo: Fecha Nacimiento --}}
                                        <div class="form-row">
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento *</strong><br /></label><input class="form-control" type='date' placeholder="FechaNacimiento" name="fecha_nacimiento" value={{ $estudiante->persona->fecha_nacimiento }} disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Genero --}}
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="genero"><strong>Género *</strong></label>
                                                    <select disabled class="form-control w-100" id="genero" name="genero" required>
                                                        <option value="M" <?php if( $estudiante->persona->genero == "M" ) { ?> option selected<?php } ?>>Masculino</option>
                                                        <option value="F" <?php if( $estudiante->persona->genero == "F" ) { ?> option selected<?php } ?>>Femenino</option>
                                                        <option value="Otro" <?php if( $estudiante->persona->genero == "Otro" ) { ?> option selected<?php } ?>>Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Estado Civil --}}
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="estadoCivil"><strong>Estado Civil *</strong></label>
                                                    <select class="form-control" id="estado_civil" name="estado_civil" form="estudiante" disabled>
                                                        @foreach($estadosCiviles as $estadoCivil)
                                                        <option value="{{ $estadoCivil }}" @if ($estadoCivil==$estudiante->persona->estado_civil) selected @endif> {{ $estadoCivil }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Cantidad de hijos --}}
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Ingresar 0 en caso de no tener hijos" for="hijos"><strong>Hijos *</strong><br /></label><input class="form-control" type="number" placeholder="Hijos" name="cant_hijos" value="{{ $estudiante->cant_hijos }}" disabled />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            {{-- Campo: Apoyo Educativo --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Detalle del apoyo educativo recibido por el estudiante o indicar si no ha recibido" for="apoyo_educativo"><strong>Apoyo Educativo</strong><br /></label>
                                                    <textarea class="form-control" type="text" name="apoyo_educativo" disabled />{{ $estudiante->apoyo_educativo ?? "No se registra ningún dato de apoyo educativo"}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            {{-- Campo: Beca --}}
                                            <div class="col-7 mr-3">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Se enlistan tipos de becas y otro tipo de ayudas como: Giras o Préstamos Estudiantiles" for="beca"><strong>Beca *</strong></label>
                                                    <select class="form-control" id="tipo_beca" name="tipo_beca" form="estudiante" disabled>
                                                        @foreach($tiposBecas as $tipoBeca)
                                                        <option value="{{ $tipoBeca }}" @if ($tipoBeca==$estudiante->tipo_beca) selected @endif> {{ $tipoBeca }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Residencias UNA --}}
                                            <div class="col">
                                                <label for="residencia"><strong>Residencias UNA *</strong><br /></label>
                                                <div class="d-flex justify-content-start pb-4">
                                                    {{-- Segmento PHP que valida si se registro con residencia --}}
                                                    <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="1" name="residencias_UNA"
                                                        <?php if( $estudiante->residencias_UNA == "1" ) { ?>checked="checked" <?php } ?><label class="form-check-label" for="formCheck-2">Si</label>
                                                    </div>
                                                    {{-- Segmento PHP que valida si se registro con residencia --}}
                                                    <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="0" name="residencias_UNA"
                                                        <?php if( $estudiante->residencias_UNA == "0" ) { ?>checked="checked" <?php } ?><label class="form-check-label" for="formCheck-3">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Campo: Discapacidad --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Ingresar si el estudiante posee alguna discapacidad o no" for="condicion_discapacidad"><strong>Condición Discapacidad</strong><br /></label>
                                                    <textarea class="form-control" type="text" name="condicion_discapacidad" disabled /> {{ $estudiante->condicion_discapacidad ?? "No se registra ninguna discapacidad" }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Campo: Trabajo--}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group text-center mt-4">
                                                    <label for="city"><strong>Información Laboral</strong><br /></label>
                                                    <div class="w-100 d-flex justify-content-center">
                                                        <a href="/estudiante/trabajo/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo" type="button" value="Ver trabajo">Ver trabajo</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}"><br>
                <button id="guardar-cambios" type="submit" class="btn btn-rojo">Guardar cambios</button>
            </div>

        </div>
    </form>
    </div>
</div>

@endsection

@section('pie')
Copyright
@endsection
