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

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estadosCiviles = ['Soltero','Casado','Viudo','Divorciado','Unión libre'];
$generos = ['Femenino','Masculino','Otro'];
$colegiosProcedencias = ['Liceo','Técnico','Científico','Bilingüe','Nocturno','Privado'];
$tiposBecas = ['No tiene','Beca por condición socioeconómica','Beca Omar Dengo (Residencia estudiantil)','Becas de posgrado',
'Beca por participación en actividades artísticas y deportivas','Beca por participación en movimiento estudiantil',
'Honor','Estudiante Asistente Académico y Paracadémico','Intercambio estudiantil','Préstamos estudiantiles','Giras'];
@endphp

{{-- Formulario general de estudiante --}}
<form action="{{ route('estudiante.update',$estudiante->persona_id ) }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    {{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
    @method('PATCH')
    <div class="card">
        <div class="card-body">
            {{-- Contenido total del detalle --}}
            <div class="container-fluid">
                <div class=" d-flex justify-content-between">
                    <div>
                        {{-- Nombre y apellido del estudiante, que son titulos del contenido --}}
                        <h3 class="texto-gris mb-4">{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}</h3>
                    </div>
                    <div>
                        {{-- Botones superiores --}}

                        {{-- Regresar al listado de estudiantes --}}
                        <a href="/listado-estudiantil" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a>
                        {{-- Boton que habilita opcion de editar --}}
                        <button type="button" class="btn btn-rojo" id="editar-estudiante"><i class="fas fa-edit "></i> Editar </button>
                        {{-- Boton de cancelar edicion --}}
                        <button type="button" class="btn btn-rojo" id="cancelar-edi"><i class="fas fa-close "></i> Cancelar </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 col-sm-12">
                        {{-- Tarjeta de foto perfil --}}
                        <div class="card mb-3">
                            <div class="card-body text-center shadow-sm rounded pb-5">
                                {{-- Foto del estudiante --}}
                                <img class="rounded-circle mb-3 mt-4" src="{{ asset('img/fotos/'.$estudiante->persona->imagen_perfil) }}" width="160" height="160" />
                                {{-- Cedula del estudiante --}}
                                <div class="mb-3"><i class="fa fa-id-card mr-3 texto-rojo"></i><small class="texto-negro" style="font-size: 17px;"><strong>{{ $estudiante->persona_id }}</strong></small></div>
                                <div id="cambiar-foto">
                                    <hr>
                                    <input type="file" name="avatar" class="border">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id_estudiante" value="{{ $estudiante->persona->persona_id }}"><br>
                                </div>
                            </div>
                        </div>
                        {{-- Tarjeta de información académica del estudiante --}}
                        <div class="card shadow-sm mb-4 rounded">
                            <div class="card-header py-3">
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Información académica</h6>
                            </div>
                            <div class="card-body pb-5">
                                {{-- Campo: Nota admision --}}
                                <div class="form-group">
                                    <label for="nota"><strong>Nota de admisión *</strong><br /></label><input id="nota_admision" class="form-control" type="number" placeholder="Nota Admision" name="nota_admision" value="{{  $estudiante->nota_admision }}" required disabled />
                                </div>
                                {{-- Campo: Ingreso a la UNA --}}
                                <div class="form-group">
                                    <label for="anioUNA"><strong>Año de ingreso a la UNA</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la UNA" name="anio_ingreso_una" value="{{ $estudiante->anio_ingreso_UNA }}" required disabled />
                                </div>
                                {{-- Campo: Ingreso a la EBDI --}}
                                <div class="form-group">
                                    <label for="anioEBDI"><strong>Año de ingreso a la EBDI *</strong><br /></label><input class="form-control " type="date" placeholder="Ingreso a la EBDI" name="anio_ingreso_ebdi" value="{{ $estudiante->anio_ingreso_ebdi }}" required disabled />
                                </div>
                                {{-- Campo: Primera Carrera --}}
                                <div class="form-group">
                                    <label for="carrera1"><strong>Primera Carrera *</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Nombre de primera carrera" name="carrera_matriculada_1" value="{{ $estudiante->carrera_matriculada_1 }}" required disabled /> </input>
                                </div>
                                {{-- Campo: Segunda Carrera --}}
                                <div class="form-group">
                                    <label for="carrera2" data-toggle="tooltip" data-placement="left" title="Sólo en caso de que existe segunda carrera"><strong>Segunda Carrera</strong><br /></label>
                                    <input type="text" class="form-control" placeholder="Nombre de carrera" name="carrera_matriculada_2" value="{{ $estudiante->carrera_matriculada_2  }}" disabled /> </input>
                                </div>
                                {{-- Campo: Colegio Procedencia --}}
                                <div class="form-group">
                                    <label for="colegio"><strong>Tipo de colegio de procedencia</strong><br /></label>
                                    <select class="form-control" id="tipo_colegio_procedencia" name="tipo_colegio_procedencia" required disabled>
                                        @foreach($colegiosProcedencias as $colegioProcedencia)
                                        <option value="{{ $colegioProcedencia }}" @if($colegioProcedencia==$estudiante->tipo_colegio_procedencia) selected @endif> {{ $colegioProcedencia }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Campo: Estimado Graduacion --}}

                                {{-- Primera Carrera --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Año estimado de graduación de la primera carrera" for="anio_graduacion_estimado_1"><strong>Año Estimado Graduación 1 *</strong><br /></label><input class="form-control" type="number" placeholder="Estimado Graduación" name="anio_graduacion_estimado_1" value="{{ $estudiante->anio_graduacion_estimado_1 }}" required disabled />
                                </div>
                                {{-- Segunda Carrera --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Año estimado de graduación de la segunda carrera (Si el estudiante tiene)" for="anio_graduacion_estimado_2"><strong>Año Estimado Graduación 2</strong><br /></label><input class="form-control" type="number" placeholder="Estimado Graduación" name="anio_graduacion_estimado_2" value="{{ $estudiante->anio_graduacion_estimado_2  }}" disabled />
                                </div>
                                {{-- Campo: Desercion --}}
                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="left" title="Se ingresa año de deserción si existe" for="anio_desercion"><strong>Año Deserción</strong><br /></label><input class="form-control" name="anio_desercion" type="number" placeholder="Año de Deserción" value="{{ $estudiante->anio_desercion }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8  col-sm-12">
                        <div class=" row">
                            <div class="col">
                                {{-- Tarjeta de Informacion de contacto del estudiante --}}
                                <div class="card shadow-sm mb-3 rounded pb-2">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Contacto</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            {{-- Campo: Nombre estudiante --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nombre"><strong>Nombre *</strong></label><input id="nombre" class="form-control" type="text" id="nombre" placeholder="Nombre Estudiante" name="nombre" value="{{ $estudiante->persona->nombre }}" required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Apellidos --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="apellido"><strong>Apellidos *</strong></label>
                                                    <input class="form-control " type="text" name="apellido" placeholder="Apellidos" value="{{ $estudiante->persona->apellido }}" required disabled /> </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" form-row">
                                            {{-- Campos: Correo electronico --}}

                                            {{-- Correo Personal --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label><input class="form-control" placeholder="Correo Personal" type="email" name="correo_personal" value="{{ $estudiante->persona->correo_personal}}" disabled />
                                                </div>
                                            </div>
                                            {{-- Correo Institucional --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_institucional"><strong>Correo Institucional *</strong><br /></label><input class="form-control" type="email" name="correo_institucional" placeholder="Correo Institucional" value="{{ $estudiante->persona->correo_institucional}}" required disabled />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campos: Telefonos --}}
                                        <div class="form-row">

                                            {{-- Celular --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label><input class="form-control" type="text" name="telefono_celular" placeholder="Telefono Celular" value="{{ $estudiante->persona->telefono_celular  }}" disabled />
                                                </div>
                                            </div>
                                            {{-- Telefono Fijo --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label><input class="form-control" type="text" name="telefono_fijo" placeholder="Telefono Fijo" value="{{ $estudiante->persona->telefono_fijo }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Tarjeta de informacion adicional del estudiante --}}
                                <div class="card shadow-sm pb-5">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold ">Información Adicional</p>
                                    </div>
                                    <div class="card-body pb-5">
                                        {{-- Campo: Direccion Residencia --}}
                                        <div class="form-group">
                                            <label data-toggle="tooltip" data-placement="left" title="Lugar de residencia del estudiante fuera del tiempo lectivo" for="DireccionResidencia"><strong>Dirección Residencia *</strong><br /></label>
                                            <textarea class="form-control" type="text" placeholder="Direccion de residencia" name="direccion_residencia" required disabled />{{$estudiante->persona->direccion_residencia}} </textarea>
                                        </div>
                                        {{-- Campo: Direccion tiempo lectivo --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Lugar de residencia del estudiante durante el tiempo lectivo" for="DireccionLectivo"><strong>Dirección Tiempo Lectivo *</strong><br /></label>
                                                    <textarea class="form-control" type="text" placeholder="Direccion de tiempo lectivo" name="direccion_lectivo" required disabled /> {{$estudiante->direccion_lectivo}} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Fecha Nacimiento --}}
                                        <div class="form-row">
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento *</strong><br /></label><input class="form-control" type='date' placeholder="Fecha Nacimiento" name="fecha_nacimiento" value={{$estudiante->persona->fecha_nacimiento}} required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Genero --}}
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="genero"><strong>Género *</strong></label>
                                                    <select class="form-control w-100" id="genero" name="genero" required disabled>
                                                        <option value="M" @if( $estudiante->persona->genero == "M" ) option selected @endif>Masculino</option>
                                                        <option value="F" @if( $estudiante->persona->genero == "F" ) option selected @endif>Femenino</option>
                                                        <option value="Otro" @if( $estudiante->persona->genero == "Otro" ) option selected @endif>Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Estado Civil --}}
                                            <div class="col-3 mr-2">
                                                <div class="form-group">
                                                    <label for="estadoCivil"><strong>Estado Civil *</strong></label>
                                                    <select class="form-control" id="estado_civil" name="estado_civil" required disabled>
                                                        @foreach($estadosCiviles as $estadoCivil)
                                                        <option value='{{ $estadoCivil }}' @if ( $estadoCivil==$estudiante->persona->estado_civil) selected @endif> {{ $estadoCivil }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Cantidad de hijos (en numero) --}}
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Ingresar el número de hijos o 0 en caso de no tener" for="cantidad_hijos"><strong>Hijos *</strong><br /></label><input class="form-control" type="number" placeholder="Hijos" name="cantidad_hijos" value="{{ $estudiante->cant_hijos }}" required disabled />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Apoyo Educativo --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Detalle del apoyo educativo recibido por el estudiante o indicar si no ha recibido" for="apoyo_educativo"><strong>Apoyo Educativo</strong><br /></label>
                                                    <textarea class="form-control" placeholder="Apoyo educativo del estudiante" type="text" name="apoyo_educativo" disabled />{{ $estudiante->apoyo_educativo }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            {{-- Campo: Beca --}}
                                            <div class="col-7 mr-3">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Se enlistan tipos de becas y otro tipo de ayudas como: Giras o Préstamos Estudiantiles" for="beca"><strong>Beca *</strong></label>
                                                    <select class="form-control" id="tipo_beca" name="tipo_beca" required disabled>
                                                        @foreach($tiposBecas as $tipoBeca)
                                                        <option value="{{ $tipoBeca }}" @if ($tipoBeca==$estudiante->tipo_beca) selected @endif> {{ $tipoBeca }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Residencias UNA --}}
                                            <div class="col">
                                                <label for="residencias"><strong>Residencias UNA *</strong><br /></label>
                                                <div class="d-flex justify-content-start pb-4">
                                                    {{-- Segmento que valida si se registro con residencia --}}
                                                    <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" value="1" name="residencias" @if( $estudiante->residencias_UNA == "1" ) checked="checked" @endif disabled><label class="form-check-label" for="formCheck-2">Si</label>
                                                    </div>
                                                    {{-- Segmento que valida si se registro sin residencia --}}
                                                    <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" value="0" name="residencias" @if( $estudiante->residencias_UNA == "0" ) checked="checked" @endif disabled><label class="form-check-label" for="formCheck-3">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Discapacidad --}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="left" title="Ingresar si el estudiante posee alguna discapacidad o no" for="condicion_discapacidad"><strong>Condición Discapacidad</strong><br /></label>
                                                    <textarea class="form-control" placeholder="Discapacidad del estudiante" type="text" name="condicion_discapacidad" disabled />{{$estudiante->condicion_discapacidad}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campo: Trabajo--}}
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group text-center mt-4">
                                                    <label for="city"><strong>Información Laboral</strong><br /></label>
                                                    <div class="w-100 d-flex justify-content-center">
                                                        <a href="/estudiante/trabajo/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo" type="button">Ver trabajo</a>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Segmento asociado al estudiante cuando ya es graduado --}}
                                            <div class="col">
                                                <div class="form-group text-center mt-4">
                                                    <label for="city"><strong>Titulaciones</strong><br /></label>
                                                    <div class="w-100 d-flex justify-content-center">
                                                        <a href="{{ route('graduado.show',$estudiante->persona->persona_id ) }}" class="btn btn-rojo" type="button">Ver graduaciones</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{-- Guarda oculto el ID del estudiante en el detalle --}}
                    <input type="hidden" name="persona_id" value="{{ $estudiante->persona->persona_id }}"><br>
                    {{-- Boton para enviar los cambios --}}
                    <button id="guardar-cambios" type="submit" class="btn btn-rojo">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('pie')
Copyright
@endsection
