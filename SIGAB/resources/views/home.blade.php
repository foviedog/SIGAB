@extends('layouts.app')

@section('titulo')
SIGAB
@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('contenido')
<div class="card" style="height: 750px;">
    <div class="card-body">

        <div class="d-flex justify-content-center my-4">
            <img src="/img/logoSIGAB.png">
        </div>

        <div class="row px-5 py-4">
            <div class="col">
                <div class="card shadow p-3 mb-5 rounded" style="background-color:#f5f5f5;">
                    <div class="card-body">
                        <div class="d-flex">
                        <h4 class="font-weight-bold">Control estudiantil</h4><i class="fas fa-graduation-cap ml-4 fa-2x"></i></div>
                        <hr>
                        <a href="{{ route('estudiante.create' ) }}"><h6 class="card-subtitle mb-2 link-inicio">Añadir estudiantes</h6></a>
                        <a href="{{ route('listado-estudiantil' ) }}" ><h6 class="card-subtitle mb-2 link-inicio">Estudiantes</h6></a>
                        <a href="{{ route('graduados.listar' ) }}"><h6 class="card-subtitle mb-2 link-inicio">Estudiantes Graduados</h6></a>
                        <a href="{{ route('guia-academica.listar' ) }}"><h6 class="card-subtitle mb-2 link-inicio">Guías académicas</h6></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3 mb-5 rounded" style="background-color:#f5f5f5;">
                    <div class="card-body">
                        <div class="d-flex">
                            <h4 class="font-weight-bold">Control del personal</h4><i class="far fa-address-book ml-4 fa-2x" style="width: 32px;"></i></div>
                            <hr>
                            <a href="{{ route('personal.create') }}"><h6 class="card-subtitle mb-2 link-inicio">Añadir personal</h6></a>
                            <a href="{{ route('personal.listar' ) }}"><h6 class="card-subtitle mb-2 link-inicio">Personal de la EBDI</h6></a>
                            <a href="#"><h6 class="card-subtitle mb-2 link-inicio">&nbsp;</h6></a>
                            <a href="#"><h6 class="card-subtitle mb-2 link-inicio">&nbsp;</h6></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3 mb-5 rounded" style="background-color:#f5f5f5;">
                    <div class="card-body">
                        <div class="d-flex">
                            <h4 class="font-weight-bold">Control de actividades</h4><i class="fas fa-chalkboard-teacher ml-4 fa-2x" style="width: 32px;"></i></div>
                            <hr>
                            <a href="/actividad-interna/registrar"><h6 class="card-subtitle mb-2 link-inicio">Añadir actividades Internas</h6></a>
                            <a href="#"><h6 class="card-subtitle mb-2 link-inicio">Añadir actividades de promoción</h6></a>
                            <a href="{{ route('listado-actividad-interna' ) }}"><h6 class="card-subtitle mb-2 link-inicio">Actividades Internas</h6></a>
                            <a href="#"><h6 class="card-subtitle mb-2 link-inicio">Actividades de promoción</h6></a>
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
