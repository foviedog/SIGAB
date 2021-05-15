@extends('layouts.app')

@section('titulo')
Actividades de promoción
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$tiposActividad = GlobalArrays::TIPOS_ACTIVIDAD_PROMOCION;
$estados = GlobalArrays::ESTADOS_ACTIVIDAD;
@endphp

@section('contenido')

<div class="card">
    <div class="card-body">
        {{-- Items de la parte superior--}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control Actividades de Promoción</h2>
            @if(Accesos::ACCESO_REGISTRAR_ACTIVIDADES())
            <div>
                {{-- Botón para añadir actividad de promocion--}}
                <a href="{{ route('actividad-promocion.create') }}" class="btn btn-rojo"> Añadir Actividad &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
            @endif
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                {{-- Título de la tabla --}}
                <h5 class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de actividades de promoción </h5>
                <div>
                    <form action="{{ route('actividad-promocion.listado') }}" method="GET" id="form-busqueda">
                        <button type="submit" class="btn btn-contorno-azul-una" id="btn-listar-todo"><i class="fas fa-redo"></i>&nbsp; Listar todo </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(Accesos::ACCESO_BUSCAR_ACTIVIDADES()) 
                {{-- Formulario para la paginación--}}
                <form autocomplete="off" action="{{ route('actividad-promocion.listado') }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between mb-2 ">
                        <div class="col-6 d-flex justify-content-start">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="tema_filtro" name="tema_filtro" placeholder="Tema de actividad" value="{{ $tema_filtro ?? ''  }}">
                                <div class=" input-group-append">
                                    <div class="input-group-text"><i class="fas fa-bullhorn"></i></div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-rojo  ml-3 mr-2 d-flex">Buscar <i class="fas fa-search ml-2 mt-1"></i> </button>
                            </div>
                            {{-- Checkbox para escoger la busqueda avanzada --}}
                            <div class="custom-control custom-checkbox mr-5">
                                <input type="checkbox" class="custom-control-input" id="checkAvanzada" name="checkAvanzada" onchange="mostrarBusquedaAvanzada(this);" <?php if(isset($_GET['checkAvanzada'])) echo "checked='checked'"; ?>>
                                <label class="custom-control-label" for="checkAvanzada">Busqueda avanzada</label>
                            </div>
                        </div>
                        <div class="col-4 text-nowrap">
                            <div class="d-flex justify-content-end">
                                <label class="font-weight-bold" for="itemsPagina">Mostrar &nbsp;</label>
                                <div class="w-25">
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <select class="form-control  custom-select custom-select-sm" id="itemsPagina" name="itemsPagina" onchange="document.getElementById(' item-pagina').submit()">
                                        @foreach($paginaciones as $paginacion)
                                        <option value={{ $paginacion }} @if($itemsPagina==$paginacion) @endif>{{ $paginacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row " id="busqAvanzada" style="display:none;">
                        <div class="col-2">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-100">
                                    <label for="tipo_filtro">Tipo de actividad</label>
                                </div>
                                <div class="d-flex">
                                    <select class="custom-select" id="tipo_filtro" name="tipo_filtro" class="form-control">
                                        <option value="">Sin Seleccionar</option>
                                        @foreach($tiposActividad as $tipoActividad)
                                        <option value="{{ $tipoActividad }}" @if($tipo_filtro==$tipoActividad) selected @endif> {{ $tipoActividad }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-100">
                                    <label for="estado_filtro">Estado </label>
                                </div>
                                <div class="d-flex">
                                    <select class="custom-select" id="estado_filtro" name="estado_filtro" class="form-control">
                                        <option value="">Sin Seleccionar</option>
                                        @foreach($estados as $estado)
                                        <option value="{{ $estado }}" @if($estado_filtro==$estado) selected @endif> {{ $estado }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 p-0">
                            <div class="d-flex justify-content-between w-100">
                                <label for="rango_fechas"> Rango de fechas <i class="far fa-question-circle fa-lg texto-azul-una" data-toggle="tooltip" data-placement="right" title="Buscar por fecha de INICIO de la actividad"></i></label>
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="btn btn-contorno-rojo" data-toggle="tooltip" data-placement="top" title="Vaciar el campo de fecha" onclick="eliminarFechas(this);"><i class="fas fa-calendar-times fa-lg"></i></span>
                                </div>
                                <input type="text" class="form-control datetimepicker" name="rango_fechas" id="rango_fechas" placeholder="DD/MM/YYYY - DD/MM/YYYY" value="{{ $rango_fechas ?? null }}">

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
                                <th>Código</th>
                                <th style="width: 21rem;">Tema</th>
                                <th>ID Coordinador</th>
                                <th>Tipo de actividad</th>
                                <th>Estado</th>
                                <th>Fecha de inicio</th>
                                @if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD())
                                <th>Autorización</th>
                                @endif
                                @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES()) 
                                <th>Ver detalle</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($actividadesPromocion) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg">
                                    </i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa de las actividades a la tabla --}}
                            @foreach($actividadesPromocion as $actividadPromocion)

                            <tr id="promocion" class="cursor-pointer">
                                <td>{{ $actividadPromocion->actividad_id}}</td>
                                <td>{{ $actividadPromocion->tema}}</td>
                                <td>{{ $actividadPromocion->responsable_coordinar }} </td>
                                <td>{{$actividadPromocion->tipo_actividad}}</td>
                                @if ( $actividadPromocion->estado == 'Para ejecución' )
                                <td><span class=" bg-info text-dark font-weight-bold px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                @elseif($actividadPromocion->estado == 'Cancelada')
                                <td><span class=" bg-danger text-white px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                @elseif($actividadPromocion->estado == 'En progreso')
                                <td><span class=" bg-warning text-dark px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                @elseif($actividadPromocion->estado == 'Ejecutada')
                                <td><span class=" bg-success text-white px-2 rounded">{{ $actividadPromocion->estado }}</span></td>
                                @endif
                                <td>{{ date("d/m/Y", strtotime($actividadPromocion->fecha_inicio_actividad)) }} </td>
                                @if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD())
                                    @if($actividadPromocion->autorizada == 0)
                                    <td><span class="bg-info text-dark font-weight-bold px-3 py-2 rounded">Pendiente</span></td>
                                    @else
                                    <td><span class="bg-success text-white font-weight-bold px-3 py-2 rounded">Autorizada</span></td>
                                    @endif
                                @endif
                                @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES()) 
                                <td>
                                    {{-- Botón para ver el detalle de la actividad --}}
                                    <strong>
                                        <a href="{{ route('actividad-promocion.show',$actividadPromocion->actividad_id) }}" class="btn btn-contorno-rojo"> Detalle </a>
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
                                <th style="width: 21rem;">Tema</th>
                                <th>ID Coordinador</th>
                                <th>Tipo de actividad</th>
                                <th>Estado</th>
                                <th>Fecha de inicio</th>
                                @if(Accesos::ACCESO_AUTORIZAR_ACTIVIDAD())
                                <th>Autorización</th>
                                @endif
                                @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES()) 
                                <th>Ver detalle</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-5 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$actividadesPromocion->perPage() }} de {{ $actividadesPromocion->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $actividadesPromocion->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/control_actividades_internas/listado.js') }}"></script>
@endsection
