@extends('layouts.app')

@section('titulo')
Listado de Cursos
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">
        {{-- Items de la parte superior--}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control Cursos</h2>
            <div>

                @if(Accesos::ACCESO_REGISTRAR_CURSOS())
                {{-- Botón para añadir curso--}}
                <a href="{{ route('cursos.create') }}" class="btn btn-rojo"> Añadir Curso &nbsp; <i class="fas fa-plus-circle"></i> </a>
                @endif

            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                {{-- Título de la tabla --}}
                <h5 class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de Cursos</h5>
                <div>
                    <form action="{{ route('cursos.index') }}" method="GET" id="form-busqueda">
                        <button type="submit" class="btn btn-contorno-azul-una" id="btn-listar-todo"><i class="fas fa-redo"></i>&nbsp; Listar todo </button>
                    </form>
                </div>
            </div>
            <div class="card-body">

                {{-- Formulario para la paginación--}}
                <form autocomplete="off" action="{{ route('cursos.index') }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between mb-2 ">
                        <div class="col-6 d-flex justify-content-start">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="filtro" name="filtro" placeholder="Buscar cursos" value="{{ $filtro ?? ''  }}">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-bullhorn texto-azul-una"></i></div>
                                </div>
                                <button type="submit" class="btn btn-rojo  ml-3 mr-2 d-flex">Buscar <i class="fas fa-search ml-2 mt-1"></i> </button>
                            </div>
                        </div>

                        <div class="col-4 text-nowrap">
                            <div class="d-flex justify-content-end">
                                <label class="font-weight-bold" for="itemsPagina">Mostrar &nbsp;</label>
                                <div class="w-25">
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                        @foreach($paginaciones as $paginacion)
                                        <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>NRC</th>
                                @if(Accesos::ACCESO_VISUALIZAR_CURSOS())
                                <th>Ver detalle</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($cursos) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg">
                                    </i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa de cursos a la tabla --}}
                            @foreach($cursos as $curso)
                            <tr id="internas" class="cursor-pointer">
                                <td>{{ $curso->codigo }}</td>
                                <td>{{ $curso->nombre}}</td>
                                <td>{{ $curso->nrc }} </td>
                                @if(Accesos::ACCESO_VISUALIZAR_CURSOS())
                                <td>
                                    {{-- Botón para ver el detalle de curso--}}
                                    <strong>
                                        <a href="{{ route('cursos.show', $curso->codigo) }}" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Nombre de las columnas en la parte de abajode la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>NRC</th>
                                @if(Accesos::ACCESO_VISUALIZAR_CURSOS())
                                <th>Ver detalle</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-5 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$cursos->perPage() }} items de un total de {{ $cursos->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $cursos->withQueryString()->links() }}
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
