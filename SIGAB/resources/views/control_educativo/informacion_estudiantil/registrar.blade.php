@extends('layouts.app')

@section('titulo')
Registrar información laboral de
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

{{-- Link al script de registro de registro de estudiantes --}}
@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_estudiante/registrar.js') }}" defer></script>
@endsection

@section('contenido')
<h2>Registrar información del estudiante </h2>
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
                        <b>Nombre:</b> {{ $persona_insertado->nombre }} <br>
                        <b>Apellido:</b> {{ $persona_insertado->apellido }} <br>
                        <b>Fecha de nacimiento:</b> {{ $persona_insertado->fecha_nacimiento ?? "No se digitó" }} <br>
                        <b>Telefono fijo:</b> {{ $persona_insertado->telefono_fijo ?? "No se digitó" }} <br>
                        <b>Telefono Celular:</b> {{ $persona_insertado->telefono_celular ?? "No se digitó" }} <br>
                        <b>Correo personal:</b> {{ $persona_insertado->correo_personal ?? "No se digitó" }} <br>
                        <b>Correo institucional:</b> {{ $persona_insertado->correo_institucional ?? "No se digitó" }} <br>
                        <b>Estado Civil:</b> {{ $persona_insertado->estado_civil ?? "No se digitó" }} <br>
                        <b>Direccion de residencia:</b> {{ $persona_insertado->direccion_residencia ?? "No se digitó" }} <br>
                        <b>Genero:</b> {{ $persona_insertado->genero ?? "No se digitó" }} <br>
                        <b>Direccion lectivo:</b> {{ $estudiante_insertado->direccion_lectivo }} <br>
                        <b>Cantidad de hijos:</b> {{ $estudiante_insertado->cant_hijos ?? "No se digitó" }} <br>
                    </div>
                    <div class="col-6 text-justify">

                        <b>Tipo de colegio de procedencia:</b> {{ $estudiante_insertado->tipo_colegio_procedencia ?? "No se digitó" }} <br>
                        <b>Condicion de discapacidad:</b> {{ $estudiante_insertado->condicion_discapacidad ?? "No se digitó" }} <br>
                        <b>Año de ingreso a la EBDI:</b> {{ $estudiante_insertado->anio_ingreso_ebdi ?? "No se digitó" }} <br>
                        <b>Año de ingreso a la UNA:</b> {{ $estudiante_insertado->anio_ingreso_UNA ?? "No se digitó" }} <br>
                        <b>Carrera matriculada 1:</b> {{ $estudiante_insertado->carrera_matriculada_1 ?? "No se digitó" }} <br>
                        <b>Carrera matriculada 2:</b> {{ $estudiante_insertado->carrera_matriculada_2 ?? "No se digitó" }} <br>
                        <b>Año de graduacion estimado 1:</b> {{ $estudiante_insertado->anio_graduacion_estimado_1 ?? "No se digitó" }} <br>
                        <b>Año de graduacion estimado 2:</b> {{ $estudiante_insertado->anio_graduacion_estimado_2 ?? "No se digitó" }} <br>
                        <b>Año de desercion:</b> {{ $estudiante_insertado->anio_desercion ?? "No se digitó" }} <br>
                        <b>Tipo de beca:</b> {{ $estudiante_insertado->tipo_beca ?? "No se digitó" }} <br>
                        <b>Nota de admisión:</b> {{ $estudiante_insertado->nota_admision ?? "No se digitó" }} <br>
                        <b>Apoyo educativo:</b> {{ $estudiante_insertado->apoyo_educativo ?? "No se digitó" }} <br>
                        <b>Residencias:</b> {{ $estudiante_insertado->residencias_UNA ?? "No se digitó" }} <br>
                    </div>
                </div>
        </div>

        <div class="h3 mb-5 mt-4 mx-3">Agregar un nuevo estudiante:</div>
    @endif

    <div class="row">

        {{-- Campos de la izquierda --}}
        <div class="col">

            {{-- Campo: Cedula --}}
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

            {{-- Campo: Nombre --}}
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

            {{-- Campo: Apellidos --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="apellido">Apellido</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="apellido"
                    name="apellido"
                    onkeyup="contarCarApellido(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_apellido"></span>
                </div>
            </div>

                    {{-- Campo: Fecha de nacimiento --}}
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
                    onkeyup="contarCarFechaNacimiento(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_fecha_nacimiento"></span>
                </div>
            </div>

            {{-- Campo: Telefono fijo --}}
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


                    {{-- Campo: Telefono celular --}}
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

                    {{-- Campo: Correo personal --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="correo_personal">Correo personal:</label>
                </div>
                <div class="col-6">
                    <input type='email'
                    minlength="3" maxlength="45"
                    class="form-control w-100"
                    id="correo_personal"
                    name="correo_personal"
                    onkeyup="contarCarCorreoPersonal(this)"
                    multiple>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_correo_personal"></span>
                </div>
            </div>

                {{-- Campo: Correo institucional --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="correo_institucional">Correo institucional:</label>
                </div>
                <div class="col-6">
                    <input type='email'
                    minlength="3" maxlength="45"
                    class="form-control w-100"
                    id="correo_institucional"
                    name="correo_institucional"
                    onkeyup="contarCarCorreoInstitucional(this)"
                    multiple
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_correo_institucional"></span>
                </div>
            </div>

             {{-- Campo: Estado civil --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="estado_civil">Estado civil:</label>
                </div>
                <div class="col-6">
                    <select
                    class="form-control w-100"
                    id="estado_civil"
                    name="estado_civil" form="estudiante"
                    required>
  <option value="Soltero">Soltero</option>
  <option value="Casado">Casado</option>
  <option value="Viudo">Viudo</option>
  <option value="Divorsiado">Divorsiado</option>
</select>
                </div>
            </div>

            {{-- Campo: Direccion de residencia --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="direccion_residencia">Direccion de residencia:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="direccion_residencia"
                    name="direccion_residencia"
                    onkeyup="contarCarDireccionResidencia(this)"
                    required></textarea>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_direccion_residencia"></span>
                </div>
            </div>

            {{-- Campo: Genero --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="genero">Genero:</label>
                </div>
                <div class="col-6">

                    <select
                    class="form-control w-100"
                    id="genero"
                    name="genero"
                    form="estudiante"
                    required>
  <option value="M">M</option>
  <option value="F">F</option>
  <option value="Otro">Otro</option>
</select>

                </div>
            </div>


            {{-- Campo: Direccion lectivo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="direccion_lectivo">Direccion lectivo:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="direccion_lectivo"
                    name="direccion_lectivo"
                    onkeyup="contarCarDireccionLectivo(this)"
                    required></textarea>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_direccion_lectivo"></span>
                </div>
            </div>

            {{-- Campo: Cantidad de hijos --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="cantidad_hijos">Cantidad hijos:</label>
                </div>
                <div class="col-6">
                    <input type='number'
                    max="99"
                    class="form-control w-100"
                    id="cantidad_hijos"
                    name="cantidad_hijos"
                    onkeyup="contarCarCantidadHijos(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_cantidad_hijos"></span>
                </div>
            </div>

        </div>



        {{-- Campos de la derecha --}}
        <div class="col">


                    {{-- Campo: Tipo de colegio de procedencia --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tipo_colegio_procedencia">Tipo colegio procedencia:</label>
                </div>
                <div class="col-6">

                    <select
                    class="form-control w-100"
                    id="tipo_colegio_procedencia"
                    name="tipo_colegio_procedencia"
                    form="estudiante"
                    required>
  <option value="Normal">Normal</option>
  <option value="Tecnico">Tecnico</option>
  <option value="Cientifico">Cientifico</option>
  <option value="Bilingue">Bilingue</option>
</select>



                </div>
            </div>

            {{-- Campo: Condicion de discapacidad --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="condicion_discapacidad">Condicion diacapacidad:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="condicion_discapacidad"
                    name="condicion_discapacidad"
                    onkeyup="contarCarCondicionDiscapacidad(this)"></textarea>
                </div>
                                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_condicion_discapacidad"></span>
                </div>
            </div>

              {{-- Campo: Año de ingreso a la EBDI --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_ingreso_ebdi">Año ingreso EBDI:</label>
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

            {{-- Campo: Año de ingreso a la UNA --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_ingreso_una">Año ingreso UNA:</label>
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

                    {{-- Campo: Año de desercion --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_desercion">Año desercion:</label>
                </div>
                <div class="col-6">
                    <input type='number'
                    max="9999"
                    class="form-control w-100"
                    id="anio_desercion"
                    name="anio_desercion"
                    onkeyup="contarCarAnioDesercion(this)">
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_desercion"></span>
                </div>
            </div>

                    {{-- Campo: Tipo de beca --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="tipo_beca">Tipo beca:</label>
                </div>




                    <select
                    class="form-control w-50"
                    id="tipo_beca"
                    name="tipo_beca"
                    form="estudiante"
                    required>
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

            {{-- Campo: Nota de admision --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="nota_admision">Nota admision:</label>
                </div>
                <div class="col-6">
                    <input type='number'
                    class="form-control w-100"
                    max="999.99"
                    step="0.01"
                    id="nota_admision"
                    name="nota_admision"
                    onkeyup="contarCarNotaAdmision(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_admision"></span>
                </div>
            </div>

            {{-- Campo: Carrera matriculada 1 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="carrera_matriculada_1">Carrera matriculada 1:</label>
                </div>
                <div class="col-6">
                    <input type='text'
                    class="form-control w-100"
                    id="carrera_matriculada_1"
                    name="carrera_matriculada_1"
                    onkeyup="contarCarCarreraMatriculada1(this)"
                    required>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_carrera_matriculada1"></span>
                </div>
            </div>

            {{-- Campo: Carrera matriculada 2 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="carrera_matriculada_2">Carrera matriculada 2:</label>
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

            {{-- Campo: Año de graduacion estimado 1 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_gradacion_estimado_1">Año de graduacion estimado 1:</label>
                </div>
                <div class="col-6">
                    <input type='number'
                    max="9999"
                    class="form-control w-100"
                    id="anio_gradacion_estimado_1"
                    name="anio_gradacion_estimado_1"
                    onkeyup="contarCarAnioGraduacionEstimado1(this)"
                    required>
                </div>
                                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_graduacion_estimado_1"></span>
                </div>
            </div>

                        {{-- Campo: Año estimado de graduacion 2 --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="anio_graduacion_estimado_2">Año de graduacion estimado 2:</label>
                </div>
                <div class="col-6">
                    <input type='number'
                    max="9999"
                    class="form-control w-100"
                    id="anio_graduacion_estimado_2"
                    name="anio_graduacion_estimado_2"
                    onkeyup="contarCarAnioGraduacionEstimado2(this)">
                </div>
                                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_anio_graduacion_estimado_2"></span>
                </div>
            </div>


                    {{-- Campo: Apoyo educativo --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="apoyo_educativo">Apoyo educativo:</label>
                </div>
                <div class="col-6">
                    <textarea
                    class="form-control w-100"
                    id="apoyo_educativo"
                    name="apoyo_educativo"
                    onkeyup="contarCarApoyoEducativo(this)"></textarea>
                </div>
                <div class="col-1">
                    <span class="text-muted" id="mostrar_cant_apoyo_educativo"></span>
                </div>
            </div>

                {{-- Campo: Residencias --}}
            <div class="form-inline mb-3">
                <div class="col-4">
                    <label for="residencias">Residencias:</label>
                </div>
                    <select
                    class="form-control w-50"
                    id="residencias"
                    name="residencias"
                    form="estudiante"
                    required>
  <option value="0">No</option>
  <option value="1">Si</option>
                    </select>
            </div>


        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{-- Boton para agregar informacion del estudiante --}}
        <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
    </div>

</form>
@endsection

@section('pie')
Copyright
@endsection
