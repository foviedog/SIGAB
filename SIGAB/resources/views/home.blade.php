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
                                        <div class="row card-info  ">
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
                                                    <div class="ml-2 texto-info">Academicos</div>
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
                <div class="card-body" style="max-height: 300px;">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control estudiantil</h4><i class="fas fa-book texto-rojo-medio  fa-2x"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
                    <a href="{{ route('estudiante.create') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Añadir estudiantes</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_ESTUDIANTES())
                    <a href="{{ route('listado-estudiantil') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Estudiantes</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_GRADUADOS())
                    <a href="{{ route('graduados.listar') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Estudiantes Graduados</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_VISUALIZAR_GUIAS_ACADEMICAS())
                    <a href="{{ route('guia-academica.listar') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Guías académicas</h6>
                    </a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow p-3 mb-5 rounded" >
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control del personal</h4><i class="far fa-address-book texto-rojo-medio  fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_PERSONAL())
                    <a href="{{ route('personal.create') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Añadir personal</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_PERSONAL())
                    <a href="{{ route('personal.listar') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Personal de la EBDI</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <a href="{{ route('reportes-involucramiento.show') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Reporte general </h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <a href="{{ route('reportes-involucramiento.anual') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Reporte anual</h6>
                    </a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="font-weight-bold mr-3">Control de actividades</h4><i class="fas fa-chalkboard-teacher  texto-rojo-medio fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>

                    @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
                    <a href="/actividad-interna/registrar">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Añadir actividades Internas</h6>
                    </a>

                    <a href="/actividad-promocion/registrar">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Añadir actividades de promoción</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
                    <a href="{{ route('actividad-interna.listado') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Actividades Internas</h6>
                    </a>

                    <a href="{{ route('actividad-promocion.listado') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Actividades de promoción</h6>
                    </a>
                    @endif

                    @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
                    <a href="{{ route('reportes-actividades.show') }}">
                        <h6 class="card-subtitle mb-3 link-inicio"><i class="fas fa-caret-right texto-azul-una"></i> Reportes </h6>
                    </a>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
{{-- Ningún script por el momento --}}
@endsection
