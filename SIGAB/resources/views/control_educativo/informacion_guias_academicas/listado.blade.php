@extends('layouts.app')

@section('titulo')
Listado de Guías Académicas
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        @if(Accesos::ACCESO_REGISTRAR_GUIAS_ACADEMICAS())
        {{-- Modal para agregar una guía académica --}}
        @include('modal.agregar-guia-academica')
        @endif

        @if(Accesos::ACCESO_VISUALIZAR_GUIAS_ACADEMICAS()) 
        {{-- Modal para ver el detalle de una guía académica--}}
        @include('modal.detalle-guia-academica')
        @endif

        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Lista de Guías Académicas</h2>

            <div class="d-flex">

                @if(Accesos::ACCESO_LISTAR_ESTUDIANTES()) 
                <div class="mr-2">
                    {{-- Regresar al listado de estudiantes --}}
                    <a href="/listado-estudiantil" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Ir al listado de estudiantes</a>
                </div>
                @endif

                <div class="mr-2">
                    <a href="{{ route('guia-academica.listar') }}" class="btn btn-contorno-rojo"> Listar todo &nbsp; <i class="fas fa-bars"></i> </a>
                </div>

                @if(Accesos::ACCESO_REGISTRAR_GUIAS_ACADEMICAS())
                <div>
                    <button class="btn btn-rojo" data-toggle="modal" data-target="#agregar-guia-modal" data-whatever="Añadir Guía">
                        Añadir Guía Académica &nbsp; <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
                @endif

            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')
        
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de guías académicas</p>
            </div>

            <div class="card-body">
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
                <form action="{{ route('guia-academica.listar') }}" method="GET" role="form" id="item-pagina">
                    <div class="row">
                        <div class="col-md-4 text-nowrap d-flex align-items-end">
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
                        <div class="col-md-8 d-flex justify-content-end">
                            <div class="mx-2 ">
                                <label for="fecha-inicio" class="ml-3"> &nbsp;Fecha inicio: </label>
                                <div class="d-flex">
                                    <span id="fechaIni" class="fechaIni" data-toggle="tooltip" data-placement="bottom" title="Limpiar Fecha de inicio"><i class="far fa-times-circle fa-lg"></i> &nbsp;</span>
                                    <input type="date" class="form-control form-control-sm" name="fechaIni" id="fecha-inicio" @if (!is_null($fechaIni)) value={{ $fechaIni }} @endif>
                                </div>
                            </div>
                            <div class=" mx-3 ">
                                <label for=" fecha-final" class="ml-3"> &nbsp; Fecha final: </label>
                                <div class="d-flex">
                                    <span id="fechaFin" class="fechaFin" data-toggle="tooltip" data-placement="bottom" title="Limpiar Fecha final"><i class="far fa-times-circle fa-lg"></i> &nbsp;</span>
                                    <input type="date" class="form-control form-control-sm" name="fechaFin" id="fecha-final" @if (!is_null($fechaFin)) value={{ $fechaFin }} @endif>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-25">
                                <div class="text-md-right dataTables_filter d-flex align-items-center mt-3">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg"></i></span>
                                    &nbsp;&nbsp;<input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="nombreFiltro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                            <div class="d-flex align-items-center mt-3">
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
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Ciclo lectivo</th>
                                <th>Lugar de atención</th>
                                <th>Ver detalle</th>
                                @if(Accesos::ACCESO_ELIMINAR_GUIAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                            @if(count($guias) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            @foreach($guias as $guia)
                            <tr class="cursor-pointer">
                                <td>{{ $guia->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                <td>{{ $guia->apellido.", ". $guia->nombre }}</td>
                                <td> {{ $guia->tipo }}  </td>
                                <td> {{ date("d-m-Y",strtotime($guia->fecha)) }} </td>
                                <td> {{ $guia->ciclo_lectivo }} </td>
                                <td> {{ $guia->lugar_atencion }}</td>

                                @if(Accesos::ACCESO_VISUALIZAR_GUIAS_ACADEMICAS()) 
                                <td>
                                    {{-- Botón para ver el detalle de la guía académica del estudiante --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-guia-modal" data-idguia="{{ $guia->id }}">
                                        Detalle
                                    </button>
                                </td>
                                @endif

                                @if(Accesos::ACCESO_ELIMINAR_GUIAS_ACADEMICAS())
                                <form action="{{ route('guia-academica.delete',$guia->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <td>
                                        <button class="btn btn-contorno-rojo" onclick="activarLoader('Eliminando guia');"  type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                    </td>
                                @endif

                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>N° de Cédula</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Ciclo lectivo</th>
                                <th>Lugar de atención</th>
                                <th>Ver detalle</th>
                                @if(Accesos::ACCESO_ELIMINAR_GUIAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-3 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $guias->perPage() }} de {{ $guias->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{ $guias->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Variables globales
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    var documentosURL = "{{ URL::asset('/estudiante/guia-academica/download/') }}";
</script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/listado.js') }}" defer></script>
@endsection
