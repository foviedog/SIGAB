@extends('layouts.app')

@section('titulo')
SIGAB
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')

<div class="card-body ">

    {{-- Alerts --}}
    @include('layouts.messages.alerts')

    {{-- Inicio de bloque de información --}}
    <div class="container-fluid px-5">
        {{-- Fila que sepera las dos columnas de resumenes--}}
        <div class="row d-flex justify-content-between">

            {{-- Primera carta de resumen --}}
            <div class="col-xl-6 col-lg-12 ">
                <div class="container">
                    <div class="row card shadow px-4 ">
                        <div class="card-body">
                            <div class="border-bottom p-0">
                                <h4 class="font-weight-bold">Resumen de estudiantes</h4>
                            </div>
                            {{-- Contenedor de las cartas pequeñas de información horizonales --}}
                            <div class="container  py-3">
                                <div class="row">
                                    {{-- Carta de estudiantes totales --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-school fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Estudiantes</div>
                                                    <div class="ml-2 numero-info">{{ $estudiantesTotales }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de conteo de graduados --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-user-graduate fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Graduados</div>
                                                    <div class="ml-2 numero-info">{{ $graduados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de graduaciones totales --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-graduation-cap fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Graduaciones</div>
                                                    <div class="ml-2 numero-info">{{ $graduacionesTotales }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de guías académicas totales --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-comments fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Guías académica</div>
                                                    <div class="ml-2 numero-info">{{ $guiasAcademicasTotales }}</div>
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

            {{-- Segunda carta de información --}}
            <div class="col-xl-6 col-lg-12 ">
                <div class="container">
                    <div class="row card shadow px-4 ">
                        <div class="card-body">
                            <div class="border-bottom p-0">
                                <h4 class="font-weight-bold">Resumen de personal</h4>
                            </div>
                            <div class="container py-3">
                                <div class="row">
                                    {{-- Carta de personal total --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-user fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Personal total</div>
                                                    <div class="ml-2 numero-info">{{ $personalTotal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de cantidad de administrativos --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-briefcase fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Administrativos</div>
                                                    <div class="ml-2 numero-info">{{ $administrativos }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de cantidad de académicos --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="row card-info  ">
                                            <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                                <i class="fas fa-chalkboard-teacher fa-2x texto-rojo-medio"></i>
                                            </div>
                                            <div class="col-8 p-0 ">
                                                <div class="border-left">
                                                    <div class="ml-2 texto-info">Académicos</div>
                                                    <div class="ml-2 numero-info">{{ $academicos }}</div>
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
        </div>
    </div>

    {{-- Cartas de resumen --}}
    <div class="row px-5 mt-5">

        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body" style="min-height: 250px;">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control estudiantil</h4><i class="fas fa-book texto-rojo-medio  fa-2x"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('estudiante.create') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Añadir estudiantes
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_ESTUDIANTES())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('listado-estudiantil') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Estudiantes
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_GRADUADOS())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('graduados.listar') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Estudiantes Graduados
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_VISUALIZAR_GUIAS_ACADEMICAS())
                    <div>
                        <a href="{{ route('guia-academica.listar') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Guías académicas
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow p-3 mb-5 rounded" >
                <div class="card-body" style="min-height: 250px;">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control del personal</h4><i class="far fa-address-book texto-rojo-medio  fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_PERSONAL())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('personal.create') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Añadir personal
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_PERSONAL())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('personal.listar') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Personal de la EBDI
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('reportes-involucramiento.show') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Reporte general 
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('reportes-involucramiento.anual') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Reporte anual
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body"  style="min-height: 250px;">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control de actividades</h4><i class="fas fa-chalkboard-teacher  texto-rojo-medio fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('actividad-interna.create') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Añadir actividades Internas
                        </a>
                    </div>

                    <div class="link-inicio-contenedor">
                        <a href="{{ route('actividad-promocion.create') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Añadir actividades de promoción
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('actividad-interna.listado') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Actividades Internas
                        </a>
                    </div>

                    <div class="link-inicio-contenedor">
                        <a href="{{ route('actividad-promocion.listado') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Actividades de promoción
                        </a>
                    </div>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <div class="link-inicio-contenedor">
                        <a href="{{ route('reportes-actividades.show') }}" class="card-subtitle mb-3 link-inicio">
                            <i class="fas fa-caret-right texto-azul-una"></i> Reportes 
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    {{-- Tarjeta de información personal --}}
    <div class="container-fluid px-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card shadow p-3 rounded border-info-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <i class="fas fa-users texto-rojo-medio fa-2x"></i><h4 class="font-weight-bold ml-3">Datos personales</h4>
                        </div>
                        <hr>

                        <div class="row ">

                            {{-- Datos personales --}}
                            <div class="col text-center">
                                <img src="{{ asset('img/fotos/'.$persona->imagen_perfil) }}" class="mb-3 img-fluid" id="imagen-personal" style="max-width: 160px; max-height: 160px; border-radius: 10%;" />
                                                            
                                <div class="card-subtitle my-3">{{ $persona->nombre." ".$persona->apellido }}</div>
                        
                                <div class="card-subtitle font-weight-bold mb-3">{{ session()->get('rol') }}</div>
                            
                            </div>

                            {{-- Accesos --}}
                            <div class="col mt-4">

                                <div class="link-inicio-contenedor">
                                    <a href="{{ route('perfil.show') }}" class="my-3 card-subtitle mb-3 link-inicio link-card">
                                        <i class="fas fa-caret-right texto-azul-una"></i> Mi perfil</h6>
                                    </a>
                                </div>

                                <div class="link-inicio-contenedor">
                                    <a href="{{ route('perfil.notifications') }}" class="my-3 card-subtitle mb-3 link-inicio">
                                        <i class="fas fa-caret-right texto-azul-una"></i> Mis notificaciones
                                    </a>
                                </div>

                                <div class="link-inicio-contenedor">
                                    <a href="{{ route('perfil.mis-actividades') }}" class="my-3 card-subtitle mb-3 link-inicio">
                                        <i class="fas fa-caret-right texto-azul-una"></i> Mis actividades</h6>
                                    </a>
                                </div>

                                <div class="link-inicio-contenedor">
                                    <a href="{{ route('perfil.actualizar-contrasenna') }}" class="my-3 card-subtitle mb-3 link-inicio">
                                        <i class="fas fa-caret-right texto-azul-una"></i> Cambiar contraseña</h6>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
{{-- Ningún script por el momento --}}
@endsection
