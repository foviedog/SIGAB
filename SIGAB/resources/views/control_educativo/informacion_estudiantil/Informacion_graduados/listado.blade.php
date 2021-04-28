@extends('layouts.app')

@section('titulo')
Listado de Graduados
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@php
$anios = array();
for ($anio = 2000; $anio <= date("Y"); $anio++) { 
    array_push($anios,$anio); 
} 
@endphp 

@section('contenido') 

<div class="card">
    
    <div class="card-body">
        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control de estudiantes graduados</h2>
            <div class="d-flex ">
                <div class="mr-2">
                    <a href="{{ route('graduados.listar') }}" class="btn btn-contorno-rojo"> Listar todo &nbsp; <i class="fas fa-bars"></i> </a>
                </div>
                <div>
                    {{-- //Botón para añadir estudainte --}}
                    <a href=" {{ route('estudiante.create') }}" class="btn btn-rojo"> Añadir Estudiante &nbsp; <i class="fas fa-plus-circle"></i> </a>
                </div>
            </div>
        </div>
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de estudiantes </p>
            </div>
            <div class="card-body">
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
                <form action="{{ route('graduados.listar' ) }}" method="GET" role="form" id="item-pagina">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 d text-nowrap">
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
                        <div class="col-md-9  col-sm-12 d-flex justify-content-end">
                            <div class=" mx-3 w-25">
                                <label for="anio" class="ml-3"> &nbsp; Año de graduación: </label>
                                <div class="d-flex align-items-center">
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <i class="far fa-question-circle fa-lg" data-toggle="tooltip" data-placement="bottom" title="Ver estudiantes graduados en un año determinado"></i>
                                    &nbsp;&nbsp;

                                    <select class="form-control form-control-sm custom-select custom-select-sm" name="anio">
                                        <option value=' '>Sin seleccionar</option>
                                        @foreach($anios as $anio)
                                        <option value={{ $anio }}>{{ $anio }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante por año--}}
                            <div class="d-flex align-items-end ">
                                <button class="btn btn-rojo mr-4" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>
                            <div class="d-flex justify-content-end w-25">
                                <div class="text-md-right dataTables_filter d-flex align-items-end">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg mb-2"></i></span>
                                    &nbsp;&nbsp;<input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="nombreFiltro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                            <div class="d-flex align-items-end ">
                                <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>N° de Cédula</th>
                                <th>Nombre</th>
                                <th>Carrera (Principal) matriculada</th>
                                <th>Teléfono celular</th>
                                <th>Correo</th>
                                <td><strong>Ver detalle<br /></strong></td>
                                <th>Graduaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Si no vienen registros --}}
                            @if(count($graduados) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa de los graduados dentro de la tabla --}}
                            @foreach($graduados as $graduado)
                            <tr id="graduado" class="cursor-pointer">
                                <td>{{ $graduado->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del graduado, si así se desea. --}}
                                <td>{{ $graduado->persona->apellido.", ". $graduado->persona->nombre }}</td>
                                <td>{{ $graduado->carrera_matriculada_1 }} </td>
                                <td>{{ $graduado->persona->telefono_celular }}<br /> </td>
                                <td>
                                    <strong>
                                        {{ $graduado->persona->correo_personal }}
                                    </strong>
                                </td>
                                <td>
                                    {{-- Botón para ver el detalle del estudiante --}}
                                    <strong>
                                        <a href="/estudiante/detalle/{{ $graduado->persona_id }}" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                                <td>
                                    {{-- Botón para ver las guías académicas del estudiante --}}
                                    <strong>
                                        <a href="{{ route('graduado.show', $graduado->persona->persona_id ) }}" class="btn btn-contorno-rojo"> Graduaciones </a>
                                    </strong><br />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <td><strong>N° de Cédula<br /></strong></td>
                                <td><strong>Nombre<strong></td>
                                <td><strong>Carrera (Principal) matriculada<br /></strong></td>
                                <td><strong>Teléfono celular</strong><br /></td>
                                <td><strong>Correo<br /></strong></td>
                                <td><strong>Ver detalle<br /></strong></td>
                                <td><strong>Graduaciones<br /></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-3 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $graduados->perPage() }} de {{ $graduados->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $graduados->withQueryString()->links() }}
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
