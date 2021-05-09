@extends('layouts.app')

@section('titulo')
Trabajos de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle del trabajo --}}
        @include('modal.detalle-trabajo')

        @if(Accesos::ACCESO_ELIMINAR_TRABAJOS())
            @include('layouts.messages.confirmar_eliminar')
        @endif

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Trabajos de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                @if(Accesos::ACCESO_VISUALIZAR_ESTUDIANTES())
                {{-- Regresar al detalle del estudiante --}}
                <a href="{{ route('estudiante.show', $estudiante->persona->persona_id) }}"  class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                @endif

                @if(Accesos::ACCESO_REGISTRAR_TRABAJOS())
                {{-- //Botón para añadir trabajo --}}
                <a href="{{ route('trabajo.create', $estudiante->persona->persona_id) }}" class="btn btn-rojo"> Añadir nuevo trabajo &nbsp; <i class="fas fa-plus-circle"></i> </a>
                @endif

            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información laboral</p>
            </div>
            <div class="card-body">
                {{-- Form para la paginación de la página y para la búsqueda de trabajos --}}
                <form autocomplete="off" action="{{ route('trabajo.listar',$estudiante->persona->persona_id) }}"  method="GET" role="form" id="item-pagina">
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
                                @if(Accesos::ACCESO_ELIMINAR_TRABAJOS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($trabajos))
                            {{-- Inserción iterativa de los trabajos dentro de la tabla --}}
                            @foreach($trabajos as $trabajo)
                            <tr id="trabajo" class="cursor-pointer">
                                <td>{{ $trabajo->nombre_organizacion }}</td>
                                <td>{{ $trabajo->cargo_actual }} </td>
                                <td>{{ $trabajo->jornada_laboral }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información del trabajo --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-trabajo-modal" data-idtrabajo="{{ $trabajo->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                                
                                @if(Accesos::ACCESO_ELIMINAR_TRABAJOS())
                                <td>
                                    <button class="btn btn-contorno-rojo" onclick="rutaTrabajo({{ $trabajo->id }})" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                </td>
                                @endif
                                
                            </tr>
                            @endforeach
                            @else
                            <tr class="cursor-pointer">
                                <td colspan="4" > <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre de la organización</th>
                                <th>Cargo actual</th>
                                <th>Jornada laboral</th>
                                <th>Ver más</th>
                                @if(Accesos::ACCESO_ELIMINAR_TRABAJOS())
                                <th>Eliminar</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-3 align-self-center">
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

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_laboral/listado.js') }}" defer></script>
@endsection
