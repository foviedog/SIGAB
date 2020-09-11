@extends('layouts.app')

@section('titulo')
Detalle del estudiante {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- No hay --}}
@endsection

@section('scripts')
{{-- <script src="{{ asset('js/control_educativo/estudiante/detalle.js') }}" defer></script> --}}
@endsection

@section('contenido')
<div class="container-fluid">
    <h3 class="text-dark mb-4">{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }} <div class="w-100 d-flex justify-content-end"><button class="btn btn-rojo" type="button" value="Editar" data-target="#trabajoModal" data-toggle="modal" disabled>Editar</button></div></h3>

    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    {{--  <img class="rounded-circle mb-3 mt-4" src="" width="160" height="160" />  --}}
                    <div class="mb-3"><i class="fa fa-id-card mr-3 texto-rojo"></i><small class="texto-negro" style="font-size: 17px;"><strong>{{ $estudiante->persona_id }}</strong></small></div>
                    <div class="mb-3"><button class="btn btn-contorno-rojo btn-sm" type="button">Cambiar Foto</button></div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Información académica</h6>
                </div>
                <div class="card-body pb-5">
                    <form>
                        <div class="form-group"><label for="nota"><strong>Nota de admisión</strong><br /></label><input class="form-control" type="text" placeholder="Nota Admision" name="nota_admision" value={{ $estudiante->nota_admision }} disabled/></div>
                        <div class="form-group"><label for="anioUNA"><strong>Año de ingreso a la UNA</strong><br /></label><input class="form-control " type="text" placeholder="Ingreso a la UNA" name="anio_ingreso_una" value={{ $estudiante->anio_ingreso_UNA }} disabled/></div>
                        <div class="form-group"><label for="anioEBDI"><strong>Año de ingreso a la EBDI</strong><br /></label><input class="form-control " type="text" placeholder="Ingreso a la EBDI" name="anio_ingreso_ebdi" value={{ $estudiante->anio_ingreso_ebdi }} disabled/></div>
                        <div class="form-group"><label for="carrera1"><strong>Primera Carrera</strong><br /></label><input class="form-control" type="text" placeholder="Carrera 1" name="carrera_matriculada_1" value={{ $estudiante->carrera_matriculada_1 }} disabled/></div>
                        <div class="form-group"><label for="carrera2"><strong>Segunda Carrera</strong><br /></label><input class="form-control" type="text" placeholder="Carrera 2" name="carrera_matriculada_2" value={{ $estudiante->carrera_matriculada_2 }} disabled/></div>
                        <div class="form-group"><label for="colegio"><strong>Tipo de colegio de procedencia</strong><br /></label><input class="form-control" type="text" placeholder="Colegio Procedencia" name="tipo_colegio_procedencia" value={{ $estudiante->tipo_colegio_procedencia }} disabled/></div>
                        <div class="form-group"><label for="anio_graduacion_estimado_1"><strong>Año Estimado Graduación 1</strong><br /></label><input class="form-control" type="text" placeholder="Estimado Graduación" name="anio_graduacion_estimado_1" value={{ $estudiante->anio_graduacion_estimado_1 }} disabled/></div>
                        <div class="form-group"><label for="anio_graduacion_estimado_2"><strong>Año Estimado Graduación 2</strong><br /></label><input class="form-control" type="text" placeholder="Estimado Graduación" name="anio_graduacion_estimado_2" value={{ $estudiante->anio_graduacion_estimado_2 }} disabled/></div>
                        <div class="form-group"><label for="anio_desercion"><strong>Año Deserción</strong><br /></label><input class="form-control" type="text" placeholder="Deserción" name="anio_desercion" value={{ $estudiante->anio_desercion }} disabled/></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row mb-3 d-none">
                <div class="col">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Contacto</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="nombre"><strong>Nombre</strong></label><input class="form-control" type="text" name="nombre" value={{ $estudiante->persona->nombre }} disabled/></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="apellido"><strong>Apellidos</strong></label><input class="form-control" type="text" name="apellido" placeholder="Apellidos" value={{ $estudiante->persona->apellido }}  disabled/></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="correo_personal"><strong>Correo Personal</strong><br /></label><input class="form-control" type="email" name="correo_personal" value={{ $estudiante->persona->correo_personal}} disabled/></div>

                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="correo_institucional"><strong>Correo Institucional</strong><br /></label><input class="form-control" type="email" name="correo_institucional" value={{ $estudiante->persona->correo_institucional}} disabled/></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label><input class="form-control" type="text" name="telefono_celular" value={{ $estudiante->persona->telefono_celular }} disabled/></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="telefono_fijo"><strong>Telefono Fijo</strong><br /></label><input class="form-control" type="text" placeholder="Telefono" name="telefono_celular"  value={{ $estudiante->persona->telefono_fijo}} disabled/></div>
                                    </div>
                                </div>
                                {{--  <div class="form-group d-flex justify-content-center py-2"><button class="btn btn-primary btn-sm rojo" type="submit">Save Settings</button></div>  --}}
                            </form>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="texto-rojo-medio m-0 font-weight-bold ">Información adicional</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group"><label for="DireccionResidencia"><strong>Dirección Residencia</strong><br /></label><input class="form-control" type="text" placeholder="Direccion" name="direccion_residencia" value={{ $estudiante->persona->direccion_residencia }} disabled/></div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="DireccionLectivo"><strong>Dirección Tiempo Lectivo</strong><br /></label><input class="form-control" type="text" placeholder="Direccion" value={{ $estudiante->direccion_lectivo }} name="direccion_lectivo" disabled/></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="fecha_nacimiento"><strong>Fecha de Nacimiento</strong><br /></label><input class="form-control" type="text" placeholder="FechaNacimiento" name="fecha_nacimiento" value={{ $estudiante->persona->fecha_nacimiento }} disabled/></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="genero"><strong>Genero</strong><br /></label><input disabled class="form-control" type="text" placeholder="Genero" name="genero"
                                            <?php if( $estudiante->persona->genero == "masc" ) { ?>value="Masculino":value="Femenino"<?php } ?>  /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="hijos"><strong>Hijos</strong><br /></label><input class="form-control" type="text" placeholder="Hijos" name="cant_hijos" value={{ $estudiante->cant_hijos }} disabled/></div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col"><label for="apoyo"><strong>Apoyo Educativo</strong><br /></label>
                                        <div class="d-flex justify-content-start pb-4">
                                            <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="si" name="apoyo_educativo"
                                                <?php if( $estudiante->apoyo_educativo == "sí" ) { ?>checked="checked"<?php } ?><label class="form-check-label" for="formCheck-2">Si</label></div>
                                            <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="no" name="apoyo_educativo"
                                                <?php if( $estudiante->apoyo_educativo == "no" ) { ?>checked="checked"<?php } ?><label class="form-check-label" for="formCheck-3">No</label></div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="beca"><strong>Beca</strong><br /></label><input class="form-control" type="text" placeholder="Beca" name="tipo_beca" value={{ $estudiante->tipo_beca }} disabled/></div>
                                    </div>
                                    <div class="col"><label for="residencia"><strong>Residencias UNA</strong><br /></label>
                                        <div class="d-flex justify-content-start pb-4">
                                            <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="1" name="residencias_UNA"
                                                <?php if( $estudiante->residencias_UNA == "1" ) { ?>checked="checked"<?php } ?><label class="form-check-label" for="formCheck-2">Si</label></div>
                                            <div class="form-check px-2 mx-3"><input disabled class="form-check-input" type="radio" value="0" name="residencias_UNA"
                                                <?php if( $estudiante->residencias_UNA == "0" ) { ?>checked="checked"<?php } ?><label class="form-check-label" for="formCheck-3">No</label></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="discapacidad"><strong>Condicion Discapacidad</strong><br/></label><input class="form-control" type="text" placeholder="Condicion Discapacidad" name="condicion_discapacidad"  value={{ $estudiante->condicion_discapacidad}} disabled  /></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Información Laboral</strong><br /></label>
                                            <div class="w-100 d-flex justify-content-center"><button class="btn btn-rojo" type="button" value="Ver trabajo" data-target="#trabajoModal" data-toggle="modal">Ver trabajo</button></div>
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

</div>

@endsection

@section('pie')
Copyright
@endsection
