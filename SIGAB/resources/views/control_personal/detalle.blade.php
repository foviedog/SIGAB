@extends('layouts.app')

@section('titulo')
Detalle del personal {{ $personal->persona->nombre }}
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
if(is_null($idiomas)){
$idiomas = [];
}
@endphp

@section('contenido')

@if(Accesos::ACCESO_ELIMINAR_PERSONAL())
    @include('layouts.messages.confirmar_eliminar')
@endif

@if(Accesos::ACCESO_MODIFICAR_PERSONAL())
{{-- Formulario general de personal --}}
<form autocomplete="off" action="{{ route('personal.update',$personal->persona_id ) }}" method="POST" role="form" enctype="multipart/form-data" id="personal-form" onsubmit="activarLoader('Enviando cambios');">
    @csrf
    {{-- Metodo invocado para realizar la modificacion correctamente del personal --}}
    @method('PATCH')
    @endif

    <div class="card">

        <div class="card-body">
            {{-- Input para el array de idiomas en JSON --}}
            <input type="hidden" name="idiomasJSON" id="idiomasJSON">

            {{-- Contenido total del detalle --}}
            <div class="container-fluid">
                <div class=" d-flex justify-content-between">
                    <div>
                        {{-- Nombre y apellido del personal, que son titulos del contenido --}}
                        <h3 class="texto-gris mb-4">{{ $personal->persona->nombre }} {{ $personal->persona->apellido }}</h3>
                    </div>
                    <div>

                        {{-- Regresar al listado de personal --}}
                        <a href="{{ route('personal.listar') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a>
                        @if(Accesos::ACCESO_ELIMINAR_PERSONAL())
                        {{-- Boton para eliminar el personal --}}
                        <a class="btn btn-rojo" data-toggle="modal" data-target="#modal-confirmacion"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
                        @endif
                        @if(Accesos::ACCESO_MODIFICAR_PERSONAL())
                        {{-- Boton que habilita opcion de editar --}}
                        <button type="button" id="editar-personal" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                        {{-- Boton de cancelar edicion --}}
                        <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 col-sm-12">
                        {{-- Tarjeta de foto perfil --}}
                        <div class="card mb-3">
                            <div class="card-body text-center shadow-sm rounded pb-5">
                                {{-- Foto del personal --}}
                                <div class="d-flex justify-content-center mb-3 mt-4">
                                    <div class="overflow-hidden rounded-circle " style="max-width: 160px; max-height: 160px; ">
                                        <img class="" src="{{ asset('img/fotos/'.$personal->persona->imagen_perfil) }}" style="max-width: 100%;  " />
                                    </div>
                                </div>
                                {{-- Cedula del personal --}}
                                <div class="mb-3" data-toggle="tooltip" data-placement="bottom" title="Cédula del personal"><i class="fa fa-id-card mr-1 texto-rojo"></i><small class="texto-negro" style="font-size: 17px;"><strong>ID {{ $personal->persona_id }} </strong></small></div>
                                <div id="cambiar-foto">
                                    <hr>
                                    <input type="file" name="avatar" class="border">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id_personal" value="{{ $personal->persona->persona_id }}"><br>
                                </div>
                            </div>
                        </div>
                        {{-- Tarjeta de información académica del personal --}}
                        <div class="card shadow-sm mb-4 rounded">
                            <div class="card-header py-3">
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Participaciones </h6>
                            </div>
                            <div class="card-body pb-5">
                                {{-- Campo: capacitacion_didactica --}}
                                <div class="form-group">
                                    <label for="capacitacion_didactica"><strong>Capacitación didáctica</strong><br /></label>
                                    <textarea type="text" id="capacitacion_didactica" name="capacitacion_didactica" class="form-control" placeholder="" rows="4" disabled>{{ $personal->capacitacion_didactica }}</textarea>
                                </div>
                                {{-- Campo: Publicaciones --}}
                                <div class="form-group">
                                    <label for="publicaciones"><strong>Publicaciones</strong><br /></label>
                                    <textarea type="text" id="publicaciones" name="publicaciones" class="form-control" placeholder="" rows="4" disabled>{{ $personal->publicaciones }}</textarea>
                                </div>
                                {{-- Campo: cursos_impartidos --}}
                                <div class="form-group">
                                    <label for="cursos_impartidos"><strong>Cursos impartidos</strong><br /></label>
                                    <textarea type="text" id="cursos_impartidos" name="cursos_impartidos" class="form-control" placeholder="" rows="4" disabled> {{ $personal->cursos_impartidos }} </textarea>
                                </div>
                                {{-- Campo: miembro_comisiones --}}
                                <div class="form-group">
                                    <label for="miembro_comisiones"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="miembro_comisiones" name="miembro_comisiones" class="form-control" placeholder="" rows="4" disabled> {{ $personal->miembro_comisiones }}</textarea>
                                </div>
                                {{-- Campo: miembro_prueba_grado --}}
                                <div class="form-group">
                                    <label for="miembro_prueba_grado"><strong>Miembro prueba grado</strong><br /></label>
                                    <textarea type="text" id="miembro_prueba_grado" name="miembro_prueba_grado" class="form-control" placeholder="" rows="4" disabled> {{ $personal->miembro_prueba_grado }}</textarea>
                                </div>
                                {{-- Campo: evaluador_defensa_publica --}}
                                <div class="form-group">
                                    <label for="evaluador_defensa_publica"><strong>Evaluador de defensa publica</strong><br /></label>
                                    <textarea type="text" id="evaluador_defensa_publica" name="evaluador_defensa_publica" class="form-control" placeholder="" rows="4" disabled> {{ $personal->evaluador_defensa_publica }} </textarea>
                                </div>
                                {{-- Campo: evaluacion_interna_ppaa --}}
                                <div class="form-group">
                                    <label for="evaluacion_interna_ppaa"><strong>Evaluacion interna PPAA</strong><br /></label>
                                    <textarea type="text" id="evaluacion_interna_ppaa" name="evaluacion_interna_ppaa" class="form-control" placeholder="" rows="4" disabled> {{ $personal->evaluacion_interna_ppaa }}</textarea>
                                </div>
                                {{-- Campo: evaluacion_externa_ppaa --}}
                                <div class="form-group">
                                    <label for="evaluacion_externa_ppaa"><strong>Evaluacion externa PPAA</strong><br /></label>
                                    <textarea type="text" id="evaluacion_externa_ppaa" name="evaluacion_externa_ppaa" class="form-control" placeholder="" rows="4" disabled> {{ $personal->evaluacion_externa_ppaa }}</textarea>
                                </div>
                                {{-- Campo: reconocimientos --}}
                                <div class="form-group">
                                    <label for="reconocimientos"><strong>Reconocimientos</strong><br /></label>
                                    <textarea type="text" id="reconocimientos" name="reconocimientos" class="form-control" placeholder="" rows="4" disabled>{{ $personal->reconocimientos }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8  col-sm-12">
                        <div class=" row">
                            <div class="col">
                                {{-- Tarjeta de Informacion de contacto del personal --}}
                                <div class="card shadow-sm mb-3 rounded pb-2">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold texto-rojo">Contacto</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            {{-- Campo: Nombre personal --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="nombre"><strong>Nombre/s<i class="text-danger">* </i> </strong></label>
                                                        <span class="text-muted" id="mostrar_nombre"></span>
                                                    </div>
                                                    <input type="text" onkeyup="contarCaracteres(this,50)" id="nombre" name="nombre" class="form-control" placeholder="Nombre personal" value="{{ $personal->persona->nombre }}" required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Apellidos --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="apellido"><strong>Apellido/s<i class="text-danger">* </i> </strong></label>
                                                        <span class="text-muted" id="mostrar_apellido"></span>
                                                    </div>
                                                    <input type="text" name="apellido" id="apellido" class="form-control" onkeyup="contarCaracteres(this,50)" placeholder="Apellidos" value="{{ $personal->persona->apellido }}" required disabled /> </input>
                                                </div>
                                            </div>

                                        </div>
                                        <div class=" form-row">
                                            {{-- Campos: Correo electronico --}}

                                            {{-- Correo Personal --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="correo_personal"><strong>Correo Personal</strong></label>
                                                        <span class="text-muted" id="mostrar_correo_personal"></span>
                                                    </div>
                                                    <input type="email" name="correo_personal" id="correo_personal" class="form-control" onkeyup="contarCaracteres(this,50)" placeholder="Correo Personal" value="{{ $personal->persona->correo_personal}}" disabled />
                                                </div>
                                            </div>
                                            {{-- Correo Institucional --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="correo_institucional"><strong>Correo Institucional<i class="text-danger">* </i> </strong></label>
                                                        <span class="text-muted" id="mostrar_correo_institucional"></span>
                                                    </div>
                                                    <input type="email" name="correo_institucional" id="correo_institucional" class="form-control" onkeyup="contarCaracteres(this,100)" placeholder="Correo Institucional" value="{{ $personal->persona->correo_institucional}}" required disabled />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campos: Telefonos --}}
                                        <div class="form-row">

                                            {{-- Celular --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="telefono_celular"><strong>Teléfono Celular</strong>
                                                            <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span></label>
                                                        <span class="text-muted" id="mostrar_telefono_celular"></span>
                                                    </div>
                                                    <input type="text" name="telefono_celular" id="telefono_celular" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Celular" value="{{ $personal->persona->telefono_celular}}" disabled />
                                                </div>
                                            </div>
                                            {{-- Telefono Fijo --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="telefono_fijo"><strong>Teléfono Fijo</strong>
                                                            <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span></label>
                                                        <span class="text-muted" id="mostrar_telefono_fijo"></span>
                                                    </div>
                                                    <input type="text" name="telefono_fijo" id="telefono_fijo" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Fijo" value="{{ $personal->persona->telefono_fijo }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Tarjeta de informacion personal --}}
                                <div class="card shadow-sm ">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold ">Información Personal</p>
                                    </div>
                                    <div class="card-body ">

                                        {{-- Campo: Fecha Nacimiento --}}
                                        <div class="form-row">
                                            <div class="col-4 ">
                                                <div class="form-group">
                                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento <i class="text-danger">* </i></strong><br /></label><input type='date' name="fecha_nacimiento" class="form-control" placeholder="Fecha Nacimiento" value={{$personal->persona->fecha_nacimiento}} required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Genero --}}
                                            <div class="col-4 ">
                                                <div class="form-group">
                                                    <label for="genero"><strong>Género <i class="text-danger">* </i></strong></label>
                                                    <select id="genero" name="genero" class="form-control w-100" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        <option value="M" @if( $personal->persona->genero == "M" ) selected @endif>Masculino</option>
                                                        <option value="F" @if( $personal->persona->genero == "F" ) selected @endif>Femenino</option>
                                                        <option value="Otro" @if( $personal->persona->genero == "Otro" ) selected @endif>Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Estado Civil --}}
                                            <div class="col-4 ">
                                                <div class="form-group">
                                                    <label for="estadoCivil"><strong>Estado Civil <i class="text-danger">* </i></strong></label>
                                                    <select id="estado_civil" name="estado_civil" class="form-control" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($estadosCiviles as $estadoCivil)
                                                        <option value='{{ $estadoCivil }}' @if ( $estadoCivil==$personal->persona->estado_civil) selected @endif> {{ $estadoCivil }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row d-flex justify-content-between ">
                                            <div class="col-12">
                                                {{-- Campo: trabajo_externo --}}
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="trabajo_externo"><strong>Lugar de Trabajo externo </strong>
                                                            <span data-toggle="tooltip" data-placement="right" title="Aplica para personal docente interino"><i class="far fa-question-circle fa-lg mr-2"></i></span></label>
                                                        <span class="text-muted" id="mostrar_trabajo_externo"></span>
                                                    </div>
                                                    <input type="text" name="trabajo_externo" id="trabajo_externo" class=" form-control" onkeyup="contarCaracteres(this,60)" placeholder="Solamente para docente interino" value="{{ $personal->lugar_trabajo_externo}}" disabled /> </input>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center align-items-center mt-2">
                                                <div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-12">
                                                {{-- Campo: Direccion Residencia --}}
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="DireccionResidencia"><strong>Dirección Residencia <i class="text-danger">* </i></strong>
                                                            <span data-toggle="tooltip" data-placement="right" title="Lugar de residencia habitual del personal "><i class="far fa-question-circle fa-lg"></i></span></label>
                                                        <span class="text-muted" id="mostrar_direccion_residencia"></span>
                                                    </div>
                                                    <textarea type="text" name="direccion_residencia" id="direccion_residencia" class="form-control" onkeyup="contarCaracteres(this,250)" placeholder="Direccion de residencia" required disabled />{{$personal->persona->direccion_residencia}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            {{-- Campo: experiencia_profesional --}}
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="experiencia_profesional"><strong>Experiencia profesional</strong><br /></label>
                                                    <span data-toggle="tooltip" data-placement="right" title="Experiencia profesional que se obtuvo en otras entidades externas a la UNA."><i class=" far fa-question-circle fa-lg"></i></span>
                                                    <textarea type="text" name="experiencia_profesional" id="experiencia_profesional" class="form-control" placeholder="Experiencia Profesional" disabled>{{ $personal->experiencia_profesional }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between ">

                                            {{-- Campo: experiencia_academica --}}
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="experiencia_academica"><strong>Experiencia académica</strong><br /></label>
                                                    <span data-toggle="tooltip" data-placement="right" title="Experiencia académica en la UNA y en otras instituciones."><i class="far fa-question-circle fa-lg"></i></span>
                                                    <textarea type="text" name="experiencia_academica" id="experiencia_academica" class="form-control" placeholder="Experiencia académica" disabled>{{ $personal->experiencia_academica }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Espacio para agregar n idiomas a un personal --}}
                                        <div class="form-row border-top">
                                            <div class="card-header py-3 w-100">
                                                <p class="texto-rojo-medio m-0 font-weight-bold ">Lista de idiomas</p>
                                            </div>
                                            <div class="alert alert-danger text-center font-weight-bold w-100" role="alert" id="alert-idiomas">
                                                No puede dejar idiomas en blanco!
                                            </div>

                                            <table class="table table-bordered" id="lista-idiomas">
                                                {{-- Se trae el arreglo de idiomas del response, en caso de que dicho arreglo contenga datos el primero se anota
                                                    en el campo "Pivote" y los demás se agregan secuencialmente con un botón específico para ser eliminados --}}
                                                <tr>
                                                    <td><input type="text" name="name[]" placeholder="Actualmente no tiene idiomas" class="form-control idioma" @if(count($idiomas)> 0)
                                                        value="{{ $idiomas[0]->nombre }}"
                                                        @endif disabled/></td>
                                                    <td><button type="button" name="agregar-btn" id="agregar-btn" class="btn btn-contorno-rojo"> <i class="fas fa-plus-circle"></i> Agregar otro idioma</button></td>
                                                </tr>

                                                @for ($i = 1; $i < count($idiomas); $i++) <tr id="row{{ $i }}" class="idiomaRow">
                                                    <td><input type="text" name="name[]" placeholder="Nombre de idioma" class="form-control idioma" value="{{ $idiomas[$i]->nombre }}" disabled /></td>
                                                    <td><button type="button" name="eliminar-idioma" id="{{ $i }}" class="btn btn-gris eliminar-idioma-btn"><i class="fas fa-minus-circle"></i></button></td>
                                                    </tr>
                                                    @endfor
                                            </table>
                                        </div>


                                    </div>
                                </div>

                                <div class="card shadow-sm my-3 pb-5">
                                    <div class="card-header py-3">
                                        <p class="texto-rojo-medio m-0 font-weight-bold ">Información Laboral</p>
                                    </div>
                                    <div class="card-body py-5">

                                        <div class="form-row d-flex justify-content-between">
                                            <div class="col-6">
                                                {{-- Campo: tipo_puesto 1--}}
                                                <div class="form-group">
                                                    <div class="d-flex ">
                                                        <label for="tipo_puesto_1"><strong>Tipo de puesto 1<i class="text-danger">* </i></strong></label>
                                                        <span data-toggle="tooltip" data-placement="top" title="Tipo de puesto PRINCIPAL que desempeña en la EBDI" class="ml-3"><i class="far fa-question-circle fa-lg "></i></span>
                                                    </div>
                                                    <select id="tipo_puesto_1" name="tipo_puesto_1" class="form-control" required disabled>
                                                        @foreach($tipos_puestos as $tipo_puesto)
                                                        <option value="{{ $tipo_puesto }}" @if ( $tipo_puesto==$personal->tipo_puesto_1) selected @endif> {{ $tipo_puesto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- Campo: tipo_puesto 2--}}
                                                <div class="form-group">
                                                    <div class="d-flex ">
                                                        <label for="tipo_puesto_2"><strong>Tipo de puesto 2</strong></label>
                                                        <span data-toggle="tooltip" data-placement="top" title="Tipo de puesto SECUNDARIO que desempeña en la EBDI" class="ml-3"><i class="far fa-question-circle fa-lg "></i></span>
                                                    </div>
                                                    <select id="tipo_puesto_2" name="tipo_puesto_2" class="form-control" disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($tipos_puestos as $tipo_puesto)
                                                        <option value="{{ $tipo_puesto }}" @if ( $tipo_puesto==$personal->tipo_puesto_2) selected @endif> {{ $tipo_puesto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            <div class="col-4">
                                                {{-- Campo: cargo --}}
                                                <div class="form-group">
                                                    <label for="cargo"><strong>Tipo de cargo <i class="text-danger">* </i></strong></label>
                                                    <select id="cargo" name="cargo" class="form-control" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($cargos as $cargo)
                                                        <option value="{{ $cargo }}" @if ( $cargo==$personal->cargo) selected @endif> {{ $cargo }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            {{-- Campo: tipo_nombramiento --}}
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="tipo_nombramiento"><strong>Tipo de nombramiento <i class="text-danger">* </i></strong></label>
                                                    <select id="tipo_nombramiento" name="tipo_nombramiento" class="form-control" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($tipos_nombramientos as $tipo_nombramiento)
                                                        <option value="{{ $tipo_nombramiento }}" @if ( $tipo_nombramiento==$personal->tipo_nombramiento) selected @endif> {{ $tipo_nombramiento }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: jornada --}}
                                                <div class="form-group">
                                                    <label for="jornada"><strong>Jornada laboral <i class="text-danger">* </i></strong></label>
                                                    <select id="jornada" name="jornada" class="form-control" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($jornadas as $jornada)
                                                        <option value="{{ $jornada }}" @if ( $jornada==$personal->jornada) selected @endif> {{ $jornada }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row d-flex justify-content-between">
                                            <div class="col-4">
                                                {{-- Campo: grado_academico--}}
                                                <div class="form-group">
                                                    <label for="grado_academico"><strong>Grado académico <i class="text-danger">* </i></strong></label>
                                                    <select id="grado_academico" name="grado_academico" class="form-control" required disabled>
                                                        <option value="" selected>Sin seleccionar</option>
                                                        @foreach($grados_academicos as $grado_academico)
                                                        <option value="{{ $grado_academico }}" @if ( $grado_academico==$personal->grado_academico) selected @endif> {{ $grado_academico }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: area_especializacion_1 --}}
                                                <div class="form-group">
                                                    <label for="area_especializacion_1"><strong>Área de especialización 1 </strong><br /></label>
                                                    <span class="text-muted" id="mostrar_area_especializacion_1"></span>
                                                    <input type="text" name="area_especializacion_1" id="area_especializacion_1" class="form-control" onkeyup="contarCaracteres(this,100)" placeholder="Área de especialización 1" value="{{ $personal->area_especializacion_1 }}" disabled />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: area_especializacion_2 --}}
                                                <div class="form-group">
                                                    <label for="area_especializacion_2"><strong>Área de especialización 2</strong><br /></label>
                                                    <span class="text-muted" id="mostrar_area_especializacion_2"></span>
                                                    <input type="text" name="area_especializacion_2" id="area_especializacion_2" class="form-control" onkeyup="contarCaracteres(this,100)" placeholder="Área de especialización 2" value="{{ $personal->area_especializacion_2 }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            {{-- Campo: anio_propiedad --}}
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="anio_propiedad"><strong>Año de propiedad</strong><br /></label>
                                                    <span data-toggle="tooltip" data-placement="right" title="Año en el que obtuvo la propiedad en la UNA"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                                    <span class="text-muted" id="mostrar_anio_propiedad"></span>
                                                    <input type="text" name="anio_propiedad" id="anio_propiedad" class="form-control" onkeyup="contarCaracteres(this,4)" placeholder="Sin especificar" value="{{ $personal->anio_propiedad }}" disabled />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: regimen_administrativo --}}
                                                <div class="form-group">
                                                    <label for="regimen_administrativo"><strong>Régimen administrativo </strong></label>
                                                    <select id="regimen_administrativo" name="regimen_administrativo" class="form-control" disabled>
                                                        <option value="" selected>No aplica para docentes</option>
                                                        @foreach($regimenes_administrativos as $regimen_administrativo)
                                                        <option value="{{ $regimen_administrativo }}" @if ( $regimen_administrativo==$personal->regimen_administrativo) selected @endif> {{ $regimen_administrativo }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: regimen_docente --}}
                                                <label for="regimen_docente"><strong>Régimen docente </strong></label>
                                                <select id="regimen_docente" name="regimen_docente" class="form-control" disabled>
                                                    <option value="" selected>No aplica para administrativos</option>
                                                    @foreach($regimenes_docentes as $regimen_docente)
                                                    <option value="{{ $regimen_docente }}" @if ( $regimen_docente==$personal->regimen_docente) selected @endif> {{ $regimen_docente }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        @if(Accesos::ACCESO_LISTAR_CARGAS_ACADEMICAS())
                                        {{-- Campo: Carga académica--}}
                                        <div class="form-group text-center mt-4">
                                            <label for="city"><strong>Carga académica</strong><br /></label>
                                            <div class="w-100 d-flex justify-content-center">
                                                <a href="{{ route('cargaacademica.show', $personal->persona->persona_id) }}" class="btn btn-rojo" type="button">Ver carga académica</a>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                @if(Accesos::ACCESO_MODIFICAR_PERSONAL())
                {{-- Guarda oculto el ID del personal en el detalle --}}
                <input type="hidden" name="persona_id" value="{{ $personal->persona->persona_id }}"><br>
                {{-- Boton para enviar los cambios --}}
                <button type="submit" id="guardar-cambios" class="btn btn-rojo">Guardar cambios</button>
                @endif
            </div>
        </div>
    </div>
    @if(Accesos::ACCESO_MODIFICAR_PERSONAL())
</form>
@endif
@endsection

@section('scripts')
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_personal/registrar.js') }}" defer></script>
<script src="{{ asset('js/control_personal/editar.js') }}" defer></script>
<script src="{{ asset('js/global/validacionesImagenPerfil.js') }}" crossorigin="anonymous"></script>
@endsection
