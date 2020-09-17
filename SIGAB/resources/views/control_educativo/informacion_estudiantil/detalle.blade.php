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
$tiposBecas = ['Beca por condición socioeconómica','Beca Omar Dengo (Residencia estudiantil)','Becas de posgrado',
'Beca por participación en actividades artísticas y deportivas','Beca por participación en movimiento estudiantil',
'Honor','Estudiante Asistente Académico y Paracadémico','Intercambio estudiantil','Préstamos estudiantile','Giras'];
@endphp

<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class=" d-flex justify-content-between">
                <div>
                    <h3 class="texto-gris mb-4">{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}
                </div>
                <div>
                    {{-- <button class="btn btn-rojo" type="button" id="editar-estudiante" value="Editar" data-target="#trabajoModal" data-toggle="modal">Editar</button> --}}
                    <button type="button" class="btn btn-contorno-rojo" id="editar-estudiante"> Editar </button>
                    <button type="button" class="btn btn-rojo" id="cancelar-edi"> Cancelar </button>
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
                            <div class="mb-3"><button class="btn btn-contorno-rojo btn-sm" type="button" data-toggle="modal" data-target="#modalCambiarFoto">Cambiar Foto</button></div>

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
                                    <label for="nota"><strong>Nota de admisión</strong><br /></label><input class="form-control" type="number" placeholder="Nota Admision" name="nota_admision" value={{ $estudiante->nota_admision }} disabled />
                                </div>
                                {{-- Campo: Ingreso a la UNA --}}
                                <div class="form-group">
                                    <label for="anioUNA"><strong>Año de ingreso a la UNA</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la UNA" name="anio_ingreso_una" value={{ $estudiante->anio_ingreso_UNA }} disabled />
                                </div>
                                {{-- Campo: Ingreso a la EBDI --}}
                                <div class="form-group">
                                    <label for="anioEBDI"><strong>Año de ingreso a la EBDI</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la EBDI" name="anio_ingreso_ebdi" value={{ $estudiante->anio_ingreso_ebdi }} disabled />
                                </div>
                                {{-- Campo: Primera Carrera --}}
                                <div class="form-group">
                                    <label for="carrera1"><strong>Primera Carrera</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Carrera 1" name="carrera_matriculada_1" value="{{ $estudiante->carrera_matriculada_1 }}" disabled /> </input>
                                </div>
                                {{-- Campo: Segunda Carrera --}}
                                <div class="form-group">
                                    <label for="carrera2"><strong>Segunda Carrera</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Carrera 2" name="carrera_matriculada_2" value=" {{ $estudiante->carrera_matriculada_2 }}" disabled /> </input>
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
                                    <label for="anio_graduacion_estimado_1"><strong>Año Estimado Graduación 1</strong><br /></label><input class="form-control" type="date" placeholder="Estimado Graduación" name="anio_graduacion_estimado_1" value={{ $estudiante->anio_graduacion_estimado_1 }} disabled />
                                </div>
                                <div class="form-group">
                                    <label for="anio_graduacion_estimado_2"><strong>Año Estimado Graduación 2</strong><br /></label><input class="form-control" type="date" placeholder="Estimado Graduación" name="anio_graduacion_estimado_2" value={{ $estudiante->anio_graduacion_estimado_2 }} disabled />
                                </div>
                                {{-- Campo: Desercion --}}
                                <div class="form-group">
                                    <label for="anio_desercion"><strong>Año Deserción</strong><br /></label><input class="form-control" type="date" placeholder="Deserción" name="anio_desercion" value={{ $estudiante->anio_desercion }} disabled />
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
                                                    <label for="nombre"><strong>Nombre</strong></label><input class="form-control" type="text" id="nombre" name="nombre" value={{ $estudiante->persona->nombre }} disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Apellidos --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="apellido"><strong>Apellidos</strong></label>
                                                    <input type="text" class="form-control " name="apellido" disabled value="{{ $estudiante->persona->apellido }}" /> </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" form-row">
                                            {{-- Campos: Correo electronico --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label><input class="form-control" type="email" name="correo_personal" value={{ $estudiante->persona->correo_personal}} disabled />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_institucional"><strong>Correo Institucional</strong><br /></label><input class="form-control" type="email" name="correo_institucional" value={{ $estudiante->persona->correo_institucional}} disabled />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campos: Telefonos --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label><input class="form-control" type="text" name="telefono_celular" value={{ $estudiante->persona->telefono_celular }} disabled />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label><input class="form-control" type="text" placeholder="Telefono" name="telefono_celular" value={{ $estudiante->persona->telefono_fijo}} disabled />
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
                                            <label for="DireccionResidencia"><strong>Dirección Residencia</strong><br /></label><textarea class="form-control" type="text" placeholder="Direccion" name="direccion_residencia" disabled />{{ $estudiante->persona->direccion_residencia }} </textarea>
                                        </div>
                                        {{-- Campo: Direccion tiempo lectivo --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="DireccionLectivo"><strong>Dirección Tiempo Lectivo</strong><br /></label><textarea class="form-control" type="text" placeholder="Direccion" name="direccion_lectivo" disabled /> {{ $estudiante->direccion_lectivo }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Fecha Nacimiento --}}
                                        <div class="form-row">
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento</strong><br /></label><input class="form-control" type='date' placeholder="FechaNacimiento" name="fecha_nacimiento" value={{ $estudiante->persona->fecha_nacimiento }} disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Genero --}}
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="genero"><strong>Género </strong></label>
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
                                                    <label for="estadoCivil"><strong>Estado civil</strong></label>
                                                    <select disabled class="form-control w-100" id="estado_civil" name="estado_civil" required>
                                                        <option value="Soltero">Soltero</option>
                                                        <option value="Casado">Casado</option>
                                                        <option value="Viudo">Viudo</option>
                                                        <option value="Divorciado">Divorciado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Cantidad de hijos --}}
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="hijos"><strong>Hijos</strong><br /></label><input class="form-control" type="number" placeholder="Hijos" name="cant_hijos" value={{ $estudiante->cant_hijos }} disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            {{-- Campo: Apoyo Educativo --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="apoyo_educativo"><strong>Apoyo Educativo</strong><br /></label><textarea class="form-control" type="text" name="apoyo_educativo" disabled />{{ $estudiante->apoyo_educativo }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            {{-- Campo: Beca --}}
                                            <div class="col-7 mr-3">
                                                <div class="form-group">
                                                    <label for="beca"><strong>Beca</strong></label>
                                                    <select disabled class="form-control w-100" id="tipo_beca" name="tipo_beca" form="estudiante" required>
                                                        <option value="No tiene">No tiene</option>
                                                        <option value="Beca por condición socioeconómica">Beca por condición socioeconómica</option>
                                                        <option value="Beca Luis Felipe González Flores">Beca Luis Felipe González Flores</option>
                                                        <option value="Beca Omar Dengo (Residencia estudiantil)">Beca Omar Dengo (Residencia estudiantil)</option>
                                                        <option value="Becas de posgrado">Becas de posgrado</option>
                                                        <option value="Beca por participación en actividades artísticas y deportivas">Beca por participación en actividades artísticas y deportivas</option>
                                                        <option value="Beca por participación en movimiento estudiantil">Beca por participación en movimiento estudiantil</option>
                                                        <option value="Honor">Honor</option>
                                                        <option value="Estudiante Asistente Académico y Paracadémico ">Estudiante Asistente Académico y Paracadémico </option>
                                                        <option value="Intercambio estudiantil">Intercambio estudiantil</option>
                                                        <option value="Préstamos estudiantiles">Préstamos estudiantiles</option>
                                                        <option value="Giras">Giras</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Residencias UNA --}}
                                            <div class="col">
                                                <label for="residencia"><strong>Residencias UNA</strong><br /></label>
                                                <div class="d-flex justify-content-start pb-4">
                                                    <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="1" name="residencias_UNA" {{-- Segmento PHP que valida si se registro con residencia --}} <?php if( $estudiante->residencias_UNA == "1" ) { ?>checked="checked" <?php } ?><label class="form-check-label" for="formCheck-2">Si</label>
                                                    </div>
                                                    <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="0" name="residencias_UNA" {{-- Segmento PHP que valida si se registro con residencia --}} <?php if( $estudiante->residencias_UNA == "0" ) { ?>checked="checked" <?php } ?><label class="form-check-label" for="formCheck-3">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Discapacidad --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="condicion_discapacidad"><strong>Condición Discapacidad</strong><br /></label><textarea class="form-control" type="text" name="condicion_discapacidad" disabled /> {{ $estudiante->condicion_discapacidad }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Trabajo--}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group text-center mt-4">
                                                    <label for="city"><strong>Información Laboral</strong><br /></label>
                                                    <div class="w-100 d-flex justify-content-center">
                                                        <a href="/trabajo/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo" type="button" value="Ver trabajo">Ver trabajo</a>
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
                <button class="btn btn-rojo">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('pie')
Copyright
@endsection
