@extends('layouts.app')

@section('titulo')
Listado Estudiantil
@endsection

@section('css')

@endsection



@section('contenido')

<div class="card">
    <div class="card-body">
        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control Estudiantil</h2>
            <div>
                {{-- //Botón para añadir estudainte --}}
                <a href="/estudiante/registrar" class="btn btn-rojo"> Añadir Estudiante &nbsp; <i class="fas fa-plus-circle"></i> </a>
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
                <form action="listado-estudiantil" method="GET" role="form" id="item-pagina">
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
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="d-flex justify-content-end w-50">
                                <div class="text-md-right dataTables_filter input-group mb-3 ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg"></i></span>
                                    &nbsp;&nbsp; <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="filtro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                            <div>
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
                                <th>Guía Académica</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($estudiantes) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7" > <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                            @foreach($estudiantes as $estudiante)
                            <tr id="estudiante" class="cursor-pointer">
                                <td>{{ $estudiante->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                <td>{{ $estudiante->persona->apellido.", ". $estudiante->persona->nombre }}</td>
                                <td>{{ $estudiante->carrera_matriculada_1 }} </td>
                                <td>{{ $estudiante->persona->telefono_celular }}<br /> </td>
                                <td>
                                    <strong>
                                        {{ $estudiante->persona->correo_personal }}
                                    </strong>
                                </td>
                                <td>
                                    {{-- Botón para ver el detalle del estudiante --}}
                                    <strong>
                                        <a href="/estudiante/detalle/{{ $estudiante->persona_id }}" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                                <td>
                                    {{-- Botón para ver las guías académicas del estudiante --}}
                                    <strong>
                                        <a href="/estudiante/guia-academica/listar?nombreFiltro={{ $estudiante->persona_id }}" class="btn btn-contorno-rojo"> Ver guías </a>
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
                                <td><strong>Teléfono Celular</strong><br /></td>
                                <td><strong>Correo<br /></strong></td>
                                <td><strong>Ver detalle<br /></strong></td>
                                <td><strong>Guia académica<br /></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-5 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $estudiantes->perPage() }} de {{ $estudiantes->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $estudiantes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection


@section('scripts')

@endsection

@section('pie')
Copyright
@endsection
