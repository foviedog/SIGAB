@extends('layouts.app')

@section('titulo')
SIGAB
@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('contenido')

<div class="card-body">


    <div class="row px-5 ">
        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="font-weight-bold">Control estudiantil</h4><i class="fas fa-graduation-cap ml-4 fa-2x"></i>
                    </div>
                    <hr>
                    <a href="{{ route('estudiante.create') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Añadir estudiantes</h6>
                    </a>
                    <a href="{{ route('listado-estudiantil') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Estudiantes</h6>
                    </a>
                    <a href="{{ route('graduados.listar') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Estudiantes Graduados</h6>
                    </a>
                    <a href="{{ route('guia-academica.listar') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Guías académicas</h6>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="font-weight-bold">Control del personal</h4><i class="far fa-address-book ml-4 fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>
                    <a href="{{ route('personal.create') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Añadir personal</h6>
                    </a>
                    <a href="{{ route('personal.listar') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Personal de la EBDI</h6>
                    </a>
                    <a href="#">
                        <h6 class="card-subtitle mb-2 link-inicio">&nbsp;</h6>
                    </a>
                    <a href="#">
                        <h6 class="card-subtitle mb-2 link-inicio">&nbsp;</h6>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow p-3 mb-5 rounded">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="font-weight-bold">Control de actividades</h4><i class="fas fa-chalkboard-teacher ml-4 fa-2x" style="width: 32px;"></i>
                    </div>
                    <hr>
                    <a href="/actividad-interna/registrar">
                        <h6 class="card-subtitle mb-2 link-inicio">Añadir actividades Internas</h6>
                    </a>
                    <a href="#">
                        <h6 class="card-subtitle mb-2 link-inicio">Añadir actividades de promoción</h6>
                    </a>
                    <a href="{{ route('actividad-interna.listado') }}">
                        <h6 class="card-subtitle mb-2 link-inicio">Actividades Internas</h6>
                    </a>
                    <a href="#">
                        <h6 class="card-subtitle mb-2 link-inicio">Actividades de promoción</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-primary">

    </div>

    {{-- Inicio de bloque de información --}}
    <div class="container-fluid px-5">
        {{-- Fila que sepera las dos columnas de resumenes--}}
        <div class="row d-flex justify-content-between">

            {{-- primera carta de resumen --}}
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="container">
                    <div class="row card shadow px-4 ">
                        <div class="card-body">
                            <div class="border-bottom p-0">
                                <h4 class="font-weight-bold">Resumen de estudiantes</h4>
                            </div>
                            {{-- contenedor de las cartas pequeñas de información
                                horizonales --}}
                            <div class="container">
                                <div class="row">
                                    {{-- Carta de estudiantes totales
                                        --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/user.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Estudiantes totales</h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $estudiantesTotales }}</span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de conteo de graduados
                                        --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/graduado.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Graduados</h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $graduados }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carta de graduaciones totales
                                        --}}
                                    <div class="col-lg-12 col-xl-6  ">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/graduadoSombrero.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Graduaciones </h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $graduacionesTotales }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Carta de guías académicas totales
                                        --}}
                                    <div class="col-lg-12 col-xl-6 ">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/hoja.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Guías académicas</h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $guiasAcademicasTotales }}</span>
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

            {{-- Segunda carta de información --}}
            <div class="col-xl-6 col-lg-12 ">
                <div class="container">
                    <div class="row card shadow px-4 ">
                        <div class="card-body">
                            <div class="border-bottom p-0">
                                <h4 class="font-weight-bold">Resumen de personal</h4>
                            </div>
                            <div class="container">
                                <div class="row">
                                    {{-- Carta de personal total
                                        --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/user.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Personal total</h5>
                                                        <span class="p-0" style="font-size: 165%"> {{ $personalTotal }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- carta de cantidad de administrativos
                                        --}}
                                    <div class="col-lg-12 col-xl-6 py-3">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/administrativo.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Administrativos</h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $administrativos }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- carta de cantidad de académicos
                                        --}}
                                    <div class="col-lg-12 col-xl-6 ">
                                        <div class="card mb-3 shadow">
                                            <div class="row g-0 d-flex">
                                                <div class="col-md-3 pl-4 pr-1">
                                                    <img class="rounded-circle py-3 " src="/img/recursos/iconos/academico.png" style="max-width: 150%;">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body p-0 text-center">
                                                        <h5 class="pt-3 m-0">Academicos </h5>
                                                        <span class="p-0" style="font-size: 165%">{{ $academicos }}</span>
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
    </div>

</div>

@endsection

@section('pie')
Copyright
@endsection
