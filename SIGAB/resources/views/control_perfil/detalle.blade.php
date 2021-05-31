@extends('layouts.app')

@section('titulo')
Mi perfil
@endsection

@section('css')
<style>
#dropdown-perfil{
    padding: 0px !important;
    box-shadow: none !important;
}
</style>
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$generos = GlobalArrays::GENEROS;
$estadosCiviles = GlobalArrays::ESTADOS_CIVILES;
@endphp

@section('contenido')

<header class="page-header page-header-dark bg-red-polygon py-5 overflow-hidden">
    <div class="container py-5">
    </div>
</header>
{{-- Formulario general de estudiante --}}
<form autocomplete="off" action="{{ route('perfil.update', $persona->persona_id) }}" method="POST" role="form" enctype="multipart/form-data" id="persona-form">
    @csrf
    @method('PATCH')

    <div class="container-fluid container-pefil" style="margin-top: -4.4rem; padding-left: 10rem ; ">
        <div class="row">
            <div class="col-3 info-gen-perfil">
                <div class="card shadow pb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3 mt-4">
                            <div class="overflow-hidden rounded-circle d-flex justify-content-center" style="max-width: 202px; max-height: 202px;">
                                <img class="" src="{{ asset('img/fotos/'.$persona->imagen_perfil) }}" style="max-width: 100%; object-fit: cover;" />
                            </div>
                        </div>
                        <div id="cambiar-foto" class="mb-3">
                            <input type="file" name="avatar" class="border" id="avatar" style="display: none;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        {{-- Nombre completo de usario --}}
                        <div class="d-flex justify-content-center text-center border-top pt-2">
                            <small class="texto-negro font-weight-bold" style="font-size: 20px;">
                                {{ $persona->nombre ." ". $persona->apellido}}
                            </small>
                        </div>
                        {{-- Cedula de usuario --}}
                        <div class="d-flex justify-content-center my-3 text-muted" data-toggle="tooltip" data-placement="bottom" title="Cédula del usuario">
                            <i class="fa fa-id-card mr-1 mt-2 texto-rojo"></i>
                            <small style="font-size: 18px;">
                                {{ $persona->persona_id }}
                            </small>
                        </div>
                        <div class="mt-5 mb-2">
                            <div class="d-flex justify-content-center py-2 border-top border-bottom">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-4  d-flex justify-content-end">
                                            <div class="overflow-hidden" style="max-width: 65%;">
                                                <img src="{{ asset('img/recursos/iconos/administrativo2.png') }}" style="max-width: 100%;" class="rounded-circle" />
                                            </div>
                                        </div>

                                        <div class="col-8 px-0 d-flex align-items-center">
                                            <div style="font-size: 16px;">
                                                @if ($persona->personal)
                                                {{ $persona->personal->cargo }}
                                                @elseif($persona->estudiante)
                                                {{ $persona->estudiante->carrera_matriculada_1}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="d-flex justify-content-center py-2 border-bottom">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-4  d-flex justify-content-end">
                                            <div class="overflow-hidden" style="max-width: 65%;">
                                                @if ($persona->personal)
                                                <img src="{{ asset('img/recursos/iconos/time2.png') }}" style="max-width: 100%;"  class="rounded-circle"/>
                                                @else
                                                <img src="{{ asset('img/recursos/iconos/dinero.png') }}" style="max-width: 100%;" class="rounded-circle" />
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-8 px-0 d-flex align-items-center">
                                            <div class="" style="font-size: 16px;">
                                                @if ($persona->personal)
                                                {{ $persona->personal->jornada }}
                                                @elseif ($persona->estudiante)
                                                {{ $persona->estudiante->tipo_beca }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between header-perfil">
                            <div>
                                <h3 class="texto-rojo-medio font-weight-light m-0 texto-rojo pb-3">Configuración de la cuenta </h3>
                            </div>
                            <div>

                                <nav class="navbar navbar-expand-lg" style="float: left" id="dropdown-perfil">
                                    <div class="collapse navbar-collapse">
                                        <ul class="navbar-nav mr-auto">
                                        <li class="nav-item dropdown">
                                            <a class="dropdown-toggle btn btn-contorno-rojo mr-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Mis accesos personales
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                {{-- Botón para acceder a las notificaciones --}}
                                                <a href="{{ route('perfil.notifications') }}" class="dropdown-item"><i class="fas fa-bell"></i> &nbsp; Notificaciones </a>
                                                {{-- Botón para ver las actividades que ha registrado --}}
                                                <a href="{{ route('perfil.mis-actividades') }}" class="dropdown-item"><i class="fas fa-chalkboard-teacher"></i> &nbsp; Mis actividades</a>
                                                {{-- Botón para cambiar contrasenna --}}
                                                <a href="{{ route('perfil.actualizar-contrasenna') }}" class="dropdown-item"><i class="fas fa-key"></i> &nbsp; Cambiar contraseña</a>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </nav>
                                {{-- Botón para regresar a la página principal --}}
                                <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                                {{-- Boton que habilita opcion de editar --}}
                                <button type="button" id="editar-actividad" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                                {{-- Boton de cancelar edicion --}}
                                <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        {{-- Correos  --}}
                        <div class="form-row px-5 mt-3">
                            {{-- Campo: Correo personal --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label>
                                    <span class="text-muted" id="mostrar_correo_personal"></span>
                                    <input type="email" name="correo_personal" id="correo_personal" class="form-control" onkeyup="contarCaracteres(this,45)" placeholder="Correo Personal" value="{{ $persona->correo_personal }}" disabled />
                                </div>
                            </div>
                            {{-- Correo Institucional --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="correo_institucional"><strong>Correo Institucional<i class="text-danger">* </i> </strong><br /></label>
                                    <span class="text-muted" id="mostrar_correo_institucional"></span>
                                    <input type="email" name="correo_institucional" id="correo_institucional" class="form-control" onkeyup="contarCaracteres(this,45)" placeholder="Correo Institucional" value="{{ $persona->correo_institucional }}" required disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Telefonos --}}
                        <div class="form-row px-5 mt-3">
                            {{-- Celular --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_telefono_celular"></span>
                                    <input type="text" name="telefono_celular" id="telefono_celular" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Celular" value="{{ $persona->telefono_celular}}" disabled />
                                </div>
                            </div>
                            {{-- Telefono Fijo --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_telefono_fijo"></span>
                                    <input type="text" name="telefono_fijo" id="telefono_fijo" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Fijo" value="{{ $persona->telefono_fijo }}" disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Estado civil, genero y fecha de nacimiento --}}
                        <div class="form-row px-5 mt-3">
                            {{-- Estado civil --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="estadoCivil"><strong>Estado Civil <i class="text-danger">* </i></strong></label>
                                    <select id="estado_civil" name="estado_civil" class="form-control" required disabled>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($estadosCiviles as $estadoCivil)
                                        <option value='{{ $estadoCivil }}' @if ( $estadoCivil==$persona->estado_civil) selected @endif> {{ $estadoCivil }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Genero --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="genero"><strong>Género <i class="text-danger">* </i></strong></label>
                                    <select id="genero" name="genero" class="form-control w-100" required disabled>
                                        @foreach($generos as $genero)
                                        <option value='{{ $genero }}' @if ( $genero==$persona->genero) selected @endif> {{ $genero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento <i class="text-danger">* </i></strong><br /></label><input type='date' name="fecha_nacimiento" class="form-control" placeholder="Fecha Nacimiento" value={{$persona->fecha_nacimiento}} required disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Direccion--}}
                        <div class="form-row px-5 mt-3">
                            <div class="col-12">
                                {{-- Campo: Direccion Residencia --}}
                                <div class="form-group">
                                    <label for="DireccionResidencia"><strong>Dirección Residencia <i class="text-danger">* </i></strong></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Lugar de residencia habitual del usuario "><i class="far fa-question-circle fa-lg"></i></span>
                                    <span class="text-muted" id="mostrar_direccion_residencia"> </span>
                                    <textarea type="text" name="direccion_residencia" id="direccion_residencia" class="form-control" onkeyup="contarCaracteres(this,250)" placeholder="Direccion de residencia" required disabled />{{$persona->direccion_residencia}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer pb-3" id="card-footer">
                        <div class="d-flex justify-content-center">
                            {{-- Boton para enviar los cambios --}}
                            <button type="submit" id="guardar-cambios" class="btn btn-rojo" style="display: none;">Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>

@endsection

@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
</script>
<script src="{{ asset('js/control_actividades_internas/detalle_editar.js') }}" defer></script>
<script src="{{ asset('js/control_educativo/detalle_editar.js') }}" defer></script>
<script src="{{ asset('js/global/validacionesImagenPerfil.js') }}" crossorigin="anonymous"></script>
@endsection
