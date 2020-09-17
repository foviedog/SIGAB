@extends('layouts.app')

@section('titulo')
Trabajos de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
{{-- Ningún script de estilo por el momento --}}
@endsection

@section('contenido')

<div class="card">
    <div class="card-body">
        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Trabajos de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                {{-- //Botón para añadir trabajo --}}
                <a href="/trabajo/registrar/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"> Añadir nuevo trabajo &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
        </div>
        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Trabajos</p>
            </div>
            <div class="card-body">
                {{-- Form para la paginación de la página y para la búsqueda de trabajos --}}
                <form action="/trabajo/{{ $estudiante->persona->persona_id }}" method="GET" role="form" id="item-pagina">
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
                                <th>Nombre de la organización</th>
                                <th>Cargo actual</th>
                                <th>Jornada laboral</th>
                                <th>Ver más</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($trabajos))
                            {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                            @foreach($trabajos as $trabajo)
                            <tr id="trabajo" class="cursor-pointer">
                                <td>{{ $trabajo->nombre_organizacion }}</td>
                                <td>{{ $trabajo->cargo_actual }} </td>
                                <td>{{ $trabajo->jornada_laboral }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información del trabajo --}}
                                    <strong>
                                        <a href="#" class="btn btn-contorno-rojo"> Ver más </a>
                                    </strong><br />
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <td>
                                No existen registros aún
                            </td>
                            @endif
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre de la organización</th>
                                <th>Cargo actual</th>
                                <th>Jornada laboral</th>
                                <th>Ver más</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $trabajos->perPage() }} de {{ $trabajos->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{ $trabajos->withQueryString()->links() }}
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
