@extends('layouts.app')

@section('titulo')
Detalle del personal {{ $personal->persona->nombre }}
@endsection

@section('css')
{{-- No hay --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_personal/mostrarParticipaciones.js') }}" defer></script>
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
                                        <td><input type="text" name="name[]" placeholder="Nombre del idioma" class="form-control idioma" value="{{ $idiomas[0]->nombre }}" /></td>
                                        <td><button type="button" name="agregar-btn" id="agregar-btn" class="btn btn-contorno-rojo"> <i class="fas fa-plus-circle"></i> Agregar otro idioma</button></td>
                                    </tr>
                                    @for ($i = 1; $i < count($idiomas); $i++) <tr id="row{{ $i }}" class="idiomaRow">
                                        <td><input type="text" name="name[]" placeholder="Nombre de idioma" class="form-control idioma" value="{{ $idiomas[$i]->nombre }}" /></td>
                                        <td><button type="button" name="eliminar-idioma" id="{{ $i }}" class="btn btn-gris eliminar-idioma-btn"><i class="fas fa-minus-circle"></i></button></td>
                                        </tr>
                                        @endfor

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
{{-- Arreglos de opciones de los select utilizados --}}
@php
$estadosCiviles = ['Soltero(a)','Casado(a)','Viudo(a)','Divorciado(a)','Unión libre'];

$generos = ['Femenino','Masculino','Otro'];

$cargos = ['Administrativo','Académico'];


$grados_academicos = ["Bachillerato","Licenciatura","Master","Doctorado","Posdoctorado"];

$jornadas = ["Por horas","Ciclo lectivo","Año"];

$tipos_nombramientos = ["Interino","Propietario","Plazo fijo"];

$tipos_puestos = ['Secretaría','Dirección','Subdirección','Docente','Profesional Ejecutivo','Participante de PPAA',
'Responsable de PPAA','Técnico Auxiliar','Biblioteca infantil','Asistente administrativo(a)',
'Profesional Asistencial en Desarrollo Tecnológico','Profesional Ejecutivo en Desarrollo Documental'];

$regimenes_administrativos = ['Categoría 21 (Técnico Auxiliar)','Categoría 23 (Técnico General 1-2-3)','Categoría 24 (Técnico Analista 1-2-3)',
'Categoría 32 (Profesional Asistencial 1-2-3-4-5)','Categoría 34 (Profesional Ejecutivo 1-2-3-4)','Categoría 35 (Profesional Analista 1-2-3)',
'Categoría 36 (Profesional Especialista)','Categoría 37 (Profesional Asesor de Procesos 1-2)','Categoría 38 (Profesional Asesor General)',
'Categoría 42 (Director Ejecutivo)','Categoría 43 (Director Especialista)','Categoría 44 (Director Asesor)'];

$regimenes_docentes = ["Categoría 87 (Profesor Instructor Bachiller)","Categoría 88 (Profesor Instructor Licenciado)","Categoría 89 (Profesor I)",
"Categoría 90 (Profesor II)","Categoría 91 (Catedrático)"];


@endphp

{{-- Formulario general de personal --}}
<form action="{{ route('personal.update',$personal->persona_id ) }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    {{-- Metodo invocado para realizar la modificacion correctamente del personal --}}
    @method('PATCH')
    <div class="card">
        <div class="card-body">
            {{-- Contenido total del detalle --}}
            <div class="container-fluid">
                <div class=" d-flex justify-content-between">
                    <div>
                        {{-- Nombre y apellido del personal, que son titulos del contenido --}}
                        <h3 class="texto-gris mb-4">{{ $personal->persona->nombre }} {{ $personal->persona->apellido }}</h3>
                    </div>
                    <div>
                        {{-- Botones superiores --}}

                        {{-- Regresar al listado de personals --}}
                        <a href="/listado-estudiantil" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al listado </a>
                        {{-- Boton que habilita opcion de editar --}}
                        <button type="button" id="editar-personal" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                        {{-- Boton de cancelar edicion --}}
                        <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4 col-sm-12">
                        {{-- Tarjeta de foto perfil --}}
                        <div class="card mb-3">
                            <div class="card-body text-center shadow-sm rounded pb-5">
                                {{-- Foto del personal --}}
                                <img class="rounded-circle mb-3 mt-4" src="{{ asset('img/fotos/'.$personal->persona->imagen_perfil) }}" width="160" height="160" />
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
                                    <textarea type="text" id="capacitacion_didactica" name="capacitacion_didactica" class="form-control" placeholder="Carga académica" rows="4" disabled>{{ $personal->capacitacion_didactica }}</textarea>
                                </div>
                                {{-- Campo: cursos_impartidos --}}
                                <div class="form-group">
                                    <label for="cursos_impartidos"><strong>Cursos impartidos</strong><br /></label>
                                    <textarea type="text" id="cursos_impartidos" name="cursos_impartidos" class="form-control" placeholder="Carga académica" rows="4" disabled> {{ $personal->cursos_impartidos }} </textarea>
                                </div>
                                {{-- Campo: miembro_comisiones --}}
                                <div class="form-group">
                                    <label for="miembro_comisiones"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="miembro_comisiones" name="miembro_comisiones" class="form-control" placeholder="Carga académica" rows="4" disabled> {{ $personal->miembro_comisiones }}</textarea>
                                </div>
                                {{-- Campo: miembro_prueba_grado --}}
                                <div class="form-group">
                                    <label for="miembro_prueba_grado"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="miembro_prueba_grado" name="miembro_prueba_grado" class="form-control" placeholder="Carga académica" rows="4" disabled> {{ $personal->miembro_prueba_grado }}</textarea>
                                </div>
                                {{-- Campo: evaluador_defensa_publica --}}
                                <div class="form-group">
                                    <label for="evaluador_defensa_publica"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="evaluador_defensa_publica" name="evaluador_defensa_publica" class="form-control" placeholder="Carga académica" rows="4" disabled> {{ $personal->evaluador_defensa_publica }} </textarea>
                                </div>
                                {{-- Campo: evaluacion_interna_ppaa --}}
                                <div class="form-group">
                                    <label for="evaluacion_interna_ppaa"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="evaluacion_interna_ppaa" name="evaluacion_interna_ppaa" class="form-control" placeholder="Carga académica" rows="4" disabled> {{ $personal->evaluacion_interna_ppaa }}</textarea>
                                </div>
                                {{-- Campo: reconocimientos --}}
                                <div class="form-group">
                                    <label for="reconocimientos"><strong>Miembro de comisiones</strong><br /></label>
                                    <textarea type="text" id="reconocimientos" name="reconocimientos" class="form-control" placeholder="Carga académica" rows="4" disabled>{{ $personal->reconocimientos }}</textarea>
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
                                                    <label for="nombre"><strong>Nombre/s<i class="text-danger">* </i> </strong></label><input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre personal" value="{{ $personal->persona->nombre }}" required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Apellidos --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="apellido"><strong>Apellido/s<i class="text-danger">* </i> </strong></label>
                                                    <input type="text" name="apellido" class="form-control" placeholder="Apellidos" value="{{ $personal->persona->apellido }}" required disabled /> </input>
                                                </div>
                                            </div>

                                        </div>
                                        <div class=" form-row">
                                            {{-- Campos: Correo electronico --}}

                                            {{-- Correo Personal --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label><input type="email" name="correo_personal" class="form-control" placeholder="Correo Personal" value="{{ $personal->persona->correo_personal}}" disabled />
                                                </div>
                                            </div>
                                            {{-- Correo Institucional --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="correo_institucional"><strong>Correo Institucional<i class="text-danger">* </i> </strong><br /></label><input type="email" name="correo_institucional" class="form-control" placeholder="Correo Institucional" value="{{ $personal->persona->correo_institucional}}" required disabled />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Campos: Telefonos --}}
                                        <div class="form-row">

                                            {{-- Celular --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label><input type="text" name="telefono_celular" class="form-control" placeholder="Telefono Celular" value="{{ $personal->persona->telefono_celular}}" disabled />
                                                </div>
                                            </div>
                                            {{-- Telefono Fijo --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label><input type="text" name="telefono_fijo" class="form-control" placeholder="Telefono Fijo" value="{{ $personal->persona->telefono_fijo }}" disabled />
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
                                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento<i class="text-danger">* </i> </strong><br /></label><input type='date' name="fecha_nacimiento" class="form-control" placeholder="Fecha Nacimiento" value={{$personal->persona->fecha_nacimiento}} required disabled />
                                                </div>
                                            </div>
                                            {{-- Campo: Genero --}}
                                            <div class="col-4 ">
                                                <div class="form-group">
                                                    <label for="genero"><strong>Género<i class="text-danger">* </i> </strong></label>
                                                    <select id="genero" name="genero" class="form-control w-100" required disabled>
                                                        <option value="M" @if( $personal->persona->genero == "M" ) selected @endif>Masculino</option>
                                                        <option value="F" @if( $personal->persona->genero == "F" ) selected @endif>Femenino</option>
                                                        <option value="Otro" @if( $personal->persona->genero == "Otro" ) selected @endif>Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Campo: Estado Civil --}}
                                            <div class="col-4 ">
                                                <div class="form-group">
                                                    <label for="estadoCivil"><strong>Estado Civil<i class="text-danger">* </i> </strong></label>
                                                    <select id="estado_civil" name="estado_civil" class="form-control" required disabled>
                                                        @foreach($estadosCiviles as $estadoCivil)
                                                        <option value='{{ $estadoCivil }}' @if ( $estadoCivil==$personal->persona->estado_civil) selected @endif> {{ $estadoCivil }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            {{-- Campo: anio_propiedad --}}
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="anio_propiedad"><strong>Año de propiedad</strong><br /></label>
                                                    <input type="text" name="anio_propiedad" class="form-control" placeholder="Telefono Fijo" value="{{ $personal->anio_propiedad }}" disabled />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: regimen_administrativo --}}
                                                <div class="form-group">
                                                    <label for="regimen_administrativo"><strong>Regimen administrativo<i class="text-danger">* </i> </strong></label>
                                                    <select id="regimen_administrativo" name="regimen_administrativo" class="form-control" required disabled>
                                                        @foreach($regimenes_administrativos as $regimen_administrativo)
                                                        <option value="{{ $regimen_administrativo }}" @if ( $regimen_administrativo==$personal->regimen_administrativo) selected @endif> {{ $regimen_administrativo }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: regimen_docente --}}
                                                <label for="regimen_docente"><strong>Regimen docente<i class="text-danger">* </i> </strong></label>
                                                <select id="regimen_docente" name="regimen_docente" class="form-control" required disabled>
                                                    @foreach($regimenes_docentes as $regimen_docente)
                                                    <option value="{{ $regimen_docente }}" @if ( $regimen_docente==$personal->regimen_docente) selected @endif> {{ $regimen_administrativo }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                        <div class="form-row d-flex justify-content-between ">
                                            <div class="col-6">
                                                {{-- Campo: trabajo_externo --}}
                                                <div class="form-group">
                                                    <label for="trabajo_externo"><strong>Lugar de Trabajo externo<i class="text-danger">* </i> </strong></label>
                                                    <input type="text" name="trabajo_externo" class=" form-control" placeholder="Lugar de trabajo externo" value="{{ $personal->lugar_trabajo_externo}}" required disabled /> </input>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center align-items-center mt-2">
                                                <div>
                                                    {{-- Boton del modal de idiomas --}}
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-rojo" data-toggle="modal" data-target="#idomasModal">
                                                        Ver idiomas
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-12">
                                                {{-- Campo: Direccion Residencia --}}
                                                <div class="form-group">
                                                    <label for="DireccionResidencia"><strong>Dirección Residencia<i class="text-danger">* </i> </strong></label>
                                                    <span data-toggle="tooltip" data-placement="right" title="Lugar de residencia habitual del personal "><i class="far fa-question-circle fa-lg"></i></span><br />
                                                    <textarea type="text" name="direccion_residencia" class="form-control" placeholder="Direccion de residencia" required disabled />{{$personal->persona->direccion_residencia}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            {{-- Campo: experiencia_profesional --}}
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="experiencia_profesional"><strong>Experiencia profecional</strong><br /></label>
                                                    <textarea type="text" name="experiencia_profesional" class="form-control" placeholder="Experiencia Profesional" disabled>{{ $personal->experiencia_profesional }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between pb-5">

                                            {{-- Campo: experiencia_academica --}}
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="experiencia_academica"><strong>Experiencia académica</strong><br /></label>
                                                    <textarea type="text" name="experiencia_academica" class="form-control" placeholder="Experiencia académica" disabled>{{ $personal->experiencia_academica }}</textarea>
                                                </div>
                                            </div>
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
                                                {{-- Campo: cargo --}}
                                                <div class="form-group">
                                                    <label for="cargo"><strong>Tipo de cargo<i class="text-danger">* </i> </strong></label>
                                                    <select id="cargo" name="cargo" class="form-control" required disabled>
                                                        @foreach($cargos as $cargo)
                                                        <option value="{{ $cargo }}" @if ( $cargo==$personal->cargo) selected @endif> {{ $cargo }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- Campo: tipo_puesto --}}
                                                <div class="form-group">
                                                    <label for="tipo_puesto"><strong>Tipo de puesto<i class="text-danger">* </i> </strong></label>
                                                    <select id="tipo_puesto" name="tipo_puesto" class="form-control" required disabled>
                                                        @foreach($tipos_puestos as $tipo_puesto)
                                                        <option value="{{ $tipo_puesto }}" @if ( $tipo_puesto==$personal->tipo_puesto) selected @endif> {{ $tipo_puesto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between">
                                            {{-- Campo: tipo_nombramiento --}}
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="tipo_nombramiento"><strong>Tipo de nombramiento<i class="text-danger">* </i> </strong></label>
                                                    <select id="tipo_nombramiento" name="tipo_nombramiento" class="form-control" required disabled>
                                                        @foreach($tipos_nombramientos as $tipo_nombramiento)
                                                        <option value="{{ $tipo_nombramiento }}" @if ( $tipo_nombramiento==$personal->tipo_nombramiento) selected @endif> {{ $tipo_puesto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- Campo: jornada --}}
                                                <div class="form-group">
                                                    <label for="jornada"><strong>Jornada laboral<i class="text-danger">* </i> </strong></label>
                                                    <select id="jornada" name="jornada" class="form-control" required disabled>
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
                                                    <label for="grado_academico"><strong>Grado académico<i class="text-danger">* </i> </strong></label>
                                                    <select id="grado_academico" name="grado_academico" class="form-control" required disabled>
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
                                                    <input type="text" name="area_especializacion_1" class="form-control" placeholder="Telefono Fijo" value="{{ $personal->area_especializacion_1 }}" disabled />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                {{-- Campo: area_especializacion_2 --}}
                                                <div class="form-group">
                                                    <label for="area_especializacion_2"><strong>Area de especialización 2</strong><br /></label>
                                                    <input type="text" name="area_especializacion_2" class="form-control" placeholder="Telefono Fijo" value="{{ $personal->area_especializacion_2 }}" disabled />
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
                    {{-- Guarda oculto el ID del personal en el detalle --}}
                    <input type="hidden" name="persona_id" value="{{ $personal->persona->persona_id }}"><br>
                    {{-- Boton para enviar los cambios --}}
                    <button type="submit" id="guardar-cambios" class="btn btn-rojo">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('pie')
Copyright
@endsection