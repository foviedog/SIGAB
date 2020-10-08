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
                <form action="listado-actividad-interna" method="GET" role="form" id="item-pagina">
                    <div class="row">
                        <div class="col-md-6 text-nowrap">
                            <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                <label class="font-weight-bold">Mostrar &nbsp;
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                        @foreach($paginaciones as $paginacion)
                                        <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>ID Actividad</th>
                                <th>Tema</th>
                                <th>ID Coordinador</th>
                                <th>Estado</th>
                                <th>Propósito</th>
                                <th>Tipo de actividad</th>
                                <td><strong>Ver detalle<br /></strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($actividadesInternas) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa de las actividades a la tabla --}}
                            @foreach($actividadesInternas as $actividadInterna)
                            <tr id="estudiante" class="cursor-pointer">
                                <td>{{ $actividadInterna->actividad_id }}</td>
                                <td>{{ $actividadInterna->actividades->tema}}</td>
                                <td>{{ $actividadInterna->actividades->responsable_coordinar }} </td>
                                <td>{{ $actividadInterna->actividades->estado }}
                                <td>{{ $actividadInterna->proposito }} </td>
                                <td>{{ $actividadInterna->tipo_actividad }} </td><br /> </td>
                                <td>
                                    {{-- Botón para ver el detalle de la actividad --}}
                                    <strong>
                                        <a href="#" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Nombre de las columnas en la parte de abajode la tabla --}}
                        <tfoot>
                            <tr>
                                <th>ID Actividad</th>
                                <th>Tema</th>
                                <th>ID Coordinador</th>
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
