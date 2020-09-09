@extends('layouts.app')

@section('titulo')
Registrar información laboral de
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_estudiante/registrar.js') }}" defer></script>
@endsection

@section('contenido')
<h2>Registrar información del estudiante </h2>
<hr>

{{-- Formulario para registrar informacion laboral --}}
<form action="/estudiante" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {!! \Session::get('mensaje') !!}
        </div>
    @endif

    <div class="row">

        {{-- Campos de la izquierda --}}
        <div class="col">

            {{-- Campo: Nombre de la organizacion --}}
            <div class="form-inline mb-4">
                <div class="col-4">
                    <label for="cedula">Cedula:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="cedula"
                    name="cedula"
                    onkeyup="contarCarCed(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_ced"></span>
                </div>
            </div>

            {{-- Campo: Jornada laboral --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="nombre">Nombre:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="nombre"
                    name="nombre"
                    onkeyup="contarCarNombre(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_nombre"></span>
                </div>
            </div>

            {{-- Campo: Jefe inmediato --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="apellido">Apellido</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="apellido"
                    name="apellido"
                    onkeyup="contarCarApellido(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_apellido"></span>
                </div>
            </div>

                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                </div>
                <div class="col-6">
                    <input type='date'
                    value="2020-08-15"
                    class="form-control w-100"
                    id="fecha_nacimiento"
                    name="fecha_nacimiento"
                    onkeyup="contarCarFechaNacimiento(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_fecha_nacimiento"></span>
                </div>
            </div>

            {{-- Campo: Intereses Capacitacion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="telefono_fijo">Telefono fijo:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="telefono_fijo"
                    name="telefono_fijo"
                    onkeyup="contarCarTelefonoFijo(this)">
                </div>
                                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_telefono_fijo"></span>
                </div>
            </div>


                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="telefono_celular">Telefono celular:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="telefono_celular"
                    name="telefono_celular"
                    onkeyup="contarCarTelefonoCelular(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_telefono_celular"></span>
                </div>
            </div>

                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="correo_personal">Correo personal:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="correo_personal"
                    name="correo_personal"
                    onkeyup="contarCarCorreoPersonal(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_correo_personal"></span>
                </div>
            </div>

                                {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="correo_institucional">Correo institucional:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="correo_institucional"
                    name="correo_institucional"
                    onkeyup="contarCarCorreoInstitucional(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_correo_institucional"></span>
                </div>
            </div>

                                            {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="estado_civil">Estado civil:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="estado_civil"
                    name="estado_civil"
                    onkeyup="contarCarEstadoCivil(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_estado_civil"></span>
                </div>
            </div>

                                            {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="direccion_residencia">Direccion de residencia:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="direccion_residencia"
                    name="direccion_residencia"
                    onkeyup="contarCarDireccionResidencia(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_direccion_residencia"></span>
                </div>
            </div>

                                            {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="genero">Genero:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="genero"
                    name="genero"
                    onkeyup="contarCarGenero(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_genero"></span>
                </div>
            </div>


           {{-- Campo: Jornada laboral --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="direccion_lectivo">direccion lectivo:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="direccion_lectivo"
                    name="direccion_lectivo"
                    onkeyup="contarCarDireccionLectivo(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_direccion_lectivo"></span>
                </div>
            </div>

            {{-- Campo: Jefe inmediato --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="cantidad_hijos">cantidad hijos:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="cantidad_hijos"
                    name="cantidad_hijos"
                    onkeyup="contarCarCantidadHijos(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_cantidad_hijos"></span>
                </div>
            </div>

        </div>



        {{-- Campos de la derecha --}}
        <div class="col">


                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tipo_colegio_procedencia">Tipo colegio procedencia:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="tipo_colegio_procedencia"
                    name="tipo_colegio_procedencia"
                    onkeyup="contarCarTipoColegioProcedencia(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tipo_colegio_procedencia"></span>
                </div>
            </div>

            {{-- Campo: Intereses Capacitacion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="condicion_discapacidad">condicion diacapacidad:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="condicion_discapacidad"
                    name="condicion_discapacidad"
                    onkeyup="contarCarTipoColegioProcedencia(this)">
                </div>
                                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tipo_colegio_procedencia"></span>
                </div>
            </div>

              {{-- Campo: Tipo de organizacion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_ingreso_ebdi">annio ingreso EBDI:</label>
                </div>
                <div class="col-6">
                    <input type='date'
                    value="2020-08-15"
                    class="form-control w-100"
                    id="anio_ingreso_ebdi"
                    name="anio_ingreso_ebdi"
                    onkeyup="contarCarAnioIngresoEbdi(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_ingreso_ebdi"></span>
                </div>
            </div>

            {{-- Campo: Cargo actual --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_ingreso_una">annio ingreso UNA:</label>
                </div>
                <div class="col-6">
                    <input type='date'
                    value="2020-08-15"
                    class="form-control w-100"
                    id="anio_ingreso_una"
                    name="anio_ingreso_una"
                    onkeyup="contarCarAnioIngresoUna(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_ingreso_una"></span>
                </div>
            </div>

                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_desercion">anio desercion:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="anio_desercion"
                    name="anio_desercion"
                    onkeyup="contarCarAnioDesercion(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_desercion"></span>
                </div>
            </div>

                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tipo_beca">tipo beca:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="tipo_beca"
                    name="tipo_beca"
                    onkeyup="contarCarTipoBeca(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_tipo_beca"></span>
                </div>
            </div>

                                {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="nota_admision">nota admision:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="nota_admision"
                    name="nota_admision"
                    onkeyup="contarCarNotaAdmision(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_admision"></span>
                </div>
            </div>

            {{-- Campo: Telefono trabajo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="carrera_matriculada_1">carrera matriculada 1:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="carrera_matriculada_1"
                    name="carrera_matriculada_1"
                    onkeyup="contarCarCarreraMatriculada1(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_carrera_matriculada1"></span>
                </div>
            </div>

            {{-- Campo: Correo trabajo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="carrera_matriculada_2">carrera matriculada 2:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="carrera_matriculada_2"
                    name="carrera_matriculada_2"
                    onkeyup="contarCarMateriaMatriculada2(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_materia_matriculada_2"></span>
                </div>
            </div>

            {{-- Campo: Otros estudios --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_gradacion_estimado_1">anio de graduacion estimado 1:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="anio_gradacion_estimado_1"
                    name="anio_gradacion_estimado_1">
                </div>
            </div>

                        {{-- Campo: Otros estudios --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_graduacion_estimado_2">anio de graduacion estimado 2:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="anio_graduacion_estimado_2"
                    name="anio_graduacion_estimado_2">
                </div>
            </div>


                    {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="apoyo_educativo">apoyo educativo:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="apoyo_educativo"
                    name="apoyo_educativo"
                    onkeyup="contarCarApoyoEducativo(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_apoyo_educativo"></span>
                </div>
            </div>

                                {{-- Campo: Tiempo desempleado --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="residencias">residencias:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="residencias"
                    name="residencias"
                    onkeyup="contarCarResidencias(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_residencias"></span>
                </div>
            </div>


        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{-- Boton para agregar informacion laboral --}}
        <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
    </div>

</form>
@endsection

@section('pie')
Copyright
@endsection
