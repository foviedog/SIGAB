@extends('layouts.app')

@section('titulo')
Listado de Graduados
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@php
$anios = GlobalFunctions::obtenerAniosFuturos();
@endphp 

@section('contenido') <div class="card">

    <div class="card-body">
        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control de estudiantes graduados</h2>
            <div class="d-flex ">
                <div class="mr-2">
                    <a href="{{ route('graduados.listar') }}" class="btn btn-contorno-rojo"> Listar todo &nbsp; <i class="fas fa-bars"></i> </a>
                </div>

                @if(Accesos::ACCESO_REGISTRAR_ESTUDIANTES())
                <div>
                    {{-- //Botón para añadir estudiante --}}
                    <a href=" {{ route('estudiante.create') }}" class="btn btn-rojo"> Añadir Estudiante &nbsp; <i class="fas fa-plus-circle"></i> </a>
                </div>
                @endif

            </div>
        </div>
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de estudiantes </p>
            </div>
            <div class="card-body">

                @if(Accesos::ACCESO_BUSCAR_GRADUADOS())
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
                <form autocomplete="off" action="{{ route('graduados.listar') }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between">

                        <div class="col-md-10 d-flex ">

                            <div class="input-group d-flex justify-content-between mr-2">
                                <div class="input-group-prepend ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Ver estudiantes graduados en un año determinado"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                </div>
                                <select class="form-control form-control-md " name="anio">
                                    <option value=' '>Sin seleccionar</option>
                                    @foreach($anios as $anio2)
                                    <option value="{{ $anio2 }}" @if ( $anio !=null) @if ( $anio2==$anio) selected @endif @endif> {{ $anio2 }} </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante por año--}}
                            <div class="d-flex justify-content-center" style="width: 30%">
                                <button class="btn btn-rojo" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>

                            <div class="input-group ">
                                <div class="input-group-prepend ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                </div>
                                <input type="search" class="form-control form-control-md " placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="nombreFiltro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                            </div>
                            <div class="d-flex justify-content-center" style="width: 30%">
                                <button class="btn btn-rojo" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>

                        </div>
                        <div class="col-2 text-nowrap d-flex justify-content-end">
                            <label class="font-weight-bold " for="itemsPagina">Mostrar &nbsp;</label>
                            {{-- Select con la cantidad de items por páginas--}}
                            <div class="w-50">
                                <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                    @foreach($paginaciones as $paginacion)
                                    <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                @endif

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
                                <th>Ver detalle</th>
                                @if(Accesos::ACCESO_LISTAR_TITULACIONES())
                                <th>Graduaciones</th>
                                @endif
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
                                        <a href="{{ route('estudiante.show', $graduado->persona->persona_id ) }}" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                                <td>
                                    @if(Accesos::ACCESO_LISTAR_TITULACIONES())
                                    {{-- Botón para ver las graduaciones del estudiante --}}
                                    <strong>
                                        <a href="{{ route('graduado.show', $graduado->persona->persona_id ) }}" class="btn btn-contorno-rojo"> Graduaciones </a>
                                    </strong><br />
                                    @endif
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
                                @if(Accesos::ACCESO_LISTAR_TITULACIONES())
                                <td><strong>Graduaciones<br /></strong></td>
                                @endif
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
