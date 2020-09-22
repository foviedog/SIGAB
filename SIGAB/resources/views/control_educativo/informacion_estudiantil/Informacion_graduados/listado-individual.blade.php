@extends('layouts.app')

@section('titulo')
Graduaciones de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_graduaciones/listado-individual.js') }}" defer></script>
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle de la gradución --}}
        <div class="modal fade" id="detalle-graduacion-modal" tabindex="-1" aria-labelledby="detalle-graduacion-modal" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-graduacion-modal">Detalle de la gradución</h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                                    Habilitar edición
                                </button>
                                <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                                    Cancelar
                                </button>
                            </div>
                    </div>
                    <div class="modal-body">

                        {{-- Formulario para actualizar informacion de la graduación --}}
                        <form method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                        @csrf
                            <div class="d-flex justify-content-center flex-column ">
                                {{-- Campo: Grado académico --}}
                                <div class="mb-3">
                                    <label for="grado_academico">Grado académico <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_grado_academico"></span></label>
                                    <input type='text' class="form-control" id="grado_academico" name="grado_academico" onkeyup="contarCarGradoAcademico(this)" required disabled>
                                </div>

                                {{-- Campo: Carrera cursada--}}
                                <div class=" mb-3">
                                    <label for="carrera_cursada">Carrera cursada <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_carrera_cursada"></span></label>
                                    <input type='text' class="form-control" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCarCarrCursada(this)" required disabled>
                                </div>

                                {{-- Campo: Año de graduación --}}
                                <div class=" mb-3">
                                    <label for="anio_graduacion">Año de graduación <i class="text-danger">*</i><span class="text-muted ml-2" id="mostrar_cant_anio_graduacion"></span></label>
                                    <input type='number' class="form-control" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCarAnioGraduacion(this)" required disabled>
                                </div>
                            </div>
                        </form>

                    </div>

                    {{-- Botones para cerrar el modal o para guardar la edición --}}
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Graduaciones de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                {{-- //Botón para añadir graduación --}}
                <a href="/estudiante/graduacion/registrar/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"> Añadir nueva graduación &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
        </div>

        {{-- Mensaje de exito
            (solo se muestra si ha sido exitoso la edicion) --}}
        @if(Session::has('exito'))
            <div class="alert alert-success" role="alert">
                {!! \Session::get('exito') !!}
            </div>
        @endif

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Graduaciones</p>
            </div>
            <div class="card-body">
                {{-- Form para la paginación de la página y para la búsqueda de graduaciones --}}
                <form action="/estudiante/graduacion/{{ $estudiante->persona->persona_id }}" method="GET" role="form" id="item-pagina">
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
                                <th>Grado Académico</th>
                                <th>Carrera Cursada</th>
                                <th>Año de graduación</th>
                                <th>Ver más</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($graduaciones))
                            {{-- Inserción iterativa de las graduaciones dentro de la tabla --}}
                            @foreach($graduaciones as $graduacion)
                            <tr id="graduacion" class="cursor-pointer">
                                <td>{{ $graduacion->grado_academico }}</td>
                                <td>{{ $graduacion->carrera_cursada }} </td>
                                <td>{{ $graduacion->anio_graduacion }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información de la gradución --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-graduacion-modal" data-idgraduacion="{{ $graduacion->id }}">
                                        Ver más
                                    </button>
                                    <br />
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
                                <th>Grado Académico</th>
                                <th>Carrera Cursada</th>
                                <th>Año de graduación</th>
                                <th>Ver más</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $graduaciones->perPage() }} de {{ $graduaciones->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{ $graduaciones->withQueryString()->links() }}
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
