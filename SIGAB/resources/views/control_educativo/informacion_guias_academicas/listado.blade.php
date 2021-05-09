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
                    <a href="{{ route('listado-estudiantil') }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Ir al listado de estudiantes</a>
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
                <form autocomplete="off" action="{{ route('guia-academica.listar') }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-9 col-lg-7 d-flex ">
                            {{-- Busqueda por rango de fechas --}}
                            <div class="input-group d-flex justify-content-between mr-2">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text texto-azul-una font-weight-bold">
                                        &nbsp;Fechas &nbsp;
                                    </span>
                                </div>
                                <input type="text" class="form-control  datetimepicker" name="rango_fechas" id="rango_fechas" placeholder="DD/MM/YYYY - DD/MM/YYYY" value="{{ $rango_fechas ?? null }}">
                                <div class="input-group-append">
                                    <span class="btn btn-contorno-rojo" data-toggle="tooltip" data-placement="top" title="Vaciar el campo de fecha" onclick="eliminarFechas(this);"><i class="fas fa-calendar-times fa-lg"></i></span>
                                </div>
                            </div>
                            <div class="input-group ">
                                <div class="input-group-prepend ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                </div>
                                <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="nombreFiltro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                            </div>
                            <div class="d-flex justify-content-center" style="width: 30%">
                                <button class="btn btn-rojo" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        {{-- Cantidad de items --}}
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
                                        <button class="btn btn-contorno-rojo" onclick="activarLoader('Eliminando guia');" type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
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

{{-- Scripts para el DatePicker utilizado en el filtro de fecha --}}
<script src="{{ asset('js/global/inputs.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
