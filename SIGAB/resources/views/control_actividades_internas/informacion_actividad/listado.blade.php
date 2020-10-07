@extends('layouts.app')

@section('titulo')
Inicio SIGAB
@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('contenido')
<div class="card">
    <div class="card-body">
        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control Actividades </h2>
            <div>
                {{-- //Botón para añadir actividad interna--}}
                <a href="/actividad-interna/registrar" class="btn btn-rojo"> Añadir Actividad &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
        </div>
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de actividades internas </p>
            </div>
            <div class="card-body">
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}

                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tema</th>
                                <th>Coordinador</th>
                                <th>Estado</th>
                                <th>Propósito</th>
                                <th>Tipo de actividad</th>
                                <td><strong>Ver detalle<br /></strong></td>
                            </tr>
                        </thead>

                        {{-- Nombre de las columnas en la parte de abajode la tabla --}}
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tema</th>
                                <th>Coordinador</th>
                                <th>Estado</th>
                                <th>Propósito</th>
                                <th>Tipo de actividad</th>
                                <td><strong>Ver detalle<br /></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-5 align-self-center">

                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">

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
