@extends('layouts.app')

@section('titulo')
Cargas académicas de {{ $personal->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@php
$anios = GlobalFunctions::obtenerAniosFuturos();
@endphp 

@section('contenido')
<div class="card">
    <div class="card-body">

        @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
        {{-- Modal para ver el detalle de la gradución --}}
        @include('modal.detalle-carga-academica')
        @endif

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Cargas académicas de {{ $personal->persona->nombre." ".$personal->persona->apellido }}</h2>
            <div>

                @if(Accesos::ACCESO_VISUALIZAR_PERSONAL())
                {{-- Regresar al detalle del personal --}}
                <a href="{{ route('personal.show', $personal->persona->persona_id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                @endif

                @if(Accesos::ACCESO_REGISTRAR_CARGAS_ACADEMICAS())
                {{-- //Botón para añadir carga académica --}}
                <a href="{{ route('cargaacademica.create', $personal->persona->persona_id) }}" class="btn btn-rojo"> Añadir nueva carga académica &nbsp; <i class="fas fa-plus-circle"></i> </a>
                @endif
                

                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                    @include('layouts.messages.confirmar_eliminar')
                @endif



            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Cargas académicas</p>
            </div>


            <div class="card-body">

                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
                <form autocomplete="off" action="{{ route('cargaacademica.show', $personal->persona->persona_id) }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between">

                        <div class="col-md-5 d-flex ">

                            <div class="input-group d-flex justify-content-between mr-2">
                                <div class="input-group-prepend ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Ver cargas académicas por un año en específico"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                </div>
                                <select class="form-control form-control-md"  name="anioFiltro">
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
                                <th>Nombre del curso</th>
                                <th>Ciclo lectivo</th>
                                <th>Año</th>
                                <th>NRC</th>
                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <th>Ver más</th>
                                @endif
                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Si no vienen registros --}}
                            @if(count($cargas_academicas))
                            {{-- Inserción iterativa de las cargas academicas dentro de la tabla --}}
                            @foreach($cargas_academicas as $carga_academica)
                            <tr id="carga_academica" class="cursor-pointer">
                                <td>{{ $carga_academica->nombre_curso }}</td>
                                <td>{{ $carga_academica->ciclo_lectivo }} </td>
                                <td>{{ $carga_academica->anio }} </td>
                                <td>{{ $carga_academica->nrc }}<br /> </td>

                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <td>
                                    {{-- Botón para ver información de la gradución --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-carga_academica-modal" data-idcarga_academica="{{ $carga_academica->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                                @endif

                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <td>
                                    <button class="btn btn-contorno-rojo" onclick="rutaCargaAcademica({{ $carga_academica->id }})" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                </td>
                                @endif

                            </tr>
                            @endforeach
                            @else
                            <tr class="cursor-pointer">
                                <td colspan="5"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr> @endif 
                        </tbody>
                        {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Ciclo lectivo</th>
                                <th>Año</th>
                                <th>NRC</th>
                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <th>Ver más</th>
                                @endif
                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-5 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$cargas_academicas->perPage() }} de {{ $cargas_academicas->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $cargas_academicas->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/Control_personal/carga_academica.js') }}" defer></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection
